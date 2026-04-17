<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//    session_start(); //Memanggil fungsi session Codeigniter
require_once APPPATH . "/third_party/FPDF.php";

class ISI extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetTitle("SURAT IZIN MENEMPATI MESS");
        $this->SetLineWidth(0.3);
        // $this->SetXY(5, 5);
        // $this->Cell(200, 287, '', 1, 0, 'C');
        $y = $this->GetY();
        // $logor = "assets/images/PSG_logo_2022.png";
        // $title = "PT PULAU SAMBU";
        // $title2 = "SURAT IZIN MENEMPATI MESS";
        // $logo = $this->Image($logor, 43, 18, 20, 17); // posisi logo

        $this->SetAutoPageBreak(true);
    }
}

$pdf = new ISI('P', 'mm', 'A4');

foreach ($dtfrm as $dt_form) {
    $pdf->frmjdl                = $dt_form->formjudul;
    $pdf->frmefec               = date("d-m-Y", strtotime($dt_form->formefective));
    $pdf->frmnm                 = $dt_form->formnm;
    $pdf->frmkd                 = $dt_form->formkd;
    $pdf->frmvrs                = $dt_form->formversi;
    $pdf->frmparefec            = $dt_form->efective_parameter;
}

foreach ($dtheader as $header) {
    $pdf->headerid              = $header->headerid;
    $pdf->create_date           = date("d-m-Y", strtotime($header->create_date));
    $pdf->no_doc                = $header->no_doc;
    $pdf->hdr_id_mess           = $header->hdr_id_mess;
    $pdf->hdr_id_blok           = $header->hdr_id_blok;
    $pdf->page_hdr_alamat       = $header->hdr_alamat;
    $pdf->hdr_keterangan        = $header->hdr_keterangan;
    $pdf->hdr_tipe_mess         = $header->hdr_tipe_mess;
    $pdf->app1_by               = $header->app1_by;
    $pdf->app1_position         = $header->app1_position;
    $pdf->app1_date             = date("d-m-Y", strtotime($header->app1_date));
    $pdf->app2_by               = $header->app2_by;
    $pdf->app2_position         = $header->app2_position;
    $pdf->app2_date             = date("d-m-Y", strtotime($header->app2_date));
    $pdf->app3_by               = $header->app3_by;
    $pdf->app3_position         = $header->app3_position;
    $pdf->app3_date             = date("d-m-Y", strtotime($header->app3_date));
    $pdf->app1_personalid       = $header->app1_personalid;
    $pdf->app2_personalid       = $header->app2_personalid;
    $pdf->app3_personalid       = $header->app3_personalid;
    $pdf->app1_personalstatus   = $header->app1_personalstatus;
    $pdf->app2_personalstatus   = $header->app2_personalstatus;
    $pdf->app3_personalstatus   = $header->app3_personalstatus;
    $pdf->app1_status           = $header->app1_status;
    $pdf->app2_status           = $header->app2_status;
    $pdf->app3_status           = $header->app3_status;
}

if (isset($dtdetail)) {
    $no = 0;
    foreach ($dtdetail as $dtdetail_row) {
        $pdf->page_dtl_status_pekerja = $dtdetail_row->dtl_status_pekerja;
        $page_dtl_personalid[]        = $dtdetail_row->dtl_personalid;
        $page_dtl_personalstatus[]    = $dtdetail_row->dtl_personalstatus;
        $pdf->page_dtl_id_mess        = $dtdetail_row->dtl_id_mess;
        $pdf->page_dtl_id_blok        = $dtdetail_row->dtl_id_blok;
        $pdf->page_dtl_tkid           = $dtdetail_row->dtl_tkid;
        $pdf->page_dtl_jenis_kelamin  = $dtdetail_row->dtl_jenis_kelamin;
        $pdf->dtl_status_pembayaran   = $dtdetail_row->dtl_status_pembayaran;
        $pdf->dtl_jenis_pembayaran    = $dtdetail_row->dtl_jenis_pembayaran;
        $pdf->dtl_kategori            = $dtdetail_row->dtl_kategori;
        $page_dtl_nik[]               = $dtdetail_row->dtl_nik;
        $page_dtl_status_hubungan[]   = $dtdetail_row->dtl_status_hubungan;
        $page_dtl_nama[]              = $dtdetail_row->dtl_nama;
        $page_dtl_cv[]                = $dtdetail_row->dtl_cv;
        $page_dtl_dept[]              = $dtdetail_row->dtl_dept;
        $page_dtl_jabatan[]           = $dtdetail_row->dtl_jabatan;
        $page_dtl_tgl_masuk_kerja[]   = date("d-m-Y", strtotime($dtdetail_row->dtl_tgl_masuk_kerja));
        $page_dtl_tgl_masuk_mess[]    = date("d-m-Y", strtotime($dtdetail_row->dtl_tanggal_masuk_mess));
        $page_dtl_tgl_tagihan_awal[]  = date("d-m-Y", strtotime($dtdetail_row->dtl_tanggal_tagihan_awal));
        $page_dtl_no_kamar[]          = $dtdetail_row->dtl_no_kamar;
        $page_dtl_tgl_lahir[]         = date("d-m-Y", strtotime($dtdetail_row->dtl_tgl_lahir));
        $page_dtl_status_kawin[]      = $dtdetail_row->dtl_status_kawin;
        $page_dtl_umur[]              = $dtdetail_row->dtl_umur;
        $page_dtl_status_kawin_ket[]  = $dtdetail_row->dtl_status_kawin_ket;
        $page_dtl_keterangan[]        = $dtdetail_row->dtl_keterangan;
        $page_dtl_jenis_kelamin[]     = $dtdetail_row->dtl_jenis_kelamin;
        $page_jenis_pembayaran[]      = $dtdetail_row->dtl_jenis_pembayaran;
        $status_pekerja[]             = $dtdetail_row->dtl_status_pekerja;

        $jml_data = count($dtdetail);
    }
    $pdf->nama               = $page_dtl_nama[0];
    $pdf->cv                 = $page_dtl_cv[0];
    $pdf->nik                = $page_dtl_nik[0];
    $pdf->dept               = $page_dtl_dept[0];
    $pdf->jabatan            = $page_dtl_jabatan[0];
    $pdf->tgl_masuk          = $page_dtl_tgl_masuk_kerja[0];
    $pdf->nokmar             = $page_dtl_no_kamar[0];
    $pdf->tgl_lahir          = $page_dtl_tgl_lahir[0];
    $pdf->jenis_kelamin      = $page_dtl_jenis_kelamin[0];
    $pdf->umur               = $page_dtl_umur[0];
    $pdf->status_kawin       = $page_dtl_status_kawin[0];
    $pdf->status_hubungan    = $page_dtl_status_hubungan[0];
    $pdf->status_kawin_ket   = $page_dtl_status_kawin_ket[0];
    $pdf->keterangan         = $page_dtl_keterangan[0];
    $pdf->tgl_masuk_mess     = $page_dtl_tgl_masuk_mess[0];
    $pdf->tgl_tagihan_awal   = $page_dtl_tgl_tagihan_awal[0];
    $pdf->jenis_pembayaran   = $page_jenis_pembayaran[0];
    $pdf->status_pekerja     = $status_pekerja[0];
}

if ($pdf->tgl_masuk == '01-01-1970') {
    $pdf->tgl_masuk = '-';
} else {
}

// if ($pdf->cv == 'PT.PSG') {
//     $pdf->cv = '-';
// } else {
// }

$count = count($dtdetail);
$jml_data_perpage = 10;

if ($count < $jml_data_perpage) {
    $jml_page = 1;
} else {
    if (($count % $jml_data_perpage) == 1) {
        $jml_page = ($count / $jml_data_perpage);
    } else {
        $jml_page = floor(($count / $jml_data_perpage)) + 1;
    }
}

// $pdf->hlmakhir = $jml_page;
$index = 0;

for ($i = 0; $i < $jml_page; $i++) {
    // $pdf->hlmawal = $i + 1;

    // $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetXY(5, 5);
    $pdf->Cell(200, 287, '', 0, 0, 'C');
    $title = "PT PULAU SAMBU";
    $title2 = "SURAT IZIN MENEMPATI MESS";
    $pdf->Ln(0);
    $title4 = "PERMISSION LETTER OCCUPY THE MESS";
    $pdf->Ln(0);
    $pdf->SetX(35);
    $pdf->Image('assets/images/PSG_logo_2022.png', 38, 12, 20, 17);
    $pdf->SetFont('Times', 'B', 16); //size huruf header 1
    $pdf->cell(137, 25, $title, 0, 0, 'C', 0); // header1
    $pdf->SetFont('Times', '', 10); //size huruf header 1
    $pdf->Ln(8);
    $pdf->SetX(35);
    $pdf->SetFont('Times', 'BU', 12); //size huruf header 2
    $pdf->Cell(137, 33, $title2, 0, 0, 'C');
    $pdf->SetX(35);
    $pdf->SetFont('Times', 'BI', 12); //size huruf header 2
    $pdf->Cell(137, 43, $title4, 0, 0, 'C');

    $pdf->SetX(35);
    $pdf->SetFont('Times', 'B', '', 12); //size huruf header 2
    $pdf->Cell(137, 53, '' . $pdf->no_doc, 0, 0, 'C');

    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Times', '', 11);

    $pdf->Ln(25);
    coret1($pdf, 'Berdasarkan Pertimbangan dan Kebijaksanaan yang di Kuasakan Pimpinan PT PULAU SAMBU (GUNTUNG) dengan ini ');
    coret1($pdf, 'mengizinkan: ');
    coret5($pdf, 'Based on consideration and policies authorized by the leadership of PT PULAU SAMBU (GUNTUNG) hereby permits :', true);
    // coret1($pdf, 'mengizinkan: ');
    // judul1($pdf, 'Name', 'ID Number', $pdf->nama, $pdf->nik);
    // judul6($pdf, 'PT', 'Entry date', $pdf->cv, $pdf->tgl_masuk);
    running($pdf, 'Nama / Name', $pdf->nama);
    running($pdf, 'NIK / ID Number', $pdf->nik);
    running($pdf, 'PT', $pdf->cv);
    running($pdf, 'Tanggal Masuk Kerja / Work Entry Date', $pdf->tgl_masuk);
    running($pdf, 'Jabatan / Position', $pdf->jabatan);
    running($pdf, 'Department / Department', $pdf->dept);

    coret1($pdf, 'Keterangan yang tertera di atas pada Surat Izin ini merupakan KARYAWAN,  guna menempati perumahan milik ');
    coret1($pdf, 'PT PULAU SAMBU (GUNTUNG) yang selanjutnya diperizinkan PERUSAHAAN, terletak di : ');
    coret_miring2($pdf, 'The information stated above on this permit is that they are EMPLOYEES, to occupy HOUSING OWNED BY PT PULAU ', true);
    coret_miring2($pdf, 'SAMBU (CWP-1) which is further permitted by THE COMPANY  to be located at : ', true);
    judul4($pdf, '( Alamat Mess/Mess address ', 'No kamar/Room Number  ', $pdf->page_hdr_alamat, $pdf->nokmar . ' ).');

    coret1($pdf, 'Selanjutnya rumah yang ditunjuk untuk ditempati sesuai Surat Izin merupakan RUMAH MILIK PERUSAHAAN.');
    coret_miring2($pdf, 'Furthermor, the house designated for occupancy according TO THE PERMIT is HOUSE OWNED BY THE COMPANY.', true);

    coret1($pdf, 'Adapun KETENTUAN dan SYARAT-SYARAT yang harus di Patuhi untuk menempati Rumah Perusahaan sebagai berikut:');
    coret_miring2($pdf, 'THE TERMS and CONDITIONS that must BE COMPLIED with to occupy a company house are follows :', true);

    coret($pdf, '1.    Karyawan Wajib Terdaftar serta memiliki Izin Tertulis dari Perusahaan dan melengkapi Persyaratan yang diminta');
    coret($pdf, '       Pihak yang di Kuasakan. Hal-hal mengenai Pemindahan dan Pengaturan Perumahan Milik Perusahaan merupakan');
    coret($pdf, '       Hak dan Wewenang Penuh dari Perusahaan melalui Pihak-Pihak yang di Kuasakan.');
    coret_miring($pdf, '        Employes Must be registed and have written permission from the company and complete the requirements requested by', true);
    coret_miring($pdf, '        the authorized party. Matters regarding the transfer and arrangement of company owned housing constitute the full', true);
    coret_miring($pdf, '        rights and authority of the company through authorized parties.', true);
    coret($pdf, '2.    Izin Menempati Rumah Milik Perusahaan Berstatus Pinjam Pakai bukan Hak Milik Karyawan. Rumah Perusahaan');
    coret($pdf, '       hanya ditempati oleh Karyawan dari Suami/Istri dan Anak, jika ada Penghuni Keluarga lain Wajib Lapor Ketua RT');
    coret($pdf, '       setempat 1x24 Jam dengan Sepengetahuan dan Izin Tertulis dari Pihak Perusahaan.');
    coret_miring($pdf, '        Permission to Occupy a house owned by a company has the status of Loan to use not employee own rights. The', true);
    coret_miring($pdf, '        company house is only occupied by husband /wife Employees and Children, if there are other family residents must be', true);
    coret_miring($pdf, '        report the head of local RT 1 X 24 hours with knowledge and written permission from the company', true);
    coret($pdf, '3.    Karyawan diizinkan menempati Rumah Milik Perusahaan terhitung Surat Izin diberlakukan dari tanggal masuk,');
    coret($pdf, '       hingga Keluar sampai Batas Waktu yang ditetapkan oleh Pihak Perusahaan.');
    coret_miring($pdf, '        Employees are permitted to occupy a house belonging to the company as of the permit letter in value from the date of', true);
    coret_miring($pdf, '        entry to exit until the time limit set by the company.', true);
    coret($pdf, '4.    Karyawan Dilarang Memindah Tangankan, Menyerahkan, Meminjamkan atau Menyewakan Rumah Milik');
    coret($pdf, '       Perusahaan kepada Pihak Ketiga baik secara Keseluruhan maupun Sebagian.');
    $pdf->Ln();
    $pdf->SetLineWidth(0.3);
    $pdf->SetY(-10);
    $pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());
    $pdf->SetX(5);

    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(27, 5, 'Tanggal Berlaku / ', 0, 0, 'L');
    $pdf->SetFont('Times', 'I', 10); // Mengatur jenis huruf menjadi miring
    $pdf->Cell(0, 5, 'Effective Date: ' . $pdf->frmefec, 0, 0, 'L');
    $pdf->SetFont('Times', '', 10); // Mengembalikan jenis huruf ke normal

    $pdf->SetX(177);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(0, 5, $pdf->frmnm . '-' . $pdf->frmvrs, 0, 'L');
    coret_miring($pdf, '        Employees are prohibited from transferring or lending or renting company-owned houses to third parties either in', true);
    coret_miring($pdf, '        whole or in part  .', true);
    coret($pdf, '5.    Rumah Milik Perusahaan secara keseluruhan harus dipergunakan Karyawan sesuai fungsi sebagai Tempat Tinggal dan');
    coret($pdf, '       Tidak dipergunakan untuk kegiatan berkumpul dengan Tujuan Tidak Baik serta Tidak diperkenankan untuk Usaha');
    coret($pdf, '       maupun Berjualan dalam bentuk apapun.');
    coret_miring($pdf, '        The house owned by the company as a whole must be used by employees according to its function as a residence and', true);
    coret_miring($pdf, '        should not be used for gathering activities bad purposes and not allowed for bussines or selling in any form', true);
    // coret($pdf, '       maupun Berjualan dalam bentuk apapun.');
    coret($pdf, '6.    Karyawan Wajib Memelihara dan Merawat Rumah Milik Perusahan serta Menjaga Perlengkapan atau Inventaris mess');
    coret($pdf, '       dengan sebaik-baiknya. Tidak dibenarkan Memelihara Ternak atau Hewan Peliharaan yang tidak terjaga sebagaimana');
    coret($pdf, '       mestinya yang akan menimbulkan Penyakit dan menimbulkan Suasana Kebersihan Lingkungan menjadi tidak nyaman,');
    coret($pdf, '       KECUALI memelihara hewan peliharaan didalam mess dan tidak membiarkan berkeliaran disekitar mess.');
    coret_miring($pdf, '        Employees must maintain and take care of the companys house and maintain the best equipment or inventory', true);
    coret_miring($pdf, '        as well .it is not justified In maintaining livestock or pets that are not maintained as it should cause', true);
    coret_miring($pdf, '        disease and cause environmental hygiene atmosphere to be uncomfortable. EXCEPT for maintaining pets in ', true);
    coret_miring($pdf, '        the mess and do not let wander around the mess.', true);
    coret($pdf, '7.    Karyawan yang telah Menempati Mess WAJIB Memilah, Memilih, Mengumpulkan dan');
    coret($pdf, '       Membuang sampah ditempat yang telah sediakan sesuai dengan Jenis sampah yang ');
    coret($pdf, '       dihasilkan (Organik, Anorganik dan Limbah Berbahaya dan Beracun).');
    coret_miring($pdf, '        Employees who have occupied the mess MUST sort, select, collect and dispose of waste in the ', true);
    coret_miring($pdf, '        place provided according to the type of waste produced (organic, inorganic and hazardous and', true);
    coret_miring($pdf, '        toxic waste).', true);
    coret($pdf, '8.    Karyawan Dilarang Melakukan Perusakan, Pengurangan, Perubahan, atau Penambahan baik Sebagian maupun secara');
    coret($pdf, '       Keseluruhan atas Bangunan Perumahan meliputi Instalasi Listrik, Instalasi Air dan berbagai macam Perlengkapan lain');
    coret($pdf, '       Tanpa Seizin Pihak-Pihak Terkait, sehingga dapat Merugikan Perusahaan dan Pihak lain. Apabila hal ini terjadi,');
    coret($pdf, '       Karyawan dan Penghuni yang bersangkutan akan diberi Sanksi');
    $pdf->SetTextColor(255, 0, 0);
    $pdf->SetX(135);
    $pdf->Cell(5, 5, 'SURAT PERINGATAN', 0, 0, 'C');
    $pdf->SetX(135);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(44, 5, '.', 0, 0, 'C');
    $pdf->SetTextColor(0, 0, 0);
    coret_miring($pdf, '        Employees are prohibited from destruction of reducing changes or additions of both partial and overall housing ', true);
    coret_miring($pdf, '        buildings include electrical installations, water installations and various other equipment without permission from the', true);
    coret_miring($pdf, '        relevant parties, so that they can harm the company and other parties so that they can harm the company and other,', true);
    coret_miring($pdf, '        parties . if this happens employees and residents in question will be given a warning letter', true);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->SetX(167);
    $pdf->Cell(5, 5, 'SANCTION', 0, 0, 'C');
    $pdf->SetX(167);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(44, 5, '.', 0, 0, 'C');
    $pdf->SetTextColor(0, 0, 0);
    coret($pdf, '9.    Dalam hal Pemakaian Kwh Listrik dan Flow Meter air, Karyawan dan Penghuni Perumahan harus mempergunakan');
    coret($pdf, '       Fasilitas Perusahaan secara Efisien, dalam batas kewajaran dan tidak berlebihan sesuai dengan Ketentuan berlaku.');
    coret($pdf, '       Karyawan dan Penghuni Perumahan wajib membayar Tagihan pemakaian Listrik, Air dan biaya yang dapat di');
    coret($pdf, '       Perhitungkan.');
    coret_miring($pdf, '        In the case of the use electricity and flow meters of employees and housing residents must use the companys facilities', true);
    coret_miring($pdf, '        efficiently within the limits of reasonability and not excessively in accordance with the applicable provisions.', true);
    coret_miring($pdf, '        Employees and residents of housing must pay bills using water, electricity and cost that can be calculated ', true);
    coret($pdf, '10.    Dalam hal Karyawan bila Mengakhiri Hubungan Kerja atau Pengunduran Diri dari Perusahaan yang bersifat apapun,');
    coret($pdf, '       selama masa Karyawan dan Penghuni terkait yang tersebut dalam Point 3, Karyawan dan Penghuni terkait Wajib');
    coret($pdf, '       menyerahkan kembali Rumah Milik Perusahaan beserta Seluruh Perangkat yang disediakan dalam keadaan baik dan');
    $pdf->SetLineWidth(0.3);
    $pdf->SetY(-10);
    $pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());
    $pdf->SetX(5);

    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(27, 5, 'Tanggal Berlaku / ', 0, 0, 'L');
    $pdf->SetFont('Times', 'I', 10); // Mengatur jenis huruf menjadi miring
    $pdf->Cell(0, 5, 'Effective Date: ' . $pdf->frmefec, 0, 0, 'L');
    $pdf->SetFont('Times', '', 10); // Mengembalikan jenis huruf ke normal

    $pdf->SetX(177);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(0, 5, $pdf->frmnm . '-' . $pdf->frmvrs, 0, 'L');

    $pdf->AddPage();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetXY(5, 5);
    $pdf->Cell(200, 287, '', 0, 0, 'C');
    $pdf->SetFont('Times', '', 11);
    $pdf->ln(0);
    coret($pdf, '       penyerahan diberikan kurun waktu 3 x 24 jam, terhitung tanggal Batas Waktu yang di tetapkan Pihak Perusahaan.');
    coret_miring($pdf, '        In the case of an employee terminating employment relationship or resigning from the company of any nature during', true);
    coret_miring($pdf, '        the period of the employee and related resident as mentioned point 3. Employees and residents concerned are required', true);
    coret_miring($pdf, '        to hand over the companys house and all the  equipment provided in good conditions and delivery is given within', true);
    coret_miring($pdf, '        3 X 24 hours from the deadline set by the company .', true);
    coret($pdf, '11.  Karyawan dan Penghuni Wajib Mentaati Izin serta Prosedur dan semua Ketentuan yang telah ditetapkan dan dituang-');

    // coret($pdf, '       Perhitungkan.');
    coret($pdf, '       kan dalam TATA TERTIB yang berlaku. Bagi Pihak Ketiga yang bertamu atau kunjungan, Karyawan dan Penghuni');
    coret($pdf, '       harus lebih mewaspadai dan mencegah serta melaporkan kepada Ketua RT atau Ketua RW dan Satpam/Security, bila');
    coret($pdf, '       ada hal yang mencurigakan dari rekan atau tetangga, bahwa ada Tamu atau Penghuni perumahan lain yang mungkin');
    coret($pdf, '       merencanakan itikad tidak baik hingga dapat merugikan Perusahaan dan Warga sekitar Perumahan.');
    coret_miring($pdf, '        Employees and residents are required to comply with permits and procedures and all provisions that have been ', true);
    coret_miring($pdf, '        determined and outlined in the applicable regulations. For the third parties visiting employees and residents,must be', true);
    coret_miring($pdf, '        more alert and prevent it and report it to the RT or RW head and security. If there are suspicious things from colleagues', true);
    coret_miring($pdf, '        or neighbors that there are guests or other housing residents who may be planning in bad faith that could harm the', true);
    coret_miring($pdf, '        huosing and residents around the housing.', true);
    coret($pdf, '12.  Karyawan dan Penghuni harus bersedia diperiksa Pihak yang di Kuasakan oleh Perusahaan, bila ada hal-hal yang');
    coret($pdf, '       dicurigai dan berhubungan dengan hilangnya perlengkapan milik perusahaan.');
    coret_miring($pdf, '        Employees and residents must be willing to be examined by parties auhtorized by the company if there are things that', true);
    coret_miring($pdf, '        are suspicious and related to the loss of equipment belonging to the company.', true);
    // coret($pdf, '12.  Apabila Ketentuan Perumahan Perusahaan tidak di Patuhi dan melakukan Pelanggaran terhadap Tata Tertib yang telah');
    // coret($pdf, '       diterapkan sebagaimana mestinya, maka Pihak yang di Kuasakan dapat sewaktu-waktu Mencabut Izin Penempatan');
    // coret($pdf, '       Rumah Milik Perusahaan dan Karyawan berserta Penghuni yang bersangkutan tidak di benarkan untuk menempati');
    // coret($pdf, '       Perumahan Perusahaan. Karyawan dan Penghuni bersedia menjalankan Ketentuan Izin Pinjam Pakai Perumahan');
    // coret($pdf, '       Perusahaan dengan Penuh Tanggung Jawab.');
    // coret_miring($pdf, '        If the companys housing provisions are not complied and violate the rules and regulations that have been implemented', true);
    // coret_miring($pdf, '        properly, the the authorized party can at any time revoke the permit for  housing belonging to the company and the', true);
    // coret_miring($pdf, '        employee and the occupants concerned are not permitted to occupy the companys housing. Employees and', true);
    // coret_miring($pdf, '        residents are willing to carry out the terms of the company housing loan to use permit with full responsibility', true);
    coret($pdf, '13.  Apabila Ketentuan Perumahan Perusahaan tidak di Patuhi dan melakukan Pelanggaran terhadap Tata Tertib yang telah');
    coret($pdf, '       diterapkan (Point 1- 12) maka Pihak yang di Kuasakan dapat sewaktu-waktu Mencabut Izin Penempatan');
    coret($pdf, '       Rumah Milik Perusahaan dan Karyawan berserta Penghuni yang bersangkutan tidak di benarkan untuk menempati');
    coret($pdf, '       Perumahan Perusahaan. Karyawan dan Penghuni bersedia menjalankan Ketentuan Izin Pinjam Pakai Perumahan');
    coret($pdf, '       Perusahaan dengan Penuh Tanggung Jawab.');
    coret_miring($pdf, '        If the companys housing provisions are not complied with and violate the rules that have been implemented (Points 1-12)', true);
    coret_miring($pdf, '        then the authorized party can revoke the Company Housing Occupancy Permit at any time and the Employees and the ', true);
    coret_miring($pdf, '        Occupants concerned are not permitted to occupy the Company Housing. Employees and Residents are willing to carry ', true);
    coret_miring($pdf, '        out the provisions of the Company Housing Borrow-to-Use Permit with Full Responsibility.', true);
    // coret($pdf, '       Perusahaan dengan Penuh Tanggung Jawab.');
    $pdf->ln(7);
    coret1($pdf, 'Demikian Ketentuan Penempatan Perumahan Perusahaan yang telah ditetapkan dengan Syarat-Syarat yang ditentukan dan');
    coret1($pdf, 'disetujui oleh Karyawan dalam keadaan sadar dan tanpa Paksaan dari Pihak manapun, agar Surat Izin yang diberikan dapat ');
    coret1($pdf, 'dipergunakan sebagaimana mestinya.');
    coret1_miring($pdf, 'These are the provisions for placement in company housing that have been determined with the conditions determined', true);
    coret1_miring($pdf, 'and agreed to by the employee consciously and without coercion from any party so that the permission letter given', true);
    coret1_miring($pdf, 'can be used properly.', true);
    $pdf->SetLineWidth(0.3);
    $pdf->SetY(-10);
    $pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());
    $pdf->SetX(5);

    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(27, 5, 'Tanggal Berlaku / ', 0, 0, 'L');
    $pdf->SetFont('Times', 'I', 10); // Mengatur jenis huruf menjadi miring
    $pdf->Cell(0, 5, 'Effective Date: ' . $pdf->frmefec, 0, 0, 'L');
    $pdf->SetFont('Times', '', 10); // Mengembalikan jenis huruf ke normal

    $pdf->SetX(177);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(0, 5, $pdf->frmnm . '-' . $pdf->frmvrs, 0, 'L');

    $pdf->AddPage();
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetXY(5, 5);
    $pdf->Cell(200, 287, '', 0, 0, 'C');
    $pdf->SetFont('Times', '', 11);
    // $pdf->ln(0);
    $pdf->Ln(10);
    $pdf->SetX(140);
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(5, 8, 'Sungai Guntung,  ' . $pdf->create_date, '', 0, '');
    $pdf->Cell(40, 19, 'KARYAWAN/EMPLOYEE', 0, 0, 'C');

    $pdf->ln(4);
    $pdf->SetX(24);
    $pdf->SetFont('Times', 'I', 10);
    $pdf->Cell(30, 19, 'A/N PT PULAU SAMBU', 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->SetX(24);
    $pdf->SetFont('Times', 'I', 10);
    $pdf->Cell(30, 19, 'ON BEHALF OF PT PULAU SAMBU', 0, 0, 'C');

    $pdf->Ln(21);
    $pdf->SetX(10);
    $pdf->SetFont('Times', '', 8);
    $pdf->Cell(43, 18, '(' . $pdf->app3_by . ')', 0, 0, 'C');

    $pdf->SetX(130);
    $pdf->Cell(70, 18, '(' . $pdf->nama . ')', 0, 0, 'C');

    $pdf->Ln(10);
    $pdf->SetX(130);
    $pdf->Cell(70, 8, '' . $pdf->jabatan, 0, 0, 'C');

    $pdf->SetX(9);
    $pdf->Cell(47, 8, '' . 'Pimpinan HOS/ HOS Head', 0, 0, 'C');
    // $pdf->Cell(43, 8, '( ' . $pdf->app3_position . ' )', 0, 0, 'C');

    $pdf->ln(3);
    $pdf->SetX(15);
    $pdf->SetFont('Times', 'I', 11);
    $pdf->Cell(70, 19, 'Saksi-Saksi:', 0, 0, 'C');

    $pdf->Ln(9);
    $pdf->SetX(55);
    $pdf->SetFont('Times', '', 8);
    $pdf->Cell(130, 8, '1. ' . $pdf->app1_by, 0, 0, '');
    $pdf->SetX(50);
    $pdf->Cell(130, 8, '(                )', 0, 0, 'C');

    $pdf->Ln(9);
    $pdf->SetX(55);
    $pdf->SetFont('Times', '', 8);
    $pdf->Cell(130, 8, '2. ' . $pdf->app2_by, 0, 0, '');
    $pdf->SetX(50);
    $pdf->Cell(130, 8, '(                )', 0, 0, 'C');

    if ($page_dtl_personalstatus == '2') {
        $pdf->imageurlapp2    = '/forviewfoto_pekerja/TTD_TK/';
        $pdf->imageformatapp2 = '.png';
    } else if (
        $page_dtl_personalstatus == '1'
    ) {
        $pdf->imageurlapp2    = '/forviewfoto_pekerja/';
        $pdf->imageformatapp2 = '_0_0.png';
    } else {
        $pdf->imageurlapp2    = '';
        $pdf->imageformatapp2 = '';
    }

    if ($pdf->app1_personalstatus == '2') {
        $pdf->imageurlapp1    = '/forviewfoto_pekerja/TTD_TK/';
        $pdf->imageformatapp1 = '.png';
    } else if (
        $pdf->app1_personalstatus == '1'
    ) {
        $pdf->imageurlapp1    = '/forviewfoto_pekerja/';
        $pdf->imageformatapp1 = '_0_0.png';
    } else {
        $pdf->imageurlapp1    = '';
        $pdf->imageformatapp1 = '';
    }

    if ($pdf->app2_personalstatus == '2') {
        $pdf->imageurlapp2    = '/forviewfoto_pekerja/TTD_TK/';
        $pdf->imageformatapp2 = '.png';
    } else if (
        $pdf->app2_personalstatus == '1'
    ) {
        $pdf->imageurlapp2    = '/forviewfoto_pekerja/';
        $pdf->imageformatapp2 = '_0_0.png';
    } else {
        $pdf->imageurlapp2    = '';
        $pdf->imageformatapp2 = '';
    }

    if ($pdf->app3_personalstatus == '2') {
        $pdf->imageurlapp3    = '/forviewfoto_pekerja/TTD_TK/';
        $pdf->imageformatapp3 = '.png';
    } else if (
        $pdf->app3_personalstatus == '1'
    ) {
        $pdf->imageurlapp3    = '/forviewfoto_pekerja/';
        $pdf->imageformatapp3 = '_0_0.png';
    } else {
        $pdf->imageurlapp3    = '';
        $pdf->imageformatapp3 = '';
    }

    $base_url2 = 'http://' . $_SERVER['HTTP_HOST'] . '/';
    $fcpath2   = str_replace('gaf/', '', FCPATH);
    $width_ttd = 'width:200px;';
    $hight_ttd = 'height:120px;';

    $imageapp2 = $fcpath2 . $pdf->imageurlapp2 . $pdf->imageformatapp2;
    if ($page_dtl_personalid[0] != '' && file_exists($fcpath2 . 'gaf/assets/ttd/' .  $page_dtl_personalstatus[0] . '_' . $page_dtl_personalid[0] . '.png')) {
        $pdf->Image('' . $base_url2 . 'gaf/assets/ttd/' . $page_dtl_personalstatus[0] . '_' . $page_dtl_personalid[0] . '.png', 153, 26, 25, 20);
    } else 
    if (isset($page_dtl_personalid[0]) && $page_dtl_personalid[0] != '' && $page_dtl_personalstatus[0] == '2' && file_exists($fcpath2 . 'forviewfoto_pekerja/TTD_TK/' . $page_dtl_personalid[0] . '.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/TTD_TK/' . $page_dtl_personalid[0] . '.png', 153, 26, 25, 20);
    } else if (isset($page_dtl_personalid[0]) != '' && $page_dtl_personalstatus[0] == '1' && file_exists($fcpath2 . 'forviewfoto_pekerja/TTD_KRY/' . $page_dtl_personalid[0] . '_0_0.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/TTD_KRY/' . $page_dtl_personalid[0] . '_0_0.png', 153, 26, 25, 20);
    } else if (isset($page_dtl_personalid[0]) != '' && $page_dtl_personalstatus[0] == '1' && file_exists($fcpath2 . 'forviewfoto_pekerja/' . $page_dtl_personalid[0] . '_0_0.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/' . $page_dtl_personalid[0] . '_0_0.png', 153, 26, 25, 20);
    } else if (isset($page_dtl_personalid[0]) != '' && file_exists('assets/images/approved.png')) {
        $pdf->Image('assets/images/approved.png', 153, 26, 25, 20);
    }

    $imageapp1 = $fcpath2 . $pdf->imageurlapp1 . $pdf->imageformatapp1;
    if ($pdf->app1_personalid != '' && file_exists($fcpath2 . 'gaf/assets/ttd/' .  $pdf->app1_personalstatus . '_' . $pdf->app1_personalid . '.png')) {
        $pdf->Image('' . $base_url2 . 'gaf/assets/ttd/' . $pdf->app1_personalstatus . '_' . $pdf->app1_personalid . '.png', 105, 57, 25, 15);
    } else if (isset($pdf->app1_personalid) && $pdf->app1_personalid != '' && $pdf->app1_personalstatus == '2' && file_exists($fcpath2 . 'forviewfoto_pekerja/TTD_TK/' . $pdf->app1_personalid . '.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/TTD_TK/' . $pdf->app1_personalid . '.png', 105, 57, 25, 15);
    } else if (isset($pdf->app1_personalid) != '' && $pdf->app1_personalstatus == '1' && file_exists($fcpath2 . 'forviewfoto_pekerja/TTD_KRY/' . $pdf->app1_personalid . '_0_0.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/TTD_KRY/' . $pdf->app1_personalid . '_0_0.png', 105, 57, 25, 15);
    } else if (isset($pdf->app1_personalid) != '' && $pdf->app1_personalstatus == '1' && file_exists($fcpath2 . 'forviewfoto_pekerja/' . $pdf->app1_personalid . '_0_0.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/' . $pdf->app1_personalid . '_0_0.png', 105, 57, 25, 15);
    }

    $imageapp2 = $fcpath2 . $pdf->imageurlapp2 . $pdf->imageformatapp2;
    if ($pdf->app2_personalid != '' && file_exists($fcpath2 . 'gaf/assets/ttd/' .  $pdf->app2_personalstatus . '_' . $pdf->app2_personalid . '.png')) {
        $pdf->Image('' . $base_url2 . 'gaf/assets/ttd/' . $pdf->app2_personalstatus . '_' . $pdf->app2_personalid . '.png', 105, 70, 25, 15);
    } else if (isset($pdf->app2_personalid) && $pdf->app2_personalid != '' && $pdf->app2_personalstatus == '2' && file_exists($fcpath2 . 'forviewfoto_pekerja/TTD_TK/' . $pdf->app2_personalid . '.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/TTD_TK/' . $pdf->app2_personalid . '.png', 105, 70, 25, 15);
        // } else if (isset($pdf->app2_personalid) != '' && $pdf->app2_personalstatus == '1' && file_exists($fcpath2 . 'forviewfoto_pekerja/TTD_KRY/' . $pdf->app2_personalid . '_0_0.png')) {
        //     $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/TTD_KRY/' . $pdf->app2_personalid . '_0_0.png', 105, 70, 25, 15);
    } else if (isset($pdf->app2_personalid) != '' && $pdf->app2_personalstatus == '1' && file_exists($fcpath2 . 'forviewfoto_pekerja/' . $pdf->app2_personalid . '_0_0.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/' . $pdf->app2_personalid . '_0_0.png', 105, 70, 25, 15);
    }

    $imageapp3 = $fcpath2 . $pdf->imageurlapp3 . $pdf->imageformatapp3;
    if ($pdf->app3_personalid != '' && file_exists($fcpath2 . 'gaf/assets/ttd/' .  $pdf->app3_personalstatus . '_' . $pdf->app3_personalid . '.png')) {
        $pdf->Image('' . $base_url2 . 'gaf/assets/ttd/' . $pdf->app3_personalstatus . '_' . $pdf->app3_personalid . '.png', 10, 35, 45, 30);
    } else if (isset($pdf->app3_personalid) && $pdf->app3_personalid != '' && $pdf->app3_personalstatus == '2' && file_exists($fcpath2 . 'forviewfoto_pekerja/TTD_TK/' . $pdf->app3_personalid . '.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/TTD_TK/' . $pdf->app3_personalid . '.png', 10, 35, 45, 30);
    } else if (isset($pdf->app3_personalid) != '' && $pdf->app3_personalstatus == '1' && file_exists($fcpath2 . 'forviewfoto_pekerja/' . $pdf->app3_personalid . '_0_0.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/' . $pdf->app3_personalid . '_0_0.png', 20, 35, 25, 15);
    } else if (isset($pdf->app3_personalid) != '' && $pdf->app3_personalstatus == '1' && file_exists($fcpath2 . 'forviewfoto_pekerja/TTD_KRY/' . $pdf->app3_personalid . '_0_0.png')) {
        $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/TTD_KRY/' . $pdf->app3_personalid . '_0_0.png', 10, 35, 45, 30);
    }

    // $pdf->AddPage();
    //Tabel penghuni
    $pdf->Ln(10);
    $pdf->SetX(7);
    $pdf->Cell(7, 15, 'No', 'LBT', 0, 'C');
    $pdf->Cell(38, 15, 'Nama Penghuni ', 'LBT', 0, 'C');
    $pdf->Cell(14, 15, 'PT', 'LBT', 0, 'C');
    $pdf->Cell(10, 15, 'NIK / ID', 'LBT', 0, 'C');
    $pdf->Cell(8, 15, 'Dept', 'LBT', 0, 'C');
    $pdf->Cell(33, 15, 'Jabatan', 'LBT', 0, 'C');
    $pdf->Cell(14, 15, 'Tgl.Masuk', 'LT', 0, 'C');
    $pdf->Cell(14, 15, 'Tgl Lahir', 'LBT', 0, 'C');
    $pdf->Cell(8, 15, 'Umur', 'LT', 0, 'C');
    $pdf->Cell(36, 7.5, 'Status', 'BLT', 0, 'C');
    $pdf->Cell(14, 15, 'Ket', 'BLTR', 0, 'C');

    $pdf->Ln(7.5);
    $pdf->SetX(7);
    $pdf->Cell(7, 7.5, '', 'B', 0, 'C');
    $pdf->Cell(38, 7.5, 'Residents name', 'B', 0, 'C');
    $pdf->Cell(14, 7.5, ' ', 'B', 0, 'C');
    $pdf->Cell(10, 7.5, 'Number', 'B', 0, 'C');
    $pdf->Cell(8, 7.5, 'Dept', 'B', 0, 'C');
    $pdf->Cell(33, 7.5, 'Position', 'B', 0, 'C');
    $pdf->Cell(14, 7.5, 'Entry date', 'LB', 0, 'C');
    $pdf->Cell(14, 7.5, 'Date of birth', 'B', 0, 'C');
    $pdf->Cell(8, 7.5, 'Age', 'LB', 0, 'C');
    $pdf->Cell(19, 7.5, 'K/KB', 'LB', 0, 'C');
    $pdf->Cell(17, 7.5, 'Ket', 'LB', 0, 'C');
    $pdf->Ln();

    $yawal  = $pdf->GetY();
    $yakhir = $pdf->GetY();
    $i      = 1;
    $pdf->SetFont('Times', '', 7);
    $pdf->SetLineWidth(0.3);

    $index = 0;

    for ($a = 0; $a < $jml_data; $a++) {
        $no++;

        if ($no > 2 && $index == 0) {
            $pdf->AddPage();
            $pdf->Ln(10); // Spasi antar baris pada halaman baru
            $yawal = $pdf->GetY();
            $index++;

            // Menggambar garis-garis pada halaman baru
            $yt = $pdf->GetY();
            $pdf->SetLineWidth(0.1);
            $pdf->Line(7, $yt, 203, $yt); // Garis horizontal di bagian bawah halaman
        }

        if (isset($page_dtl_nama[$a])) {
            if (trim($page_dtl_nama[$a]) != '') {
                $dtl_nama[$a] = $page_dtl_nama[$a];
            } else {
                $dtl_nama[$a] = '-';
            }
        } else {
            $dtl_nama[$a] = '-';
        }

        if (isset($page_dtl_nama[$a])) {
            $dtno  = $no;
        } else {
            $dtno = '-';
        }

        // if (isset($page_dtl_cv[$a])) {
        //     if (trim($page_dtl_cv[$a]) != 'PT.PSG') {
        //         $dtl_cv[$a] = '-';
        //     } else {
        //         $dtl_cv[$a] = $page_dtl_cv[$a];
        //     }
        // } else {
        //     $dtl_cv[$a] = '-';
        // }

        if (isset($page_dtl_nik[$a])) {
            if (trim($page_dtl_nik[$a]) != '') {
                $dtl_nik[$a] = $page_dtl_nik[$a];
            } else {
                $dtl_nik[$a] = '';
            }
        } else {
            $dtl_nik[$a] = '-';
        }

        if (isset($page_dtl_dept[$a])) {
            if (trim($page_dtl_dept[$a]) != '') {
                $dtl_dept[$a] = $page_dtl_dept[$a];
            } else {
                $dtl_dept[$a] = '-';
            }
        } else {
            $dtl_dept[$a] = '-';
        }

        if (isset($page_dtl_jabatan[$a])) {
            if (trim($page_dtl_jabatan[$a]) != '') {
                $dtl_jabatan[$a] = $page_dtl_jabatan[$a];
            } else {
                $dtl_jabatan[$a] = '-';
            }
        } else {
            $dtl_jabatan[$a] = '-';
        }

        if (isset($page_dtl_tgl_masuk_kerja[$a])) {
            if (trim($page_dtl_tgl_masuk_kerja[$a]) == '01-01-1970') {
                $dtl_tanggal_masuk_kerja[$a] = '-';
            } else {
                $dtl_tanggal_masuk_kerja[$a] = $page_dtl_tgl_masuk_kerja[$a];
            }
        } else {
            $dtl_tanggal_masuk_kerja[$a] = '-';
        }

        if (isset($page_dtl_tgl_lahir[$a])) {
            if (trim($page_dtl_tgl_lahir[$a]) != '') {
                $dtl_tgl_lahir[$a] = $page_dtl_tgl_lahir[$a];
            } else {
                $dtl_tgl_lahir[$a] = '-';
            }
        } else {
            $dtl_tgl_lahir[$a] = '-';
        }

        if (isset($page_dtl_umur[$a])) {
            if (trim($page_dtl_umur[$a]) != '') {
                $dtl_umur[$a] = $page_dtl_umur[$a];
            } else {
                $dtl_umur[$a] = '-';
            }
        } else {
            $dtl_umur[$a] = '-';
        }

        if (isset($page_dtl_status_kawin[$a])) {
            if (trim($page_dtl_status_kawin[$a]) != '') {
                $dtl_status_kawin[$a] = $page_dtl_status_kawin[$a];
            } else {
                $dtl_status_kawin[$a] = '-';
            }
        } else {
            $dtl_status_kawin[$a] = '-';
        }

        if (isset($page_dtl_status_hubungan[$a])) {
            if (trim($page_dtl_status_hubungan[$a]) != '') {
                $status_hubungan[$a] = $page_dtl_status_hubungan[$a];
            } else {
                $status_hubungan[$a] = '-';
            }
        } else {
            $status_hubungan[$a] = '-';
        }

        if (isset($page_dtl_keterangan[$a])) {
            if (trim($page_dtl_keterangan[$a]) != '') {
                $dtl_keterangan[$a] = $page_dtl_keterangan[$a];
            } else {
                $dtl_keterangan[$a] = '-';
            }
        } else {
            $dtl_keterangan[$a] = '-';
        }

        $y = $pdf->GetY();
        $pdf->SetXY(5, $y);
        $pdf->MultiCell(10, 6.2, $dtno, 0, 'C');

        $pdf->SetXY(14, $y);
        $pdf->MultiCell(50, 6.2, $dtl_nama[$a], 0, 'L');

        $pdf->SetXY(43, $y);
        $pdf->MultiCell(32, 6.2, $page_dtl_cv[$a], 0, 'C');

        $pdf->SetXY(50, $y);
        $pdf->MultiCell(42, 6.2, $dtl_nik[$a], 0, 'C');

        $pdf->SetXY(60, $y);
        $pdf->MultiCell(40, 6.2, $dtl_dept[$a], 0, 'C');

        $pdf->SetXY(75, $y);
        $pdf->MultiCell(50, 6.2, $dtl_jabatan[$a], 0, 'C');

        $pdf->SetXY(107, $y);
        $pdf->MultiCell(34, 6.2, $dtl_tanggal_masuk_kerja[$a], 0, 'C');

        $pdf->SetXY(121, $y);
        $pdf->MultiCell(34, 6.2, $dtl_tgl_lahir[$a], 0, 'C');

        $pdf->SetXY(135, $y);
        $pdf->MultiCell(28, 6.2, $dtl_umur[$a], 0, 'C');

        $pdf->SetXY(145, $y);
        $pdf->MultiCell(35, 6.2, $dtl_status_kawin[$a], 0, 'C');

        $pdf->SetXY(159, $y);
        $pdf->MultiCell(43, 6.2, $status_hubungan[$a], 0, 'C');

        $pdf->SetXY(215, $y);
        $pdf->MultiCell(50, 6.2, $dtl_keterangan[$a], 0, 'C');

        $yt = $pdf->GetY();
        $pdf->SetLineWidth(0.1);
        $pdf->Line(7, $yt, 203, $yt);
        $pdf->Line(7, $yawal, 7, $yt);
        $pdf->Line(14, $yawal, 14, $yt);
        $pdf->Line(52, $yawal, 52, $yt);
        $pdf->Line(66, $yawal, 66, $yt);
        $pdf->Line(76, $yawal, 76, $yt);
        $pdf->Line(84, $yawal, 84, $yt);
        $pdf->Line(117, $yawal, 117, $yt);
        $pdf->Line(131, $yawal, 131, $yt);
        $pdf->Line(145, $yawal, 145, $yt);
        $pdf->Line(153, $yawal, 153, $yt);
        $pdf->Line(172, $yawal, 172, $yt);
        $pdf->Line(189, $yawal, 189, $yt);
        $pdf->Line(203, $yawal, 203, $yt);
        // }


        //     $pdf->AddPage();
        //     $pdf->Ln(10); // Spasi antar baris pada halaman baru
        //     $yawal = $pdf->GetY();
        //     $index++;
        // }
    }

    $pdf->SetLineWidth(0.3);
    $pdf->SetY(-10);
    $pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());
    $pdf->SetX(5);
    // $pdf->SetFont('Times', '', 10);
    // $pdf->Cell(50, 5, 'Tanggal Berlaku / Effective Date: ' . $pdf->frmefec, 0, 'L');
    $pdf->SetX(177);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(0, 5, $pdf->frmnm . '-' . $pdf->frmvrs, 0, 'L');


    // } else {
    //     $pdf->Image('' . $base_url2 . 'forviewfoto_pekerja/TTD_KRY/' . $pdf->app3_personalid . '_0_0.png', 10, 210, 45, 30);
    // }
    // END DETAIL

    // $pdf->Ln();
    // $pdf->SetX(30);
    // $pdf->Cell(60, 6, 'Tanggal :  ' . $dateApp1, 'B', 0, 'L');
    // // $pdf->SetX(130);
    // $pdf->Cell(60, 6, 'Tanggal :  ' . $dateApp2, 'B', 0, 'L');

    // $pdf->isFinished = true;
    // $pdf->AddPage();
}

$pdf->SetLineWidth(0.3);
$pdf->SetY(-10);
$pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());
$pdf->SetX(5);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(27, 5, 'Tanggal Berlaku / ', 0, 0, 'L');
$pdf->SetFont('Times', 'I', 10); // Mengatur jenis huruf menjadi miring
$pdf->Cell(0, 5, 'Effective Date: ' . $pdf->frmefec, 0, 0, 'L');
$pdf->SetFont('Times', '', 10); // Mengembalikan jenis huruf ke normal
$pdf->SetX(177);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0, 5, $pdf->frmnm . '-' . $pdf->frmvrs, 0, 'L');

$pdf->Output();

function  judul1($pdf, $title1, $title2, $result1, $result2)
{
    $pdf->Ln(7);
    $pdf->SetXY(26, $pdf->GetY()); //objek1
    $pdf->Cell(25, 5, $title1, 0, 'L');
    $pdf->SetXY(48, $pdf->GetY()); //tanda titik
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(50, $pdf->GetY()); //parameter 1
    $pdf->Cell(35, 5, $result1, 0, 'L');
    $pdf->SetXY(110, $pdf->GetY()); //objek 2
    $pdf->Cell(34, 5, $title2, 0, 'L');
    $pdf->SetXY(145, $pdf->GetY()); //tanda titik 
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(147, $pdf->GetY()); //parameter 2
    $pdf->Cell(57, 5, $result2, 0, 'L');
    return $pdf;
}

function  judul2($pdf, $title1, $title2, $title3, $result1, $result2, $result3)
{
    $pdf->Ln(5);
    $pdf->SetXY(11, $pdf->GetY());
    $pdf->Cell(25, 5, $title1, 0, 'L');
    $pdf->SetXY(35, $pdf->GetY());
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(37, $pdf->GetY());
    $pdf->Cell(60, 5, $result1, 0, 'L');
    $pdf->SetXY(80, $pdf->GetY());
    $pdf->Cell(34, 5, $title2, 0, 'L');
    $pdf->SetXY(105, $pdf->GetY());
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(107, $pdf->GetY());
    $pdf->Cell(57, 5, $result2, 0, 'L');
    $pdf->SetXY(140, $pdf->GetY()); //objek 2
    $pdf->Cell(34, 5, $title3, 0, 'L');
    $pdf->SetXY(160, $pdf->GetY()); //tanda titik 
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(162, $pdf->GetY()); //parameter 2
    $pdf->Cell(57, 5, $result3, 0, 'L');
    return $pdf;
}

function  judul3($pdf, $title1, $result1, $title2, $result2)
{
    $pdf->Ln(5);
    $pdf->SetXY(11, $pdf->GetY());
    $pdf->Cell(25, 5, $title1, 0, 'L');
    $pdf->SetXY(35, $pdf->GetY());
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(37, $pdf->GetY());
    $pdf->Cell(60, 5, $result1, 0, 'L');
    $pdf->SetXY(80, $pdf->GetY());
    $pdf->Cell(34, 5, $title2, 0, 'L');
    $pdf->SetXY(105, $pdf->GetY());
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(107, $pdf->GetY());
    $pdf->Cell(57, 5, $result2, 0, 'L');
    return $pdf;
}

function  judul4($pdf, $title1, $title2, $result1, $result2)
{
    $pdf->Ln(7);
    $pdf->SetXY(6, $pdf->GetY()); //objek1
    $pdf->Cell(25, 5, $title1, 0, 'L');
    $pdf->SetXY(51, $pdf->GetY()); //tanda titik
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(54, $pdf->GetY()); //parameter 1
    $pdf->Cell(60, 5, $result1, 0, 'L');
    $pdf->SetXY(115, $pdf->GetY()); //objek 2
    $pdf->Cell(34, 5, $title2, 0, 'L');
    $pdf->SetXY(155, $pdf->GetY()); //tanda titik 
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(158, $pdf->GetY()); //parameter 2
    $pdf->Cell(57, 5, $result2, 0, 'L');
    return $pdf;
}

function  judul5($pdf, $title1, $title2, $result1, $result2)
{
    $pdf->Ln(7);
    $pdf->SetXY(11, $pdf->GetY()); //objek1
    $pdf->Cell(25, 5, $title1, 0, 'L');
    $pdf->SetXY(48, $pdf->GetY()); //tanda titik
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(50, $pdf->GetY()); //parameter 1
    $pdf->Cell(60, 5, $result1, 0, 'L');
    $pdf->SetXY(100, $pdf->GetY()); //objek 2
    $pdf->Cell(34, 5, $title2, 0, 'L');
    $pdf->SetXY(135, $pdf->GetY()); //tanda titik 
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(140, $pdf->GetY()); //parameter 2
    $pdf->Cell(57, 5, $result2, 0, 'L');
    return $pdf;
}

function  judul6($pdf, $title1, $title2, $result1, $result2)
{
    $pdf->Ln(5);
    $pdf->SetXY(26, $pdf->GetY()); //objek1
    $pdf->Cell(25, 5, $title1, 0, 'L');
    $pdf->SetXY(48, $pdf->GetY()); //tanda titik
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(50, $pdf->GetY()); //parameter 1
    $pdf->Cell(60, 5, $result1, 0, 'L');
    $pdf->SetXY(110, $pdf->GetY()); //objek 2
    $pdf->Cell(34, 5, $title2, 0, 'L');
    $pdf->SetXY(145, $pdf->GetY()); //tanda titik 
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(147, $pdf->GetY()); //parameter 2
    $pdf->Cell(57, 5, $result2, 0, 'L');
    return $pdf;
}

function  running($pdf, $title1, $result1)
{
    $pdf->Ln(5);
    $pdf->SetXY(26, $pdf->GetY());
    $pdf->Cell(25, 5, $title1, 0, 'L');
    $pdf->SetXY(92, $pdf->GetY());
    $pdf->Cell(2, 5, ': ', 0, 'L');
    $pdf->SetXY(95, $pdf->GetY());
    $pdf->Cell(60, 5, $result1, 0, 'L');
    return $pdf;
}

function  coret($pdf, $title1)
{
    $pdf->Ln(7);
    $pdf->SetXY(11, $pdf->GetY());
    $pdf->Cell(25, 5, $title1, 0, 'L');
    return $pdf;
}

function  coret1($pdf, $title1)
{
    $pdf->Ln(7);
    $pdf->SetXY(6, $pdf->GetY());
    $pdf->Cell(25, 5, $title1, 0, 'L');
    return $pdf;
}
function  coret1_miring($pdf, $text2, $miring2 = false)
{
    $pdf->SetFont('Times', $miring2 ? 'I' : '', 11);
    $pdf->Ln(7);
    $pdf->SetXY(6, $pdf->GetY());
    $pdf->Cell(25, 5, $text2, 0, 'L');
    return $pdf;
}

function coret5($pdf, $text, $miring = false)
{
    $pdf->Ln(5);
    $pdf->SetFont('Times', '', 11);
    $pdf->SetXY(6, $pdf->GetY());
    if ($miring) {
        $pdf->SetFont('Times', 'I', 11);
    }

    $pdf->Cell(0, 5, $text, 0, 1, 'L');

    $pdf->SetFont('Times', '', 11);

    return $pdf;
}

function coret_miring($pdf, $text1, $miring1 = false)
{
    $pdf->SetFont('Times', $miring1 ? 'I' : '', 11);
    // $pdf->SetXY(15, $pdf->GetY());
    $pdf->Ln(7);
    $pdf->Cell(0, 5, $text1);
    $pdf->SetFont('Times', '', 11);
}
function coret_miring2($pdf, $text1, $miring1 = false)
{
    $pdf->SetFont('Times', $miring1 ? 'I' : '', 11);
    $pdf->Ln(7);
    $pdf->SetXY(6, $pdf->GetY());
    $pdf->Cell(25, 5, $text1);
    $pdf->SetFont('Times', '', 11);
}
