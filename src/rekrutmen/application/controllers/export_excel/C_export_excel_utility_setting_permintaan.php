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

class C_export_excel_utility_setting_permintaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_wawancara', 'm_configpermintaan'));
    }

    public function exportxls()
    {
        // $this->load->library("Excel/PHPExcel");
        $this->load->model(array('M_monitor', 'M_configpermintaan'));
        $style = $this->excelStyle();
        // print_r($style['PTStyle']);
        // die;


        $id = $this->uri->segment(4);
        $dt_detail = $this->M_configpermintan->getIdealBor($id);
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
            $jekel = $dt->Jenis_Kelamin == 'M' ? 'Laki-laki' : 'Perempuan';
            $tinggi_badan = $dt->TinggiBadan . ' cm';
            $berat_badan = $dt->BeratBadan . ' kg';
            $suku = $dt->Suku;
            $daerah_asal = $dt->Daerah_Asal;
            $bahasa_daerah = $dt->BahasaDaerah;
            $agama = $dt->Agama;
            $status_perkawinan = $dt->Status_Personal;
            $nama_suami_istri = $dt->NamaSuamiIstri != NULL ? 'Tidak Beristri/Bersuami' : ucwords(strtolower($dt->NamaSuamiIstri));
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


        // $objPHPExcel    = new PHPExcel();
        $objPHPExcel = new Spreadsheet();
        $col = 'A';
        for ($i = 1; $i <= 19; $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(8);
        }
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:S2');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'DAFTAR RIWAYAT HIDUP');


        $obj = $objPHPExcel->setActiveSheetIndex(0);
        $obj->setCellValue('A3', 'NO.');
        $obj->mergeCells('B3:I3')->setCellValue('B3', 'Item');
        $obj->mergeCells('J3:S3')->setCellValue('J3', '');
        $objPHPExcel->getActiveSheet()->getStyle('A1:S2')->applyFromArray($style['PTStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A3:S3')->applyFromArray($style['DetailheaderStyle']);


        $counter = 4;
        $no = 1;
        foreach ($item as $key => $row) :
            $obj->setCellValue('A' . $counter, $key + 1);
            $obj->mergeCells('B' . $counter . ':I' . $counter)->setCellValue('B' . $counter, $row['item'] . ((($key + 1) != 35) && ($key + 1) != 47 && ($key + 1) != 48 && ($key + 1) != 49 && ($key + 1) != 57 && ($key + 1) != 58 ? ' *)' : ''));
            if (($key + 1) >= 64) {

                $obj->mergeCells('J' . $counter . ':O' . $counter)->setCellValue('J' . $counter, (($key + 1) == 3 ? '`' : '') . $row['value']);
            } else {
                $obj->mergeCells('J' . $counter . ':S' . $counter)->setCellValue('J' . $counter, (($key + 1) == 3 ? '`' : '') . $row['value']);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':S' . $counter)->applyFromArray($style['DetailheaderStyle']);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $counter . ':B' . $counter)->applyFromArray($style['headerStyleLeft']);
            $objPHPExcel->getActiveSheet()->getStyle('J' . $counter . ':J' . $counter)->applyFromArray($style['headerStyleLeft']);

            $counter++;
            $no++;
        endforeach;
        $obj->mergeCells('P67:S67')->setCellValue('P67', 'Diverifikasi');
        $obj->mergeCells('P68:S68')->setCellValue('P68', 'By : ');
        $obj->mergeCells('P69:S69')->setCellValue('P69', 'Tgl :  ');
        $obj->mergeCells('P70:S70')->setCellValue('P70', 'Paraf : ');

        $counterb = $counter + 0;

        $obj->mergeCells('A' . ($counterb + 0) . ':B' . ($counterb + 6))->setCellValue('A' . ($counterb + 0), 'PHOTO');
        $obj->mergeCells('C' . ($counterb + 0) . ':E' . ($counterb + 0))->setCellValue('C' . ($counterb + 0), 'Lampiran dan keterangan');
        $obj->mergeCells('C' . ($counterb + 1) . ':E' . ($counterb + 1))->setCellValue('C' . ($counterb + 1), '- TRANSKIP NILAI');
        $obj->mergeCells('C' . ($counterb + 2) . ':E' . ($counterb + 2))->setCellValue('C' . ($counterb + 2), '-  *) HARUS DIISI');

        $obj->mergeCells('N' . ($counterb + 0) . ':O' . ($counterb + 0))->setCellValue('N' . ($counterb + 0), 'Tanggal Data');
        $obj->mergeCells('P' . ($counterb + 0) . ':Q' . ($counterb + 0))->setCellValue('P' . ($counterb + 0), ': ' . date('d-m-Y'));
        $obj->mergeCells('A' . ($counterb + 7) . ':S' . ($counterb + 7))->setCellValue('A' . ($counterb + 7), 'Demikian Daftar Riwayat Hidup ini saya buat dengan sebenarnya');

        $objPHPExcel->getActiveSheet()->getStyle('A' . ($counterb + 0) . ':B' . ($counterb + 6))->applyFromArray($style['DetailheaderStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('C' . ($counterb + 0) . ':S' . ($counterb + 6))->applyFromArray($style['noborderStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($counterb + 7) . ':S' . ($counterb + 7))->applyFromArray($style['DetailheaderStyle']);
        $objPHPExcel->getActiveSheet()->getStyle('P67:P70')->applyFromArray($style['headerStyleLeft']);

        $objPHPExcel->getActiveSheet()->getStyle('S' . ($counterb + 0) . ':S' . ($counterb + 6))->applyFromArray($style['headerStyleRight']);



        // $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        // header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
        // header('Chace-Control: no-store, no-cache, must-revalation');
        // header('Chace-Control: post-check=0, pre-check=0', FALSE);
        // header('Pragma: no-cache');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="Daftar Riwayat Hidup ( ' . $nama_lengkap . ' ).xlsx"');

        // $objWriter->save('php://output');
        $writer = new Xlsx($objPHPExcel);

        header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Daftar Riwayat Hidup ( ' . $nama_lengkap . ' ).xlsx"');

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
