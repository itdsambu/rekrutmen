<?php 

class Datakarantina extends CI_Controller { 

   public function __construct(){
      parent::__construct();
      $this->load->model('M_karantina');
      $this->load->library('session');
      date_default_timezone_set("Asia/Jakarta");
      $this->load->library(array('template','form_validation'));
  }

   public function index() {
      $data['view'] = $this->M_karantina->getAllData();
      $this->template->display('registrasi/karantina/index', $data);
   }

   public function tambahdata() {

      $create_date      = $this->input->post('tanggal_inputan');
      $nama_pemborong   = $this->input->post('nama_pemborong');
      $jumlah_karantina = $this->input->post('jumlah_karantina');
      $id_registrasi    = $this->input->post('id_registrasi');

      $data['pemborong'] = $this->M_karantina->list_pemborong();

      $this->form_validation->set_rules('tanggal_inputan', 'Create Date', 'required');

      if ($this->form_validation->run() == false) {
         echo "<script>alert('Silahkan Input Data Untuk Karantina Calon Tenaga Kerja Baru....!!!! ');</script>";
         $this->template->display('registrasi/karantina/tambah-data', $data);
      } else {
         
         $cek_validasi = $this->M_karantina->check_data($create_date,$nama_pemborong,$jumlah_karantina);
         
         if($create_date <= '2022-04-03' || $nama_pemborong == '' && $jumlah_karantina == ''){
            echo "<script>alert('Anda Tidak Bisa Input Data....!!!! ');</script>";
            $this->template->display('registrasi/karantina/tambah-data');
         }else{
            if (count($cek_validasi) > 0){
              echo "<script>alert('Data Sudah Pernah Disimpann Mohon Cek di monitoring data karantina!!!! ');</script>";
              $this->template->display('registrasi/karantina/tambah-data');
            }else{
              $this->M_karantina->insertData();
              echo "<script>alert('Data berhasil disimpan....!!!! ');</script>";
              redirect('datakarantina');
            }
         }
      }
   }

   public function detail($id) {
      $data['dept'] = $this->session->userdata('dept');
      $data['detail'] = $this->M_karantina->getDetail($id);
      $this->template->display('registrasi/karantina/detail', $data);
   }

   public function editDetail($id) {
      $data['tampilData'] = $this->M_karantina->getDataDetail($id);
      $this->template->display('registrasi/karantina/edit-detail', $data);
   }

   public function updateEditDetail() {
      $this->M_karantina->updateEditDetail();
   }


   public function dataAjax() {
      $reg_id = $this->input->post('reg_id'); 
      $where = array ('HeaderID' => $reg_id);
      $data = $this->M_karantina->getAllTK($where); 
      $res = '';

      if (count($data) == 1) {
         foreach ($data as $dt) {
            $res .= $dt->HeaderID .'//'.  $dt->Nama .'//'. $dt->Jenis_Kelamin .'//'. $dt->CVNama .'//'. $dt->Daerah_Asal;
            
         }
      } else {
         $res .= 'Error';
         
      }

      echo $res;

   }

   public function edit($id) {
      $data['result'] = $this->M_karantina->getDataResult($id);
      $this->template->display('registrasi/karantina/edit-data', $data);
   }

   public function laporan() {
      $data['tampil_laporan'] = $this->M_karantina->getLaporan();
      $this->template->display('registrasi/karantina/laporan', $data);
   }

   public function delete_data($id){
      $id = $this->input->post('header_id');
      $this->M_karantina->deleteData($id);

      echo "<script>alert('Data berhasil dihapus....!!!! ');</script>";
      redirect('datakarantina');
   }

   public function tombolUbahDetail() {
      $id = $this->input->post('id');
      $this->M_karantina->tombolUbah($id);
   }

   public function cetak($id) {
      
      include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
      include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';

      $style1 = [

         'font'      => ['bold'=> true, 'name'=> 'Time New Roman', 'size'=> '14'],
         'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'wrap' =>true,
                         'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER],
   
         'borders'   => [    
                        'top'   => ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis   
                        'right' => ['style'  => PHPExcel_Style_Border::BORDER_THIN],  // Set border right dengan garis tipis    
                        'bottom'=> ['style'  => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis    
                        'left'  => ['style'  => PHPExcel_Style_Border::BORDER_THIN] // Set border left dengan garis tipis  
                        ]
                  ];
      
      $objPHPExcel = new PHPExcel();
      
      $cetak = $this->M_karantina->cetakExcel($id);

      $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
        
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
         $no = 0;
         $ex = $objPHPExcel->setActiveSheetIndex(0);
        foreach ($cetak as $ctk) { $no++;
         $tanggal_kedatangan = date('d-m-Y', strtotime($ctk['tanggal_kedatangan']));
        $objPHPExcel->getActiveSheet()->mergeCells('A2:K2')->setCellValue('A2', 'DAFTAR KARANTINA PERTANGGAL ' . $tanggal_kedatangan)->getStyle('A2:K2')->applyFromArray($style1);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'No.')
                ->setCellValue('B4', 'ID Registrasi')
                ->setCellValue('C4', 'Nama Karyawan')
            ->setCellValue('D4', 'Jenis Kelamin')
                ->setCellValue('E4', 'Perusahaan')
            ->setCellValue('F4', 'Daerah Asal')
            ->setCellValue('G4', 'Tanggal Kedatangan')
            ->setCellValue('H4', 'Tanggal Rapid Test')
            ->setCellValue('I4', 'Tanggal Interview')
            ->setCellValue('J4', 'Alamat Karantina')
            ->setCellValue('K4', 'Tanggal Masuk Karantina')
            ->setCellValue('L4', 'Keterangan')
            ->setCellValue('M4', 'Tanggal Keluar Karantina')
            ->setCellValue('N4', 'Hasil Tes Karantina');
      }

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 5;
        foreach ($cetak as $row){
         $tanggal_kedatangan = date('d-m-Y', strtotime($row['tanggal_kedatangan']));
         $tanggal_rapid = date('d-m-Y', strtotime($row['tanggal_rapid']));
         $tanggal_interview = date('d-m-Y', strtotime($row['tanggal_interview']));
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row['registrasi_id']);
            $ex->setCellValue('C'.$counter, $row['nama_karyawan']);
            $ex->setCellValue('D'.$counter, $row['jenis_kelamin']);
            $ex->setCellValue('E'.$counter, $row['perusahaan']);
            $ex->setCellValue('F'.$counter, $row['daerah_asal']);
            $ex->setCellValue('G'.$counter, $tanggal_kedatangan);
            $ex->setCellValue('H'.$counter, $tanggal_rapid);
            $ex->setCellValue('I'.$counter, $tanggal_interview);
            $ex->setCellValue('J'.$counter, $row['alamat_karantina']);
            $ex->setCellValue('K'.$counter, $row['tgl_masuk_karantina']);
            $ex->setCellValue('L'.$counter, $row['keterangan']);
            $ex->setCellValue('M'.$counter, $row['tgl_klr_karantina']);
            $ex->setCellValue('N'.$counter, $row['hasil_tes_karantina']);
            $counter = $counter+1;
        }
      

      $filename = "Data Karantina".'.xlsx';
      $objPHPExcel->getActiveSheet()->setTitle('Data Karantina');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachement; filename="'.$filename. '"');
      header('Cache-Control: max-age=0');

      $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $writer->save('php://output');
      exit;
   }



}