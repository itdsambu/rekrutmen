<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends CI_Controller{
	
    public function __construct(){
        parent::__construct();
        $this->load->model(array('darurat','m_transaksi'));
		$this->load->helper('path');
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        $this->load->library(array('template','form_validation'));
    }


    function kouta(){
        $libur              = $this->m_transaksi->getLibur();
        foreach ($libur as $h) {
            $hr     = $h->Hari;
            $tgl    = $h->tanggal;
            $status = $h->sts;
        }
        //if(($hariini  'Saturday') && ($tanggallibur <> '1')){
        if($status != 0){
            $periode           = date('d-m-Y',strtotime('+2 days'));
        }elseif($status != 1){
            $periode           = date('d-m-Y',strtotime('+1 days'));
        }
        $idpemborong = $this->session->userdata('idpemborong');
        $data['_periode'] = $periode;
        $data['_getPSGPemorong'] = $this->m_transaksi->getPSGPemborong($idpemborong);
        $this->template->display('transaksi/kouta/index',$data);
    }

    function saveKouta(){
        $data = array(
            'Periode'       => $this->input->post('txtPeriode'),
            'JmlKouta'      => $this->input->post('txtJmlKouta'),
            'BatasInput'    => $this->input->post('txtBatasInput'),
            'CVNama'        => $this->input->post('txtPerusahaan'),
            'Pemborong'     => $this->input->post('txtPemborong'),
            'Status'        => 'UNLOCK',
            'CreatedBy'     => strtoupper($this->session->userdata('username')),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );
        $this->load->model('m_transaksi');
        $header = $this->m_transaksi->savekouta($data);
        if($header['status'] == FALSE){
            $this->session->set_flashdata('_message',$header['data']);
            redirect(base_url('Transaksi/bypsn?err=header'));
            return;
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('Transaksi/bypsn?success=ok'));
    }

    function saveKuota(){
        $periode    = $this->input->post('txtPeriode');
        $jmlkuota   = $this->input->post('txtJmlKouta');
        $batasinput = $this->input->post('txtBatasInput');
        $cv         = $this->input->post('txtPerusahaan');
        $pemborong  = $this->input->post('txtPemborong');
        $status     = 'UNLOCK';
        $createdby  = strtoupper($this->session->userdata('username'));
        $createdate = date('Y-m-d H:i:s');

        for ($i=0; $i < $cv; $i++) {
            $data = array(
                'Periode'       => $periode,
                'JmlKouta'      => $jmlkuota,
                'BatasInput'    => $batasinput,
                'CVNama'        => $cv[$i],
                'Pemborong'     => $pemborong[$i],
                'Status'        => $status,
                'CreatedBy'     => $createdby,
                'CreatedDate'   => $createdate
            );
            $this->load->model('m_transaksi');
            $result = $this->m_transaksi->savekouta($data);
            if($result['status'] == FALSE){
                $this->session->set_flashdata('_message',$result['data']);
                redirect(base_url('Transaksi/bypsn?err=header'));
                return;
            }
            $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
            redirect(base_url('Transaksi/bypsn?success=ok'));
        }
    }

    function list(){
        $libur              = $this->m_transaksi->getLibur();
        foreach ($libur as $h) {
            $hr     = $h->Hari;
            $tgl    = $h->tanggal;
            $status = $h->sts;
        }
        //if(($hariini  'Saturday') && ($tanggallibur <> '1')){
        if($status != 0){
            $periode           = date('d-m-Y',strtotime('+2 days'));
        }elseif($status != 1){
            $periode           = date('d-m-Y',strtotime('+1 days'));
        }
        $idpemborong    = $this->session->userdata('idpemborong');
        $data['kouta'] = $this->m_transaksi->list($periode,$idpemborong);
        $data['dataKouta'] = $this->m_transaksi->listTK($periode,$idpemborong);
        $data['_getDate']   = $periode;
        $this->template->display('transaksi/kouta/list',$data);
    }

    function ajaxlist($id){
        $data['_getDdata'] = $this->m_transaksi->getDataTK($id);
        $data['_cekDdata'] = $this->m_transaksi->getDataTK($id);
        $this->load->view('transaksi/kouta/ajaxlist',$data);
    }

    function add(){
		$cek = $this->db->query("SELECT * FROM tblTrnKoutaTK WHERE HeaderID='".$this->input->post('txtFindByid')."' AND Periode='".$this->input->post('txtPeriode')."'")->num_rows();
        if($cek<=0){
			$data = array(
				'HeaderID'    => $this->input->post('txtFindByid'),
				'Nama'        => $this->input->post('txtnama'),
				'CVNama'      => $this->input->post('txtcv'),
				'Periode'     => $this->input->post('txtPeriode'),
				'CreatedBy'   => strtoupper($this->session->userdata('username')),
				'CreatedDate' => date('Y-m-d H:i:s')
			);
			$this->load->model('m_transaksi');
			$result = $this->m_transaksi->saveTKkouta($data);
			$this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>Data Berhasil Ditambah...!!!</div>');
			redirect('Transaksi/list?msg=success_add','refresh');
		}else{
			$this->session->set_flashdata('message', 
                    '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Mohon Maaf ID REG sudah Terdaftar...!!!
                    </div>');
                redirect('Transaksi/list?msg=failed_add','refresh');
		}
    }

    function bypsn(){
		$libur              = $this->m_transaksi->getLibur();
        foreach ($libur as $h) {
            $hr     = $h->Hari;
            $tgl    = $h->tanggal;
            $status = $h->sts;
        }
        //if(($hariini  'Saturday') && ($tanggallibur <> '1')){
        if($status != 0){
            $periode           = date('d-m-Y',strtotime('+2 days'));
        }elseif($status != 1){
            $periode           = date('d-m-Y',strtotime('+1 days'));
        }
        $data['_getKouta'] = $this->m_transaksi->getKouta($periode);
        $this->template->display('transaksi/kouta/bypsn/index',$data);
    }

    function lockKouta(){
        $id = $this->input->get('id');
        $this->load->model('m_transaksi');
        $result = $this->m_transaksi->lockKouta($id);
        if(!$result){
            redirect('transaksi/bypsn?msg=success_lock');
        }else{
            redirect('transaksi/bypsn?msg=failed_lock');
        }
    }

    function unlockKouta(){
        $id = $this->input->get('id');
        $this->load->model('m_transaksi');
        $result = $this->m_transaksi->unlockKouta($id);
        if(!$result){
            redirect('transaksi/bypsn?msg=success_unlock');
        }else{
            redirect('transaksi/bypsn?msg=failed_unlock');
        }
    }

    function editKounta(){
        if('IS_AJAX'){
            $kode = $this->input->post('kode');
            $data['data'] = $this->m_transaksi->get_kouta($kode)->result();
            $this->load->view('transaksi/kouta/bypsn/editKouta',$data);
        }
    }

    function updateKouta(){
        $data = array(
			'JmlKouta'    => $this->input->post('txtJmlKouta',TRUE),
            'BatasInput'  => $this->input->post('txtBatasInput',TRUE)
        );
        $id = $this->input->get('id');
        $result = $this->m_transaksi->updateKouta($id,$data);
        if($result){
            redirect('transaksi/bypsn?msg=success_update');
        } else {
            redirect('transaksi/bypsn?msg=failed_update');
        }
    }

    function listbypsn(){
        $data['_getList']   = $this->m_transaksi->listKoutaTK();
        $this->template->display('transaksi/kouta/bypsn/listkouta',$data);
    }

    function TransAksi(){
        if(isset($_POST['Verifi'])){
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->m_transaksi->DeleteTransTK($checked[$i]);
            }
            redirect(site_url('transaksi/listbypsn'));
        }
    }

    function selectPemborong(){
        $this->load->model('m_register');
        if('IS_AJAX') {
            $data['namapt'] = $this->m_transaksi->getPemborong();
            $this->load->view('transaksi/kouta/perusahaan',$data);
        }
    }

    function listbypbr(){
		$libur              = $this->m_transaksi->getLibur();
        foreach ($libur as $h) {
            $hr     = $h->Hari;
            $tgl    = $h->tanggal;
            $status = $h->sts;
        }
        //if(($hariini  'Saturday') && ($tanggallibur <> '1')){
        if($status != 0){
            $periode           = date('d-m-Y',strtotime('+2 days'));
        }elseif($status != 1){
            $periode           = date('d-m-Y',strtotime('+1 days'));
        }
        $idpemborong    = $this->session->userdata('idpemborong');
        $data['_getPBR'] = $this->m_transaksi->getListPBR($idpemborong,$periode);
        $this->template->display('transaksi/kouta/listbypbr',$data);
    }
	
	public function downloadKuotaPBR(){
        $this->load->library("Excel/PHPExcel");
        
        $export = $this->input->post('selDataExport');
        // select data from database
        // $periode    = date('d-m-Y',strtotime());
        $periode   = $this->input->post('txtPeiode');

        $title  = 'List Kuota TK';
        $data   = $this->m_transaksi->getListperiode($periode);
        
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(36);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
        
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $title.' : '.$periode)
                
                ->setCellValue('A3', 'No.')
                ->setCellValue('B3', 'RegisID')
                ->setCellValue('C3', 'Nama')
                ->setCellValue('D3', 'CVNama')
                ->setCellValue('E3', 'Periode');
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 4;
        foreach ($data as $row):
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->HeaderID);
            $ex->setCellValue('C'.$counter, $row->Nama);
            $ex->setCellValue('D'.$counter, $row->CVNama);
            $ex->setCellValue('E'.$counter, $row->Periode);
            $counter = $counter+1;
        endforeach;
        
        $objPHPExcel->getActiveSheet()->setTitle('LaporanKuotaTK');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LaporanKuotaTK('.$periode.').xls"');
        
        $objWriter->save('php://output');
    }
}

