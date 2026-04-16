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
        
		/*
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
		*/
		$libur = $this->m_transaksi->gettglinputkuota();
		$row = $libur->row();
		$thedate = date_create_from_format('Y-m-d',$row->DateValue);
		$periode = $thedate->format('d-m-Y');
		
        $idpemborong = $this->session->userdata('idpemborong');
        $data['_periode'] = $periode;
        $data['_getdatekuota'] = $this->m_transaksi->getPSGPemborong($idpemborong);
        $this->template->display('transaksi/kouta/index',$data);
    }

    // function saveKouta(){
    //     $data = array(
    //         'Periode'       => $this->input->post('txtPeriode'),
    //         'JmlKouta'      => $this->input->post('txtJmlKouta'),
    //         'BatasInput'    => $this->input->post('txtBatasInput'),
    //         'CVNama'        => $this->input->post('txtPerusahaan'),
    //         'Pemborong'     => $this->input->post('txtPemborong'),
    //         'Status'        => 'UNLOCK',
    //         'CreatedBy'     => strtoupper($this->session->userdata('username')),
    //         'CreatedDate'   => date('Y-m-d H:i:s')
    //     );
    //     $this->load->model('m_transaksi');
    //     $header = $this->m_transaksi->savekouta($data);
    //     if($header['status'] == FALSE){
    //         $this->session->set_flashdata('_message',$header['data']);
    //         redirect(base_url('Transaksi/bypsn?err=header'));
    //         return;
    //     }
    //     $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
    //     redirect(base_url('Transaksi/bypsn?success=ok'));
    // }
    function saveKouta(){
        $periode = date('Y-m-d',strtotime($this->input->post('txtPeriode')));
        $startInput = $this->input->post('txtStartInput');
        $batasInput = $this->input->post('txtBatasInput');

        $idpbr = $this->input->post('txtIDPerusahaan');
        $cv = $this->input->post('txtPerusahaan');
        $pbr = $this->input->post('txtPemborong');
        $KuotaPendidikan = $this->input->post('txtKuotaPendidikan');
        $KuotaNonPendidikan = $this->input->post('txtKuotaNonPendidikan');

        for ($i=0; $i < count($cv) ; $i++) { 
            $data = array(
                'IDPemborong'        => $idpbr[$i],
                'CVNama'             => $cv[$i],
                'Pemborong'          => $pbr[$i],
                'KuotaPendidikan'    => $KuotaPendidikan[$i],
                'KuotaNonPendidikan' => $KuotaNonPendidikan[$i],
                'Periode'            => $periode,
                'StartInput'         => $startInput,
                'BatasInput'         => $batasInput,
                'CreatedBy'          => strtoupper($this->session->userdata('username')),
                'CreatedDate'        => date('Y-m-d H:i:s')
            );
            $this->load->model('m_transaksi');
            $header = $this->m_transaksi->savekouta($data);
        }
        if(!$header){
            $this->session->set_flashdata('_message',$header['data']);
            redirect(base_url('Transaksi/bypsn?err=header'));
            return;
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('Transaksi/bypsn?success=ok'));
    }

    // function saveKuota(){
    //     $periode    = $this->input->post('txtPeriode');
    //     $jmlkuota   = $this->input->post('txtJmlKouta');
    //     $batasinput = $this->input->post('txtBatasInput');
    //     $cv         = $this->input->post('txtPerusahaan');
    //     $pemborong  = $this->input->post('txtPemborong');
    //     $status     = 'UNLOCK';
    //     $createdby  = strtoupper($this->session->userdata('username'));
    //     $createdate = date('Y-m-d H:i:s');

    //     for ($i=0; $i < $cv; $i++) {
    //         $data = array(
    //             'Periode'       => $periode,
    //             'JmlKouta'      => $jmlkuota,
    //             'BatasInput'    => $batasinput,
    //             'CVNama'        => $cv[$i],
    //             'Pemborong'     => $pemborong[$i],
    //             'Status'        => $status,
    //             'CreatedBy'     => $createdby,
    //             'CreatedDate'   => $createdate
    //         );
    //         $this->load->model('m_transaksi');
    //         $result = $this->m_transaksi->savekouta($data);
    //         if($result['status'] == FALSE){
    //             $this->session->set_flashdata('_message',$result['data']);
    //             redirect(base_url('Transaksi/bypsn?err=header'));
    //             return;
    //         }
    //         $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
    //         redirect(base_url('Transaksi/bypsn?success=ok'));
    //     }
    // }

    function list(){
        $libur                     = $this->m_transaksi->gettglinputkuota();
        $row                       = $libur->row();
        $thedate                   = date_create_from_format('Y-m-d',$row->DateValue);
        $periode                   = $thedate->format('d-m-Y');
        $idpemborong               = $this->session->userdata('idpemborong');
        $totalKuotaNonPendidikan   = $this->m_transaksi->getTotalKuotaNonPendidikan($periode,$idpemborong);
        $kuotaNonPendidikanHariIni = $this->m_transaksi->countKuotaBiasaToDay($periode,$idpemborong);
        $sum = $totalKuotaNonPendidikan - $kuotaNonPendidikanHariIni;
        // $data = array(
        //     'kouta'           => $this->m_transaksi->list($periode,$idpemborong),
        //     'dataKouta'       => $this->m_transaksi->listTK($periode,$idpemborong),
        //     '_getDate'        => $periode,
        //     '_getDate'        => $thedate->format('d-m-Y'),
        //     '_totalKuota'     => $this->m_transaksi->getTotalKuotaMedicalPerHari(),
        //     '_kuotaHariIni'   => $this->m_transaksi->countKuotaToDay()
        // );
        $data = array(
            '_getDate'                      => $periode,
            'dataKouta'                     => $this->m_transaksi->listTK($periode,$idpemborong),
            '_totalKuotaBiasaNonPendidikan' => $this->m_transaksi->getTotalKuotaNonPendidikan($periode,$idpemborong),
            '_kuotaNonPendidikanHariIni'    => $this->m_transaksi->countKuotaBiasaToDay($periode,$idpemborong),
            '_StartInput'                   => $this->m_transaksi->mulaiwaktuinputkuotabiasa($periode,$idpemborong),
            '_BatasInput'                   => $this->m_transaksi->bataswaktuinputkuotabiasa($periode,$idpemborong),
            '_sumKuota'                     => $totalKuotaNonPendidikan-$kuotaNonPendidikanHariIni,
            'sum'                           => $totalKuotaNonPendidikan - $kuotaNonPendidikanHariIni
        );
        $this->template->display('transaksi/kouta/list',$data);
    }

    function ajaxlist($id){
        $libur = $this->m_transaksi->gettglinputkuota();
        $row = $libur->row();
        $thedate = date_create_from_format('Y-m-d',$row->DateValue);
        $periode = $thedate->format('d-m-Y');
        $idpemborong       = $this->session->userdata('idpemborong');
        $data['_getDate' ] = $thedate->format('d-m-Y');
        $data['_getDdata'] = $this->m_transaksi->getDataTK($id,$idpemborong);
        $data['_cekDdata'] = $this->m_transaksi->getDataTK($id,$idpemborong);
        $kuota = $this->m_transaksi->getTotalKuotaMedicalPerHari($periode);
        $totalkuota = $this->m_transaksi->countKuotaToDay($periode);
        $data['sum'] = $kuota - $totalkuota;
        $this->load->view('transaksi/kouta/ajaxlist',$data);
    }

  //   function add(){
		// $cek = $this->db->query("SELECT * FROM tblTrnKoutaTK WHERE HeaderID='".$this->input->post('txtFindByid')."' AND Periode='".$this->input->post('txtPeriode')."'")->num_rows();
  //       if($cek<=0){
		// 	$data = array(
		// 		'HeaderID'    => $this->input->post('txtFindByid'),
		// 		'Nama'        => $this->input->post('txtnama'),
		// 		'CVNama'      => $this->input->post('txtcv'),
		// 		'Periode'     => date('Y-m-d',strtotime($this->input->post('txtPeriode'))),
		// 		'CreatedBy'   => strtoupper($this->session->userdata('username')),
		// 		'CreatedDate' => date('Y-m-d H:i:s')
		// 	);
		// 	$this->load->model('m_transaksi');
		// 	$result = $this->m_transaksi->saveTKkouta($data);
		// 	$this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>Data Berhasil Ditambah...!!!</div>');
		// 	redirect('Transaksi/list?msg=success_add','refresh');
		// }else{
		// 	$this->session->set_flashdata('message', 
  //                   '<div class="alert alert-warning alert-dismissible" role="alert">
  //                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
  //                       Mohon Maaf ID REG sudah Terdaftar...!!!
  //                   </div>');
  //               redirect('Transaksi/list?msg=failed_add','refresh');
		// }
  //   }
        function addkuota(){
        $id                        = $this->input->post('txtFindByid');
        $periode                   = $this->input->post('txtPeriode');
        $tgl                       = date('Y-m-d',strtotime($periode));
        $idpemborong               = $this->session->userdata('idpemborong');
        $pendidikan                = $this->input->post('txtpendidikan');
        $cek                       = $this->db->query("SELECT * FROM tblTrnKuotaTK WHERE HeaderID='".$id."' AND Periode=convert(date,'".$periode."',105)")->num_rows();
        $totalKuotaNonPendidikan   = $this->m_transaksi->getTotalKuotaNonPendidikan($tgl,$idpemborong);
        $kuotaNonPendidikanHariIni = $this->m_transaksi->countKuotaBiasaToDay($tgl,$idpemborong);
        $sum                       = $totalKuotaNonPendidikan - $kuotaNonPendidikanHariIni;
        
        if($sum != '0'){
            if($id != 0){
				if($cek<=0){
					$data = array(
						'HeaderID'         => $this->input->post('txtFindByid'),
						'Nama'             => $this->input->post('txtnama'),
						'CVNama'           => $this->input->post('txtcv'),
						'Periode'          => date('Y-m-d',strtotime($this->input->post('txtPeriode'))),
						'StatusPendidikan' => $this->input->post('txtpendidikan'),
						'CreatedBy'        => strtoupper($this->session->userdata('username')),
						'CreatedDate'      => date('Y-m-d H:i:s')
					);
					$this->load->model('m_transaksi');
					$result = $this->m_transaksi->saveTKkouta($data);
					if (!$result) {
						$this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>Data Gagal Ditambah...!!!</div>');
						redirect('Transaksi/list?msg=failed','refresh');
					}else{
						$this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>Data Berhasil Ditambah...!!!</div>');
						redirect('Transaksi/list?msg=success','refresh');
					}
				}else {
					$this->session->set_flashdata('message', 
						'<div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							Mohon Maaf ID REG sudah Terdaftar...!!!
						</div>');
					redirect('Transaksi/list?msg=failed','refresh');
				}
            }else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Mohon Maaf ID tidak Terdaftar...!!!
                    </div>');
                redirect('Transaksi/list?msg=failed','refresh');
            }
        }elseif($sum == '0') {
            $this->session->set_flashdata('message', 
				'<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					ID '.$id.' gagal diinput karna kuota sudah pernuh.
				</div>');
			redirect('Transaksi/list?msg=failed','refresh');
        }

        // if($cek<=0){
        //     $data = array(
        //         'HeaderID'    => $this->input->post('txtFindByid'),
        //         'Nama'        => $this->input->post('txtnama'),
        //         'CVNama'      => $this->input->post('txtcv'),
        //         'Periode'     => date('Y-m-d',strtotime($this->input->post('txtPeriode'))),
        //         'CreatedBy'   => strtoupper($this->session->userdata('username')),
        //         'CreatedDate' => date('Y-m-d H:i:s')
        //     );
        //     $this->load->model('m_transaksi');
        //     $result = $this->m_transaksi->saveTKkouta($data);
        //     $this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>Data Berhasil Ditambah...!!!</div>');
        //     redirect('Transaksi/list?msg=success_add','refresh');
        // }else{
        //     $this->session->set_flashdata('message', 
        //             '<div class="alert alert-warning alert-dismissible" role="alert">
        //                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        //                 Mohon Maaf ID REG sudah Terdaftar...!!!
        //             </div>');
        //         redirect('Transaksi/list?msg=failed_add','refresh');
        // }
    }

    function bypsn(){
		/*
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
		*/
		$libur = $this->m_transaksi->gettglinputkuota();
		$row = $libur->row();
		$thedate = date_create_from_format('Y-m-d',$row->DateValue);
		$periode = $thedate->format('d-m-Y');
		
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
		/*
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
		*/
		$libur = $this->m_transaksi->gettglinputkuota();
		$row = $libur->row();
		$thedate = date_create_from_format('Y-m-d',$row->DateValue);
		$periode = $thedate->format('d-m-Y');
		
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

    function kuotaperhari(){
        $libur = $this->m_transaksi->gettglinputkuota();
        $row = $libur->row();
        $thedate = date_create_from_format('Y-m-d',$row->DateValue);
        $periode = $thedate->format('d-m-Y');
        $data['_getKouta'] = $this->m_transaksi->getKoutaPerHari();
        $data['sisakuota'] = $this->m_transaksi->getsisakuota($periode);
        $this->template->display('transaksi/kouta/kuotaperhari',$data);
    }

    function viewSettingDetail(){
        if('IS_AJAX') {
            $id = $this->input->post('kode');
            $data['setKouta'] = $this->m_transaksi->setKoutaPerHari($id);
            $this->load->view('transaksi/kouta/setKouta',$data);
        }
    }

    function UpdateKuota(){
        $id = $this->input->post('txtID');
        $data = array(
            'Kuota' => $this->input->post('txtKuota'),
			'StartInput'         => date('H:i',strtotime($this->input->post('txtStartInput'))),
            'BatasInput' => $this->input->post('txtBatasInput'),
            'Alert' => $this->input->post('txtAlert')
        );
        // $data = array(
        //     'KuotaPendidikan'    => $this->input->post('txtKuotaPendidikan'),
        //     'KuotaNonPendidikan' => $this->input->post('txtKuotaNonPendidikan'),
        //     'StartInput'         => date('H:i',strtotime($this->input->post('txtStartInput'))),
        //     'BatasInput'         => date('H:i',strtotime($this->input->post('txtBatasInput'))),
        //     'Alert'              => $this->input->post('txtAlert')
        // );
        $result = $this->m_transaksi->updateKoutaPerhari($id,$data);
        if($result['status'] == FALSE){
            $this->session->set_flashdata('_message',$header['data']);
            redirect(base_url('transaksi/kuotaperhari?err=header'));
            return;
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('transaksi/kuotaperhari?success=ok'));
    }

    function listTKkhusus(){
        $libur = $this->m_transaksi->gettglinputkuota();
        $row = $libur->row();
        $thedate = date_create_from_format('Y-m-d',$row->DateValue);
        $periode = $thedate->format('d-m-Y');
        $idpemborong    = $this->session->userdata('idpemborong');
        $kuota = $this->m_transaksi->getTotalKuotaMedicalPerHari($periode);
        $totalkuota = $this->m_transaksi->countKuotaToDay($periode);
        $kuotaPendidikanHariIni    = $this->m_transaksi->countKuotaPendidikanToDay($periode);
        $totalKuotaPendidikan      = $this->m_transaksi->getTotalKuotaPendidikanPerHari($periode);
        $kuotaNonPendidikanHariIni = $this->m_transaksi->countKuotaNonPendidikanToDay($periode);
        $totalKuotaNonPendidikan   = $this->m_transaksi->getTotalKuotaNonPendidikanPerHari($periode);
        $data = array(
            'kouta'           => $this->m_transaksi->list($periode,$idpemborong),
            'dataKouta'       => $this->m_transaksi->listTK($periode,$idpemborong),
            '_getDate'        => $periode,
            // '_getDate'        => $thedate->format('d-m-Y'),
            '_totalKuota'     => $this->m_transaksi->getTotalKuotaMedicalPerHari(),
            '_BatasInput'     => $this->m_transaksi->getBatasInputKuotaMedicalPerHari(),
            '_MsgAlert'       => $this->m_transaksi->getAlertKuotaMedicalPerHari(),
            '_kuotaHariIni'   => $this->m_transaksi->countKuotaToDay($periode),
            '_sumKuota'       => $kuota - $totalkuota,

            '_kuotaPendidikanHariIni'    => $this->m_transaksi->countKuotaPendidikanToDay($periode),
            '_kuotaNonPendidikanHariIni' => $this->m_transaksi->countKuotaNonPendidikanToDay($periode),
            '_totalKuotaPendidikan'      => $this->m_transaksi->getTotalKuotaPendidikanPerHari($periode),
            '_totalKuotaNonPendidikan'   => $this->m_transaksi->getTotalKuotaNonPendidikanPerHari($periode),

            '_StartInput'                => $this->m_transaksi->getStartInputKuotaMedicalPerHari(),

            '_sumKuotaPendidikan'        => $totalKuotaPendidikan - $kuotaPendidikanHariIni,
            '_sumKuotaNonPendidikan'     => $totalKuotaNonPendidikan - $kuotaNonPendidikanHariIni
        );
        if ($this->session->userdata('userid')=='riyan') {
            $this->template->display('transaksi/kouta/inputKuotaKhususModif',$data);
        }else{
            $this->template->display('transaksi/kouta/inputKuotaKhusus',$data);
        }
        
    }

    function addkuotakhusus(){
        $id = $this->input->post('txtFindByid');
        $periode = $this->input->post('txtPeriode');
        $cek = $this->db->query("SELECT * FROM tblTrnKuotaTK WHERE HeaderID='".$id."' AND Periode=convert(date,'".$periode."',105)")->num_rows();
        $kuota = $this->m_transaksi->getTotalKuotaMedicalPerHari($periode);
        $totalkuota = $this->m_transaksi->countKuotaToDay($periode);
        $sum = $kuota - $totalkuota;

        if($sum != '0'){
            if($id != 0){
                if($cek<= 0){
                    $data = array(
                        'HeaderID'    => $this->input->post('txtFindByid'),
                        'Nama'        => $this->input->post('txtnama'),
                        'CVNama'      => $this->input->post('txtcv'),
                        'Periode'     => date('Y-m-d',strtotime($this->input->post('txtPeriode'))),
                        'CreatedBy'   => strtoupper($this->session->userdata('username')),
                        'CreatedDate' => date('Y-m-d H:i:s')
                    );
                    $this->load->model('m_transaksi');
                    $result = $this->m_transaksi->saveTKkouta($data);
                    $this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>Data Berhasil Ditambah...!!!</div>');
                    redirect('Transaksi/listTKkhusus?msg=success','refresh');
                } else {
                    $this->session->set_flashdata('message', 
                        '<div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            Mohon Maaf ID REG sudah Terdaftar...!!!
                        </div>');
                    redirect('Transaksi/listTKkhusus?msg=failed','refresh');
                }
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Mohon Maaf ID REG sudah Terdaftar...!!!
                    </div>');
                redirect('Transaksi/listTKkhusus?msg=failed','refresh');
            }
        } elseif($sum == '0') {
            $this->session->set_flashdata('message', 
                    '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        ID '.$id.' gagal diinput karna kuota sudah pernuh.
                    </div>');
                redirect('Transaksi/listTKkhusus?msg=failed','refresh');
        }

        // if($cek<=0){
        //     $data = array(
        //         'HeaderID'    => $this->input->post('txtFindByid'),
        //         'Nama'        => $this->input->post('txtnama'),
        //         'CVNama'      => $this->input->post('txtcv'),
        //         'Periode'     => date('Y-m-d',strtotime($this->input->post('txtPeriode'))),
        //         'CreatedBy'   => strtoupper($this->session->userdata('username')),
        //         'CreatedDate' => date('Y-m-d H:i:s')
        //     );
        //     $this->load->model('m_transaksi');
        //     $result = $this->m_transaksi->saveTKkouta($data);
        //     $this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>Data Berhasil Ditambah...!!!</div>');
        //     redirect('Transaksi/listTKkhusus?msg=success_add','refresh');
        // }else{
        //     $this->session->set_flashdata('message', 
        //             '<div class="alert alert-warning alert-dismissible" role="alert">
        //                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        //                 Mohon Maaf ID REG sudah Terdaftar...!!!
        //             </div>');
        //         redirect('Transaksi/listTKkhusus?msg=failed_add','refresh');
        // }
    }

    function monkuotakhusus(){
        $libur = $this->m_transaksi->gettglinputkuota();
        $row = $libur->row();
        $thedate = date_create_from_format('Y-m-d',$row->DateValue);
        $periode = $thedate->format('d-m-Y');
        $idpemborong    = $this->session->userdata('idpemborong');
        $data['_getDataKuota'] = $this->m_transaksi->getDataKuotaPerHari($periode);
        $this->template->display('transaksi/kouta/monKuotaKhusus',$data);
    }

    function viewDocs(){
        if('IS_AJAX') {
            $userID=$this->input->post('kode');
            $berkas=$this->input->post('nama');
            $data['_jenisBerkas'] = $berkas;
            $data['_getViewDocs'] = $this->m_transaksi->getDocs($userID);
            $this->load->view('transaksi/kouta/viewDocs',$data);
        }
    }

    function getkuota(){
        $jenis='ALL PEMBORONG';
        $status = 1;
        $dept = 17;
        $data['_getIssue'] = $this->m_transaksi->getTransByStatus($status,$jenis,$dept);
        $this->template->display('transaksi/kouta/getkuota',$data);
    }
}

