<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class ToExcel extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('m_monitor','m_upload_berkas','m_screening','m_blacklist','M_Interview','M_transaksi'));
    }
    
    public function downloadExcel(){
        $this->load->library("Excel/PHPExcel");
        
        $export = $this->input->post('selDataExport');
        // select data from database
        $bln    = $this->input->post('selBulan');
        $thn    = $this->input->post('selTahun');
        $blnthn = $bln."-".$thn;
        
        if($export == 'all'){
            $title  = 'LAPORAN SEMUA CALON TENAGA KERJA BULAN';
            $by     = 'Registered By';
            $dateBy = 'Registered Date';
            $data   = $this->m_monitor->toExcelSemuaLimitMonth($bln, $thn);
        }elseif($export == 'post'){
            $data   = $this->m_monitor->reportPostedLimitDate($bln, $thn);
            $by     = 'Posted By';
            $dateBy = 'Posted Date';
            $title  = 'LAPORAN TENAGA KERJA YANG DIKIRIM, BULAN';
        }else{
            $data   = NULL;
            $title  = NULL;
            $by     = NULL;
            $dateBy = NULL;
        }
        
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $title.' : '.$blnthn)
                
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
                ->setCellValue('BE3', $by)
                ->setCellValue('BF3', $dateBy);
        
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
            
            if($export == 'all'){
                $ex->setCellValue('BE'.$counter, $row->CreatedBy);
                $ex->setCellValue('BF'.$counter, $row->CreatedDate);
            }elseif($export == 'post'){
                $ex->setCellValue('BE'.$counter, $row->PostedBy);
                $ex->setCellValue('BF'.$counter, $row->PostedDate);
            }else{
                $ex->setCellValue('BE'.$counter, NULL);
                $ex->setCellValue('BF'.$counter, NULL);
            }
            $counter = $counter+1;
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
	
	public function downloadExcelCalonKandidat(){
		$this->load->library("Excel/PHPExcel");

		$export = $this->input->post('selDataExport');

		if($export == 'all'){
			$title = 'Calon Kandidat';
			$data = $this->m_monitor->getCalonKandidatExcelAll();
		}elseif($export == 'lulus'){
			$title = 'Calon Kandidat';
			$data = $this->m_monitor->getCalonKandidatExcelLulus();
		}elseif($export == 'tidaklulus'){
			$title = 'Calon Kandidat';
			$data = $this->m_monitor->getCalonKandidatExcelTidakLulus();
		}else{
            $data   = NULL;
            $title  = NULL;
		}
		
		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(43);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(32);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(21);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(53);
        
        //$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true)->setSize(30);
		
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Calon Kandidat PT. PSG')
                
                ->setCellValue('A3', 'No.')
                ->setCellValue('B3', 'Nama')
                ->setCellValue('C3', 'Jenis Kelamin')
                ->setCellValue('D3', 'TTL')
                ->setCellValue('E3', 'No. KTP')
                ->setCellValue('F3', 'No. HP')
                ->setCellValue('G3', 'Email')
                ->setCellValue('H3', 'Pendidikan Akhir')
                ->setCellValue('I3', 'Jurusan')
                ->setCellValue('J3', 'Jadwal Test')
				->setCellValue('K3', 'Status')
				->setCellValue('L3', 'Test')
				->setCellValue('M3', 'Biaya Transport')
				->setCellValue('N3', 'Keterangan');
		
		$ex = $objPHPExcel->setActiveSheetIndex(0);
		$no = 1;
        $counter = 4;
        foreach ($data as $row):
            $ex->setCellValue('A'.$counter, $no++);
			$ex->setCellValue('B'.$counter, $row->Nama);
			if($row->JK == 'L'){
				$ex->setCellValue('C'.$counter, 'Laki-laki');
			}else{
				$ex->setCellValue('C'.$counter, 'Perempuan');
			}
            $ex->setCellValue('D'.$counter, $row->Tempat_Lhr.' - '.$row->Tanggal_Lhr);
            $ex->setCellValue('E'.$counter, $row->NoKTP);
			$ex->setCellValue('F'.$counter, $row->NoHP);
			$ex->setCellValue('G'.$counter, $row->Email);
			$ex->setCellValue('H'.$counter, $row->Pendidikan);
			$ex->setCellValue('I'.$counter, $row->Jurusan);
			$ex->setCellValue('J'.$counter, $row->JadwalTest);
			if($row->Status == 'L'){
				$ex->setCellValue('K'.$counter, 'Lulus');
			}elseif($row->Status == 'TL'){
				$ex->setCellValue('K'.$counter, 'Tidak Lulus');
			}else{
				$ex->setCellValue('K'.$counter, '');
			}
			$ex->setCellValue('L'.$counter, $row->StsTest);
            $ex->setCellValue('M'.$counter, $row->Biaya);
            $ex->setCellValue('N'.$counter, $row->Keterangan);
            $counter = $counter+1;
        endforeach;

		$objPHPExcel->getActiveSheet()->setTitle('LaporanCalonKandidat');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lap_('.$title.').xlsx"');
        
        $objWriter->save('php://output');
	}
	
	public function downloadExcelTenaker(){
        $this->load->library("Excel/PHPExcel");
        
        $export = $this->input->post('selDataExport');
        
        if($export == 'karyawan'){
            $title  = 'KARYAWAN BLACKLIST';
            $data   = $this->m_blacklist->printBlacklistKaryawan();
        }elseif($export == 'tenaker'){
            $data   = $this->m_blacklist->printBlacklistTenaker();
            $title  = 'TENAGA KERJA BLACKLIST';
        }else{
            $data   = NULL;
            $title  = NULL;
        }
        
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(43);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(123);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(24);
        
        //$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true)->setSize(30);
		
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:K2');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'DATA BLACKLIST PT. PSG')
                
                ->setCellValue('A3', 'No.')
                ->setCellValue('B3', 'Photo')
                ->setCellValue('C3', 'Nik')
                ->setCellValue('D3', 'Nama')
                ->setCellValue('E3', 'Perusahaan / CV')
                ->setCellValue('F3', 'Pemborong')
                ->setCellValue('G3', 'Departement')
                ->setCellValue('H3', 'Tanggal Masuk')
                ->setCellValue('I3', 'Tanggal Keluar')
                ->setCellValue('J3', 'Keterangan')
                ->setCellValue('K3', 'Nama Ibu Kandung');
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 4;
        foreach ($data as $row):
            $ex->setCellValue('A'.$counter, $no++);
			if($export == 'karyawan'){
				$ex->setCellValue('B'.$counter, 'dataupload/Blacklist/fd_foto/'.trim($row->NIK).'.jpg');
			}elseif($export == 'tenaker'){
				$ex->setCellValue('B'.$counter, 'dataupload/Blacklist/fd_foto/BORO/'.trim($row->NIK).'.jpg');
			}else{
				$ex->setCellValue('B'.$counter, '');
			}
            $ex->setCellValue('C'.$counter, $row->NIK);
            $ex->setCellValue('D'.$counter, $row->NAMA);
            $ex->setCellValue('E'.$counter, $row->CVNAMA);
            $ex->setCellValue('F'.$counter, $row->PEMBORONG);
            $ex->setCellValue('G'.$counter, $row->DEPT);
			$ex->setCellValue('H'.$counter, date('d M Y', strtotime($row->TGLMASUK)));
			$ex->setCellValue('I'.$counter, date('d M Y', strtotime($row->TGLKELUAR)));
            $ex->setCellValue('J'.$counter, $row->REMARK);
            $ex->setCellValue('K'.$counter, $row->NAMAIBU);
            $counter = $counter+1;
        endforeach;
        
        $objPHPExcel->getActiveSheet()->setTitle('LaporanBlacklist');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lap_('.$title.').xlsx"');
        
        $objWriter->save('php://output');
    }
	
	public function printdrh(){
        $this->load->library("Excel/PHPExcel");
        
        $export = $this->input->post('selDataExport');
        $title  = 'Daftar Riwayat Hidup';
		$id = $this->input->get('id');
        $data   = $this->m_upload_berkas->getdrhID($id);
		
		$kop = new PHPExcel_Style();
		
		$kop->applyFromArray(array
            ('fill'   => array(
                           'type'    => PHPExcel_Style_Fill::FILL_SOLID
                         ),
             'font' => array(
             'bold'    => true,
             'name' => 'Trebuchet MS',
             'size' => 12
             ),
            'numberformat'   => array(
                           'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
            'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                         ),
            'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap'       => true
                           ),
            )
        );
        
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
        
		$objPHPExcel->getActiveSheet()->getStyle('J6')->getNumberFormat()->setFormatCode('0');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(True);
		$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(TRUE)->setSize(15);
		$objPHPExcel->getActiveSheet()->getStyle('C73')->getFont()->setBold(TRUE)->setSize(11);
		//$objPHPExcel->getActiveSheet()->getStyle('A1:S2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A71:B76')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A3:S70')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A1:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A3:J70')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:S2')->getAlignment()->applyFromArray(
         array(
             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
         ));
		$objPHPExcel->getActiveSheet()->getStyle('A71:B76')->getAlignment()->applyFromArray(
         array(
             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
         ));
		        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:S2');
		
		$objPHPExcel->getActiveSheet()->mergeCells('A71:B76');
		$objPHPExcel->getActiveSheet()->mergeCells('C71:E71');
		$objPHPExcel->getActiveSheet()->mergeCells('C72:E72');
		$objPHPExcel->getActiveSheet()->mergeCells('C73:E73');
		$objPHPExcel->getActiveSheet()->mergeCells('A77:S77');
		
		$objPHPExcel->getActiveSheet()->mergeCells('B3:I3');
		$objPHPExcel->getActiveSheet()->mergeCells('B4:I4');
		$objPHPExcel->getActiveSheet()->mergeCells('B5:I5');
		$objPHPExcel->getActiveSheet()->mergeCells('B6:I6');
		$objPHPExcel->getActiveSheet()->mergeCells('B7:I7');
		$objPHPExcel->getActiveSheet()->mergeCells('B8:I8');
		$objPHPExcel->getActiveSheet()->mergeCells('B9:I9');
		$objPHPExcel->getActiveSheet()->mergeCells('B10:I10');
		$objPHPExcel->getActiveSheet()->mergeCells('B11:I11');
		$objPHPExcel->getActiveSheet()->mergeCells('B12:I12');
		$objPHPExcel->getActiveSheet()->mergeCells('B13:I13');
		$objPHPExcel->getActiveSheet()->mergeCells('B14:I14');
		$objPHPExcel->getActiveSheet()->mergeCells('B15:I15');
		$objPHPExcel->getActiveSheet()->mergeCells('B16:I16');
		$objPHPExcel->getActiveSheet()->mergeCells('B17:I17');
		$objPHPExcel->getActiveSheet()->mergeCells('B18:I18');
		$objPHPExcel->getActiveSheet()->mergeCells('B19:I19');
		$objPHPExcel->getActiveSheet()->mergeCells('B20:I20');
		$objPHPExcel->getActiveSheet()->mergeCells('B21:I21');
		$objPHPExcel->getActiveSheet()->mergeCells('B22:I22');
		$objPHPExcel->getActiveSheet()->mergeCells('B23:I23');
		$objPHPExcel->getActiveSheet()->mergeCells('B24:I24');
		$objPHPExcel->getActiveSheet()->mergeCells('B25:I25');
		$objPHPExcel->getActiveSheet()->mergeCells('B26:I26');
		$objPHPExcel->getActiveSheet()->mergeCells('B27:I27');
		$objPHPExcel->getActiveSheet()->mergeCells('B28:I28');
		$objPHPExcel->getActiveSheet()->mergeCells('B29:I29');
		$objPHPExcel->getActiveSheet()->mergeCells('B30:I30');
		$objPHPExcel->getActiveSheet()->mergeCells('B31:I31');
		$objPHPExcel->getActiveSheet()->mergeCells('B32:I32');
		$objPHPExcel->getActiveSheet()->mergeCells('B33:I33');
		$objPHPExcel->getActiveSheet()->mergeCells('B34:I34');
		$objPHPExcel->getActiveSheet()->mergeCells('B35:I35');
		$objPHPExcel->getActiveSheet()->mergeCells('B36:I36');
		$objPHPExcel->getActiveSheet()->mergeCells('B37:I37');
		$objPHPExcel->getActiveSheet()->mergeCells('B38:I38');
		$objPHPExcel->getActiveSheet()->mergeCells('B39:I39');
		$objPHPExcel->getActiveSheet()->mergeCells('B40:I40');
		$objPHPExcel->getActiveSheet()->mergeCells('B41:I41');
		$objPHPExcel->getActiveSheet()->mergeCells('B42:I42');
		$objPHPExcel->getActiveSheet()->mergeCells('B43:I43');
		$objPHPExcel->getActiveSheet()->mergeCells('B44:I44');
		$objPHPExcel->getActiveSheet()->mergeCells('B45:I45');
		$objPHPExcel->getActiveSheet()->mergeCells('B46:I46');
		$objPHPExcel->getActiveSheet()->mergeCells('B47:I47');
		$objPHPExcel->getActiveSheet()->mergeCells('B48:I48');
		$objPHPExcel->getActiveSheet()->mergeCells('B49:I49');
		$objPHPExcel->getActiveSheet()->mergeCells('B50:I50');
		$objPHPExcel->getActiveSheet()->mergeCells('B51:I51');
		$objPHPExcel->getActiveSheet()->mergeCells('B52:I52');
		$objPHPExcel->getActiveSheet()->mergeCells('B53:I53');
		$objPHPExcel->getActiveSheet()->mergeCells('B54:I54');
		$objPHPExcel->getActiveSheet()->mergeCells('B55:I55');
		$objPHPExcel->getActiveSheet()->mergeCells('B56:I56');
		$objPHPExcel->getActiveSheet()->mergeCells('B57:I57');
		$objPHPExcel->getActiveSheet()->mergeCells('B58:I58');
		$objPHPExcel->getActiveSheet()->mergeCells('B59:I59');
		$objPHPExcel->getActiveSheet()->mergeCells('B60:I60');
		$objPHPExcel->getActiveSheet()->mergeCells('B61:I61');
		$objPHPExcel->getActiveSheet()->mergeCells('B62:I62');
		$objPHPExcel->getActiveSheet()->mergeCells('B63:I63');
		$objPHPExcel->getActiveSheet()->mergeCells('B64:I64');
		$objPHPExcel->getActiveSheet()->mergeCells('B65:I65');
		$objPHPExcel->getActiveSheet()->mergeCells('B66:I66');
		$objPHPExcel->getActiveSheet()->mergeCells('B67:I67');
		$objPHPExcel->getActiveSheet()->mergeCells('B68:I68');
		$objPHPExcel->getActiveSheet()->mergeCells('B69:I69');
		$objPHPExcel->getActiveSheet()->mergeCells('B70:I70');
		
		$objPHPExcel->getActiveSheet()->mergeCells('J3:S3');
		$objPHPExcel->getActiveSheet()->mergeCells('J4:S4');
		$objPHPExcel->getActiveSheet()->mergeCells('J5:S5');
		$objPHPExcel->getActiveSheet()->mergeCells('J6:S6');
		$objPHPExcel->getActiveSheet()->mergeCells('J7:S7');
		$objPHPExcel->getActiveSheet()->mergeCells('J8:S8');
		$objPHPExcel->getActiveSheet()->mergeCells('J9:S9');
		$objPHPExcel->getActiveSheet()->mergeCells('J10:S10');
		$objPHPExcel->getActiveSheet()->mergeCells('J11:S11');
		$objPHPExcel->getActiveSheet()->mergeCells('J12:S12');
		$objPHPExcel->getActiveSheet()->mergeCells('J13:S13');
		$objPHPExcel->getActiveSheet()->mergeCells('J14:S14');
		$objPHPExcel->getActiveSheet()->mergeCells('J15:S15');
		$objPHPExcel->getActiveSheet()->mergeCells('J16:S16');
		$objPHPExcel->getActiveSheet()->mergeCells('J17:S17');
		$objPHPExcel->getActiveSheet()->mergeCells('J18:S18');
		$objPHPExcel->getActiveSheet()->mergeCells('J19:S19');
		$objPHPExcel->getActiveSheet()->mergeCells('J20:S20');
		$objPHPExcel->getActiveSheet()->mergeCells('J21:S21');
		$objPHPExcel->getActiveSheet()->mergeCells('J22:S22');
		$objPHPExcel->getActiveSheet()->mergeCells('J23:S23');
		$objPHPExcel->getActiveSheet()->mergeCells('J24:S24');
		$objPHPExcel->getActiveSheet()->mergeCells('J25:S25');
		$objPHPExcel->getActiveSheet()->mergeCells('J26:S26');
		$objPHPExcel->getActiveSheet()->mergeCells('J27:S27');
		$objPHPExcel->getActiveSheet()->mergeCells('J28:S28');
		$objPHPExcel->getActiveSheet()->mergeCells('J29:S29');
		$objPHPExcel->getActiveSheet()->mergeCells('J30:S30');
		$objPHPExcel->getActiveSheet()->mergeCells('J31:S31');
		$objPHPExcel->getActiveSheet()->mergeCells('J32:S32');
		$objPHPExcel->getActiveSheet()->mergeCells('J33:S33');
		$objPHPExcel->getActiveSheet()->mergeCells('J34:S34');
		$objPHPExcel->getActiveSheet()->mergeCells('J35:S35');
		$objPHPExcel->getActiveSheet()->mergeCells('J36:S36');
		$objPHPExcel->getActiveSheet()->mergeCells('J37:S37');
		$objPHPExcel->getActiveSheet()->mergeCells('J38:S38');
		$objPHPExcel->getActiveSheet()->mergeCells('J39:S39');
		$objPHPExcel->getActiveSheet()->mergeCells('J40:S40');
		$objPHPExcel->getActiveSheet()->mergeCells('J41:S41');
		$objPHPExcel->getActiveSheet()->mergeCells('J42:S42');
		$objPHPExcel->getActiveSheet()->mergeCells('J43:S43');
		$objPHPExcel->getActiveSheet()->mergeCells('J44:S44');
		$objPHPExcel->getActiveSheet()->mergeCells('J45:S45');
		$objPHPExcel->getActiveSheet()->mergeCells('J46:S46');
		$objPHPExcel->getActiveSheet()->mergeCells('J47:S47');
		$objPHPExcel->getActiveSheet()->mergeCells('J48:S48');
		$objPHPExcel->getActiveSheet()->mergeCells('J49:S49');
		$objPHPExcel->getActiveSheet()->mergeCells('J50:S50');
		$objPHPExcel->getActiveSheet()->mergeCells('J51:S51');
		$objPHPExcel->getActiveSheet()->mergeCells('J52:S52');
		$objPHPExcel->getActiveSheet()->mergeCells('J53:S53');
		$objPHPExcel->getActiveSheet()->mergeCells('J54:S54');
		$objPHPExcel->getActiveSheet()->mergeCells('J55:S55');
		$objPHPExcel->getActiveSheet()->mergeCells('J56:S56');
		$objPHPExcel->getActiveSheet()->mergeCells('J57:S57');
		$objPHPExcel->getActiveSheet()->mergeCells('J58:S58');
		$objPHPExcel->getActiveSheet()->mergeCells('J59:S59');
		$objPHPExcel->getActiveSheet()->mergeCells('J60:S60');
		$objPHPExcel->getActiveSheet()->mergeCells('J61:S61');
		$objPHPExcel->getActiveSheet()->mergeCells('J62:S62');
		$objPHPExcel->getActiveSheet()->mergeCells('J63:S63');
		$objPHPExcel->getActiveSheet()->mergeCells('J64:S64');
		$objPHPExcel->getActiveSheet()->mergeCells('J65:S65');
		$objPHPExcel->getActiveSheet()->mergeCells('J66:S66');
		$objPHPExcel->getActiveSheet()->mergeCells('J67:O67');
		$objPHPExcel->getActiveSheet()->mergeCells('J68:O68');
		$objPHPExcel->getActiveSheet()->mergeCells('J69:O69');
		$objPHPExcel->getActiveSheet()->mergeCells('J70:O70');
		
		$objPHPExcel->getActiveSheet()->mergeCells('P67:S67');
		$objPHPExcel->getActiveSheet()->mergeCells('P68:S68');
		$objPHPExcel->getActiveSheet()->mergeCells('P69:S69');
		$objPHPExcel->getActiveSheet()->mergeCells('P70:S70');
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A71', 'PHOTO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C71', 'Lampiran dan keterangan');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C72', '- TRANSKIP NILAI');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C73', '-  *) HARUS DIISI');
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A77', 'Demikian Daftar Riwayat Hidup ini saya buat dengan sebenarnya');
		
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P67', 'Diverifikasi');
		
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'DAFTAR RIWAYAT HIDUP')
                ->setCellValue('A3', 'No.')
				->setCellValue('A4', '1.')
				->setCellValue('A5', '2.')
				->setCellValue('A6', '3.')
				->setCellValue('A7', '4.')
				->setCellValue('A8', '5.')
				->setCellValue('A9', '6.')
				->setCellValue('A10', '7.')
				->setCellValue('A11', '8.')
				->setCellValue('A12', '9.')
				->setCellValue('A13', '10.')
				->setCellValue('A14', '11.')
				->setCellValue('A15', '12.')
				->setCellValue('A16', '13.')
				->setCellValue('A17', '14.')
				->setCellValue('A18', '15.')
				->setCellValue('A19', '16.')
				->setCellValue('A20', '17.')
				->setCellValue('A21', '18.')
				->setCellValue('A22', '19.')
				->setCellValue('A23', '20.')
				->setCellValue('A24', '21.')
				->setCellValue('A25', '22.')
				->setCellValue('A26', '23.')
				->setCellValue('A27', '24.')
				->setCellValue('A28', '25.')
				->setCellValue('A29', '26.')
				->setCellValue('A30', '27.')
				->setCellValue('A31', '28.')
				->setCellValue('A32', '29.')
				->setCellValue('A33', '30.')
				->setCellValue('A34', '31.')
				->setCellValue('A35', '32.')
				->setCellValue('A36', '33.')
				->setCellValue('A37', '34.')
				->setCellValue('A38', '35.')
				->setCellValue('A39', '36.')
				->setCellValue('A40', '37.')
				->setCellValue('A41', '38.')
				->setCellValue('A42', '39.')
				->setCellValue('A43', '40.')
				->setCellValue('A44', '41.')
				->setCellValue('A45', '42.')
				->setCellValue('A46', '43.')
				->setCellValue('A47', '44.')
				->setCellValue('A48', '45.')
				->setCellValue('A49', '46.')
				->setCellValue('A50', '47.')
				->setCellValue('A51', '48.')
				->setCellValue('A52', '49.')
				->setCellValue('A53', '50.')
				->setCellValue('A54', '51.')
				->setCellValue('A55', '52.')
				->setCellValue('A56', '53.')
				->setCellValue('A57', '54.')
				->setCellValue('A58', '55.')
				->setCellValue('A59', '56.')
				->setCellValue('A60', '57.')
				->setCellValue('A61', '58.')
				->setCellValue('A62', '59.')
				->setCellValue('A63', '60.')
				->setCellValue('A64', '61.')
				->setCellValue('A65', '62.')
				->setCellValue('A66', '63.')
				->setCellValue('A67', '64.')
				->setCellValue('A68', '65.')
				->setCellValue('A69', '66.')
				->setCellValue('A70', '67.')
				->setCellValue('B3', 'Item')
				->setCellValue('B4', 'Perusahaan *)')
				->setCellValue('B5', 'Nama Lengkap *)')
				->setCellValue('B6', 'Nomor KTP  *)')
				->setCellValue('B7', 'Alamat Sekarang *)')
				->setCellValue('B8', 'RT / RW *)')
				->setCellValue('B9', 'Tinggal Dengan *)')
				->setCellValue('B10', 'Hubungan dengan Calon Pelamar *)')
				->setCellValue('B11', 'Nomor Ponsel / HP *)')
				->setCellValue('B12', 'Tempat Lahir *)')
				->setCellValue('B13', 'Tanggal Lahir *)')
				->setCellValue('B14', 'Jenis Kelamin *)')
				->setCellValue('B15', 'Tinggi Badan *)')
				->setCellValue('B16', 'Berat Badan *)')
				->setCellValue('B17', 'Suku *)')
				->setCellValue('B18', 'Daerah Asal *)')
				->setCellValue('B19', 'Bahasa Daerah *)')
				->setCellValue('B20', 'Agama *)')
				->setCellValue('B21', 'Status Perkawinan *)')
				->setCellValue('B22', 'Nama Suami / Istri *)')
				->setCellValue('B23', 'Tgl Lhr. Suami/Istri *)')
				->setCellValue('B24', 'Pekerjaan Suami/Istri *)')
				->setCellValue('B25', 'Alamat Sekarang Suami/Istri *)')
				->setCellValue('B26', 'Jumlah Anak *)')
				->setCellValue('B27', 'Nama Anak *)')
				->setCellValue('B28', 'Tempat Lhr. naka *)')
				->setCellValue('B29', 'Tgl Lhr. Anak *)')
				->setCellValue('B30', 'Jenis Kelamin . Anak *)')
				->setCellValue('B31', 'Nama Bapak Kandung *)')
				->setCellValue('B32', 'Nama Ibu Kandung *)')
				->setCellValue('B33', 'Pekerjaan Orang Tua *)')
				->setCellValue('B34', 'Jumlah Saudara *)')
				->setCellValue('B35', 'Anak Ke *)')
				->setCellValue('B36', 'Pendidikan Terakhir *)')
				->setCellValue('B37', 'Nama Sekolah *)')
				->setCellValue('B38', 'Jurusan ')
				->setCellValue('B39', 'Tahun Masuk - Tahun Lulus *) ')
				->setCellValue('B40', 'Nilai/IPK *)')
				->setCellValue('B41', 'Pengalaman Kerja  (kalau ada) ')
				->setCellValue('B42', 'Keahlian / Ketrampilan yang dimiliki ')
				->setCellValue('B43', 'Pernah Kerja di Sambu Group *)')
				->setCellValue('B44', 'Bagian / Departemen *)')
				->setCellValue('B45', 'Ada Keluarga / Saudara yang bekerja di PT. PSG *)')
				->setCellValue('B46', 'Jika ada, siapa nama saudara/keluarga Anda tersebut *)')
				->setCellValue('B47', 'Bekerja di Departemen/Bagian apa *)')
				->setCellValue('B48', 'Alamat Saudara anda*)')
				->setCellValue('B49', 'Nomor telephone Saudara anda*)')
				->setCellValue('B50', 'Hobby')
				->setCellValue('B51', 'Kegiatan Ekstra')
				->setCellValue('B52', 'Kegiatan Organisasi')
				->setCellValue('B53', 'Keadaan Fisik *)')
				->setCellValue('B54', 'Pernah Mengidap Penyakit *)')
				->setCellValue('B55', 'Pernah Terlibat Kriminal *)')
				->setCellValue('B56', 'Apakah Anda bertato *)')
				->setCellValue('B57', 'Apakah Anda bertindik *)')
				->setCellValue('B58', 'Bersedia Potong Rambut Pendek (untuk laki-laki) *)')
				->setCellValue('B59', 'Bersedia Diberhentikan Jika Kinerja Dinilai Kurang *)')
				->setCellValue('B60', 'Akun Facebook')
				->setCellValue('B61', 'Akun Twitter atau Instagram')
				->setCellValue('B62', 'Nama Ahli Waris Anda *)')
				->setCellValue('B63', 'Jenis Kelamin Ahli Waris *)')
				->setCellValue('B64', 'Alamat lengkap Ahli Waris *)')
				->setCellValue('B65', 'Hubungan dengan Ahli Waris *)')
				->setCellValue('B66', 'Nomor Telpon / HP Ahli Waris *)')
				->setCellValue('B67', 'Nama Kerabat Terdekat *)')
				->setCellValue('B68', 'Hubungan Kerabat Terdekat *)')
				->setCellValue('B69', 'No. Tlp Kerabat Terdekat *)')
				->setCellValue('B70', 'Alamat Kerabat Terdekat *)')
				->setCellValue('J3', '');;
		$ex = $objPHPExcel->setActiveSheetIndex(0);
        foreach ($data as $row):
				$ex->setCellValue('J4', $row->CVNama);
				$ex->setCellValue('J5', $row->Nama);
				$ex->setCellValue('J6', "'".$row->No_Ktp);
				$ex->setCellValue('J7', $row->Alamat);
				$ex->setCellValue('J8', $row->RT .'/'. $row->RW );
				$ex->setCellValue('J9', $row->TinggalDengan);
				$ex->setCellValue('J10', $row->HubunganDenganTK);
				$ex->setCellValue('J11', "'".$row->NoHP);
				$ex->setCellValue('J12', $row->Tempat_Lahir);
				$ex->setCellValue('J13', date('d-m-Y',strtotime($row->Tgl_Lahir)));
				$ex->setCellValue('J14', $row->Jenis_Kelamin);
				$ex->setCellValue('J15', $row->TinggiBadan.' Cm');
				$ex->setCellValue('J16', $row->BeratBadan.' Kg');
				$ex->setCellValue('J17', $row->Suku);
				$ex->setCellValue('J18', $row->Daerah_Asal);
				$ex->setCellValue('J19', $row->BahasaDaerah);
				$ex->setCellValue('J20', $row->Agama);
				$ex->setCellValue('J21', $row->Status_Personal);
				$ex->setCellValue('J22', $row->NamaSuamiIstri);
				$ex->setCellValue('J23', $row->TglLahirSuamiIstri);
				$ex->setCellValue('J24', $row->PekerjaanSuamiIstri);
				$ex->setCellValue('J25', $row->AlamatSuamiIstri);
				if($row->JumlahAnak == NULL || $row->JumlahAnak =='0'){
					$ex->setCellValue('J26', '-');
				}else{
					$ex->setCellValue('J26', $row->JumlahAnak);
				}
				if($row->NamaAnak == NULL || $row->NamaAnak == ''){
					$ex->setCellValue('J27', '-');
				}else{
					$ex->setCellValue('J27', $row->NamaAnak);
				}
				if($row->TempatLahirAnak == NULL || $row->TempatLahirAnak == ''){
					$ex->setCellValue('J28', '-');
				}else{
					$ex->setCellValue('J28', $row->TempatLahirAnak);
				}
				if($row->TglLahirAnak == NULL || $row->TglLahirAnak == ''){
					$ex->setCellValue('J29', '-');
				}else{
					$ex->setCellValue('J29', $row->TglLahirAnak);
				}
				if($row->JenisKelaminAnak == NULL || $row->JenisKelaminAnak == ''){
					$ex->setCellValue('J30', '-');
				}else{
					$ex->setCellValue('J30', $row->JenisKelaminAnak);
				}
				$ex->setCellValue('J31', $row->NamaBapak);
				$ex->setCellValue('J32', $row->NamaIbuKandung);
				$ex->setCellValue('J33', $row->ProfesiOrangTua);
				$ex->setCellValue('J34', $row->JumlahSaudara. ' Bersaudara');
				$ex->setCellValue('J35', $row->AnakKe);
				$ex->setCellValue('J36', $row->Pendidikan);
				$ex->setCellValue('J37', $row->Universitas);
				$ex->setCellValue('J38', $row->Jurusan);
				$ex->setCellValue('J39', $row->TahunMasuk.' - '.$row->TahunLulus);
				$ex->setCellValue('J40', $row->IPK);
				$ex->setCellValue('J41', $row->PengalamanKerja);
				$ex->setCellValue('J42', $row->Keahlian);
				$ex->setCellValue('J43', $row->PernahKerjaDiSambu);
				$ex->setCellValue('J44', $row->KerjadiBagian);
				if($row->NamaSaudara == NULL || $row->NamaSaudara == ''){
					$ex->setCellValue('J45', 'Tidak Ada');
				}else{
					$ex->setCellValue('J45', 'Ada');
				}
				if($row->NamaSaudara == NULL || $row->NamaSaudara == ''){
					$ex->setCellValue('J46', '-');
				}else{
					$ex->setCellValue('J46', $row->NamaSaudara);
				}
				if($row->DeptSaudata == NULL || $row->DeptSaudata == ''){
					$ex->setCellValue('J47', '-');
				}else{
					$ex->setCellValue('J47', $row->DeptSaudata);
				}
				if($row->AlamatSaudata == NULL || $row->AlamatSaudata == ''){
					$ex->setCellValue('J48', '-');
				}else{
					$ex->setCellValue('J48', $row->AlamatSaudata);
				}
				$ex->setCellValue('J48', $row->AlamatSaudata);
				$ex->setCellValue('J49', '');
				if($row->Hobby == NULL || $row->Hobby == ''){
					$ex->setCellValue('J50', '-');
				}else{
					$ex->setCellValue('J50', $row->Hobby);
				}
				if($row->KegiatanEkstra == NULL || $row->KegiatanEkstra == ''){
					$ex->setCellValue('J51', '-');
				}else{
					$ex->setCellValue('J51', $row->KegiatanEkstra);
				}
				if($row->KegiatanOrganisasi == NULL || $row->KegiatanOrganisasi == ''){
					$ex->setCellValue('J52', '-');
				}else{
					$ex->setCellValue('J52', $row->KegiatanOrganisasi);
				}
				$ex->setCellValue('J53', $row->KeadaanFisik);
				$ex->setCellValue('J54', $row->PernahIdapPenyakit);
				$ex->setCellValue('J55', $row->Kriminal);
				$ex->setCellValue('J56', $row->Bertato);
				$ex->setCellValue('J57', $row->Bertindik);
				$ex->setCellValue('J58', $row->SediaPotongRambut);
				$ex->setCellValue('J59', $row->Sediadiberhentikan);
				if($row->AccountFacebook == NULL || $row->AccountFacebook == ''){
					$ex->setCellValue('J60', '-');
				}else{
					$ex->setCellValue('J60', $row->AccountFacebook);
				}
				if($row->AccountTwitter == NULL || $row->AccountTwitter == ''){
					if($row->AccountTwitter == NULL || $row->AccountTwitter == ''){
						$ex->setCellValue('J61', '-');
					}else{
						$ex->setCellValue('J61', $row->AccountTwitter);
					}
				}else{
					if($row->AccountInstagram == NULL || $row->AccountInstagram == ''){
						$ex->setCellValue('J61', '-');
					}else{
						$ex->setCellValue('J61', $row->AccountInstagram);
					}
				}
				$ex->setCellValue('J62', $row->AhliWaris_Hubungan);
				$ex->setCellValue('J63', "'".$row->AhliWaris_NoHP);
				$ex->setCellValue('J64', $row->AhliWaris_Nama);
				$ex->setCellValue('J65', $row->AhliWaris_Hubungan);
				$ex->setCellValue('J66', "'".$row->AhliWaris_NoHP);
				$ex->setCellValue('J67', $row->Kerabat_Nama);
				$ex->setCellValue('J68', $row->Kerabat_Hubungan);
				$ex->setCellValue('J69', "'".$row->Kerabat_Telepon);
				$ex->setCellValue('J70', $row->Kerabat_Alamat);
				$ex->setCellValue('P68', 'By : '.$row->VerifiedBy);
				$ex->setCellValue('P69', 'Tgl : '.date('d-m-Y',strtotime($row->VerifiedDate)));
				$ex->setCellValue('P70', 'Paraf :');
				$ex->setCellValue('N71', 'Tanggal Data : '.date('d-m-Y',strtotime($row->CreatedDate)));
				$ex->setCellValue('O75', $row->Nama);
				$ex->setCellValue('P76', 'Dibuat Oleh');
		endforeach;
        
		foreach ($data as $row):
		$objPHPExcel->setActiveSheetIndex(0);

		// Menambahkan file gambar pada document excel pada kolom B2
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Photo');
		$objDrawing->setDescription('Photo');
		$objDrawing->setPath('dataupload/foto/'.$row->HeaderID.'.jpg');
		$objDrawing->setHeight(120);
		$objDrawing->setCoordinates('A71'); 
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		endforeach;
		
        $objPHPExcel->getActiveSheet()->setTitle('Daftar Riwayat Hidup');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lap_('.$title.').xlsx"');
        
        $objWriter->save('php://output');
    }
	
	
}