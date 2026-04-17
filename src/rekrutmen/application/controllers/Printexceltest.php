<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class printexcel extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('m_monitor','m_upload_berkas','m_screening','m_print'));
    }

    // function printPaging(){
    //     /*
    //      * -- dataSelect -- 
    //      * 0 => Semua Data
    //      * 1 => Dalam Proses
    //      * 2 => Telah Close
    //      * 3 => Telah Posting
    //      */
    //     $dataSelect             = $this->uri->segment(3);
    //     $num                    = $this->uri->segment(4);
    //     if($num === FALSE && $dataSelect === FALSE){
    //         redirect('monitor/printPaging/0/1');
    //     }elseif ($num === FALSE) {
    //         redirect('monitor/printPaging/'.$dataSelect.'/1');
    //     }

    //     $data['dataSelect']     = $dataSelect;
    //     $data['num']            = $num;
        
    //     $numStart               = $num-1;
    //     $start                  = 1;
    //     $end                    = 0;
    //     $startPaging            = (int)$numStart.$start;
    //     $endPaging              = (int)$num.$end;
    //     if($dataSelect == 0){
    //         $total                  = $this->m_monitor->countAllTenaker();
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectAllTenaker($startPaging,$endPaging);
    //         $data['getpemborong']   = $this->m_monitor->getPemborong();
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 1){
    //         $total                  = $this->m_monitor->countOnProccessTenaker();
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectOnProccessTenaker($startPaging,$endPaging);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 2){
    //         $total                  = $this->m_monitor->countClosedTenaker();
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectClosedTenaker($startPaging,$endPaging);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 3){
    //         $total                  = $this->m_monitor->countPostedTenaker();
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectPostedTenaker($startPaging,$endPaging);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 4){
    //         $total                  = $this->m_monitor->countOnProccessTenakerview();
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectOnProccessTenakerview($startPaging,$endPaging);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 5){
    //         $total                  = $this->m_monitor->countOnTenakerGagal();
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectOnTenakerGagal($startPaging,$endPaging);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }else{
    //         $total                  = NULL;
    //         $data['_selected']      = NULL;
    //         $data['_selectWhere']   = NULL;
    //         $data['_pagination']    = NULL;
    //     }
        
    //     $this->template->display('monitor/calon_tk/print_Paging',$data);
    // }

    // function testPrint(){
    //     $dataFilter = $this->input->post('selDataFilter');

    //     // $data['dataSelect']     = $dataSelect;
    //     // $data['num']            = $num;
        
    //     $this->session->unset_userdata('w_pemborong');
    //     $this->session->unset_userdata('w_jekel');
    //     $this->session->unset_userdata('w_status');
    //     $this->session->unset_userdata('w_pendidikan');
    //     $this->session->unset_userdata('w_jurusan');
    //     $this->session->unset_userdata('w_noreg');
    //     $this->session->unset_userdata('w_nama');
        
    //     if($this->input->post('txtThnLahir') == NULL && $this->input->post('txtNama') == NULL && $this->input->post('txtNoreg') == NULL && $this->input->post('txtPemborong') == NULL && $this->input->post('txtJekel') == NULL && $this->input->post('txtStatus') == NULL && $this->input->post('txtPendidikan') == NULL && $this->input->post('txtJurusan') == NULL){
    //         redirect('monitor/printPaging/'.$dataFilter);
    //     }
        
    //     $this->session->set_userdata('w_pemborong', $this->input->post('txtPemborong'));
    //     $this->session->set_userdata('w_jekel', $this->input->post('txtJekel'));
    //     $this->session->set_userdata('w_status', $this->input->post('txtStatus'));
    //     $this->session->set_userdata('w_pendidikan', $this->input->post('txtPendidikan'));
    //     $this->session->set_userdata('w_jurusan', $this->input->post('txtJurusan'));
    //     $this->session->set_userdata('w_noreg', $this->input->post('txtNoreg'));
    //     $this->session->set_userdata('w_nama', $this->input->post('txtNama'));
        
    //     redirect('monitor/testPrintWhere/'.$dataFilter.'/1');
    // }

    // function testPrintWhere(){
    //     $dataSelect             = $this->uri->segment(3);
    //     $num                    = $this->uri->segment(4);

    //     $data['dataSelect']     = $dataSelect;
    //     $data['num']            = $num;
 
        
    //     $pemborong      = $this->session->userdata('w_pemborong');
    //     $jekel          = $this->session->userdata('w_jekel');
    //     $status         = $this->session->userdata('w_status');
    //     $pendidikan     = $this->session->userdata('w_pendidikan');
    //     $jurusan        = $this->session->userdata('w_jurusan');
    //     $noreg          = $this->session->userdata('w_noreg');
    //     $nama           = $this->session->userdata('w_nama');
        
    //     $numStart               = $num-1;
    //     $start                  = 1;
    //     $end                    = 0;
    //     $startPaging            = (int)$numStart.$start;
    //     $endPaging              = (int)$num.$end;
        
    //     if($dataSelect == 0){
    //         $total                  = $this->m_monitor->countAllTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectAllTenakerWhere($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['getpemborong']   = $this->m_monitor->getPemborong();
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 1){
    //         $total                  = $this->m_monitor->countOnProccessTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectOnProccessTenakerWhere($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 2){
    //         $total                  = $this->m_monitor->countClosedTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectClosedTenakerWhere($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 3){
    //         $total                  = $this->m_monitor->countPostedTenakerWhere($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectPostedTenakerWhere($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 4){
    //         $total                  = $this->m_monitor->countOnProccessTenakerWhereview($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectOnProccessTenakerWhereview($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }elseif($dataSelect == 5){
    //         $total                  = $this->m_monitor->countOnTenakerWhereGagal($pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_selected']      = $dataSelect;
    //         $data['_selectWhere']   = $this->m_monitor->selectOnTenakerWhereGagal($startPaging,$endPaging,$pemborong,$jekel,$status,$pendidikan,$jurusan,$noreg,$nama);
    //         $data['_pagination']    = $this->pagination($page = $num, 10, $total);
    //     }else{
    //         $total                  = NULL;
    //         $data['_selected']      = NULL;
    //         $data['_selectWhere']   = NULL;
    //         $data['_pagination']    = NULL;
    //     }
    //     $this->template->display('monitor/calon_tk/print_Paging',$data);
    // }
    function upload(){
        $this->load->library("Excel/PHPExcel");

        // $thn                    = $_GET['thn'];
        // $bln                    = $_GET['bln'];
        // $thn                    = $this->input->get('thn');
        // $bln                    = $this->input->get('bln');
        $thn                    = 2018;
        $bln                    = 3;

        $Pemborong              = $_GET['Pemborong'];
        $Jenis_Kelamin          = $_GET['Jenis_Kelamin'];
        $Pendidikan             = $_GET['Pendidikan'];
        // $export                 = $_GET['selDataExport'];

        $data['getPemborong']  = $this->m_monitor->getPemborong();

        if($Pendidikan == 1){
            $data['getData']       = $this->m_print->toExcelSemua1($Pemborong, $Jenis_Kelamin, $thn, $bln);
        }elseif($Pendidikan == 2){
            $data['getData']       = $this->m_print->toExcelSemua2($Pemborong, $Jenis_Kelamin, $thn, $bln);
        }else{
            $data['getData']       = $this->m_print->toExcelData($Pemborong, $Jenis_Kelamin, $thn, $bln);
        }

        // if($export == 1){
        //     $data['getData']        = $this->m_monitor->toExcelAll($thn, $bln, $Pemborong, $Jenis_Kelamin);
        // }elseif($export == 2){
        //     $data['getData']        = $this->m_monitor->toExcelPost($thn, $bln);
        // }elseif($export == 3){
        //     $data['getData']        = $this->m_monitor->toExcelGagalview($thn, $bln);
        // }elseif($export == 4){
        //     $data['getData']        = $this->m_monitor->toExcelNotview($thn, $bln);
        // }elseif($export == 5){
        //     $data['getData']        = $this->m_monitor->toExcelTelahview($thn, $bln);
        // }else{
        //     $data['getData']        = $this->m_monitor->toExcelData($Pemborong, $Jenis_Kelamin, $thn, $bln);
        // }

        $this->load->view('monitor/calon_tk/laporan_excel',$data);
    }

    function dataprint(){  

        $data['getPemborong']  = $this->m_monitor->getPemborong();

        $this->template->display('monitor/calon_tk/print_Paging',$data);
    }

    // function find(){
    //     $txtDeptAsal    = $this->input->post('txtDeptAsal');
    //     $txtDeptTerima  = $this->input->post('txtDeptTerima');
    //     $txtDate1       = date('Y-m-d', strtotime($this->input->post('txtDate1')));
    //     $txtDate2       = date('Y-m-d', strtotime($this->input->post('txtDate2')));

    //     if(empty($txtDeptTerima)){
    //         $data['listWo'] = $this->m_monitor->searchWO1($txtDeptAsal,$txtDate1,$txtDate2);
    //     }else{
    //         $data['listWo'] = $this->m_monitor->searchWO($txtDeptAsal,$txtDeptTerima,$txtDate1,$txtDate2);
    //     }

    //     $this->load->view('monitor/dept_pengirim/list_findwo',$data);
    // }

    function printdata()
    {
        $HdrID              = $this->input->post('HdrID');
        $Nama               = $this->input->post('Nama');
        $Pemborong          = $this->input->post('Pemborong');
        $Jenis_Kelamin      = $this->input->post('Jenis_Kelamin');
        $thn                = $this->input->post('thn');
        $bln                = $this->input->post('bln');
        $blnthn             = $bln."-".$thn;
        $Pendidikan         = $this->input->post('Pendidikan');
        $export             = $this->input->post('selDataExport');
        // $total      = $total;
        
        $data['getPemborong']  = $this->m_print->getPemborong();

        //========================== ALL PEMBORONG ==============================//
        if($Nama != NULL){
            $data['getData']        = $this->m_print->toExcelSearch($Nama);

        }elseif($HdrID != NULL){
            $data['getData']        = $this->m_print->toExcelSearchID($HdrID);

        }elseif($export == 1 && $Pendidikan == 1 && $Jenis_Kelamin == NULL){
            $data['getData']        = $this->m_print->toExcelAll1($thn, $bln);

        }elseif($export == 1 && $Pendidikan == 2 && $Jenis_Kelamin == NULL){
            $data['getData']        = $this->m_print->toExcelAll2($thn, $bln);

        }elseif($export == 1 && $Pendidikan == 1 && $Jenis_Kelamin != NULL){
            $data['getData']        = $this->m_print->toExcelAll3($thn, $bln, $Jenis_Kelamin);

        }elseif($export == 1 && $Pendidikan == 2 && $Jenis_Kelamin != NULL){
            $data['getData']        = $this->m_print->toExcelAll4($thn, $bln, $Jenis_Kelamin);

        }elseif($export == 1 && $Jenis_Kelamin != NULL){
            $data['getData']        = $this->m_print->toExcelAll5($thn, $bln, $Jenis_Kelamin);

        }elseif($export == 1){
            $data['getData']        = $this->m_print->toExcelAll($thn, $bln);

        //========================== TELAH POSTING ==============================//
        // }elseif($export == 2) {
        //     $data['getData']        = $this->m_print->toExcelPost($thn, $bln);

        }elseif($export == 2 && $Pemborong == NULL) {
            $data['getData']        = $this->m_print->toExcelPost($thn, $bln);

        }elseif($export == 2 && $Pemborong != NULL && $Jenis_Kelamin == NULL) {
            $data['getData']        = $this->m_print->toExcelPost1($thn, $bln, $Pemborong);

        }elseif($export == 2 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == NULL) {
            $data['getData']        = $this->m_print->toExcelPost2($thn, $bln, $Pemborong, $Jenis_Kelamin);

        }elseif($export == 2 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == 1) {
            $data['getData']        = $this->m_print->toExcelPost3($thn, $bln, $Pemborong, $Jenis_Kelamin);

        }elseif($export == 2 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == 2) {
            $data['getData']        = $this->m_print->toExcelPost4($thn, $bln, $Pemborong, $Jenis_Kelamin);



        }elseif($export == 2 && $Pendidikan == 1 && $Pemborong == NULL && $Jenis_Kelamin == NULL) {
            $data['getData']        = $this->m_print->toExcelPost6($thn, $bln);

        }elseif($export == 2 && $Pendidikan == 2 && $Pemborong == NULL && $Jenis_Kelamin == NULL) {
            $data['getData']        = $this->m_print->toExcelPost7($thn, $bln);

        // }elseif($export == 2 && $Jenis_Kelamin == NULL) {
        //     $data['getData']        = $this->m_print->toExcelPost5($thn, $bln, $Jenis_Kelamin);

        // }elseif($export == 2 && $Pemborong == NULL && $Jenis_Kelamin != NULL) {
        //     $data['getData']        = $this->m_print->toExcelPost5($thn, $bln, $Jenis_Kelamin);

        // ============================== Gagal Interview =============================
        // }elseif($export == 3) {
        //     $data['getData']        = $this->m_print->toExcelGagalview($thn, $bln);

        }elseif($export == 3 && $Pemborong == NULL) {
            $data['getData']        = $this->m_print->toExcelGagalview($thn, $bln);

        }elseif($export == 3 && $Pemborong != NULL && $Jenis_Kelamin == NULL) {
            $data['getData']        = $this->m_print->toExcelGagalview1($thn, $bln, $Pemborong);

        }elseif($export == 3 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == NULL) {
            $data['getData']        = $this->m_print->toExcelGagalview2($thn, $bln, $Pemborong, $Jenis_Kelamin);

        }elseif($export == 3 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == 1) {
            $data['getData']        = $this->m_print->toExcelGagalview3($thn, $bln, $Pemborong, $Jenis_Kelamin);

        }elseif($export == 3 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == 2) {
            $data['getData']        = $this->m_print->toExcelGagalview4($thn, $bln, $Pemborong, $Jenis_Kelamin);

        //=============================== Belum Wawancara ==============================
        // }elseif($export == 4) {
        //     $data['getData']        = $this->m_print->toExcelNotview($thn, $bln);

        }elseif($export == 4 && $Pemborong == NULL) {
            $data['getData']        = $this->m_print->toExcelNotview($thn, $bln);

        }elseif($export == 4 && $Pemborong != NULL && $Jenis_Kelamin == NULL) {
            $data['getData']        = $this->m_print->toExcelNotview1($thn, $bln, $Pemborong);

        }elseif($export == 4 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == NULL) {
            $data['getData']        = $this->m_print->toExcelNotview2($thn, $bln, $Pemborong, $Jenis_Kelamin);

        }elseif($export == 4 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == 1) {
            $data['getData']        = $this->m_print->toExcelNotview3($thn, $bln, $Pemborong, $Jenis_Kelamin);

        }elseif($export == 4 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == 2) {
            $data['getData']        = $this->m_print->toExcelNotview4($thn, $bln, $Pemborong, $Jenis_Kelamin);


        //============================== Belum Wawancara ==============================
        // }elseif($export == 5) {
        //     $data['getData']        = $this->m_print->toExcelTelahview($thn, $bln);

        }elseif($export == 5 && $Pemborong == NULL) {
            $data['getData']        = $this->m_print->toExcelTelahview($thn, $bln);

        }elseif($export == 5 && $Pemborong != NULL && $Jenis_Kelamin == NULL) {
            $data['getData']        = $this->m_print->toExcelTelahview1($thn, $bln, $Pemborong);

        }elseif($export == 5 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == NULL) {
            $data['getData']        = $this->m_print->toExcelTelahview2($thn, $bln, $Pemborong, $Jenis_Kelamin);

        }elseif($export == 5 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == 1) {
            $data['getData']        = $this->m_print->toExcelTelahview3($thn, $bln, $Pemborong, $Jenis_Kelamin);

        }elseif($export == 5 && $Pemborong != NULL && $Jenis_Kelamin != NULL && $Pendidikan == 2) {
            $data['getData']        = $this->m_print->toExcelTelahview4($thn, $bln, $Pemborong, $Jenis_Kelamin);


        }elseif($Pendidikan == 1){
            $data['getData']        = $this->m_print->toExcelSemua1($Pemborong, $Jenis_Kelamin, $thn, $bln);
        }elseif($Pendidikan == 2){
            $data['getData']        = $this->m_print->toExcelSemua2($Pemborong, $Jenis_Kelamin, $thn, $bln);
        }else{
            $data['getData']        = $this->m_print->toExcelData($Pemborong, $Jenis_Kelamin, $thn, $bln);
        }

        // if($export == 1){
        //     $data['getData']        = $this->m_monitor->toExcelAll($thn, $bln, $Pemborong, $Jenis_Kelamin);
        // }elseif($export == 2){
        //     $data['getData']        = $this->m_monitor->toExcelPost($thn, $bln);
        // }elseif($export == 3){
        //     $data['getData']        = $this->m_monitor->toExcelGagalview($thn, $bln, $Jenis_Kelamin, $Pemborong);
        // }elseif($export == 4){
        //     $data['getData']        = $this->m_monitor->toExcelNotview($thn, $bln);
        // }elseif($export == 5){
        //     $data['getData']        = $this->m_monitor->toExcelTelahview($thn, $bln);
        // }elseif($Pendidikan == 1){
        //     $data['getData']        = $this->m_print->toExcelSemua1($Pemborong, $Jenis_Kelamin, $thn, $bln);
        // }elseif($Pendidikan == 2){
        //     $data['getData']        = $this->m_print->toExcelSemua2($Pemborong, $Jenis_Kelamin, $thn, $bln);
        // }else{
        //     $data['getData']        = $this->m_print->toExcelData($Pemborong, $Jenis_Kelamin, $thn, $bln);
        // }
           
        $this->load->view('monitor/calon_tk/Paging_print',$data);
    }

    public function dengan(){
        $param=$this->uri->segment(3);
        $this->load->model('m_monitor');
        $this->load->library("Excel/PHPExcel");

            $newdata = array(
                    'Pemborong'          => $this->input->post('Pemborong'),
                    'Jenis_Kelamin'      => $this->input->post('Jenis_Kelamin'),
                    'thn'                => $this->input->post('thn'),
                    'bln'                => $this->input->post('bln'),
            );

            $this->session->set_userdata($newdata);
    }
    
    public function downloadExcel(){

        // $refres     = $this->input->post('Refres');
        // $print      = $this->input->post('Print');



        // if ($refres = 'Refres') {

        // $export     = $this->input->post('selDataExport');
        // // select data from database
        // $pemborong  = $this->input->post('txtPemborong');
        // $jekel      = $this->input->post('txtJekel');
        // $bln        = $this->input->post('selBulan');
        // $thn        = $this->input->post('selTahun');
        // $blnthn     = $bln."-".$thn;
        // // $total      = $total;
        
        // if($export == 'all'){
        //     $title  = 'LAPORAN SEMUA CALON TENAGA KERJA BULAN';
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $data['getData']   = $this->m_monitor->toExcelSemuaLimitMonth($bln, $thn, $jekel, $pemborong);
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'post'){
        //     $data['getData']   = $this->m_monitor->reportPostedLimitDate($bln, $thn, $jekel, $pemborong);
        //     $by     = 'Posted By';
        //     $dateBy = 'Posted Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG DIKIRIM, BULAN';
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'view'){
        //     $data['getData']   = $this->m_monitor->toExcelProsesview($bln, $thn, $jekel, $pemborong);
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG BELUM INTERVIEW, BULAN';
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'non'){
        //     $data['getData']   = $this->m_monitor->toExcelnonPendidikan($bln, $thn, $jekel, $pemborong);
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG BELUM INTERVIEW NON PENDIDIKAN, BULAN';
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'smu'){
        //     $data['getData']   = $this->m_monitor->toExcelsmusederajat($bln, $thn, $jekel, $pemborong);
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG BELUM INTERVIEW SMU SEDERAJAT, BULAN';
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'interview'){
        //     $data['getData']   = $this->m_monitor->toExcelProsesinterview($bln, $thn, $jekel ,$pemborong);
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG BELUM INTERVIEW, BULAN';
        //     $total  = 'TOTAL : ';
        // }else{
        //     $data   = NULL;
        //     $title  = NULL;
        //     $by     = NULL;
        //     $dateBy = NULL;
        // }

        // $this->template->display('monitor/calon_tk/print_Paging',$data);
        // }

        // if($print = 'Print'){
        $this->load->library("Excel/PHPExcel");
        
        // $export     = $this->input->post('selDataExport');
        // // select data from database
        // $pemborong  = $this->input->post('txtPemborong');
        // $jekel      = $this->input->post('txtJekel');
        // $bln        = $this->input->post('selBulan');
        // $thn        = $this->input->post('selTahun');
        // $blnthn     = $bln."-".$thn;
        // // $total      = $total;
        
        // if($export == 'all'){
        //     $title  = 'LAPORAN SEMUA CALON TENAGA KERJA BULAN';
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $data   = $this->m_monitor->toExcelSemuaLimitMonth($bln, $thn);
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'post'){
        //     $data   = $this->m_monitor->reportPostedLimitDate($bln, $thn);
        //     $by     = 'Posted By';
        //     $dateBy = 'Posted Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG DIKIRIM, BULAN';
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'view'){
        //     $data   = $this->m_monitor->toExcelProsesview($bln, $thn, $jekel, $pemborong);
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG BELUM INTERVIEW, BULAN';
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'non'){
        //     $data   = $this->m_monitor->toExcelnonPendidikan($bln, $thn, $jekel, $pemborong);
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG BELUM INTERVIEW NON PENDIDIKAN, BULAN';
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'smu'){
        //     $data   = $this->m_monitor->toExcelsmusederajat($bln, $thn, $jekel, $pemborong);
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG BELUM INTERVIEW SMU SEDERAJAT, BULAN';
        //     $total  = 'TOTAL : ';
        // }elseif($export == 'interview'){
        //     $data   = $this->m_monitor->toExcelProsesinterview($bln, $thn, $jekel ,$pemborong);
        //     $by     = 'Registered By';
        //     $dateBy = 'Registered Date';
        //     $title  = 'LAPORAN TENAGA KERJA YANG BELUM INTERVIEW, BULAN';
        //     $total  = 'TOTAL : ';
        // }else{
        //     $data   = NULL;
        //     $title  = NULL;
        //     $by     = NULL;
        //     $dateBy = NULL;
        // }

        // $Pemborong          = $this->session->userdata('Pemborong');
        // $Jenis_Kelamin      = $this->session->userdata('Jenis_Kelamin');
        // $thn                = $this->session->userdata('thn');
        // $bln                = $this->session->userdata('bln');
        // $blnthn             = '3'."-".'2018';

        // $Pemborong          = $this->input->post('Pemborong');
        // $Jenis_Kelamin      = $this->input->post('Jenis_Kelamin');
        // $thn                = $this->input->post('thn');
        // $bln                = $this->input->post('bln');
        // $blnthn             = $bln."-".$thn;

        $Pemborong          = 'M. BUYUNG';
        $Jenis_Kelamin      = 'LAKI-LAKI';
        $thn                = '2018';
        $bln                = '3';
        $blnthn             = $bln."-".$thn;

        $title  = 'LAPORAN SEMUA CALON TENAGA KERJA BULAN';
        $by     = 'Registered By';
        $dateBy = 'Registered Date';

        $data = $this->m_monitor->toExcelSemua($Pemborong, $Jenis_Kelamin, $thn, $bln);
        
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $title.' : '.$blnthn)
                // ->setCellValue('A2', $total)
                ->setCellValue('A3', 'No.')
                ->setCellValue('B3', 'RegisID')
                ->setCellValue('C3', 'Nama')
                ->setCellValue('D3', 'Pemborong')
                ->setCellValue('E3', 'Perusahaan')
                ->setCellValue('F3', 'KTP')
                ->setCellValue('G3', 'Jenis Kelamin')
                ->setCellValue('H3', 'Alamat')
                ->setCellValue('I3', 'RT')
                ->setCellValue('J3', 'RW')
                ->setCellValue('K3', 'Handphone')
                ->setCellValue('L3', 'Tempat Lahir')
                ->setCellValue('M3', 'Tanggal Lahir')
                ->setCellValue('N3', 'Tinggal Dengan')
                ->setCellValue('O3', 'Hubungan dg Pelamar')
                ->setCellValue('P3', 'Tinggi Badan')
                ->setCellValue('Q3', 'Berat Badan')
                ->setCellValue('R3', 'Suku')
                ->setCellValue('S3', 'Daerah Asal')
                ->setCellValue('T3', 'Bahasa Daerah')
                ->setCellValue('U3', 'Agama')
                ->setCellValue('V3', 'Status Perkawinan')
                
                ->setCellValue('W3', 'Nama Pasangan')
                ->setCellValue('X3', 'Tanggal Lahir Pasangan')
                ->setCellValue('Y3', 'Pekerjaan Pasangan')
                ->setCellValue('Z3', 'Alamat Pasangan')
                ->setCellValue('AA3', 'Jumlah Anak')
                
                ->setCellValue('AB3', 'Nama Ayah')
                ->setCellValue('AC3', 'Nama Ibu')
                ->setCellValue('AD3', 'Pekerjaan Ortu')
                ->setCellValue('AE3', 'Anak Ke')
                ->setCellValue('AF3', 'Jumlah Saudara')
                ->setCellValue('AG3', 'Pendidikan Terakhir')
                ->setCellValue('AH3', 'Jurusan')
                ->setCellValue('AI3', 'Nama Univ/Sekolah')
                ->setCellValue('AJ3', 'Rata Nilai')
                ->setCellValue('AK3', 'Tahun Masuk')
                ->setCellValue('AL3', 'Tahun Lulus')
                ->setCellValue('AM3', 'Pengalaman Kerja')
                ->setCellValue('AN3', 'Skill/Keahlian')
                ->setCellValue('AO3', 'Pernah Kerja di SAMBU')
                ->setCellValue('AP3', 'Bag/Dept')
                ->setCellValue('AQ3', 'Hobby')
                ->setCellValue('AR3', 'Kegiatan Ekstra')
                ->setCellValue('AS3', 'Kegiatan Organisasi')
                ->setCellValue('AT3', 'Keadaan Fisik')
                ->setCellValue('AU3', 'Idap Penyakit')
                ->setCellValue('AV3', 'Penyakit Apa')
                ->setCellValue('AW3', 'Pernah Terlibat Kriminal')
                ->setCellValue('AX3', 'Perkara Apa')
                ->setCellValue('AY3', 'Bertato')
                ->setCellValue('AZ3', 'Bertindik')
                ->setCellValue('BA3', 'Sedia Rambut Pendek')
                ->setCellValue('BB3', 'Sedia Diberhentikan')
                ->setCellValue('BC3', 'Facebook')
                ->setCellValue('BD3', 'Twitter')
                ->setCellValue('BE3', 'Status')
                ->setCellValue('BF3', 'Hasil Wawancara')
                ->setCellValue('BG3', $by)
                ->setCellValue('BH3', $dateBy);
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 4;
        foreach ($data as $row):
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->HeaderID);
            $ex->setCellValue('C'.$counter, $row->Nama);
            $ex->setCellValue('D'.$counter, $row->Pemborong);
            $ex->setCellValue('E'.$counter, $row->CVNama);
            $ex->setCellValue('F'.$counter, $row->No_Ktp);
            $ex->setCellValue('G'.$counter, $row->Jenis_Kelamin);
            $ex->setCellValue('H'.$counter, $row->Alamat);
            $ex->setCellValue('I'.$counter, $row->RT);
            $ex->setCellValue('J'.$counter, $row->RW);
            $ex->setCellValue('K'.$counter, $row->NoHP);
            $ex->setCellValue('L'.$counter, $row->Tempat_Lahir);
            $ex->setCellValue('M'.$counter, date('d M Y', strtotime($row->Tgl_Lahir)));
            $ex->setCellValue('N'.$counter, $row->TinggalDengan);
            $ex->setCellValue('O'.$counter, $row->HubunganDenganTK);
            $ex->setCellValue('P'.$counter, $row->TinggiBadan);
            $ex->setCellValue('Q'.$counter, $row->BeratBadan);
            $ex->setCellValue('R'.$counter, $row->Suku);
            $ex->setCellValue('S'.$counter, $row->Daerah_Asal);
            $ex->setCellValue('T'.$counter, $row->BahasaDaerah);
            $ex->setCellValue('U'.$counter, $row->Agama);
            $ex->setCellValue('V'.$counter, $row->Status_Personal);
            
            $ex->setCellValue('W'.$counter, $row->NamaSuamiIstri);
            $ex->setCellValue('X'.$counter, date('d M Y', strtotime($row->TglLahirSuamiIstri)));
            $ex->setCellValue('Y'.$counter, $row->PekerjaanSuamiIstri);
            $ex->setCellValue('Z'.$counter, $row->AlamatSuamiIstri);
            $ex->setCellValue('AA'.$counter, $row->JumlahAnak);
            
            $ex->setCellValue('AB'.$counter, $row->NamaBapak);
            $ex->setCellValue('AC'.$counter, $row->NamaIbuKandung);
            $ex->setCellValue('AD'.$counter, $row->ProfesiOrangTua);
            $ex->setCellValue('AE'.$counter, $row->AnakKe);
            $ex->setCellValue('AF'.$counter, $row->JumlahSaudara);
            
            $ex->setCellValue('AG'.$counter, $row->Pendidikan);
            $ex->setCellValue('AH'.$counter, $row->Jurusan);
            $ex->setCellValue('AI'.$counter, $row->Universitas);
            $ex->setCellValue('AJ'.$counter, $row->IPK);
            $ex->setCellValue('AK'.$counter, $row->TahunMasuk);
            $ex->setCellValue('AL'.$counter, $row->TahunLulus);
            
            $ex->setCellValue('AM'.$counter, $row->PengalamanKerja);
            $ex->setCellValue('AN'.$counter, $row->Keahlian);
            $ex->setCellValue('AO'.$counter, $row->PernahKerjaDiSambu);
            $ex->setCellValue('AP'.$counter, $row->KerjadiBagian);
            
            $ex->setCellValue('AQ'.$counter, $row->Hobby);
            $ex->setCellValue('AR'.$counter, $row->KegiatanEkstra);
            $ex->setCellValue('AS'.$counter, $row->KegiatanOrganisasi);
            $ex->setCellValue('AT'.$counter, $row->KeadaanFisik);
            $ex->setCellValue('AU'.$counter, $row->PernahIdapPenyakit);
            $ex->setCellValue('AV'.$counter, $row->PenyakitApa);
            $ex->setCellValue('AW'.$counter, $row->Kriminal);
            $ex->setCellValue('AX'.$counter, $row->PerkaraApa);
            $ex->setCellValue('AY'.$counter, $row->Bertato);
            $ex->setCellValue('AZ'.$counter, $row->Bertindik);
            $ex->setCellValue('BA'.$counter, $row->SediaPotongRambut);
            $ex->setCellValue('BB'.$counter, $row->Sediadiberhentikan);
            
            $ex->setCellValue('BC'.$counter, $row->AccountFacebook);
            $ex->setCellValue('BD'.$counter, $row->AccountTwitter);

            $dt = $row->DeptTujuan;
            $wh = $row->WawancaraHasil;
            $Fa = $row->Verified;
            $Gs = $row->GeneralStatus;
            if ($Fa == NULL) {
                $wnc    = ' - ';
            }elseif ($dt == NULL) {
                $wnc    = 'Belum Set Dept';
            }elseif ($dt != NULL && $wh == 1) {
                $wnc    = substr($dt, 0, 3).' - Lulus Interview';
            }elseif ($dt != NULL && $wh == 0 && $Gs == 1) {
                $wnc    = substr($dt, 0, 3).' - Gagal Interview';
            }elseif ($dt != NULL && $wh == NULL && $Gs == 0) {
                $wnc    = substr($dt, 0, 3).' - Belum Interview';
            }else{
                $wnc    = ' - ';
            }

            $Sh = $row->ScreeningHasil;
            $Sc = $row->ScreeningComplete;
            $Ss = $row->SpecialScreening;
            $Pd = $row->PostingData;
            if($Pd == NULL && $Sc == NULL && $Ss == NULL && $Fa == 1){
                $status = "Telah Verifikasi";
            }elseif($Pd == NULL && $Sc == 1 && $Ss == NULL && $Fa == 1){
                $status = "Sudah Screening Tim";
            }elseif($Pd == NULL && $Sc == 1 && $Ss == 1 && $Fa == 1) {
                $status = "Sudah Screening PSN";
            }elseif ($Pd == 1 && $Sc == 1 && $Ss == 1 && $Fa == 1) {
                $status = "Telah Posting";
            }else{
                $status = "Belum Verifikasi";
            }
            $ex->setCellValue('BE'.$counter, $status);
            $ex->setCellValue('BF'.$counter, $wnc);
            
            // if($export == 'all'){
            //     $ex->setCellValue('BG'.$counter, $row->CreatedBy);
            //     $ex->setCellValue('BH'.$counter, $row->CreatedDate);
            // }elseif($export == 'post'){
            //     $ex->setCellValue('BG'.$counter, $row->PostedBy);
            //     $ex->setCellValue('BH'.$counter, $row->PostedDate);
            // }elseif($export == 'view'){
            //     $ex->setCellValue('BG'.$counter, $row->CreatedBy);
            //     $ex->setCellValue('BH'.$counter, $row->CreatedDate);
            // }elseif($export == 'non'){
            //     $ex->setCellValue('BG'.$counter, $row->CreatedBy);
            //     $ex->setCellValue('BH'.$counter, $row->CreatedDate);
            // }elseif($export == 'smu'){
            //     $ex->setCellValue('BG'.$counter, $row->CreatedBy);
            //     $ex->setCellValue('BH'.$counter, $row->CreatedDate);
            // }elseif($export == 'interview'){
            //     $ex->setCellValue('BG'.$counter, $row->CreatedBy);
            //     $ex->setCellValue('BH'.$counter, $row->CreatedDate);
            // }else{
            //     $ex->setCellValue('BG'.$counter, NULL);
            //     $ex->setCellValue('BH'.$counter, NULL);
            // }
            // $counter = $counter+1;
        endforeach;
        
        $objPHPExcel->getActiveSheet()->setTitle('LaporanCalonTenaker');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lap_CalonTenaker('.$blnthn.').xlsx"');
        
        $objWriter->save('php://output');
    }
}