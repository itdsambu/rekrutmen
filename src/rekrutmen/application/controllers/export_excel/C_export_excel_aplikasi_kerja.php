<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class C_export_excel_aplikasi_kerja extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_wawancara'));
    }

    public function exportxls()
    {
        // $this->load->library("Excel/PHPExcel");
        $this->load->model(array('M_monitor'));  //
        $style = $this->excelStyle();

        // print_r($style['PTStyle']);
        // die; 


        $id = $this->uri->segment(4);
        $dt_detail = $this->M_monitor->getDataTenagaKerjaNew($id);
        $get_data_anak = $this->M_monitor->getDataAnak($id);
        $get_data_pendidikan = $this->M_monitor->getDataPendidikan($id);
        $get_data_saudara = $this->M_monitor->getDataSaudara($id);
        // print_r($get_data_anak[0]->DetailID);
        // die;

        foreach ($dt_detail as $dt) {
            $perusahaan = $dt->CVNama;
            $nama_lengkap = $dt->Nama;
            $nomor_ktp = $dt->No_Ktp;
            $alamat_sekarang = $dt->Alamat;
            $rt_rw = $dt->RT . ' / ' . $dt->RW;
            $tinggal_dengan = $dt->TinggalDengan;
            $hub_dengan_calon_pelamar = $dt->HubunganDenganTK;
            $hp = '+62' . substr($dt->NoHP, 1);
            $tempat_lahir = $dt->Tempat_Lahir;
            $tanggal_lahir = date('d-m-Y',  strtotime($dt->Tgl_Lahir));
            $jekel = $dt->Jenis_Kelamin == 'M' ||  $dt->Jenis_Kelamin == 'LAKI-LAKI'  ? 'Laki-laki' : 'Perempuan';
            $tinggi_badan = $dt->TinggiBadan . ' cm';
            $berat_badan = $dt->BeratBadan . ' kg';
            $suku = $dt->Suku;
            $daerah_asal = $dt->Daerah_Asal;
            $bahasa_daerah = $dt->BahasaDaerah;
            $agama = $dt->Agama;
            $status_perkawinan = $dt->Status_Personal;
            $nama_suami_istri = $dt->NamaSuamiIstri == NULL ? 'Tidak Beristri/Bersuami' : ucwords(strtolower($dt->NamaSuamiIstri));
            $tgl_lahir_suami_istri = $dt->TglLahirSuamiIstri ? date('d-m-Y',  strtotime($dt->TglLahirSuamiIstri)) : '';
            $pekerjaan_suamiistri = $dt->PekerjaanSuamiIstri == NULL ? 'Tidak Beristri/Bersuami' : ucwords(strtolower($dt->PekerjaanSuamiIstri));
            $alamat_suamiistri = $dt->AlamatSuamiIstri;
            $jumlah_anak = $dt->JumlahAnak;
            $nama_anak = '';
            $tempat_lahir_anak = '';
            $tanggal_lahir_anak = '';
            $jekel_anak = '';
            $nama_bapak = $dt->NamaBapak;
            $nama_ibu = $dt->NamaIbuKandung;
            $pekerjaan_ortu = $dt->ProfesiOrangTua;
            $jumlah_sudara = $dt->JumlahSaudara;
            $anak_ke = $dt->AnakKe;
            $pendidikan_terakhir = $dt->Pendidikan;
            $nama_sekolah = $dt->Universitas;
            $jurusan = $dt->Jurusan;
            $tahun_masuk = $dt->TahunMasuk . ' - ' . $dt->TahunLulus;
            $ipk = $dt->IPK;
            $pengalaman_kerja = $dt->PengalamanKerja;
            $keahlian = $dt->Keahlian;
            $PernahKerjaDiSambu = $dt->PernahKerjaDiSambu;
            $bagian = $dt->KerjadiBagian;
            $ada_keluarga = '';
            $nama_keluarga_jika_ada = '';
            $bekerja_di_departemen_apa = '';
            $alamat_saudara = '';
            $nohp_saudara = '+62' . substr($dt->Kerabat_Telepon, 1);
            $hobby = $dt->Hobby;
            $kegiatan_extra = $dt->KegiatanEkstra;
            $kegiatan_organisasi = $dt->KegiatanOrganisasi;
            $keadaan_fisik = $dt->KeadaanFisik;
            $idap_penyakit = $dt->PernahIdapPenyakit;
            $kriminal = $dt->Kriminal;
            $bertato = $dt->Bertato;
            $bertindik = $dt->Bertindik;
            $potong_rambut = $dt->SediaPotongRambut;
            $sedia_hentikan = $dt->Sediadiberhentikan;
            $akun_facebook = 'http://facebook.com/' . $dt->AccountFacebook;
            $akun_twitter = 'http://twitter.com/' . $dt->AccountTwitter;
            // $instagram = '';
            $nama_ahli_waris = $dt->AhliWaris_Nama;
            $jekel_ahli_waris = $dt->AhliWaris_Jekel;
            $alamat_ahli_waris = $dt->AhliWaris_Alamat;
            $hubungan_ahli_waris = $dt->AhliWaris_Hubungan;
            $nohp_ahli_waris = '+62' . substr($dt->AhliWaris_NoHP, 1);
            $nama_kerabat = $dt->Kerabat_Nama;
            $hubung_kerabat = $dt->Kerabat_Hubungan;
            $hp_kerabat = '+62' . substr($dt->Kerabat_Telepon, 1);
            $alamat_kerabat = '';
        }


        $item = [
            [
                'item' => 'Perusahaan',
                'value' => $perusahaan,
            ],
            [
                'item' => 'Nama Lengkap',
                'value' => $nama_lengkap,
            ],
            [
                'item' => 'Nomor KTP',
                'value' => $nomor_ktp,
            ],
            [
                'item' => 'Alamat Sekarang',
                'value' => $alamat_sekarang,
            ],
            [
                'item' => 'RT / RW',
                'value' => $rt_rw,
            ],
            [
                'item' => 'Tinggal Dengan',
                'value' => $tinggal_dengan,
            ],
            [
                'item' => 'Hubungan dengan Calon Pelamar',
                'value' => $hub_dengan_calon_pelamar,
            ],
            [
                'item' => 'Nomor Ponsel / HP',
                'value' => $hp,
            ],
            [
                'item' => 'Tempat Lahir',
                'value' => $tempat_lahir,
            ],
            [
                'item' => 'Tanggal Lahir',
                'value' => $tanggal_lahir,
            ],
            [
                'item' => 'Jenis Kelamin',
                'value' => $jekel,
            ],
            [
                'item' => 'Tinggi Badan',
                'value' => $tinggi_badan,
            ],
            [
                'item' => 'Berat Badan',
                'value' => $berat_badan,
            ],
            [
                'item' => 'Suku',
                'value' => $suku,
            ],
            [
                'item' => 'Daerah Asal',
                'value' => $daerah_asal,
            ],
            [
                'item' => 'Bahasa Daerah',
                'value' => $bahasa_daerah,
            ],
            [
                'item' => 'Agama',
                'value' => $agama,
            ],
            [
                'item' => 'Status Perkawinan',
                'value' => $status_perkawinan,
            ],
            [
                'item' => 'Nama Suami / Istri',
                'value' => $nama_suami_istri,
            ],
            [
                'item' => 'Tanggal Lahir Suami/Istri',
                'value' => $tgl_lahir_suami_istri,
            ],
            [
                'item' => 'Pekerjaan Suami/Istri',
                'value' => $pekerjaan_suamiistri,
            ],
            [
                'item' => 'Alamat Sekarang Suami/Istri',
                'value' => $alamat_suamiistri,
            ],
            [
                'item' => 'Jumlah Anak',
                'value' => $jumlah_anak,
            ],
            [
                'item' => 'Nama Anak',
                'value' => $nama_anak,
            ],
            [
                'item' => 'Tempat Lahir Anak',
                'value' => $tempat_lahir_anak,
            ],
            [
                'item' => 'Tanggal Lahir Anak',
                'value' => $tanggal_lahir_anak,
            ],
            [
                'item' => 'Jenis Kelamin Anak',
                'value' => $jekel_anak,
            ],
            [
                'item' => 'Nama Bapak Kandung',
                'value' => $nama_bapak,
            ],
            [
                'item' => 'Nama Ibu Kandung',
                'value' => $nama_ibu,
            ],
            [
                'item' => 'Pekerjaan Orang Tua',
                'value' => $pekerjaan_ortu,
            ],
            [
                'item' => 'Jumlah Saudara',
                'value' => $jumlah_sudara,
            ],
            [
                'item' => 'Anak Ke',
                'value' => $anak_ke,
            ],
            [
                'item' => 'Pendidikan Terakhir',
                'value' => $pendidikan_terakhir,
            ],
            [
                'item' => 'Nama Sekolah',
                'value' => $nama_sekolah,
            ],
            [
                'item' => 'Jurusan',
                'value' => $jurusan,
            ],
            [
                'item' => 'Tahun Masuk - Tahun Lulus',
                'value' => $tahun_masuk,
            ],
            [
                'item' => 'Nilai/IPK',
                'value' => $ipk,
            ],
            [
                'item' => 'Pengalaman Kerja',
                'value' => $pengalaman_kerja,
            ],
            [
                'item' => 'Keahlian / Ketrampilan yang Dimiliki',
                'value' => $keahlian,
            ],
            [
                'item' => 'Pernah Kerja di Sambu Group',
                'value' => $PernahKerjaDiSambu,
            ],
            [
                'item' => 'Bagian / Departemen',
                'value' => $bagian,
            ],
            [
                'item' => 'Ada Keluarga / Saudara yang bekerja di PT. PSG',
                'value' => $ada_keluarga,
            ],
            [
                'item' => 'Jika ada, siapa nama saudara/keluarga Anda tersebut',
                'value' => $nama_keluarga_jika_ada,
            ],
            [
                'item' => 'Bekerja di Departemen/Bagian apa',
                'value' => $bekerja_di_departemen_apa,
            ],
            [
                'item' => 'Alamat Saudara',
                'value' => $alamat_saudara,
            ],
            [
                'item' => 'Nomor Telepon Saudara',
                'value' => $nohp_saudara,
            ],
            [
                'item' => 'Hobby',
                'value' => $hobby,
            ],
            [
                'item' => 'Kegiatan Ekstra',
                'value' => $kegiatan_extra,
            ],
            [
                'item' => 'Kegiatan Organisasi',
                'value' => $kegiatan_organisasi,
            ],
            [
                'item' => 'Keadaan Fisik',
                'value' => $keadaan_fisik,
            ],
            [
                'item' => 'Pernah Mengidap Penyakit',
                'value' => $idap_penyakit,
            ],
            [
                'item' => 'Pernah Terlibat Kriminal',
                'value' => $kriminal,
            ],
            [
                'item' => 'Apakah Anda Bertato',
                'value' => $bertato,
            ],
            [
                'item' => 'Apakah Anda Bertindik',
                'value' => $bertindik,
            ],
            [
                'item' => 'Bersedia Potong Rambut Pendek (untuk laki-laki)',
                'value' => $potong_rambut,
            ],
            [
                'item' => 'Bersedia Diberhentikan Jika Kinerja Dinilai Kurang',
                'value' => $sedia_hentikan,
            ],
            [
                'item' => 'Akun Facebook',
                'value' => $akun_facebook,
            ],
            [
                'item' => 'Akun Twitter atau Instagram',
                'value' => $akun_twitter,
            ],
            [
                'item' => 'Nama Ahli Waris',
                'value' => $nama_ahli_waris,
            ],
            [
                'item' => 'Jenis Kelamin Ahli Waris',
                'value' => $jekel_ahli_waris,
            ],
            [
                'item' => 'Alamat Lengkap Ahli Waris',
                'value' => $alamat_ahli_waris,
            ],
            [
                'item' => 'Hubungan dengan Ahli Waris',
                'value' => $hubungan_ahli_waris,
            ],
            [
                'item' => 'Nomor Telpon / HP Ahli Waris',
                'value' => $nohp_ahli_waris,
            ],
            [
                'item' => 'Nama Kerabat Terdekat',
                'value' => $nama_kerabat,
            ],
            [
                'item' => 'Hubungan Kerabat Terdekat',
                'value' => $hubung_kerabat,
            ],
            [
                'item' => 'No. Tlp Kerabat Terdekat',
                'value' => $hp_kerabat,
            ],
            [
                'item' => 'Alamat Kerabat Terdekat',
                'value' => $alamat_kerabat,
            ],
            // ... teruskan dengan item lainnya sesuai kebutuhan Anda
        ];

        // $objPHPExcel = new PHPExcel();
        $objPHPExcel = new Spreadsheet();

        // Membuat sheet pertama
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('APLIKASI KERJA');
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(2.5);

        // Mengatur orientasi halaman dan ukuran kertas
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setRight(0.5);
        $sheet->getPageMargins()->setBottom(0.5);
        $sheet->getPageMargins()->setTop(0.1);
        $sheet->getPageSetup()->setScale(90);

        // $sheet->getPageSetup()->setFitToWidth(1);
        // $sheet->getPageSetup()->setFitToHeight(0);

        $sheet->getStyle(3)->getFont()->setBold(true);

        // Mengatur tinggi baris 
        $sheet->getRowDimension(2)->setRowHeight(27.75);
        $sheet->getRowDimension(3)->setRowHeight(18);
        $sheet->getRowDimension(5)->setRowHeight(7.50);
        $sheet->getRowDimension(7)->setRowHeight(54.75);

        $sheet->getColumnDimension('D')->setWidth(2.86);


        // Menambahkan gambar ke sheet aktif
        $objDrawing = new Drawing();
        $objDrawing->setPath('assets/images/logo_terbaru.png');
        $objDrawing->setWidthAndHeight(50, 50);

        // Mengatur worksheet untuk gambar
        $objDrawing->setWorksheet($sheet);


        // Mengatur posisi gambar
        $start_row = 1;  // Misalkan gambar dimulai dari baris 1, sesuaikan sesuai kebutuhan Anda
        $objDrawing->setCoordinates('B' . ($start_row + 1))->setOffsetX(-6)->setOffsetY(3);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($start_row + 1) . ':D' . ($start_row + 2));
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($start_row + 1) . ':AC' . ($start_row + 2))->setCellValue('E' . ($start_row + 1), 'PT PULAU SAMBU');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($start_row + 3) . ':D' . ($start_row + 3))->setCellValue('A' . ($start_row + 3), 'JUDUL');
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($start_row + 3) . ':AC' . ($start_row + 3))->setCellValue('E' . ($start_row + 3), 'APLIKASI KERJA');

        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($start_row + 1) . ':AF' . ($start_row + 1))->setCellValue('AD' . ($start_row + 1), 'DOK');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($start_row + 1) . ':AL' . ($start_row + 1))->setCellValue('AG' . ($start_row + 1), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($start_row + 2) . ':AF' . ($start_row + 2))->setCellValue('AD' . ($start_row + 2), 'TGL');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($start_row + 2) . ':AL' . ($start_row + 2))->setCellValue('AG' . ($start_row + 2), ': ' . date('d-m-Y'));
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($start_row + 3) . ':AF' . ($start_row + 3))->setCellValue('AD' . ($start_row + 3), 'HLM');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($start_row + 3) . ':AL' . ($start_row + 3))->setCellValue('AG' . ($start_row + 3), ': 1 dari 3');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($start_row + 1) . ':D' . ($start_row + 2))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('E' . ($start_row + 1) . ':AC' . ($start_row + 2))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('E' . ($start_row + 3) . ':AC' . ($start_row + 3))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($start_row + 3) . ':D' . ($start_row + 3))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($start_row + 1) . ':AF' . ($start_row + 1))->applyFromArray($style['headerStyleLeftBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($start_row + 2) . ':AF' . ($start_row + 2))->applyFromArray($style['headerStyleLeftBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($start_row + 3) . ':AF' . ($start_row + 3))->applyFromArray($style['headerStyleLeftBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . ($start_row + 1) . ':AL' . ($start_row + 1))->applyFromArray($style['headerStyleRightBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . ($start_row + 2) . ':AL' . ($start_row + 2))->applyFromArray($style['headerStyleRightBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . ($start_row + 3) . ':AL' . ($start_row + 3))->applyFromArray($style['headerStyleRightBottomTop']);

        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($start_row + 1) . ':AL' . ($start_row + 3))->applyFromArray($style['headerStyleRight']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($start_row + 1) . ':A' . ($start_row + 3))->applyFromArray($style['headerStyleLeft']);

        $header_row = $start_row + 3;

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 0) . ':A' . ($header_row + 25))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 0) . ':AL' . ($header_row + 25))->applyFromArray($style['headerStyleRight']);

        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($header_row + 1) . ':AL' . ($header_row + 1));
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 2) . ':G' . ($header_row + 2))->setCellValue('A' . ($header_row + 2), 'Referensi dari :');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 2) . ':Q' . ($header_row + 2))->setCellValue('H' . ($header_row + 2), '');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($header_row + 2) . ':AI' . ($header_row + 2))->setCellValue('AD' . ($header_row + 2), 'PHOTO');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($header_row + 3) . ':AI' . ($header_row + 5))->setCellValue('AD' . ($header_row + 3), '3 x 4');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 5) . ':S' . ($header_row + 5))->setCellValue('A' . ($header_row + 5), 'TULISLAH DENGAN HURUF CETAK !');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 7) . ':AL' . ($header_row + 7))->setCellValue('A' . ($header_row + 7), '1. DATA PRIBADI');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 9) . ':G' . ($header_row + 9))->setCellValue('B' . ($header_row + 9), 'Nama lengkap');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 9) . ':H' . ($header_row + 9))->setCellValue('H' . ($header_row + 9), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 9) . ':AK' . ($header_row + 9))->setCellValue('I' . ($header_row + 9),  $nama_lengkap);

        for ($i = 14; $i <= 28; $i++) {
            if ($i % 2 == 0) {
                $sheet->getRowDimension($i)->setRowHeight(3.0);
            }
        }
        $sheet->getRowDimension(29)->setRowHeight(3.0);

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 11) . ':I' . ($header_row + 11))->setCellValue('B' . ($header_row + 11), 'Tempat /Tanggal lahir');
        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($header_row + 11) . ':J' . ($header_row + 11))->setCellValue('J' . ($header_row + 11), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('K' . ($header_row + 11) . ':Q' . ($header_row + 11))->setCellValue('K' . ($header_row + 11),  $tempat_lahir);
        $objPHPExcel->getActiveSheet()->mergeCells('R' . ($header_row + 11) . ':Y' . ($header_row + 11))->setCellValue('R' . ($header_row + 11), $tanggal_lahir);
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 11) . ':AC' . ($header_row + 11))->setCellValue('AA' . ($header_row + 11), 'Umur');

        // Mengubah string tanggal lahir menjadi objek DateTime
        $tanggal_lahir_obj = DateTime::createFromFormat('d-m-Y', $tanggal_lahir);

        // Mendapatkan tanggal saat ini sebagai objek DateTime
        $tanggal_saat_ini = new DateTime();

        // Menghitung selisih antara tanggal saat ini dan tanggal lahir
        $selisih = $tanggal_saat_ini->diff($tanggal_lahir_obj);

        // Mengambil selisih tahun saja
        $umur = $selisih->y;
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($header_row + 11) . ':AF' . ($header_row + 11))->setCellValue('AD' . ($header_row + 11), $umur);
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($header_row + 11) . ':AK' . ($header_row + 11))->setCellValue('AG' . ($header_row + 11), 'Tahun');

        $objPHPExcel->getActiveSheet()->getStyle('H' . ($header_row + 2) . ':Q' . ($header_row + 2))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($header_row + 2) . ':AI' . ($header_row + 5))->applyFromArray($style['bodyStylewithDot']);
        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 9) . ':AK' . ($header_row + 9))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('K' . ($header_row + 11) . ':Q' . ($header_row + 11))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('R' . ($header_row + 11) . ':Y' . ($header_row + 11))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($header_row + 11) . ':AF' . ($header_row + 11))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 7) . ':AL' . ($header_row + 7))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 7) . ':A' . ($header_row + 7))->getAlignment()->setHorizontal('PHPExcel_Style_Alignment::HORIZONTAL_LEFT');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':F' . ($header_row + 2))->getFont()->setSize('12')->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 5) . ':A' . ($header_row + 5))->getFont()->setSize('12')->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 7) . ':A' . ($header_row + 7))->getFont()->setSize('12')->setBold(true);




        // print_r($jekel);
        // die;

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 13) . ':G' . ($header_row + 13))->setCellValue('B' . ($header_row + 13), 'Jenis kelamin');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 13) . ':H' . ($header_row + 13))->setCellValue('H' . ($header_row + 13), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 13) . ':I' . ($header_row + 13))->setCellValue('I' . ($header_row + 13), $jekel == 'Laki-laki' ? '✓' : '');
        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($header_row + 13) . ':L' . ($header_row + 13))->setCellValue('J' . ($header_row + 13), 'Laki-Laki');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 13) . ':M' . ($header_row + 13))->setCellValue('M' . ($header_row + 13), $jekel == 'Perempuan' ? '✓' : '');
        $objPHPExcel->getActiveSheet()->mergeCells('N' . ($header_row + 13) . ':Q' . ($header_row + 13))->setCellValue('N' . ($header_row + 13), 'Perempuan');
        $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + 13) . ':Y' . ($header_row + 13))->setCellValue('S' . ($header_row + 13), 'WNI/WNA/Keturunan');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($header_row + 13) . ':Z' . ($header_row + 13))->setCellValue('Z' . ($header_row + 13), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 13) . ':AK' . ($header_row + 13))->setCellValue('AA' . ($header_row + 13), '');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 15) . ':G' . ($header_row + 15))->setCellValue('B' . ($header_row + 15), 'Agama');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 15) . ':H' . ($header_row + 15))->setCellValue('H' . ($header_row + 15), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 15) . ':Q' . ($header_row + 15))->setCellValue('I' . ($header_row + 15), $agama);
        $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + 15) . ':Y' . ($header_row + 15))->setCellValue('S' . ($header_row + 15), 'Suku');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($header_row + 15) . ':Z' . ($header_row + 15))->setCellValue('Z' . ($header_row + 15), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 15) . ':AK' . ($header_row + 15))->setCellValue('AA' . ($header_row + 15), $suku);

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 17) . ':G' . ($header_row + 17))->setCellValue('B' . ($header_row + 17), 'Status ');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 17) . ':H' . ($header_row + 17))->setCellValue('H' . ($header_row + 17), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 17) . ':I' . ($header_row + 17))->setCellValue('I' . ($header_row + 17), $status_perkawinan == 'NIKAH' ? '✓' : '');
        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($header_row + 17) . ':L' . ($header_row + 17))->setCellValue('J' . ($header_row + 17), 'Kawin');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 17) . ':M' . ($header_row + 17))->setCellValue('M' . ($header_row + 17), $status_perkawinan != 'NIKAH' ? '✓' : '');
        $objPHPExcel->getActiveSheet()->mergeCells('N' . ($header_row + 17) . ':Q' . ($header_row + 17))->setCellValue('N' . ($header_row + 17), 'Belum Kawin');
        $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + 17) . ':Y' . ($header_row + 17))->setCellValue('S' . ($header_row + 17), 'Bahasa yang dikuasai');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($header_row + 17) . ':Z' . ($header_row + 17))->setCellValue('Z' . ($header_row + 17), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 17) . ':AK' . ($header_row + 17))->setCellValue('AA' . ($header_row + 17), 'Indonesia, ' . $bahasa_daerah);

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 19) . ':G' . ($header_row + 19))->setCellValue('B' . ($header_row + 19), 'Alamat dalam kota ');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 19) . ':H' . ($header_row + 19))->setCellValue('H' . ($header_row + 19), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 19) . ':R' . ($header_row + 19))->setCellValue('I' . ($header_row + 19), $alamat_sekarang);
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 19) . ':Y' . ($header_row + 19))->setCellValue('T' . ($header_row + 19), 'Alamat Luar Kota');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($header_row + 19) . ':Z' . ($header_row + 19))->setCellValue('Z' . ($header_row + 19), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 19) . ':AK' . ($header_row + 19))->setCellValue('AA' . ($header_row + 19), '');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 21) . ':R' . ($header_row + 21))->setCellValue('B' . ($header_row + 21), '');
        $objPHPExcel->getActiveSheet()->mergeCells('U' . ($header_row + 21) . ':AK' . ($header_row + 21))->setCellValue('U' . ($header_row + 21), '');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 23) . ':G' . ($header_row + 23))->setCellValue('B' . ($header_row + 23), 'No Telp / HP ');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 23) . ':H' . ($header_row + 23))->setCellValue('H' . ($header_row + 23), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 23) . ':R' . ($header_row + 23))->setCellValue('I' . ($header_row + 23), $hp);
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 23) . ':Y' . ($header_row + 23))->setCellValue('T' . ($header_row + 23), 'No Telp / HP ');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($header_row + 23) . ':Z' . ($header_row + 23))->setCellValue('Z' . ($header_row + 23), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 23) . ':AK' . ($header_row + 23))->setCellValue('AA' . ($header_row + 23), '');

        $objPHPExcel->getActiveSheet()->getStyle('H' . ($header_row + 2) . ':Q' . ($header_row + 2))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 13) . ':I' . ($header_row + 13))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 13) . ':I' . ($header_row + 13))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('M' . ($header_row + 13) . ':M' . ($header_row + 13))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AA' . ($header_row + 13) . ':AK' . ($header_row + 13))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 15) . ':Q' . ($header_row + 15))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AA' . ($header_row + 15) . ':AK' . ($header_row + 15))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 17) . ':I' . ($header_row + 17))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('M' . ($header_row + 17) . ':M' . ($header_row + 17))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AA' . ($header_row + 17) . ':AK' . ($header_row + 17))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 19) . ':R' . ($header_row + 19))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AA' . ($header_row + 19) . ':AK' . ($header_row + 19))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 21) . ':R' . ($header_row + 21))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('U' . ($header_row + 21) . ':AK' . ($header_row + 21))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 23) . ':R' . ($header_row + 23))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 23) . ':AK' . ($header_row + 23))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 23) . ':AK' . ($header_row + 23))->applyFromArray($style['bodyStyle']);

        for ($i = 30; $i <= 45; $i++) {
            if ($i % 2 != 0) {
                $sheet->getRowDimension($i)->setRowHeight(3.0);
            }
        }

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 26) . ':AC' . ($header_row + 26))->setCellValue('B' . ($header_row + 26), 'Bila dalam keadaan mendesak/ darurat kami dari perusahaan dapat menghubungi :');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 28) . ':G' . ($header_row + 28))->setCellValue('B' . ($header_row + 28), 'Nama');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 28) . ':H' . ($header_row + 28))->setCellValue('H' . ($header_row + 28), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 28) . ':Q' . ($header_row + 28))->setCellValue('I' . ($header_row + 28), $nama_suami_istri == 'Tidak Beristri/Bersuami' ? $nama_suami_istri : ($nama_ibu != '' ? $nama_ibu : ($nama_bapak != '' ? $nama_bapak : '')));
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 28) . ':Y' . ($header_row + 28))->setCellValue('T' . ($header_row + 28), 'Hubungan');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($header_row + 28) . ':Z' . ($header_row + 28))->setCellValue('Z' . ($header_row + 28), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 28) . ':AK' . ($header_row + 28))->setCellValue('AA' . ($header_row + 28), $nama_suami_istri == 'Tidak Beristri/Bersuami' ? 'Suami / Istri ' : ($nama_ibu != '' ? 'Ibu' : ($nama_bapak != '' ? 'Ayah' : '')));

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 30) . ':G' . ($header_row + 30))->setCellValue('B' . ($header_row + 30), 'No Telp / HP');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 30) . ':H' . ($header_row + 30))->setCellValue('H' . ($header_row + 30), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 30) . ':Q' . ($header_row + 30))->setCellValue('I' . ($header_row + 30), $nohp_saudara ? $nohp_saudara : $hp_kerabat);
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 30) . ':Y' . ($header_row + 30))->setCellValue('T' . ($header_row + 30), 'Alamat Lengkap');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($header_row + 30) . ':Z' . ($header_row + 30))->setCellValue('Z' . ($header_row + 30), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 30) . ':AK' . ($header_row + 30))->setCellValue('AA' . ($header_row + 30), '');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 32) . ':H' . ($header_row + 32))->setCellValue('B' . ($header_row + 32), 'Data Keluarga :');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 34) . ':G' . ($header_row + 34))->setCellValue('B' . ($header_row + 34), 'Nama Ayah');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 34) . ':H' . ($header_row + 34))->setCellValue('H' . ($header_row + 34), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 34) . ':Q' . ($header_row + 34))->setCellValue('I' . ($header_row + 34), $nama_bapak);
        $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + 34) . ':U' . ($header_row + 34))->setCellValue('S' . ($header_row + 34), 'Pekerjaan');
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($header_row + 34) . ':V' . ($header_row + 34))->setCellValue('V' . ($header_row + 34), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 34) . ':AA' . ($header_row + 34))->setCellValue('W' . ($header_row + 34), $pekerjaan_ortu);
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . ($header_row + 34) . ':AD' . ($header_row + 34))->setCellValue('AC' . ($header_row + 34), 'Umur');
        $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($header_row + 34) . ':AE' . ($header_row + 34))->setCellValue('AE' . ($header_row + 34), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AF' . ($header_row + 34) . ':AG' . ($header_row + 34))->setCellValue('AF' . ($header_row + 34), '');
        $objPHPExcel->getActiveSheet()->mergeCells('AH' . ($header_row + 34) . ':AK' . ($header_row + 34))->setCellValue('AH' . ($header_row + 34), 'Thn');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 36) . ':G' . ($header_row + 36))->setCellValue('B' . ($header_row + 36), 'Nama Ibu');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 36) . ':H' . ($header_row + 36))->setCellValue('H' . ($header_row + 36), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 36) . ':Q' . ($header_row + 36))->setCellValue('I' . ($header_row + 36), $nama_ibu);
        $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + 36) . ':U' . ($header_row + 36))->setCellValue('S' . ($header_row + 36), 'Pekerjaan');
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($header_row + 36) . ':V' . ($header_row + 36))->setCellValue('V' . ($header_row + 36), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 36) . ':AA' . ($header_row + 36))->setCellValue('W' . ($header_row + 36), $pekerjaan_ortu);
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . ($header_row + 36) . ':AD' . ($header_row + 36))->setCellValue('AC' . ($header_row + 36), 'Umur');
        $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($header_row + 36) . ':AE' . ($header_row + 36))->setCellValue('AE' . ($header_row + 36), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AF' . ($header_row + 36) . ':AG' . ($header_row + 36))->setCellValue('AF' . ($header_row + 36), '');
        $objPHPExcel->getActiveSheet()->mergeCells('AH' . ($header_row + 36) . ':AK' . ($header_row + 36))->setCellValue('AH' . ($header_row + 36), 'Thn');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 38) . ':G' . ($header_row + 38))->setCellValue('B' . ($header_row + 38), 'Jumlah Saudara');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 38) . ':H' . ($header_row + 38))->setCellValue('H' . ($header_row + 38), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 38) . ':K' . ($header_row + 38))->setCellValue('I' . ($header_row + 38), $jumlah_sudara);
        $objPHPExcel->getActiveSheet()->mergeCells('L' . ($header_row + 38) . ':P' . ($header_row + 38))->setCellValue('L' . ($header_row + 38), 'Orang');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 40) . ':N' . ($header_row + 40))->setCellValue('B' . ($header_row + 40), 'Data Kakak/ Adik (Saudara Kandung) :');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 42) . ':B' . ($header_row + 42))->setCellValue('B' . ($header_row + 42), 'No');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 42) . ':N' . ($header_row + 42))->setCellValue('C' . ($header_row + 42), 'Nama Saudara Kandung');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . ($header_row + 42) . ':O' . ($header_row + 42))->setCellValue('O' . ($header_row + 42), 'L');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 42) . ':P' . ($header_row + 42))->setCellValue('P' . ($header_row + 42), 'P');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 42) . ':R' . ($header_row + 42))->setCellValue('Q' . ($header_row + 42), 'Umur');
        $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + 42) . ':X' . ($header_row + 42))->setCellValue('S' . ($header_row + 42), 'Pekerjaan');
        $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($header_row + 42) . ':AD' . ($header_row + 42))->setCellValue('Y' . ($header_row + 42), 'Perusahaan');
        $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($header_row + 42) . ':AK' . ($header_row + 42))->setCellValue('AE' . ($header_row + 42), 'Jabatan');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 26) . ':A' . ($header_row + 42))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AK' . ($header_row + 26) . ':AL' . ($header_row + 42))->applyFromArray($style['headerStyleRight']);

        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 28) . ':Q' . ($header_row + 28))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AA' . ($header_row + 28) . ':AK' . ($header_row + 28))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 30) . ':Q' . ($header_row + 30))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AA' . ($header_row + 30) . ':AK' . ($header_row + 30))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 34) . ':Q' . ($header_row + 34))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('W' . ($header_row + 34) . ':AA' . ($header_row + 34))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AF' . ($header_row + 34) . ':AG' . ($header_row + 34))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 36) . ':Q' . ($header_row + 36))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('W' . ($header_row + 36) . ':AA' . ($header_row + 36))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AF' . ($header_row + 36) . ':AG' . ($header_row + 36))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('I' . ($header_row + 38) . ':K' . ($header_row + 38))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 42) . ':AK' . ($header_row + 42))->applyFromArray($style['headerStyle']);

        $loop_row = $header_row + 42;
        $no = 1;
        for ($i = 0; $i < 10; $i++) {

            $m = '';
            $p = '';
            if (isset($get_data_saudara[$i]->JenisKelamin) && $get_data_saudara[$i]->JenisKelamin == '1') {
                $m = '✔';
            }
            if (isset($get_data_saudara[$i]->JenisKelamin) && $get_data_saudara[$i]->JenisKelamin == '0') {
                $p = '✔';
            }
            $loop_row++;
            $objPHPExcel->getActiveSheet()->mergeCells('B' . ($loop_row + 0) . ':B' . ($loop_row + 0))->setCellValue('B' . ($loop_row + 0), $no++);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . ($loop_row + 0) . ':N' . ($loop_row + 0))->setCellValue('C' . ($loop_row + 0), isset($get_data_saudara[$i]->Nama) ? $get_data_saudara[$i]->Nama : '');
            $objPHPExcel->getActiveSheet()->mergeCells('O' . ($loop_row + 0) . ':O' . ($loop_row + 0))->setCellValue('O' . ($loop_row + 0), $m);
            $objPHPExcel->getActiveSheet()->mergeCells('P' . ($loop_row + 0) . ':P' . ($loop_row + 0))->setCellValue('P' . ($loop_row + 0), $p);
            $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($loop_row + 0) . ':R' . ($loop_row + 0))->setCellValue('Q' . ($loop_row + 0), isset($get_data_saudara[$i]->Umur) ? $get_data_saudara[$i]->Umur : '');
            $objPHPExcel->getActiveSheet()->mergeCells('S' . ($loop_row + 0) . ':X' . ($loop_row + 0))->setCellValue('S' . ($loop_row + 0), isset($get_data_saudara[$i]->Pekerjaan) ? $get_data_saudara[$i]->Pekerjaan : '');
            $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($loop_row + 0) . ':AD' . ($loop_row + 0))->setCellValue('Y' . ($loop_row + 0), isset($get_data_saudara[$i]->Perusahaan) ? $get_data_saudara[$i]->Perusahaan : '');
            $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->setCellValue('AE' . ($loop_row + 0), isset($get_data_saudara[$i]->Jabatan) ? $get_data_saudara[$i]->Jabatan : '');

            $objPHPExcel->getActiveSheet()->getStyle('A' . ($loop_row + 0) . ':A' . ($loop_row + 0))->applyFromArray($style['headerStyleLeft']);
            $objPHPExcel->getActiveSheet()->getStyle('AK' . ($loop_row + 0) . ':AL' . ($loop_row + 0))->applyFromArray($style['headerStyleRight']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->applyFromArray($style['headerStyle']);
        }

        $header_row = $loop_row;

        for ($i = 58; $i <= 60; $i++) {
            if ($i % 2 == 0) {
                $sheet->getRowDimension($i)->setRowHeight(3.0);
            }
        }

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 3) . ':G' . ($header_row + 3))->setCellValue('B' . ($header_row + 3), 'Nama Suami/Istri');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 3) . ':H' . ($header_row + 3))->setCellValue('H' . ($header_row + 3), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($header_row + 3) . ':Q' . ($header_row + 3))->setCellValue('J' . ($header_row + 3), $nama_suami_istri);
        $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + 3) . ':U' . ($header_row + 3))->setCellValue('S' . ($header_row + 3), 'Pekerjaan');
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($header_row + 3) . ':V' . ($header_row + 3))->setCellValue('V' . ($header_row + 3), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 3) . ':AA' . ($header_row + 3))->setCellValue('W' . ($header_row + 3), $pekerjaan_suamiistri);
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . ($header_row + 3) . ':AD' . ($header_row + 3))->setCellValue('AC' . ($header_row + 3), 'Umur');
        $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($header_row + 3) . ':AE' . ($header_row + 3))->setCellValue('AE' . ($header_row + 3), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AF' . ($header_row + 3) . ':AG' . ($header_row + 3))->setCellValue('AF' . ($header_row + 3), '');
        $objPHPExcel->getActiveSheet()->mergeCells('AH' . ($header_row + 3) . ':AJ' . ($header_row + 3))->setCellValue('AH' . ($header_row + 3), 'Thn');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 5) . ':G' . ($header_row + 5))->setCellValue('B' . ($header_row + 5), 'Anak');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 5) . ':H' . ($header_row + 5))->setCellValue('H' . ($header_row + 5), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($header_row + 5) . ':L' . ($header_row + 5))->setCellValue('J' . ($header_row + 5), '');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 5) . ':O' . ($header_row + 5))->setCellValue('M' . ($header_row + 5), 'Orang');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 7) . ':B' . ($header_row + 7))->setCellValue('B' . ($header_row + 7), 'No');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 7) . ':N' . ($header_row + 7))->setCellValue('C' . ($header_row + 7), 'Nama Anak');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . ($header_row + 7) . ':O' . ($header_row + 7))->setCellValue('O' . ($header_row + 7), 'L');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 7) . ':P' . ($header_row + 7))->setCellValue('P' . ($header_row + 7), 'P');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 7) . ':R' . ($header_row + 7))->setCellValue('Q' . ($header_row + 7), 'Umur');
        $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + 7) . ':X' . ($header_row + 7))->setCellValue('S' . ($header_row + 7), 'Tempat Lahir');
        $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($header_row + 7) . ':AK' . ($header_row + 7))->setCellValue('Y' . ($header_row + 7), 'Alamat');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 0) . ':A' . ($header_row + 7))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 0) . ':AL' . ($header_row + 7))->applyFromArray($style['headerStyleRight']);

        $objPHPExcel->getActiveSheet()->getStyle('J' . ($header_row + 3) . ':Q' . ($header_row + 3))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AF' . ($header_row + 3) . ':AG' . ($header_row + 3))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 7) . ':AK' . ($header_row + 7))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('J' . ($header_row + 5) . ':L' . ($header_row + 5))->applyFromArray($style['headerStyle']);


        $loop_row = $header_row + 7;
        $jml = count($get_data_anak);
        $jmlAnak = $jml <= 0 ? 5 : $jml;
        $no = 1;
        for ($i = 0; $i < 5; $i++) {
            $m = '';
            $p = '';
            if (isset($get_data_anak[$i]->JenisKelamin) && $get_data_anak[$i]->JenisKelamin == 'M') {
                $m = '✔';
            }
            if (isset($get_data_anak[$i]->JenisKelamin) && $get_data_anak[$i]->JenisKelamin == 'P') {
                $p = '✔';
            }
            $loop_row++;
            $objPHPExcel->getActiveSheet()->mergeCells('B' . ($loop_row + 0) . ':B' . ($loop_row + 0))->setCellValue('B' . ($loop_row + 0), $no++);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . ($loop_row + 0) . ':N' . ($loop_row + 0))->setCellValue('C' . ($loop_row + 0), isset($get_data_anak[$i]->Nama) ? $get_data_anak[$i]->Nama : '');
            $objPHPExcel->getActiveSheet()->mergeCells('O' . ($loop_row + 0) . ':O' . ($loop_row + 0))->setCellValue('O' . ($loop_row + 0), $m);
            $objPHPExcel->getActiveSheet()->mergeCells('P' . ($loop_row + 0) . ':P' . ($loop_row + 0))->setCellValue('P' . ($loop_row + 0), $p);
            $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($loop_row + 0) . ':R' . ($loop_row + 0))->setCellValue('Q' . ($loop_row + 0), '');
            $objPHPExcel->getActiveSheet()->mergeCells('S' . ($loop_row + 0) . ':X' . ($loop_row + 0))->setCellValue('S' . ($loop_row + 0), isset($get_data_anak[$i]->TempatLahir) ? $get_data_anak[$i]->TempatLahir : '');
            $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->setCellValue('Y' . ($loop_row + 0), isset($get_data_anak[$i]->Alamat) ? $get_data_anak[$i]->Alamat : '');

            $objPHPExcel->getActiveSheet()->getStyle('A' . ($loop_row + 0) . ':A' . ($loop_row + 0))->applyFromArray($style['headerStyleLeft']);
            $objPHPExcel->getActiveSheet()->getStyle('AK' . ($loop_row + 0) . ':AL' . ($loop_row + 0))->applyFromArray($style['headerStyleRight']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->applyFromArray($style['headerStyle']);
        }

        $header_row = $loop_row;


        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 2) . ':S' . ($header_row + 2))->setCellValue('B' . ($header_row + 2), 'Berapa orang yang menjadi tanggung jawab saat ini ?');
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 2) . ':V' . ($header_row + 2))->setCellValue('T' . ($header_row + 2), '');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 2) . ':Y' . ($header_row + 2))->setCellValue('W' . ($header_row + 2), 'Orang');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 3) . ':D' . ($header_row + 3))->setCellValue('B' . ($header_row + 3), 'Sebutkan');
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($header_row + 3) . ':AK' . ($header_row + 3))->setCellValue('E' . ($header_row + 3), '');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 0) . ':A' . ($header_row + 3))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 0) . ':AL' . ($header_row + 3))->applyFromArray($style['headerStyleRight']);

        $objPHPExcel->getActiveSheet()->getStyle('T' . ($header_row + 2) . ':V' . ($header_row + 2))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('E' . ($header_row + 3) . ':AK' . ($header_row + 3))->applyFromArray($style['headerStyle']);


        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 4) . ':P' . ($header_row + 4))->setCellValue('A' . ($header_row + 4), 'Mulai Berlaku : 05-04-2023');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 4) . ':AL' . ($header_row + 4))->setCellValue('Q' . ($header_row + 4), 'FRM-FSS-403-05');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 4) . ':P' . ($header_row + 4))->applyFromArray($style['footerStyleLeftbottom']);
        $objPHPExcel->getActiveSheet()->getStyle('Q' . ($header_row + 4) . ':AL' . ($header_row + 4))->applyFromArray($style['footerStyleRightbottom']);


        $sheet->setBreak('A67', Worksheet::BREAK_NONE);
        $sheet->setBreak('A68', Worksheet::BREAK_NONE);

        $objPHPExcel->getActiveSheet()->setBreak('A' . ($header_row + 4),  Worksheet::BREAK_ROW);

        // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// HALAMAN 2 //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Menambahkan gambar ke sheet aktif
        $objDrawing2 = new Drawing();
        $objDrawing2->setPath('assets/images/logo_terbaru.png');
        $objDrawing2->setWidthAndHeight(50, 50);

        // Mengatur worksheet untuk gambar
        $objDrawing2->setWorksheet($sheet);

        $start_row = $header_row + 5;
        $objDrawing2->setCoordinates('B' . ($start_row + 1))->setOffsetX(-6)->setOffsetY(3);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($start_row + 1) . ':D' . ($start_row + 2));
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($start_row + 1) . ':AC' . ($start_row + 2))->setCellValue('E' . ($start_row + 1), 'PT PULAU SAMBU');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($start_row + 3) . ':D' . ($start_row + 3))->setCellValue('A' . ($start_row + 3), 'JUDUL');
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($start_row + 3) . ':AC' . ($start_row + 3))->setCellValue('E' . ($start_row + 3), 'APLIKASI KERJA');

        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($start_row + 1) . ':AF' . ($start_row + 1))->setCellValue('AD' . ($start_row + 1), 'DOK');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($start_row + 1) . ':AL' . ($start_row + 1))->setCellValue('AG' . ($start_row + 1), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($start_row + 2) . ':AF' . ($start_row + 2))->setCellValue('AD' . ($start_row + 2), 'TGL');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($start_row + 2) . ':AL' . ($start_row + 2))->setCellValue('AG' . ($start_row + 2), ': ' . date('d-m-Y'));
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($start_row + 3) . ':AF' . ($start_row + 3))->setCellValue('AD' . ($start_row + 3), 'HLM');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($start_row + 3) . ':AL' . ($start_row + 3))->setCellValue('AG' . ($start_row + 3), ': 2 dari 3');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($start_row + 1) . ':D' . ($start_row + 2))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('E' . ($start_row + 1) . ':AC' . ($start_row + 2))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('E' . ($start_row + 3) . ':AC' . ($start_row + 3))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($start_row + 3) . ':D' . ($start_row + 3))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($start_row + 1) . ':AF' . ($start_row + 1))->applyFromArray($style['headerStyleLeftBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($start_row + 2) . ':AF' . ($start_row + 2))->applyFromArray($style['headerStyleLeftBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($start_row + 3) . ':AF' . ($start_row + 3))->applyFromArray($style['headerStyleLeftBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . ($start_row + 1) . ':AL' . ($start_row + 1))->applyFromArray($style['headerStyleRightBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . ($start_row + 2) . ':AL' . ($start_row + 2))->applyFromArray($style['headerStyleRightBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . ($start_row + 3) . ':AL' . ($start_row + 3))->applyFromArray($style['headerStyleRightBottomTop']);

        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($start_row + 1) . ':AL' . ($start_row + 3))->applyFromArray($style['headerStyleRight']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($start_row + 1) . ':A' . ($start_row + 3))->applyFromArray($style['headerStyleLeft']);

        $header_row = $start_row + 3;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 2) . ':AL' . ($header_row + 2))->setCellValue('A' . ($header_row + 2), '2. LATAR BELAKANG PENDIDIKAN');
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':AL' . ($header_row + 2))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':A' . ($header_row + 2))->getAlignment()->setHorizontal('PHPExcel_Style_Alignment::HORIZONTAL_LEFT');
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':AL' . ($header_row + 2))->getFont()->setBold(true);




        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 4) . ':H' . ($header_row + 4))->setCellValue('B' . ($header_row + 4), 'Pendidikan terakhir ');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 4) . ':I' . ($header_row + 4))->setCellValue('I' . ($header_row + 4), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($header_row + 4) . ':J' . ($header_row + 4))->setCellValue('J' . ($header_row + 4), $pendidikan_terakhir == 'SD' || $pendidikan_terakhir == 'SMP' || $pendidikan_terakhir == 'MTS' ? '✓' : '');
        $objPHPExcel->getActiveSheet()->mergeCells('K' . ($header_row + 4) . ':M' . ($header_row + 4))->setCellValue('K' . ($header_row + 4), '≤ SMP');
        $objPHPExcel->getActiveSheet()->mergeCells('N' . ($header_row + 4) . ':N' . ($header_row + 4))->setCellValue('N' . ($header_row + 4), $pendidikan_terakhir == 'SMK' || $pendidikan_terakhir == 'SMU' || $pendidikan_terakhir == 'MAN'  ? '✓' : '');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . ($header_row + 4) . ':T' . ($header_row + 4))->setCellValue('O' . ($header_row + 4), 'SMA Sederajat');
        $objPHPExcel->getActiveSheet()->mergeCells('U' . ($header_row + 4) . ':U' . ($header_row + 4))->setCellValue('U' . ($header_row + 4), $pendidikan_terakhir == 'D3' || $pendidikan_terakhir == 'D4'  ? '✓' : '');
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($header_row + 4) . ':X' . ($header_row + 4))->setCellValue('V' . ($header_row + 4), 'Diploma');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($header_row + 4) . ':Z' . ($header_row + 4))->setCellValue('Z' . ($header_row + 4), $pendidikan_terakhir == 'S1' ? '✓' : '');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 4) . ':AD' . ($header_row + 4))->setCellValue('AA' . ($header_row + 4), 'Strata 1');
        $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($header_row + 4) . ':AE' . ($header_row + 4))->setCellValue('AE' . ($header_row + 4), $pendidikan_terakhir == 'S2' ? '✓' : '');
        $objPHPExcel->getActiveSheet()->mergeCells('AF' . ($header_row + 4) . ':AL' . ($header_row + 4))->setCellValue('AF' . ($header_row + 4), 'Strata 2');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 6) . ':K' . ($header_row + 6))->setCellValue('B' . ($header_row + 6), 'Sekolah / Universitas Terakhir ');
        $objPHPExcel->getActiveSheet()->mergeCells('L' . ($header_row + 6) . ':L' . ($header_row + 6))->setCellValue('L' . ($header_row + 6), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 6) . ':AK' . ($header_row + 6))->setCellValue('M' . ($header_row + 6), $nama_sekolah);

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 8) . ':H' . ($header_row + 8))->setCellValue('B' . ($header_row + 8), 'Jurusan ');
        $objPHPExcel->getActiveSheet()->mergeCells('I' . ($header_row + 8) . ':I' . ($header_row + 8))->setCellValue('I' . ($header_row + 8), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($header_row + 8) . ':T' . ($header_row + 8))->setCellValue('J' . ($header_row + 8), $jurusan);
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($header_row + 8) . ':Z' . ($header_row + 8))->setCellValue('V' . ($header_row + 8), 'Ijazah terakhir');
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . ($header_row + 8) . ':AC' . ($header_row + 8))->setCellValue('AC' . ($header_row + 8), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($header_row + 8) . ':AK' . ($header_row + 8))->setCellValue('AD' . ($header_row + 8), '');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 1) . ':A' . ($header_row + 10))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 1) . ':AL' . ($header_row + 10))->applyFromArray($style['headerStyleRight']);

        $objPHPExcel->getActiveSheet()->getStyle('J' . ($header_row + 4) . ':J' . ($header_row + 4))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('N' . ($header_row + 4) . ':N' . ($header_row + 4))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('U' . ($header_row + 4) . ':U' . ($header_row + 4))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('Z' . ($header_row + 4) . ':Z' . ($header_row + 4))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AE' . ($header_row + 4) . ':AE' . ($header_row + 4))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('M' . ($header_row + 6) . ':AK' . ($header_row + 6))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($header_row + 8) . ':AK' . ($header_row + 8))->applyFromArray($style['bodyStyle']);


        for ($i = 80; $i <= 85; $i++) {
            if ($i % 2 != 0) {
                $sheet->getRowDimension($i)->setRowHeight(3.0);
            }
        }
        $sheet->getRowDimension(86)->setRowHeight(27.73);

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 10) . ':F' . ($header_row + 10))->setCellValue('B' . ($header_row + 10), 'TINGKAT' . PHP_EOL . '(SD s/d S2)');
        $objPHPExcel->getActiveSheet()->mergeCells('G' . ($header_row + 10) . ':V' . ($header_row + 10))->setCellValue('G' . ($header_row + 10), 'NAMA SEKOLAH / TEMPAT ');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 10) . ':Z' . ($header_row + 10))->setCellValue('W' . ($header_row + 10), 'JURUSAN ');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 10) . ':AC' . ($header_row + 10))->setCellValue('AA' . ($header_row + 10), 'Tahun' . PHP_EOL . 'Masuk');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($header_row + 10) . ':AF' . ($header_row + 10))->setCellValue('AD' . ($header_row + 10), 'Tahun' . PHP_EOL . 'Keluar');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($header_row + 10) . ':AK' . ($header_row + 10))->setCellValue('AG' . ($header_row + 10), 'LULUS');

        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 10) . ':AK' . ($header_row + 10))->applyFromArray($style['headerStyle']);


        $loop_row = $header_row + 10;
        $no = 1;
        for ($i = 0; $i < 10; $i++) {
            $loop_row++;
            $objPHPExcel->getActiveSheet()->mergeCells('B' . ($loop_row + 0) . ':F' . ($loop_row + 0))->setCellValue('B' . ($loop_row + 0), isset($get_data_pendidikan[$i]->Tingkat) ? $get_data_pendidikan[$i]->Tingkat : '');
            $objPHPExcel->getActiveSheet()->mergeCells('G' . ($loop_row + 0) . ':V' . ($loop_row + 0))->setCellValue('G' . ($loop_row + 0), isset($get_data_pendidikan[$i]->Nama) ? $get_data_pendidikan[$i]->Nama : '');
            $objPHPExcel->getActiveSheet()->mergeCells('W' . ($loop_row + 0) . ':Z' . ($loop_row + 0))->setCellValue('W' . ($loop_row + 0), isset($get_data_pendidikan[$i]->Bidang) ? $get_data_pendidikan[$i]->Bidang : '');
            $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($loop_row + 0) . ':AC' . ($loop_row + 0))->setCellValue('AA' . ($loop_row + 0), isset($get_data_pendidikan[$i]->TahunMasuk) ? $get_data_pendidikan[$i]->TahunMasuk : '');
            $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($loop_row + 0) . ':AF' . ($loop_row + 0))->setCellValue('AD' . ($loop_row + 0), isset($get_data_pendidikan[$i]->TahunKeluar) ? $get_data_pendidikan[$i]->TahunKeluar : '');
            $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->setCellValue('AG' . ($loop_row + 0), isset($get_data_pendidikan[$i]->Lulus) ? $get_data_pendidikan[$i]->Lulus : '');

            $objPHPExcel->getActiveSheet()->getStyle('A' . ($loop_row + 0) . ':A' . ($loop_row + 0))->applyFromArray($style['headerStyleLeft']);
            $objPHPExcel->getActiveSheet()->getStyle('AL' . ($loop_row + 0) . ':AL' . ($loop_row + 0))->applyFromArray($style['headerStyleRight']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->applyFromArray($style['headerStyle']);
        }

        $sheet->getRowDimension(97)->setRowHeight(3.0);

        $header_row = $loop_row;
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 2) . ':Q' . ($header_row + 2))->setCellValue('B' . ($header_row + 2), 'Apa anda pernah mengikuti kursus/ training ?');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 3) . ':B' . ($header_row + 3))->setCellValue('B' . ($header_row + 3), 'No');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 3) . ':J' . ($header_row + 3))->setCellValue('C' . ($header_row + 3), 'Bidang');
        $objPHPExcel->getActiveSheet()->mergeCells('K' . ($header_row + 3) . ':P' . ($header_row + 3))->setCellValue('K' . ($header_row + 3), 'Tempat/Kota');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 3) . ':W' . ($header_row + 3))->setCellValue('Q' . ($header_row + 3), 'Berapa lama ');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 3) . ':AD' . ($header_row + 3))->setCellValue('X' . ($header_row + 3), 'Bulan/Tahun ');
        $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($header_row + 3) . ':AK' . ($header_row + 3))->setCellValue('AE' . ($header_row + 3), 'Keterangan ');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 0) . ':A' . ($header_row + 3))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 0) . ':AL' . ($header_row + 3))->applyFromArray($style['headerStyleRight']);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 3) . ':AK' . ($header_row + 3))->applyFromArray($style['headerStyle']);


        $loop_row = $header_row + 3;
        $no = 1;
        for ($i = 1; $i <= 3; $i++) {
            $loop_row++;
            $objPHPExcel->getActiveSheet()->mergeCells('B' . ($loop_row + 0) . ':B' . ($loop_row + 0))->setCellValue('B' . ($loop_row + 0), $no++);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . ($loop_row + 0) . ':J' . ($loop_row + 0))->setCellValue('C' . ($loop_row + 0), '');
            $objPHPExcel->getActiveSheet()->mergeCells('K' . ($loop_row + 0) . ':P' . ($loop_row + 0))->setCellValue('K' . ($loop_row + 0), '');
            $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($loop_row + 0) . ':W' . ($loop_row + 0))->setCellValue('Q' . ($loop_row + 0), '');
            $objPHPExcel->getActiveSheet()->mergeCells('X' . ($loop_row + 0) . ':AD' . ($loop_row + 0))->setCellValue('X' . ($loop_row + 0), '');
            $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->setCellValue('AE' . ($loop_row + 0), '');

            $objPHPExcel->getActiveSheet()->getStyle('A' . ($loop_row + 0) . ':A' . ($loop_row + 0))->applyFromArray($style['headerStyleLeft']);
            $objPHPExcel->getActiveSheet()->getStyle('AK' . ($loop_row + 0) . ':AL' . ($loop_row + 0))->applyFromArray($style['headerStyleRight']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->applyFromArray($style['headerStyle']);
        }

        $header_row = $loop_row;

        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 2) . ':AL' . ($header_row + 2))->setCellValue('A' . ($header_row + 2), '3. LATAR BELAKANG PEKERJAAN ');

        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 4) . ':AC' . ($header_row + 4))->setCellValue('A' . ($header_row + 4), 'Apakah anda mempunyai teman / saudara yang berkerja di Group Perusahaan ini ? ');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($header_row + 4) . ':AD' . ($header_row + 4))->setCellValue('AD' . ($header_row + 4), '');
        $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($header_row + 4) . ':AE' . ($header_row + 4))->setCellValue('AE' . ($header_row + 4), 'Ya');
        $objPHPExcel->getActiveSheet()->mergeCells('AF' . ($header_row + 4) . ':AF' . ($header_row + 4))->setCellValue('AF' . ($header_row + 4), '');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($header_row + 4) . ':AI' . ($header_row + 4))->setCellValue('AG' . ($header_row + 4), 'Tidak');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 6) . ':D' . ($header_row + 6))->setCellValue('B' . ($header_row + 6), 'Sebutkan');
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($header_row + 6) . ':E' . ($header_row + 6))->setCellValue('E' . ($header_row + 6), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('G' . ($header_row + 6) . ':G' . ($header_row + 6))->setCellValue('G' . ($header_row + 6), '1.');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 6) . ':O' . ($header_row + 6))->setCellValue('H' . ($header_row + 6), 'Nama');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 6) . ':U' . ($header_row + 6))->setCellValue('P' . ($header_row + 6), 'Jabatan');
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($header_row + 6) . ':V' . ($header_row + 6))->setCellValue('V' . ($header_row + 6), '3.');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 6) . ':AD' . ($header_row + 6))->setCellValue('W' . ($header_row + 6), 'Nama');
        $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($header_row + 6) . ':AK' . ($header_row + 6))->setCellValue('AE' . ($header_row + 6), 'Jabatan');

        $objPHPExcel->getActiveSheet()->mergeCells('G' . ($header_row + 8) . ':G' . ($header_row + 8))->setCellValue('G' . ($header_row + 8), '2.');
        $objPHPExcel->getActiveSheet()->mergeCells('H' . ($header_row + 8) . ':O' . ($header_row + 8))->setCellValue('H' . ($header_row + 8), 'Nama');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 8) . ':u' . ($header_row + 8))->setCellValue('P' . ($header_row + 8), 'Jabatan');
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($header_row + 8) . ':V' . ($header_row + 8))->setCellValue('V' . ($header_row + 8), '4.');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 8) . ':AD' . ($header_row + 8))->setCellValue('W' . ($header_row + 8), 'Nama');
        $objPHPExcel->getActiveSheet()->mergeCells('AE' . ($header_row + 8) . ':AK' . ($header_row + 8))->setCellValue('AE' . ($header_row + 8), 'Jabatan');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 0) . ':A' . ($header_row + 13))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 0) . ':AL' . ($header_row + 13))->applyFromArray($style['headerStyleRight']);

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':AL' . ($header_row + 2))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':A' . ($header_row + 2))->getAlignment()->setHorizontal('PHPExcel_Style_Alignment::HORIZONTAL_LEFT');

        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($header_row + 4) . ':AD' . ($header_row + 4))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AF' . ($header_row + 4) . ':AF' . ($header_row + 4))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('H' . ($header_row + 6) . ':U' . ($header_row + 6))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('W' . ($header_row + 6) . ':AK' . ($header_row + 6))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('H' . ($header_row + 8) . ':U' . ($header_row + 8))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('W' . ($header_row + 8) . ':AK' . ($header_row + 8))->applyFromArray($style['bodyStyle']);



        for ($i = 106; $i <= 114; $i++) {
            if ($i % 2 != 0) {
                $sheet->getRowDimension($i)->setRowHeight(3.0);
            }
        }
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 10) . ':J' . ($header_row + 10))->setCellValue('B' . ($header_row + 10), 'Data Pengalaman Kerja');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 12) . ':B' . ($header_row + 12))->setCellValue('B' . ($header_row + 12), 'No');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 12) . ':I' . ($header_row + 12))->setCellValue('C' . ($header_row + 12), 'Nama Perusahaan');
        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($header_row + 12) . ':N' . ($header_row + 12))->setCellValue('J' . ($header_row + 12), 'Lama Bekerja');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . ($header_row + 12) . ':T' . ($header_row + 12))->setCellValue('O' . ($header_row + 12), 'Jabatan Terakhir');
        $objPHPExcel->getActiveSheet()->mergeCells('U' . ($header_row + 12) . ':Z' . ($header_row + 12))->setCellValue('U' . ($header_row + 12), 'Gaji Terakhir');
        $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($header_row + 12) . ':AK' . ($header_row + 12))->setCellValue('AA' . ($header_row + 12), 'Alasan Berhenti');

        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 12) . ':AK' . ($header_row + 12))->applyFromArray($style['headerStyle']);

        $loop_row = $header_row + 12;
        $no = 1;
        for ($i = 1; $i <= 5; $i++) {
            $loop_row++;
            $objPHPExcel->getActiveSheet()->mergeCells('B' . ($loop_row + 0) . ':B' . ($loop_row + 0))->setCellValue('B' . ($loop_row + 0), $no++);
            $objPHPExcel->getActiveSheet()->mergeCells('C' . ($loop_row + 0) . ':I' . ($loop_row + 0))->setCellValue('C' . ($loop_row + 0), '');
            $objPHPExcel->getActiveSheet()->mergeCells('J' . ($loop_row + 0) . ':L' . ($loop_row + 0))->setCellValue('J' . ($loop_row + 0), '');
            $objPHPExcel->getActiveSheet()->mergeCells('M' . ($loop_row + 0) . ':N' . ($loop_row + 0))->setCellValue('M' . ($loop_row + 0), 'Thn');
            $objPHPExcel->getActiveSheet()->mergeCells('O' . ($loop_row + 0) . ':T' . ($loop_row + 0))->setCellValue('O' . ($loop_row + 0), '');
            $objPHPExcel->getActiveSheet()->mergeCells('U' . ($loop_row + 0) . ':Z' . ($loop_row + 0))->setCellValue('U' . ($loop_row + 0), 'Rp');
            $objPHPExcel->getActiveSheet()->mergeCells('AA' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->setCellValue('AA' . ($loop_row + 0), '');

            $objPHPExcel->getActiveSheet()->getStyle('A' . ($loop_row + 0) . ':A' . ($loop_row + 0))->applyFromArray($style['headerStyleLeft']);
            $objPHPExcel->getActiveSheet()->getStyle('AK' . ($loop_row + 0) . ':AL' . ($loop_row + 0))->applyFromArray($style['headerStyleRight']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($loop_row + 0) . ':AK' . ($loop_row + 0))->applyFromArray($style['headerStyle']);
            $objPHPExcel->getActiveSheet()->getStyle('U' . ($loop_row + 0) . ':U' . ($loop_row + 0))->getAlignment()->setHorizontal('PHPExcel_Style_Alignment::HORIZONTAL_LEFT');
        }

        $header_row = $loop_row;

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 2) . ':AK' . ($header_row + 2))->setCellValue('B' . ($header_row + 2), 'Bila diterima berapa besar gaji brutto yang anda harapkan per bulan atau sesuai gaji standar perusahaan?');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 3) . ':AK' . ($header_row + 3))->setCellValue('B' . ($header_row + 3), '');

        $sheet->getRowDimension(123)->setRowHeight(3.0);
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 5) . ':U' . ($header_row + 5))->setCellValue('B' . ($header_row + 5), 'Berapa besar penghasilan bersih per bulan anda saat ini ?');
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($header_row + 5) . ':V' . ($header_row + 5))->setCellValue('V' . ($header_row + 5), 'Rp');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 5) . ':AK' . ($header_row + 5))->setCellValue('W' . ($header_row + 5), '');

        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 7) . ':K' . ($header_row + 7))->setCellValue('A' . ($header_row + 7), 'KHUSUS DIISI OLEH PERUSAHAAN');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 7) . ':W' . ($header_row + 7))->setCellValue('M' . ($header_row + 7), 'KHUSUS DIISI OLEH PERUSAHAAN');
        $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($header_row + 7) . ':AL' . ($header_row + 7))->setCellValue('Y' . ($header_row + 7), 'KHUSUS DIISI OLEH PERUSAHAAN');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 0) . ':A' . ($header_row + 7))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 0) . ':AL' . ($header_row + 7))->applyFromArray($style['headerStyleRight']);

        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 3) . ':AK' . ($header_row + 3))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('W' . ($header_row + 5) . ':AK' . ($header_row + 5))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 7) . ':AL' . ($header_row + 7))->applyFromArray($style['bodyStyle']);


        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 9) . ':O' . ($header_row + 9))->setCellValue('C' . ($header_row + 9), 'Daftar Dokumen Wajib ');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 10) . ':C' . ($header_row + 10))->setCellValue('C' . ($header_row + 10), ' ');
        $objPHPExcel->getActiveSheet()->mergeCells('D' . ($header_row + 11) . ':O' . ($header_row + 11))->setCellValue('D' . ($header_row + 11), 'Surat Lamaran Kerja');
        $objPHPExcel->getActiveSheet()->mergeCells('D' . ($header_row + 12) . ':O' . ($header_row + 12))->setCellValue('D' . ($header_row + 12), 'Daftar Riwayat Hidup / CV');
        $objPHPExcel->getActiveSheet()->mergeCells('D' . ($header_row + 13) . ':O' . ($header_row + 13))->setCellValue('D' . ($header_row + 13), 'Salinan Ijazah Terakhir ');
        $objPHPExcel->getActiveSheet()->mergeCells('D' . ($header_row + 14) . ':O' . ($header_row + 14))->setCellValue('D' . ($header_row + 14), 'Transcript Nilai ');
        $objPHPExcel->getActiveSheet()->mergeCells('D' . ($header_row + 15) . ':O' . ($header_row + 15))->setCellValue('D' . ($header_row + 15), 'Salinan KTP ');
        $objPHPExcel->getActiveSheet()->mergeCells('D' . ($header_row + 16) . ':o' . ($header_row + 16))->setCellValue('D' . ($header_row + 16), '3 Lbr Pas Photo 3 x 4  ');


        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 11) . ':AA' . ($header_row + 11))->setCellValue('Q' . ($header_row + 11), 'Salinan SKCK ');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 12) . ':AA' . ($header_row + 12))->setCellValue('Q' . ($header_row + 12), 'Surat Dokter Ket. Sehat ');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 13) . ':AA' . ($header_row + 13))->setCellValue('P' . ($header_row + 13), 'Daftar Dokumen Non-Wajib ');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 14) . ':AA' . ($header_row + 14))->setCellValue('Q' . ($header_row + 14), 'Salinan Sertifikat pelatihan/kursus');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 15) . ':AA' . ($header_row + 15))->setCellValue('Q' . ($header_row + 15), 'Salinan Surat Pengalaman Kerja ');

        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($header_row + 9) . ':AE' . ($header_row + 9))->setCellValue('AB' . ($header_row + 9), 'STAFF HRD');
        $objPHPExcel->getActiveSheet()->mergeCells('AF' . ($header_row + 9) . ':AH' . ($header_row + 9))->setCellValue('AF' . ($header_row + 9), 'MGR');
        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($header_row + 10) . ':AE' . ($header_row + 15))->setCellValue('AB' . ($header_row + 10), '');
        $objPHPExcel->getActiveSheet()->mergeCells('AF' . ($header_row + 10) . ':AH' . ($header_row + 15))->setCellValue('AF' . ($header_row + 10), '');
        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($header_row + 16) . ':AC' . ($header_row + 16))->setCellValue('AB' . ($header_row + 16), 'TGL:');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($header_row + 16) . ':AH' . ($header_row + 16))->setCellValue('AD' . ($header_row + 16), '');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 8) . ':A' . ($header_row + 18))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 8) . ':AL' . ($header_row + 18))->applyFromArray($style['headerStyleRight']);

        $objPHPExcel->getActiveSheet()->getStyle('C' . ($header_row + 11) . ':C' . ($header_row + 11))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('C' . ($header_row + 12) . ':C' . ($header_row + 12))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('C' . ($header_row + 13) . ':C' . ($header_row + 13))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('C' . ($header_row + 14) . ':C' . ($header_row + 14))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('C' . ($header_row + 15) . ':C' . ($header_row + 15))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('C' . ($header_row + 16) . ':C' . ($header_row + 16))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 11) . ':P' . ($header_row + 11))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 12) . ':P' . ($header_row + 12))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 14) . ':P' . ($header_row + 14))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 15) . ':P' . ($header_row + 15))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('AB' . ($header_row + 9) . ':AH' . ($header_row + 9))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AB' . ($header_row + 10) . ':AH' . ($header_row + 15))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AB' . ($header_row + 16) . ':AH' . ($header_row + 16))->applyFromArray($style['headerStyle']);



        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 18) . ':P' . ($header_row + 18))->setCellValue('A' . ($header_row + 18), 'Mulai Berlaku : 05-04-2023');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 18) . ':AL' . ($header_row + 18))->setCellValue('Q' . ($header_row + 18), 'FRM-FSS-403-05');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 18) . ':P' . ($header_row + 18))->applyFromArray($style['footerStyleLeftbottom']);
        $objPHPExcel->getActiveSheet()->getStyle('Q' . ($header_row + 18) . ':AL' . ($header_row + 18))->applyFromArray($style['footerStyleRightbottom']);


        // ////////////////////////////////////////////////////////////////////////////////////////////////////////////// HALAMAN 3 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Menambahkan gambar ke sheet aktif
        $objDrawing3 = new Drawing();
        $objDrawing3->setPath('assets/images/logo_terbaru.png');
        $objDrawing3->setWidthAndHeight(50, 50);

        // Mengatur worksheet untuk gambar
        $objDrawing3->setWorksheet($sheet);

        $start_row = $header_row + 21;
        $objDrawing3->setCoordinates('B' . ($start_row + 1))->setOffsetX(-6)->setOffsetY(3);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($start_row + 1) . ':D' . ($start_row + 2));
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($start_row + 1) . ':AC' . ($start_row + 2))->setCellValue('E' . ($start_row + 1), 'PT PULAU SAMBU');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($start_row + 3) . ':D' . ($start_row + 3))->setCellValue('A' . ($start_row + 3), 'JUDUL');
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($start_row + 3) . ':AC' . ($start_row + 3))->setCellValue('E' . ($start_row + 3), 'APLIKASI KERJA');

        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($start_row + 1) . ':AF' . ($start_row + 1))->setCellValue('AD' . ($start_row + 1), 'DOK');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($start_row + 1) . ':AL' . ($start_row + 1))->setCellValue('AG' . ($start_row + 1), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($start_row + 2) . ':AF' . ($start_row + 2))->setCellValue('AD' . ($start_row + 2), 'TGL');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($start_row + 2) . ':AL' . ($start_row + 2))->setCellValue('AG' . ($start_row + 2), ': ' . date('d-m-Y'));
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($start_row + 3) . ':AF' . ($start_row + 3))->setCellValue('AD' . ($start_row + 3), 'HLM');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($start_row + 3) . ':AL' . ($start_row + 3))->setCellValue('AG' . ($start_row + 3), ': 3 dari 3');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($start_row + 1) . ':D' . ($start_row + 2))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('E' . ($start_row + 1) . ':AC' . ($start_row + 2))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('E' . ($start_row + 3) . ':AC' . ($start_row + 3))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($start_row + 3) . ':D' . ($start_row + 3))->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($start_row + 1) . ':AF' . ($start_row + 1))->applyFromArray($style['headerStyleLeftBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($start_row + 2) . ':AF' . ($start_row + 2))->applyFromArray($style['headerStyleLeftBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($start_row + 3) . ':AF' . ($start_row + 3))->applyFromArray($style['headerStyleLeftBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . ($start_row + 1) . ':AL' . ($start_row + 1))->applyFromArray($style['headerStyleRightBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . ($start_row + 2) . ':AL' . ($start_row + 2))->applyFromArray($style['headerStyleRightBottomTop']);
        $objPHPExcel->getActiveSheet()->getStyle('AG' . ($start_row + 3) . ':AL' . ($start_row + 3))->applyFromArray($style['headerStyleRightBottomTop']);

        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($start_row + 1) . ':AL' . ($start_row + 3))->applyFromArray($style['headerStyleRight']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($start_row + 1) . ':A' . ($start_row + 3))->applyFromArray($style['headerStyleLeft']);

        $header_row = $start_row + 3;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 2) . ':AL' . ($header_row + 2))->setCellValue('A' . ($header_row + 2), '4. DEKLARASI');
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':AL' . ($header_row + 2))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':A' . ($header_row + 2))->getAlignment()->setHorizontal('PHPExcel_Style_Alignment::HORIZONTAL_LEFT');
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':AL' . ($header_row + 2))->getFont()->setBold(true);

        for ($i = 145; $i <= 152; $i++) {
            if ($i % 2 == 0) {
                $sheet->getRowDimension($i)->setRowHeight(3.0);
            }
        }

        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 4) . ':AL' . ($header_row + 4))->setCellValue('A' . ($header_row + 4), 'CENTANG DENGAN (X) UNTUK JAWABAN YANG BENAR!');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 6) . ':B' . ($header_row + 6))->setCellValue('B' . ($header_row + 6), '1. ');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 6) . ':O' . ($header_row + 6))->setCellValue('C' . ($header_row + 6), 'Bagaimana kesehatan anda saat ini?');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 6) . ':S' . ($header_row + 6))->setCellValue('Q' . ($header_row + 6), 'Baik');
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($header_row + 6) . ':Z' . ($header_row + 6))->setCellValue('V' . ($header_row + 6), 'Kurang Baik');
        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($header_row + 6) . ':AE' . ($header_row + 6))->setCellValue('AB' . ($header_row + 6), 'Tidak Sehat');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 8) . ':B' . ($header_row + 8))->setCellValue('B' . ($header_row + 8), '2. ');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 8) . ':V' . ($header_row + 8))->setCellValue('C' . ($header_row + 8), 'Apakah anda pernah / mengidap penyakit sbb  :');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 10) . ':B' . ($header_row + 10))->setCellValue('B' . ($header_row + 10), 'a.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 10) . ':N' . ($header_row + 10))->setCellValue('C' . ($header_row + 10), 'Jantung');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 11) . ':B' . ($header_row + 11))->setCellValue('B' . ($header_row + 11), 'b.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 11) . ':N' . ($header_row + 11))->setCellValue('C' . ($header_row + 11), 'Diabetes / Kencing Manis');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 12) . ':B' . ($header_row + 12))->setCellValue('B' . ($header_row + 12), 'c.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 12) . ':N' . ($header_row + 12))->setCellValue('C' . ($header_row + 12), 'Hepatitis A/B (Lever)');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 13) . ':B' . ($header_row + 13))->setCellValue('B' . ($header_row + 13), 'd.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 13) . ':N' . ($header_row + 13))->setCellValue('C' . ($header_row + 13), 'Epilepsi (Ayan)');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 14) . ':B' . ($header_row + 14))->setCellValue('B' . ($header_row + 14), 'e.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 14) . ':N' . ($header_row + 14))->setCellValue('C' . ($header_row + 14), 'Darah Tinggi');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 15) . ':B' . ($header_row + 15))->setCellValue('B' . ($header_row + 15), 'f.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 15) . ':N' . ($header_row + 15))->setCellValue('C' . ($header_row + 15), 'Darah Rendah');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 16) . ':B' . ($header_row + 16))->setCellValue('B' . ($header_row + 16), 'g.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 16) . ':N' . ($header_row + 16))->setCellValue('C' . ($header_row + 16), 'AIDS');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 17) . ':B' . ($header_row + 17))->setCellValue('B' . ($header_row + 17), 'h.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 17) . ':N' . ($header_row + 17))->setCellValue('C' . ($header_row + 17), 'Kanker');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 18) . ':B' . ($header_row + 18))->setCellValue('B' . ($header_row + 18), 'i.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 18) . ':N' . ($header_row + 18))->setCellValue('C' . ($header_row + 18), 'TBC');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 19) . ':B' . ($header_row + 19))->setCellValue('B' . ($header_row + 19), 'j.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 19) . ':N' . ($header_row + 19))->setCellValue('C' . ($header_row + 19), 'Lepra');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 20) . ':B' . ($header_row + 20))->setCellValue('B' . ($header_row + 20), 'k.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 20) . ':N' . ($header_row + 20))->setCellValue('C' . ($header_row + 20), 'Rabun (jauh/Dekat)');

        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 10) . ':W' . ($header_row + 10))->setCellValue('W' . ($header_row + 10), 'l.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 10) . ':AC' . ($header_row + 10))->setCellValue('X' . ($header_row + 10), 'Tipus');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 11) . ':W' . ($header_row + 11))->setCellValue('W' . ($header_row + 11), 'm.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 11) . ':AC' . ($header_row + 11))->setCellValue('X' . ($header_row + 11), 'Buta Warna');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 12) . ':W' . ($header_row + 12))->setCellValue('W' . ($header_row + 12), 'n.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 12) . ':AC' . ($header_row + 12))->setCellValue('X' . ($header_row + 12), 'Beri-Beri');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 13) . ':W' . ($header_row + 13))->setCellValue('W' . ($header_row + 13), 'o.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 13) . ':AC' . ($header_row + 13))->setCellValue('X' . ($header_row + 13), 'Maag');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 14) . ':W' . ($header_row + 14))->setCellValue('W' . ($header_row + 14), 'p.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 14) . ':AC' . ($header_row + 14))->setCellValue('X' . ($header_row + 14), 'Reumatik (encok)');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 15) . ':W' . ($header_row + 15))->setCellValue('W' . ($header_row + 15), 'q.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 15) . ':AC' . ($header_row + 15))->setCellValue('X' . ($header_row + 15), 'Ginjal');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 16) . ':W' . ($header_row + 16))->setCellValue('W' . ($header_row + 16), 'r.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 16) . ':AC' . ($header_row + 16))->setCellValue('X' . ($header_row + 16), 'Cacar Air');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 17) . ':W' . ($header_row + 17))->setCellValue('W' . ($header_row + 17), 's.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 17) . ':AC' . ($header_row + 17))->setCellValue('X' . ($header_row + 17), 'Alergi');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 18) . ':W' . ($header_row + 18))->setCellValue('W' . ($header_row + 18), 't.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 18) . ':AC' . ($header_row + 18))->setCellValue('X' . ($header_row + 18), 'Hernia');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 19) . ':W' . ($header_row + 19))->setCellValue('W' . ($header_row + 19), 'u.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 19) . ':AC' . ($header_row + 19))->setCellValue('X' . ($header_row + 19), 'Usus Buntu');
        $objPHPExcel->getActiveSheet()->mergeCells('W' . ($header_row + 20) . ':W' . ($header_row + 20))->setCellValue('W' . ($header_row + 20), 'v.');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($header_row + 20) . ':AC' . ($header_row + 20))->setCellValue('X' . ($header_row + 20), 'Operasi*');


        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 0) . ':AL' . ($header_row + 20))->applyFromArray($style['headerStyleRight']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 0) . ':A' . ($header_row + 20))->applyFromArray($style['headerStyleLeft']);

        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 6) . ':P' . ($header_row + 6))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('U' . ($header_row + 6) . ':U' . ($header_row + 6))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AA' . ($header_row + 6) . ':AA' . ($header_row + 6))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 4) . ':A' . ($header_row + 4))->getAlignment()->setHorizontal('PHPExcel_Style_Alignment::HORIZONTAL_LEFT');
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 4) . ':AL' . ($header_row + 4))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C' . ($header_row + 6) . ':C' . ($header_row + 6))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C' . ($header_row + 8) . ':C' . ($header_row + 8))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 2) . ':AL' . ($header_row + 2))->getFont()->setBold(true);



        for ($i = 10; $i <= 20; $i++) {
            $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + $i) . ':P' . ($header_row + $i))->setCellValue('P' . ($header_row + $i), 'Ya');
            $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + $i) . ':U' . ($header_row + $i))->setCellValue('S' . ($header_row + $i), 'Tidak');
            $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($header_row + $i) . ':AG' . ($header_row + $i))->setCellValue('AG' . ($header_row + $i), 'Ya');
            $objPHPExcel->getActiveSheet()->mergeCells('AJ' . ($header_row + $i) . ':AL' . ($header_row + $i))->setCellValue('AJ' . ($header_row + $i), 'Tidak');

            $objPHPExcel->getActiveSheet()->getStyle('O' . ($header_row + $i) . ':O' . ($header_row + $i))->applyFromArray($style['bodyStyle']);
            $objPHPExcel->getActiveSheet()->getStyle('R' . ($header_row + $i) . ':R' . ($header_row + $i))->applyFromArray($style['bodyStyle']);
            $objPHPExcel->getActiveSheet()->getStyle('AF' . ($header_row + $i) . ':AF' . ($header_row + $i))->applyFromArray($style['bodyStyle']);
            $objPHPExcel->getActiveSheet()->getStyle('AI' . ($header_row + $i) . ':AI' . ($header_row + $i))->applyFromArray($style['bodyStyle']);
        }
        $sheet->getRowDimension(164)->setRowHeight(3.0);
        $sheet->getRowDimension(166)->setRowHeight(3.0);

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 22) . ':S' . ($header_row + 22))->setCellValue('B' . ($header_row + 22), '*Jika anda pernah mengalami operasi, jelaskan:');
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 22) . ':AK' . ($header_row + 22))->setCellValue('T' . ($header_row + 22), '');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 24) . ':B' . ($header_row + 24))->setCellValue('B' . ($header_row + 24), '3. ');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 24) . ':I' . ($header_row + 24))->setCellValue('C' . ($header_row + 24), 'Apakah anda :');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 25) . ':B' . ($header_row + 25))->setCellValue('B' . ($header_row + 25), 'a.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 25) . ':I' . ($header_row + 25))->setCellValue('C' . ($header_row + 25), 'Merokok');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 25) . ':M' . ($header_row + 25))->setCellValue('M' . ($header_row + 25), 'Ya');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 25) . ':R' . ($header_row + 25))->setCellValue('P' . ($header_row + 25), 'Tidak');
        $objPHPExcel->getActiveSheet()->mergeCells('S' . ($header_row + 25) . ':AC' . ($header_row + 25))->setCellValue('S' . ($header_row + 25), 'Bila Ya, berapa batang per hari?');
        $objPHPExcel->getActiveSheet()->mergeCells('AD' . ($header_row + 25) . ':AF' . ($header_row + 25))->setCellValue('AD' . ($header_row + 25), '');
        $objPHPExcel->getActiveSheet()->mergeCells('AG' . ($header_row + 25) . ':AI' . ($header_row + 25))->setCellValue('AG' . ($header_row + 25), 'Batang');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 27) . ':B' . ($header_row + 27))->setCellValue('B' . ($header_row + 27), 'b.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 27) . ':K' . ($header_row + 27))->setCellValue('C' . ($header_row + 27), 'Mengkonsumsi Alkohol');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 27) . ':M' . ($header_row + 27))->setCellValue('M' . ($header_row + 27), 'Ya');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 27) . ':R' . ($header_row + 27))->setCellValue('P' . ($header_row + 27), 'Tidak');


        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 29) . ':B' . ($header_row + 29))->setCellValue('B' . ($header_row + 29), '4.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 29) . ':O' . ($header_row + 29))->setCellValue('C' . ($header_row + 29), 'Apakah anda pernah / memiliki :');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 31) . ':B' . ($header_row + 31))->setCellValue('B' . ($header_row + 31), 'a.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 31) . ':I' . ($header_row + 31))->setCellValue('C' . ($header_row + 31), 'Tato');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 31) . ':Q' . ($header_row + 31))->setCellValue('Q' . ($header_row + 31), 'Ya');
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 31) . ':V' . ($header_row + 31))->setCellValue('T' . ($header_row + 31), 'Tidak');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 33) . ':B' . ($header_row + 33))->setCellValue('B' . ($header_row + 33), 'b.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 33) . ':O' . ($header_row + 33))->setCellValue('C' . ($header_row + 33), 'Mengkonsumsi obat - obat terlarang');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 33) . ':Q' . ($header_row + 33))->setCellValue('Q' . ($header_row + 33), 'Ya');
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 33) . ':V' . ($header_row + 33))->setCellValue('T' . ($header_row + 33), 'Tidak');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 35) . ':B' . ($header_row + 35))->setCellValue('B' . ($header_row + 35), 'c.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 35) . ':O' . ($header_row + 35))->setCellValue('C' . ($header_row + 35), 'Terlibat dalam kasus kriminal');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 35) . ':Q' . ($header_row + 35))->setCellValue('Q' . ($header_row + 35), 'Ya');
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 35) . ':V' . ($header_row + 35))->setCellValue('T' . ($header_row + 35), 'Tidak');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 37) . ':B' . ($header_row + 37))->setCellValue('B' . ($header_row + 37), 'd.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 37) . ':O' . ($header_row + 37))->setCellValue('C' . ($header_row + 37), 'Dipenjara');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 37) . ':Q' . ($header_row + 37))->setCellValue('Q' . ($header_row + 37), 'Ya');
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 37) . ':V' . ($header_row + 37))->setCellValue('T' . ($header_row + 37), 'Tidak');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 39) . ':B' . ($header_row + 39))->setCellValue('B' . ($header_row + 39), '5.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 39) . ':O' . ($header_row + 39))->setCellValue('C' . ($header_row + 39), 'Apakah anda sedang mengandung ?');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 39) . ':Q' . ($header_row + 39))->setCellValue('Q' . ($header_row + 39), 'Ya');
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 39) . ':V' . ($header_row + 39))->setCellValue('T' . ($header_row + 39), 'Tidak');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 41) . ':B' . ($header_row + 41))->setCellValue('B' . ($header_row + 41), '6.');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 41) . ':O' . ($header_row + 41))->setCellValue('C' . ($header_row + 41), 'Apakah anda berencana utk memiliki');
        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($header_row + 43) . ':O' . ($header_row + 43))->setCellValue('C' . ($header_row + 43), 'anak dalam waktu dekat ?');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 41) . ':Q' . ($header_row + 41))->setCellValue('Q' . ($header_row + 41), 'Ya');
        $objPHPExcel->getActiveSheet()->mergeCells('T' . ($header_row + 41) . ':V' . ($header_row + 41))->setCellValue('T' . ($header_row + 41), 'Tidak');

        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 45) . ':AK' . ($header_row + 45))->setCellValue('B' . ($header_row + 45), 'Saya bersedia dimutasikan ke SAMBU GROUP, bila sewaktu-waktu diperlukan Perusahaan. ');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 46) . ':AK' . ($header_row + 46))->setCellValue('B' . ($header_row + 46), 'Demikian pernyataan ini saya berikan dengan sesungguhnya dan sebenar-benarnya. Apabila ternyata data yang ');
        $objPHPExcel->getActiveSheet()->mergeCells('B' . ($header_row + 47) . ':AK' . ($header_row + 47))->setCellValue('B' . ($header_row + 47), 'saya buat tidak benar, saya  bersedia di PHK-kan tanpa syarat. ');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 22) . ':A' . ($header_row + 49))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 22) . ':AL' . ($header_row + 49))->applyFromArray($style['headerStyleRight']);

        $objPHPExcel->getActiveSheet()->getStyle('T' . ($header_row + 22) . ':AK' . ($header_row + 22))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('L' . ($header_row + 25) . ':L' . ($header_row + 25))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('O' . ($header_row + 25) . ':O' . ($header_row + 25))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AD' . ($header_row + 25) . ':AF' . ($header_row + 25))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('L' . ($header_row + 27) . ':L' . ($header_row + 27))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('O' . ($header_row + 27) . ':O' . ($header_row + 27))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 31) . ':P' . ($header_row + 31))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('S' . ($header_row + 31) . ':S' . ($header_row + 31))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 33) . ':P' . ($header_row + 33))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('S' . ($header_row + 33) . ':S' . ($header_row + 33))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 35) . ':P' . ($header_row + 35))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('S' . ($header_row + 35) . ':S' . ($header_row + 35))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 37) . ':P' . ($header_row + 37))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('S' . ($header_row + 37) . ':S' . ($header_row + 37))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 39) . ':P' . ($header_row + 39))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('S' . ($header_row + 39) . ':S' . ($header_row + 39))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('P' . ($header_row + 41) . ':P' . ($header_row + 41))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('S' . ($header_row + 41) . ':S' . ($header_row + 41))->applyFromArray($style['bodyStyle']);


        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 24) . ':C' . ($header_row + 24))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 39) . ':C' . ($header_row + 39))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 41) . ':C' . ($header_row + 41))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($header_row + 43) . ':C' . ($header_row + 43))->getFont()->setBold(true);



        for ($i = 168; $i <= 186; $i++) {
            if ($i % 2 != 0) {
                $sheet->getRowDimension($i)->setRowHeight(3.0);
            }
        }

        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 49) . ':L' . ($header_row + 49))->setCellValue('A' . ($header_row + 49), 'Pemohon ');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 49) . ':AL' . ($header_row + 49))->setCellValue('M' . ($header_row + 49), 'Disetujui ');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 49) . ':AL' . ($header_row + 52))->applyFromArray($style['headerStyle']);

        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 50) . ':L' . ($header_row + 52))->setCellValue('A' . ($header_row + 50), ' ');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 50) . ':X' . ($header_row + 52))->setCellValue('M' . ($header_row + 50), ' ');
        $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($header_row + 50) . ':AL' . ($header_row + 52))->setCellValue('Y' . ($header_row + 50), ' ');

        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 53) . ':D' . ($header_row + 53))->setCellValue('A' . ($header_row + 53), 'Nama');
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($header_row + 53) . ':E' . ($header_row + 53))->setCellValue('E' . ($header_row + 53), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('F' . ($header_row + 53) . ':L' . ($header_row + 53))->setCellValue('F' . ($header_row + 53), '');

        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 54) . ':D' . ($header_row + 54))->setCellValue('A' . ($header_row + 54), 'Tanggal');
        $objPHPExcel->getActiveSheet()->mergeCells('E' . ($header_row + 54) . ':E' . ($header_row + 54))->setCellValue('E' . ($header_row + 54), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('F' . ($header_row + 54) . ':L' . ($header_row + 54))->setCellValue('F' . ($header_row + 54), '');

        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 53) . ':O' . ($header_row + 53))->setCellValue('M' . ($header_row + 53), 'Nama');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 53) . ':P' . ($header_row + 53))->setCellValue('P' . ($header_row + 53), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 53) . ':X' . ($header_row + 53))->setCellValue('Q' . ($header_row + 53), '');

        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 54) . ':O' . ($header_row + 54))->setCellValue('M' . ($header_row + 54), 'Jabatan');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 54) . ':P' . ($header_row + 54))->setCellValue('P' . ($header_row + 54), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 54) . ':X' . ($header_row + 54))->setCellValue('Q' . ($header_row + 54), 'KD/MGR DEPT.');

        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($header_row + 55) . ':O' . ($header_row + 55))->setCellValue('M' . ($header_row + 55), 'Tanggal');
        $objPHPExcel->getActiveSheet()->mergeCells('P' . ($header_row + 55) . ':P' . ($header_row + 55))->setCellValue('P' . ($header_row + 55), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 55) . ':X' . ($header_row + 55))->setCellValue('Q' . ($header_row + 55), '');

        $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($header_row + 53) . ':AA' . ($header_row + 53))->setCellValue('Y' . ($header_row + 53), 'Nama');
        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($header_row + 53) . ':AB' . ($header_row + 53))->setCellValue('AB' . ($header_row + 53), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 53) . ':X' . ($header_row + 53))->setCellValue('Q' . ($header_row + 53), '');

        $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($header_row + 54) . ':AA' . ($header_row + 54))->setCellValue('Y' . ($header_row + 54), 'Jabatan');
        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($header_row + 54) . ':AB' . ($header_row + 54))->setCellValue('AB' . ($header_row + 54), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . ($header_row + 54) . ':AL' . ($header_row + 54))->setCellValue('AC' . ($header_row + 54), 'KD/MGR DEPT.');

        $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($header_row + 55) . ':AA' . ($header_row + 55))->setCellValue('Y' . ($header_row + 55), 'Tanggal');
        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($header_row + 55) . ':AB' . ($header_row + 55))->setCellValue('AB' . ($header_row + 55), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . ($header_row + 55) . ':AL' . ($header_row + 55))->setCellValue('AC' . ($header_row + 55), '');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 53) . ':A' . ($header_row + 55))->applyFromArray($style['headerStyleLeft']);
        $objPHPExcel->getActiveSheet()->getStyle('L' . ($header_row + 53) . ':L' . ($header_row + 55))->applyFromArray($style['headerStyleRight']);
        $objPHPExcel->getActiveSheet()->getStyle('X' . ($header_row + 53) . ':X' . ($header_row + 55))->applyFromArray($style['headerStyleRight']);
        $objPHPExcel->getActiveSheet()->getStyle('AL' . ($header_row + 53) . ':AL' . ($header_row + 55))->applyFromArray($style['headerStyleRight']);


        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($header_row + 56) . ':P' . ($header_row + 56))->setCellValue('A' . ($header_row + 56), 'Mulai Berlaku : 05-04-2023');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($header_row + 56) . ':AL' . ($header_row + 56))->setCellValue('Q' . ($header_row + 56), 'FRM-FSS-403-05');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($header_row + 56) . ':P' . ($header_row + 56))->applyFromArray($style['footerStyleLeftbottom']);
        $objPHPExcel->getActiveSheet()->getStyle('Q' . ($header_row + 56) . ':AL' . ($header_row + 56))->applyFromArray($style['footerStyleRightbottom']);

        $foot_row = $header_row + 56;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($foot_row + 2) . ':L' . ($foot_row + 2))->setCellValue('A' . ($foot_row + 2), 'KHUSUS DIISI OLEH PERUSAHAAN');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($foot_row + 2) . ':X' . ($foot_row + 2))->setCellValue('M' . ($foot_row + 2), 'KHUSUS DIISI OLEH PERUSAHAAN');
        $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($foot_row + 2) . ':AL' . ($foot_row + 2))->setCellValue('Y' . ($foot_row + 2), 'KHUSUS DIISI OLEH PERUSAHAAN');

        for ($i = 203; $i <= 212; $i++) {
            if ($i % 2 == 0) {
                $sheet->getRowDimension($i)->setRowHeight(3.0);
            }
        }

        $sheet->getRowDimension(202)->setRowHeight(3.0);
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($foot_row + 4) . ':H' . ($foot_row + 4))->setCellValue('A' . ($foot_row + 4), 'Diwawancarai oleh:');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($foot_row + 5) . ':H' . ($foot_row + 9))->setCellValue('A' . ($foot_row + 5), '');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . ($foot_row + 10) . ':H' . ($foot_row + 10))->setCellValue('A' . ($foot_row + 10), 'INTERVIEWER');

        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($foot_row + 4) . ':L' . ($foot_row + 4))->setCellValue('J' . ($foot_row + 4), 'Tempat');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($foot_row + 4) . ':M' . ($foot_row + 4))->setCellValue('M' . ($foot_row + 4), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('N' . ($foot_row + 4) . ':V' . ($foot_row + 4))->setCellValue('N' . ($foot_row + 4), '');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($foot_row + 4) . ':AA' . ($foot_row + 4))->setCellValue('X' . ($foot_row + 4), 'Gaji Bruto');
        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($foot_row + 4) . ':AB' . ($foot_row + 4))->setCellValue('AB' . ($foot_row + 4), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . ($foot_row + 4) . ':AL' . ($foot_row + 4))->setCellValue('AC' . ($foot_row + 4), '');

        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($foot_row + 6) . ':L' . ($foot_row + 6))->setCellValue('J' . ($foot_row + 6), 'Tanggal');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($foot_row + 6) . ':M' . ($foot_row + 6))->setCellValue('M' . ($foot_row + 6), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('N' . ($foot_row + 6) . ':V' . ($foot_row + 6))->setCellValue('N' . ($foot_row + 6), '');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($foot_row + 6) . ':AA' . ($foot_row + 6))->setCellValue('X' . ($foot_row + 6), 'Mulai Kerja');
        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($foot_row + 6) . ':AB' . ($foot_row + 6))->setCellValue('AB' . ($foot_row + 6), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . ($foot_row + 6) . ':AL' . ($foot_row + 6))->setCellValue('AC' . ($foot_row + 6), '');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($foot_row + 2) . ':AL' . ($foot_row + 2))->applyFromArray($style['headerStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($foot_row + 4) . ':H' . ($foot_row + 10))->applyFromArray($style['headerStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('N' . ($foot_row + 4) . ':V' . ($foot_row + 4))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AC' . ($foot_row + 4) . ':AL' . ($foot_row + 4))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('N' . ($foot_row + 6) . ':V' . ($foot_row + 6))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AC' . ($foot_row + 6) . ':AL' . ($foot_row + 6))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->getStyle('N' . ($foot_row + 6) . ':V' . ($foot_row + 6))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AC' . ($foot_row + 6) . ':AL' . ($foot_row + 6))->applyFromArray($style['bodyStyle']);



        $objPHPExcel->getActiveSheet()->mergeCells('J' . ($foot_row + 8) . ':L' . ($foot_row + 8))->setCellValue('J' . ($foot_row + 8), 'Trial');
        $objPHPExcel->getActiveSheet()->mergeCells('M' . ($foot_row + 8) . ':M' . ($foot_row + 8))->setCellValue('M' . ($foot_row + 8), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('N' . ($foot_row + 8) . ':P' . ($foot_row + 8))->setCellValue('N' . ($foot_row + 8), '');
        $objPHPExcel->getActiveSheet()->mergeCells('Q' . ($foot_row + 8) . ':V' . ($foot_row + 8))->setCellValue('Q' . ($foot_row + 8), 'Bulan');
        $objPHPExcel->getActiveSheet()->mergeCells('X' . ($foot_row + 8) . ':AA' . ($foot_row + 8))->setCellValue('X' . ($foot_row + 8), 'Jabatan');
        $objPHPExcel->getActiveSheet()->mergeCells('AB' . ($foot_row + 8) . ':AB' . ($foot_row + 8))->setCellValue('AB' . ($foot_row + 8), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('AC' . ($foot_row + 8) . ':AL' . ($foot_row + 8))->setCellValue('AC' . ($foot_row + 8), '');

        $objPHPExcel->getActiveSheet()->getStyle('AC' . ($foot_row + 8) . ':P' . ($foot_row + 8))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AC' . ($foot_row + 6) . ':AL' . ($foot_row + 6))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('N' . ($foot_row + 8) . ':P' . ($foot_row + 8))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('AC' . ($foot_row + 8) . ':AL' . ($foot_row + 8))->applyFromArray($style['bodyStyle']);

        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($foot_row + 12) . ':E' . ($foot_row + 12))->setCellValue('C' . ($foot_row + 12), 'TK-0');
        $objPHPExcel->getActiveSheet()->mergeCells('G' . ($foot_row + 12) . ':I' . ($foot_row + 12))->setCellValue('G' . ($foot_row + 12), 'TK-1');
        $objPHPExcel->getActiveSheet()->mergeCells('K' . ($foot_row + 12) . ':M' . ($foot_row + 12))->setCellValue('K' . ($foot_row + 12), 'TK-2');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . ($foot_row + 12) . ':Q' . ($foot_row + 12))->setCellValue('O' . ($foot_row + 12), 'TK-3');
        $objPHPExcel->getActiveSheet()->mergeCells('V' . ($foot_row + 12) . ':X' . ($foot_row + 12))->setCellValue('V' . ($foot_row + 12), 'Shift');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($foot_row + 12) . ':AC' . ($foot_row + 12))->setCellValue('Z' . ($foot_row + 12), 'Non-Shift');

        $objPHPExcel->getActiveSheet()->getStyle('B' . ($foot_row + 12) . ':B' . ($foot_row + 12))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('F' . ($foot_row + 12) . ':F' . ($foot_row + 12))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('J' . ($foot_row + 12) . ':J' . ($foot_row + 12))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('N' . ($foot_row + 12) . ':N' . ($foot_row + 12))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('U' . ($foot_row + 12) . ':U' . ($foot_row + 12))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('Y' . ($foot_row + 12) . ':Y' . ($foot_row + 12))->applyFromArray($style['bodyStyle']);


        $objPHPExcel->getActiveSheet()->mergeCells('C' . ($foot_row + 14) . ':E' . ($foot_row + 14))->setCellValue('C' . ($foot_row + 14), 'K-0');
        $objPHPExcel->getActiveSheet()->mergeCells('G' . ($foot_row + 14) . ':I' . ($foot_row + 14))->setCellValue('G' . ($foot_row + 14), 'K-1');
        $objPHPExcel->getActiveSheet()->mergeCells('K' . ($foot_row + 14) . ':M' . ($foot_row + 14))->setCellValue('K' . ($foot_row + 14), 'K-2');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . ($foot_row + 14) . ':Q' . ($foot_row + 14))->setCellValue('O' . ($foot_row + 14), 'K-3');
        $objPHPExcel->getActiveSheet()->mergeCells('U' . ($foot_row + 14) . ':X' . ($foot_row + 14))->setCellValue('U' . ($foot_row + 14), 'Departement');
        $objPHPExcel->getActiveSheet()->mergeCells('Y' . ($foot_row + 14) . ':Y' . ($foot_row + 14))->setCellValue('Y' . ($foot_row + 14), ':');
        $objPHPExcel->getActiveSheet()->mergeCells('Z' . ($foot_row + 14) . ':AK' . ($foot_row + 14))->setCellValue('Z' . ($foot_row + 14), '');

        $objPHPExcel->getActiveSheet()->getStyle('B' . ($foot_row + 14) . ':B' . ($foot_row + 14))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('F' . ($foot_row + 14) . ':F' . ($foot_row + 14))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('J' . ($foot_row + 14) . ':J' . ($foot_row + 14))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('N' . ($foot_row + 14) . ':N' . ($foot_row + 14))->applyFromArray($style['bodyStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('Z' . ($foot_row + 14) . ':AK' . ($foot_row + 14))->applyFromArray($style['bodyStyle']);






























        // $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('A1', 'DAFTAR RIWAYAT HIDUP');


        // $obj = $objPHPExcel->setActiveSheetIndex(0);
        // $obj->setCellValue('A3', 'NO.');
        // $obj->mergeCells('B3:I3')->setCellValue('B3', 'Item');
        // $obj->mergeCells('J3:S3')->setCellValue('J3', '');
        // $objPHPExcel->getActiveSheet()->getStyle('A1:S2')->applyFromArray($style['PTStyle']);
        // $objPHPExcel->getActiveSheet()->getStyle('A3:S3')->applyFromArray($style['DetailheaderStyle']);


        // $counter = 4;
        // $no = 1;
        // foreach ($item as $key => $row) :
        //     $obj->setCellValue('A' . $counter, $key + 1);
        //     $obj->mergeCells('B' . $counter . ':I' . $counter)->setCellValue('B' . $counter, $row['item'] . ((($key + 1) != 35) && ($key + 1) != 47 && ($key + 1) != 48 && ($key + 1) != 49 && ($key + 1) != 57 && ($key + 1) != 58 ? ' *)' : ''));
        //     if (($key + 1) >= 64) {

        //         $obj->mergeCells('J' . $counter . ':O' . $counter)->setCellValue('J' . $counter, (($key + 1) == 3 ? '`' : '') . $row['value']);
        //     } else {
        //         $obj->mergeCells('J' . $counter . ':S' . $counter)->setCellValue('J' . $counter, (($key + 1) == 3 ? '`' : '') . $row['value']);
        //     }
        //     $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':S' . $counter)->applyFromArray($style['DetailheaderStyle']);
        //     $objPHPExcel->getActiveSheet()->getStyle('B' . $counter . ':B' . $counter)->applyFromArray($style['headerStyleLeft']);
        //     $objPHPExcel->getActiveSheet()->getStyle('J' . $counter . ':J' . $counter)->applyFromArray($style['headerStyleLeft']);

        //     $counter++;
        //     $no++;
        // endforeach;
        // $obj->mergeCells('P67:S67')->setCellValue('P67', 'Diverifikasi');
        // $obj->mergeCells('P68:S68')->setCellValue('P68', 'By : ');
        // $obj->mergeCells('P69:S69')->setCellValue('P69', 'Tgl :  ');
        // $obj->mergeCells('P70:S70')->setCellValue('P70', 'Paraf : ');

        // $counterb = $counter + 0;

        // $obj->mergeCells('A' . ($counterb + 0) . ':B' . ($counterb + 6))->setCellValue('A' . ($counterb + 0), 'PHOTO');
        // $obj->mergeCells('C' . ($counterb + 0) . ':E' . ($counterb + 0))->setCellValue('C' . ($counterb + 0), 'Lampiran dan keterangACn');
        // $obj->mergeCells('C' . ($counterb + 1) . ':E' . ($counterb + 1))->setCellValue('C' . ($counterb + 1), '- TRANSKIP NILAI');
        // $obj->mergeCells('C' . ($counterb + 2) . ':E' . ($counterb + 2))->setCellValue('C' . ($counterb + 2), '-  *) HARUS DIISI');

        // $obj->mergeCells('N' . ($counterb + 0) . ':O' . ($counterb + 0))->setCellValue('N' . ($counterb + 0), 'Tanggal Data');
        // $obj->mergeCells('P' . ($counterb + 0) . ':Q' . ($counterb + 0))->setCellValue('P' . ($counterb + 0), ': ' . date('d-m-Y'));
        // $obj->mergeCells('A' . ($counterb + 7) . ':S' . ($counterb + 7))->setCellValue('A' . ($counterb + 7), 'Demikian Daftar Riwayat Hidup ini saya buat dengan sebenarnya');

        // $objPHPExcel->getActiveSheet()->getStyle('A' . ($counterb + 0) . ':B' . ($counterb + 6))->applyFromArray($style['DetailheaderStyle']);
        // $objPHPExcel->getActiveSheet()->getStyle('C' . ($counterb + 0) . ':S' . ($counterb + 6))->applyFromArray($style['noborderStyle']);
        // $objPHPExcel->getActiveSheet()->getStyle('A' . ($counterb + 7) . ':S' . ($counterb + 7))->applyFromArray($style['DetailheaderStyle']);
        // $objPHPExcel->getActiveSheet()->getStyle('P67:P70')->applyFromArray($style['headerStyleLeft']);

        // $objPHPExcel->getActiveSheet()->getStyle('S' . ($counterb + 0) . ':S' . ($counterb + 6))->applyFromArray($style['headerStyleRight']);



        // $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        // header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
        // header('Chace-Control: no-store, no-cache, must-revalation');
        // header('Chace-Control: post-check=0, pre-check=0', FALSE);
        // header('Pragma: no-cache');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="APLIKASI KERJA.xlsx"');

        // $objWriter->save('php://output');
        // batas
        // print_r($dt_detail);

        // ob_clean();
        // header('Content-Type: text/html; charset=utf-8');
        // header('Content-type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="CV (' . $nama_lengkap . ').xlsx"');

        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save('php://output');
        // exit();
        // ob_end_clean();

        $writer = new Xlsx($objPHPExcel);

        header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="CV (' . $nama_lengkap . ').xlsx"');

        $writer->save('php://output');
        exit;
    }

    public function index()
    {
        $this->load->library("Excel/PHPExcel");

        $dt_detail   = $this->m_wawancara->getTenagaKerja();

        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Identifikasi By PSN - List Tenaga Kerja Baru / ' . date("d-m-Y H:i:s"))
            ->setCellValue('A3', 'No.')
            ->setCellValue('B3', 'RegisID')
            ->setCellValue('C3', 'Nama')
            ->setCellValue('D3', 'Jenis Kelamin')
            ->setCellValue('E3', 'Pemborong')
            ->setCellValue('F3', 'Asal')
            ->setCellValue('G3', 'Terakhir Verifikasi Oleh');

        $obj = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 4;
        foreach ($dt_detail as $key => $row) :
            $obj->setCellValue('A' . $counter, $key + 1);
            $obj->setCellValue('B' . $counter, $row->HeaderID);
            $obj->setCellValue('C' . $counter, $row->Nama);
            $obj->setCellValue('D' . $counter, $row->Jenis_Kelamin);
            $obj->setCellValue('E' . $counter, $row->Pemborong . ' - ' . $row->CVNama);
            $obj->setCellValue('F' . $counter, $row->Alamat);
            $obj->setCellValue('G' . $counter, $row->VerifiedBy . ' (' . date("d-m-Y", strtotime($row->VerifiedDate)) . ')');
            $counter++;
        endforeach;

        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Identifikasi By PSN (' . date("d-m-Y His") . ').xlsx"');

        $objWriter->save('php://output');
    }

    function excelStyle()
    {
        // ============================================================
        // BASE STYLE - digunakan sebagai template dasar
        // ============================================================
        $baseFont = [
            'name' => 'Times New Roman',
            'size' => 11,
        ];

        $baseNumberFormat = [
            'formatCode' => NumberFormat::FORMAT_TEXT,
        ];

        $borderThin = ['borderStyle' => Border::BORDER_THIN];
        $borderDotted = ['borderStyle' => Border::BORDER_DOTTED];
        $borderDouble = ['borderStyle' => Border::BORDER_DOUBLE];
        $borderThick = ['borderStyle' => Border::BORDER_THICK];
        $borderDashDotDot = ['borderStyle' => Border::BORDER_DASHDOTDOT];

        // ============================================================
        // DIAGONAL BORDER
        // ============================================================
        $DiagonalBorder = [
            'borders' => [
                'diagonal' => $borderThin,
                'diagonalDirection' => Borders::DIAGONAL_DOWN,
            ],
        ];

        // ============================================================
        // PT STYLE - Header PT PULAU SAMBU (bold, size 14, all border)
        // ============================================================
        $PTStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 14],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $PTStyleNoRightBorder = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 14],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        // ============================================================
        // DETAIL HEADER - dengan border DashDotDot di kiri-kanan
        // ============================================================
        $DetailheaderDetDashStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderDashDotDot,
                'left' => $borderDashDotDot,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        // ============================================================
        // JUST BORDER STYLE - all border thin, size 12
        // ============================================================
        $justBorderStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 12],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
        ];

        $borderJustBottomStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 12],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
            ],
        ];

        // ============================================================
        // HEADER STYLE - bold, all border (menggunakan allBorders)
        // ============================================================
        $headerStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'allBorders' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        // ============================================================
        // HEADER STYLE VARIANTS - untuk berbagai posisi border
        // ============================================================
        $headerStyleRight = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['right' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleRightcenter = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['right' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleRightleftcenter = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'left' => $borderThin,
                'right' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $StyleBottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['bottom' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $StyleBorderTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['top' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $StyleBottomunderline = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['bottom' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleLeft = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['left' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleLeftRight = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'left' => $borderThin,
                'right' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleLeftRight2 = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'left' => $borderThin,
                'right' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleRightTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleLeftTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleRightbottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleRightbottomcenter = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleRightleftbottomcenter = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
                'left' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleRightleftbottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
                'left' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleLeftBottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'left' => $borderThin,
                'bottom' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleRightBottomTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $StyleRightBottomTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $Style14 = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 14],
            'numberFormat' => $baseNumberFormat,
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleLeftBottomTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'left' => $borderThin,
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleLeftRightTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'left' => $borderThin,
                'right' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $headerStyleTopBottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $justBottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['bottom' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $justTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['top' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $justRight = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['right' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $justLeft = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['left' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $StyleLeftBottomTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'left' => $borderThin,
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $StyleBottomTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        // ============================================================
        // NO BORDER STYLE
        // ============================================================
        $noborderStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $rightborderStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['right' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $leftborderStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['left' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        // ============================================================
        // DETAIL HEADER VARIANTS
        // ============================================================
        $DetailheaderStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $DetailheaderStyleBold = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $DetailheaderStyleleft = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $DetailheaderStyleleftNoBorder = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $DetailheaderStyletopbottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $DetailheaderStyleright = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $DetailheaderVerticalStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_BOTTOM,
                'wrapText' => true,
            ],
        ];

        $DetailheaderRightTopStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $DetailheaderRightBottomStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $DetailheaderRightStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['right' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $DetailheaderLeftStyle = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => true, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['left' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        // ============================================================
        // FOOTER STYLES
        // ============================================================
        $footerStyleRightbottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerStyleRightTop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerStyleRightbottom2 = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerStyleRightbottom3 = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'bottom' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerStyleRight = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['right' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerStyleRightLeftbottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'left' => $borderThin,
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerRightLeftbottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'right' => $borderThin,
                'left' => $borderThin,
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerStyleLeftbottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'top' => $borderThin,
                'left' => $borderThin,
                'bottom' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerStyleLeft = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['left' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerStylebottomtop = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $footerStylebottom = [
            'fill' => ['fillType' => Fill::FILL_SOLID],
            'font' => ['bold' => false, 'name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['bottom' => $borderThin],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        // ============================================================
        // BODY STYLES - untuk cell isi data
        // ============================================================
        $bodyStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $bodyStylewithDoth = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderDotted,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $bodyStylewithNoBorderTop = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $bodyStyleLeft = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        // ============================================================
        // DOUBLE & SPECIAL BORDER STYLES
        // ============================================================
        $doubleLeft = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderDouble,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $doubleLeftBottom = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderDouble,
                'right' => $borderThin,
                'left' => $borderDouble,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $doubleSolidTop = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['top' => $borderThick],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $doubleSolidBottom = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThick,
                'right' => $borderThin,
                'left' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $doubleBottom = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderDouble,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $doubleBottomBold = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11, 'bold' => true],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderDouble,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $noborderTop = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderDouble,
                'right' => $borderThin,
                'left' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $noborderTop2 = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderDouble,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $noborderTop3 = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'left' => $borderThin,
                'top' => $borderDouble,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $boderdottedbottom = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11, 'bold' => true],
            'numberFormat' => $baseNumberFormat,
            'borders' => ['bottom' => $borderDotted],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $leftBottomTop = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'left' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $rightBottomTop = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'right' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $BottomTop = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderThin,
                'top' => $borderThin,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $bodyStylewithDot = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'font' => ['name' => 'Times New Roman', 'size' => 11],
            'numberFormat' => $baseNumberFormat,
            'borders' => [
                'bottom' => $borderDotted,
                'right' => $borderDotted,
                'left' => $borderDotted,
                'top' => $borderDotted,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        // ============================================================
        // RETURN ALL STYLES
        // ============================================================
        return [
            'PTStyle'                          => $PTStyle,
            'DetailheaderDetDashStyle'         => $DetailheaderDetDashStyle,
            'justBorderStyle'                  => $justBorderStyle,
            'PTStyleNoRightBorder'             => $PTStyleNoRightBorder,
            'headerStyle'                      => $headerStyle,
            'DetailheaderStyle'                => $DetailheaderStyle,
            'DetailheaderStyleBold'            => $DetailheaderStyleBold,
            'DetailheaderStyleleft'            => $DetailheaderStyleleft,
            'DetailheaderStyleleftNoBorder'    => $DetailheaderStyleleftNoBorder,
            'DetailheaderStyletopbottom'       => $DetailheaderStyletopbottom,
            'DetailheaderStyleright'           => $DetailheaderStyleright,
            'DetailheaderVerticalStyle'        => $DetailheaderVerticalStyle,
            'bodyStyle'                        => $bodyStyle,
            'doubleLeft'                       => $doubleLeft,
            'doubleLeftBottom'                 => $doubleLeftBottom,
            'doubleBottom'                     => $doubleBottom,
            'doubleBottomBold'                 => $doubleBottomBold,
            'doubleSolidTop'                   => $doubleSolidTop,
            'doubleSolidBottom'                => $doubleSolidBottom,
            'noborderTop'                      => $noborderTop,
            'noborderTop2'                     => $noborderTop2,
            'noborderTop3'                     => $noborderTop3,
            'headerStyleRight'                 => $headerStyleRight,
            'headerStyleRightcenter'           => $headerStyleRightcenter,
            'headerStyleRightleftcenter'       => $headerStyleRightleftcenter,
            'headerStyleLeft'                  => $headerStyleLeft,
            'headerStyleLeftRight'             => $headerStyleLeftRight,
            'headerStyleLeftRight2'            => $headerStyleLeftRight2,
            'headerStyleRightTop'              => $headerStyleRightTop,
            'headerStyleLeftTop'               => $headerStyleLeftTop,
            'headerStyleRightbottom'           => $headerStyleRightbottom,
            'headerStyleRightbottomcenter'     => $headerStyleRightbottomcenter,
            'headerStyleRightleftbottomcenter' => $headerStyleRightleftbottomcenter,
            'headerStyleRightleftbottom'       => $headerStyleRightleftbottom,
            'headerStyleLeftBottom'            => $headerStyleLeftBottom,
            'headerStyleRightBottomTop'        => $headerStyleRightBottomTop,
            'headerStyleLeftBottomTop'         => $headerStyleLeftBottomTop,
            'headerStyleLeftRightTop'          => $headerStyleLeftRightTop,
            'headerStyleTopBottom'             => $headerStyleTopBottom,
            'StyleLeftBottomTop'               => $StyleLeftBottomTop,
            'StyleRightBottomTop'              => $StyleRightBottomTop,
            'Style14'                          => $Style14,
            'StyleBottomTop'                   => $StyleBottomTop,
            'StyleBottom'                      => $StyleBottom,
            'StyleBorderTop'                   => $StyleBorderTop,
            'StyleBottomunderline'             => $StyleBottomunderline,
            'borderJustBottomStyle'            => $borderJustBottomStyle,
            'noborderStyle'                    => $noborderStyle,
            'rightborderStyle'                 => $rightborderStyle,
            'leftborderStyle'                  => $leftborderStyle,
            'DetailheaderRightTopStyle'        => $DetailheaderRightTopStyle,
            'DetailheaderRightStyle'           => $DetailheaderRightStyle,
            'DetailheaderLeftStyle'            => $DetailheaderLeftStyle,
            'DetailheaderRightBottomStyle'     => $DetailheaderRightBottomStyle,
            'footerStyleRightbottom'           => $footerStyleRightbottom,
            'footerStyleRightbottom2'          => $footerStyleRightbottom2,
            'footerStyleRightbottom3'          => $footerStyleRightbottom3,
            'footerStyleRightTop'              => $footerStyleRightTop,
            'footerStyleRight'                 => $footerStyleRight,
            'footerStyleRightLeftbottom'       => $footerStyleRightLeftbottom,
            'footerRightLeftbottom'            => $footerRightLeftbottom,
            'footerStyleLeftbottom'            => $footerStyleLeftbottom,
            'footerStyleLeft'                  => $footerStyleLeft,
            'footerStylebottomtop'             => $footerStylebottomtop,
            'footerStylebottom'                => $footerStylebottom,
            'boderdottedbottom'                => $boderdottedbottom,
            'bodyStyleLeft'                    => $bodyStyleLeft,
            'bodyStylewithDoth'                => $bodyStylewithDoth,
            'bodyStylewithDot'                 => $bodyStylewithDot,
            'bodyStylewithNoBorderTop'         => $bodyStylewithNoBorderTop,
            'justBottom'                       => $justBottom,
            'justTop'                          => $justTop,
            'justRight'                        => $justRight,
            'justLeft'                         => $justLeft,
            'leftBottomTop'                    => $leftBottomTop,
            'rightBottomTop'                   => $rightBottomTop,
            'BottomTop'                        => $BottomTop,
            'DiagonalBorder'                   => $DiagonalBorder,
        ];
    }

    // function excelStyle()
    // {


    //     $DiagonalBorder = (array(
    //         'borders' => array(
    //             'diagonal' => array(
    //                 'style' => PHPExcel_Style_Border::BORDER_THIN,
    //             ),
    //             'diagonaldirection' => PHPExcel_Style_Borders::DIAGONAL_DOWN,
    //         ),
    //     ));


    //     $PTStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 14
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderDetDashStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_DASHDOTDOT),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_DASHDOTDOT),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $justBorderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 12
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //     ));

    //     $borderJustBottomStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 12
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         ),
    //     ));


    //     $PTStyleNoRightBorder = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold' => true,
    //             'name' => 'Times New Roman',
    //             'size' => 14
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'allborders' => [
    //                 'style' => PHPExcel_Style_Border::BORDER_THIN,
    //             ],
    //             // 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRight = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightcenter = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightleftcenter = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $StyleBottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $StyleBorderTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $StyleBottomunderline = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11,
    //             // 'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleLeft = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleLeftRight = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleLeftRight2 = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleLeftTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleRightbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleRightbottomcenter = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightleftbottomcenter = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $headerStyleRightleftbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleLeftBottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleRightBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $StyleRightBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $Style14 = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 14
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));


    //     $headerStyleLeftBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleLeftRightTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $headerStyleTopBottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $justBottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $justTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $justRight = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $justLeft = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $StyleLeftBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $StyleBottomTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $noborderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));


    //     $rightborderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $leftborderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyleBold = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyleleft = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyleleftNoBorder = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         // 'borders' => array(
    //         //   'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         //   'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         //   'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         // ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyletopbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderStyleright = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderVerticalStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderRightTopStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderRightBottomStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $DetailheaderRightStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $DetailheaderLeftStyle = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => true,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStyleRightbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStyleRightTop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStyleRightbottom2 = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStyleRightbottom3 = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStyleRight = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStyleRightLeftbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerRightLeftbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStyleLeftbottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'top'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStyleLeft = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $footerStylebottomtop = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $footerStylebottom = (array(
    //         'fill'   => array(
    //             'type'    => PHPExcel_Style_Fill::FILL_SOLID
    //         ),
    //         'font' => array(
    //             'bold'    => false,
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $bodyStyle = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));

    //     $bodyStylewithDoth = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));
    //     $bodyStylewithDot = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_DOTTED)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));

    //     $bodyStylewithNoBorderTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));

    //     $bodyStyleLeft = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $doubleLeft = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $doubleLeftBottom = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $doubleSolidTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'top' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $doubleSolidBottom = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THICK),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $doubleBottom = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $doubleBottomBold = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11,
    //             'bold' => true
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $noborderTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $noborderTop2 = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $noborderTop3 = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'    => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE),
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));
    //     $boderdottedbottom = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('rgb' => 'FFFFFFFF'),

    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size' => 11,
    //             'bold'    => true,
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),

    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    //             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'       => true
    //         ),
    //     ));

    //     $leftBottomTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));
    //     $rightBottomTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));
    //     $BottomTop = (array(
    //         'fill'   => array(
    //             'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    //             'color' => array('argb' => 'FFFFFFFF')
    //         ),
    //         'font'   => array(
    //             'name' => 'Times New Roman',
    //             'size'  => 11
    //         ),
    //         'numberformat'   => array(
    //             'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
    //         ),
    //         'borders' => array(
    //             'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             // 'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
    //             'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    //         ),
    //         'alignment' => array(
    //             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    //             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    //             'wrap'     => true
    //         ),
    //     ));


    //     return [
    //         'PTStyle'                          => $PTStyle,
    //         'DetailheaderDetDashStyle'         => $DetailheaderDetDashStyle,
    //         'justBorderStyle'                  => $justBorderStyle,
    //         'PTStyleNoRightBorder'             => $PTStyleNoRightBorder,
    //         'headerStyle'                      => $headerStyle,
    //         'DetailheaderStyle'                => $DetailheaderStyle,
    //         'DetailheaderStyleBold'            => $DetailheaderStyleBold,
    //         'DetailheaderStyleleft'            => $DetailheaderStyleleft,
    //         'DetailheaderStyleleftNoBorder'    => $DetailheaderStyleleftNoBorder,
    //         'DetailheaderStyletopbottom'       => $DetailheaderStyletopbottom,
    //         'DetailheaderStyleright'           => $DetailheaderStyleright,
    //         'DetailheaderVerticalStyle'        => $DetailheaderVerticalStyle,
    //         'bodyStyle'                        => $bodyStyle,
    //         'doubleLeft'                       => $doubleLeft,
    //         'doubleLeftBottom'                 => $doubleLeftBottom,
    //         'doubleBottom'                     => $doubleBottom,
    //         'doubleBottomBold'                 => $doubleBottomBold,
    //         'doubleSolidTop'                   => $doubleSolidTop,
    //         'doubleSolidBottom'                => $doubleSolidBottom,
    //         'noborderTop'                      => $noborderTop,
    //         'noborderTop2'                     => $noborderTop2,
    //         'noborderTop3'                     => $noborderTop3,
    //         'headerStyleRight'                 => $headerStyleRight,
    //         'headerStyleRightcenter'           => $headerStyleRightcenter,
    //         'headerStyleRightleftcenter'       => $headerStyleRightleftcenter,
    //         'headerStyleLeft'                  => $headerStyleLeft,
    //         'headerStyleLeftRight'             => $headerStyleLeftRight,
    //         'headerStyleLeftRight2'            => $headerStyleLeftRight2,
    //         'headerStyleRightTop'              => $headerStyleRightTop,
    //         'headerStyleLeftTop'               => $headerStyleLeftTop,
    //         'headerStyleRightbottom'           => $headerStyleRightbottom,
    //         'headerStyleRightbottomcenter'     => $headerStyleRightbottomcenter,
    //         'headerStyleRightleftbottomcenter' => $headerStyleRightleftbottomcenter,
    //         'headerStyleRightleftbottom'       => $headerStyleRightleftbottom,
    //         'headerStyleLeftBottom'            => $headerStyleLeftBottom,
    //         'headerStyleRightBottomTop'        => $headerStyleRightBottomTop,
    //         'headerStyleLeftBottomTop'         => $headerStyleLeftBottomTop,
    //         'headerStyleLeftRightTop'          => $headerStyleLeftRightTop,
    //         'headerStyleTopBottom'             => $headerStyleTopBottom,
    //         'StyleLeftBottomTop'               => $StyleLeftBottomTop,
    //         'StyleRightBottomTop'              => $StyleRightBottomTop,
    //         'Style14'                          => $Style14,
    //         'StyleBottomTop'                   => $StyleBottomTop,
    //         'StyleBottom'                      => $StyleBottom,
    //         'StyleBorderTop'                   => $StyleBorderTop,
    //         'StyleBottomunderline'             => $StyleBottomunderline,
    //         'borderJustBottomStyle'            => $borderJustBottomStyle,
    //         'noborderStyle'                    => $noborderStyle,
    //         'rightborderStyle'                 => $rightborderStyle,
    //         'leftborderStyle'                  => $leftborderStyle,
    //         'DetailheaderRightTopStyle'        => $DetailheaderRightTopStyle,
    //         'DetailheaderRightStyle'           => $DetailheaderRightStyle,
    //         'DetailheaderLeftStyle'            => $DetailheaderLeftStyle,
    //         'DetailheaderRightBottomStyle'     => $DetailheaderRightBottomStyle,
    //         'footerStyleRightbottom'           => $footerStyleRightbottom,
    //         'footerStyleRightbottom2'          => $footerStyleRightbottom2,
    //         'footerStyleRightbottom3'          => $footerStyleRightbottom3,
    //         'footerStyleRightTop'              => $footerStyleRightTop,
    //         'footerStyleRight'                 => $footerStyleRight,
    //         'footerStyleRightLeftbottom'       => $footerStyleRightLeftbottom,
    //         'footerRightLeftbottom'            => $footerRightLeftbottom,
    //         'footerStyleLeftbottom'            => $footerStyleLeftbottom,
    //         'footerStyleLeft'                  => $footerStyleLeft,
    //         'footerStylebottomtop'             => $footerStylebottomtop,
    //         'footerStylebottom'                => $footerStylebottom,
    //         'boderdottedbottom'                => $boderdottedbottom,
    //         'bodyStyleLeft'                    => $bodyStyleLeft,
    //         'bodyStylewithDoth'                => $bodyStylewithDoth,
    //         'bodyStylewithDot'                => $bodyStylewithDot,
    //         'bodyStylewithNoBorderTop'         => $bodyStylewithNoBorderTop,
    //         'justBottom'                       => $justBottom,
    //         'justTop'                          => $justTop,
    //         'justRight'                        => $justRight,
    //         'justLeft'                         => $justLeft,
    //         'leftBottomTop'                    => $leftBottomTop,
    //         'rightBottomTop'                   => $rightBottomTop,
    //         'BottomTop'                        => $BottomTop,
    //         'DiagonalBorder'                   => $DiagonalBorder,
    //     ];
    // }
}
