<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Blacklist_rsup extends CI_Controller
{
  var $API = "";
  function __construct()
  {
    parent::__construct();
    $this->API = "http://222.124.139.234/APIRekrutmen";

    $this->load->model('darurat');
    $status = $this->darurat->getStatus();
    if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
      redirect(site_url('maintenanceControl'));
    }

    date_default_timezone_set("Asia/Jakarta");
    if (!$this->session->userdata('userid')) {
      redirect('login');
    }

    $this->load->model('M_blacklist_rsup');
  }

  function index()
  {
    $data['_getFormID']                     = $this->input->get('id');
    $data['getDataBlacklistKaryawan']       = $this->M_blacklist_rsup->get_KaryawanBlacklist();
    $data['getDataBlacklistHarianBorongan'] = $this->M_blacklist_rsup->get_HarianBoronganBlacklist();
    $data['getDataCalonTenagaKerja']        = $this->M_blacklist_rsup->get_CalonTenagaKerja();
    $data['getDataBlacklistMasyarakat']     = $this->M_blacklist_rsup->get_MasyarakatBlacklist();
    $data['getDataTenagaKerjaDuaBulan']     = $this->M_blacklist_rsup->get_TenagaKerjaDuaBulanBlacklist();
    $data['getDataCalonKarantina']          = $this->M_blacklist_rsup->get_CalonKarantinaBlacklist();
    $data['jmlDataBlacklistTK']             = $this->M_blacklist_rsup->getJmlhBlacklistTK();
    $data['jmlDataBlacklistK']              = $this->M_blacklist_rsup->getJmlhBlacklistK();
    $data['jmlDataBlacklistCTK']            = $this->M_blacklist_rsup->getJmlhBlacklistCTK();
    $data['jmlDataBlacklistM']              = $this->M_blacklist_rsup->getJmlhBlacklistM();
    $data['jmlDataBlacklistTkduabulan']     = $this->M_blacklist_rsup->getJmlhBlacklistTkduabulan();
    $this->template->display('monitor/blacklist_rsup/index', $data);
  }

  function ExportToExcel2()
  {
    $this->load->library("Excel/PHPExcel");

    $data['getExcelTenagaKerja2'] = $this->M_blacklist_rsup->get_excel2();

    $this->load->view('monitor/blacklist/ExportToExcell2', $data);
  }

  function ExportToExcel()
  {
    $this->load->library("Excel/PHPExcel");

    $data['getExcelTenagaKerja'] = $this->M_blacklist_rsup->get_excel1();

    $this->load->view('monitor/blacklist/ExportToExcell1', $data);
  }

  function ExportToExcel3()
  {
    $this->load->library("Excel/PHPExcel");

    $data['getExcelTenagaKerja3'] = $this->M_blacklist_rsup->get_excel3();

    $this->load->view('monitor/blacklist/ExportToExcell3', $data);
  }

  function Karyawan()
  {
    $data['_getFormID'] = $this->input->get('id');
    $data['get_Data']   = $this->M_blacklist_rsup->karyawankeluar();

    $this->template->display('registrasi/blacklist/karyawan', $data);
  }

  function ajaxblacklistK()
  {
    $nik = $this->uri->segment(3);

    $data['_getData'] = $this->M_blacklist_rsup->getDataBlacklistK($nik);
    $data['_cekData'] = $this->M_blacklist_rsup->getDataBlacklistK($nik);

    $this->load->view('registrasi/blacklist/AjaxTableBlacklist', $data);
  }

  function ajaxDetail()
  {
    $nik = $this->uri->segment(3);

    $data['_getData'] = $this->M_blacklist_rsup->getDataBlacklistK($nik);
    $data['_cekData'] = $this->M_blacklist_rsup->getDataBlacklistK($nik);
    $this->template->display('registrasi/blacklist/AjaxTableBlacklist');
  }

  function updateData()
  {
    $nik = $this->uri->segment(3);
    // 
    $data['get_Data'] = $this->M_blacklist_rsup->get_dataKaryawan($nik);
    $this->template->display('registrasi/blacklist/tambahBlacklistK', $data);
  }

  function updateKaryawan()
  {
    $nik        = $this->input->post('txtFindBynik');
    $regno      = $this->input->post('txtregno');
    $nama       = $this->input->post('txtnama');
    $tgllahir   = $this->input->post('txttgllahir');
    $perusahaan = $this->input->post('txtperusahaan');
    $departemen = $this->input->post('txtdept');
    $tglmasuk   = $this->input->post('txttglmasuk');
    $tglkeluar  = $this->input->post('txttglkeluar');
    $keterangan = $this->input->post('txtketerangan');
    $blacklist  = $this->input->post('txttype');

    $data = array(
      'Blacklist'      => 1,
      'Blacklist_ket'  => $keterangan,
      'Blacklist_by'   => strtoupper($this->session->userdata('username')),
      'Blacklist_date' => date('Y-m-d H:i:s'),
    );

    $result = $this->M_blacklist_rsup->update_blacklist($regno, $data);
    if (!$result) {
      redirect('Blacklist_rsup?msg=success_add');
    } else {
      redirect('Blacklist_rsup?msg=failed_add');
    }
  }

  function masyarakat()
  {
    $data['_getFormID'] = $this->input->get('id');
    $data['_getData']   = $this->M_blacklist_rsup->get_MasyarakatBlacklist3();
    $this->template->display('registrasi/blacklist/tambahBlacklistMasyarakat', $data);
  }

  function simpanBlaklistMasyarakat()
  {
    $nama        = $this->input->post('txtnama');
    $nik         = $this->input->post('txtktp');
    $ibukandung  = $this->input->post('txtnamaibu');
    $alamat      = $this->input->post('txtalamat');
    $keterangan  = $this->input->post('txtketerangan');
    $tgllahir    = $this->input->post('txttgllahir');
    $tempatlahir = $this->input->post('txttempatlahir');
    $jk          = $this->input->post('txtjeniskelamin');
    $foto        = $this->input->post('txtUploadFoto');

    $data = array(
      'Nama'         => $nama,
      'NikKTP'       => $nik,
      'IbuKandung'   => $ibukandung,
      'Alamat'       => $alamat,
      'Keterangan'   => $keterangan,
      'TempatLahir'  => $tempatlahir,
      'TanggalLahir' => $tgllahir,
      'JenisKelamin' => $jk,
      'Foto'         => $foto,
    );

    // echo "hahahaha";
    $this->M_blacklist_rsup->simpanDataBlacklistM($data);
    redirect('Blacklist_rsup/masyarakat');
  }

  function tambahBalklistCalonTK()
  {
    $data['_getFormID'] = $this->input->get('id');
    $this->template->display('registrasi/blacklist/BlacklistCalonTK', $data);
  }

  function ajaxblacklistcalontk()
  {
    $hdrid         = $this->uri->segment(3);
    $data['hdrid'] = $hdrid;

    $data['_getData'] = $this->M_blacklist_rsup->getDataCalonTenagaKerja($hdrid);
    $data['_cekData'] = $this->M_blacklist_rsup->getDataCalonTenagaKerja($hdrid);
    $this->load->view('registrasi/blacklist/ajaxCalonBlacklist', $data);
  }

  function tambahdatabalcklistcalontk()
  {
    $headerid   = $this->input->post('txtFindBynik');
    $nik        = $this->input->post('txtnik');
    $nama       = $this->input->post('txtnama');
    $tgllahir   = $this->input->post('txttgllahir');
    $namaibu    = $this->input->post('txtnmibukandung');
    $perusahaan = $this->input->post('txtperusahaan');
    $pemborong  = $this->input->post('txtpemborong');
    $dept       = $this->input->post('txtdept');
    $tglmasuk   = $this->input->post('txttglmasuk');
    $tglkeluar  = $this->input->post('txttglkeluar');
    $keterangan = $this->input->post('txtketerangan');
    //-------------------------------- HEADER -----------------------------------------//
    $data = array(

      'HeaderID'       => $this->input->post('txtFindBynik'),
      'NIK'            => $nik,
      'Nama'           => $nama,
      'NamaIbuKandung' => $namaibu,
      'TanggalLahir'   => date('Y-m-d', strtotime($tgllahir)),
      'TanggalMasuk'   => date('Y-m-d', strtotime($tglmasuk)),
      'TanggalKeluar'  => date('Y-m-d', strtotime($tglkeluar)),
      'Pemborong'      => $pemborong,
      'NamaCV'         => $perusahaan,
      'Keterangan'     => $keterangan,
      'Created_by'     => strtoupper($this->session->userdata('username')),
      'Created_date'   => date('Y-m-d H:i:s'),
      'Blacklist'      => 1,
      'Blacklist_by'   => strtoupper($this->session->userdata('username')),
      'Blacklist_date' => date('Y-m-d'),
    );
    // echo $headerid;
    // echo $nik;
    $result = $this->M_blacklist_rsup->tambah_balcklistcalonTK($data);
    // // echo $Nik;
    if (!$result) {
      redirect('Blacklist_rsup/index');
    } else {
      redirect('Blacklist_rsup/index');
    }
  }

  function blacklistpsg()
  {

    $data['_getFormID']         = $this->input->get('id');
    $data['getDataBlacklistK']  = json_decode($this->curl->simple_get($this->API . '/Karyawan/getBlacklistPSG_K'));
    $data['getDataBlacklistTK'] = json_decode($this->curl->simple_get($this->API . '/Karyawan/getBlacklistPSG_TK'));

    $this->template->display('monitor/blacklist_rsup/data_blacklist_psg', $data);
  }

  // Blacklist pra pelamar

  function pra_pelamar()
  {
    $data['_getFormID'] = $this->input->get('id');
    $this->template->display('registrasi/blacklist/pra_pelamar', $data);
  }

  function ajaxblacklistpra_pelamar()
  {
    $nik = $this->uri->segment(3);

    $data['_getData'] = $this->M_blacklist_rsup->get_data_pra_pelamar($nik);

    $this->load->view('registrasi/blacklist/ajax_pra_pelamar', $data);
  }

  function tambahdatabalcklistprapelamar()
  {
    $pra_pelamarID     = $this->input->post("txtFindBynik");
    $nama              = $this->input->post("txtnama");
    $tgl_lahir         = $this->input->post("txttgllahir");
    $jenis_kelamin     = $this->input->post("txtjeniskelamin");
    $nama_ibu          = $this->input->post("txtnmibukandung");
    $nik_ktp           = $this->input->post("txtnik_ktp");
    $nik_kk            = $this->input->post("txtnik_kk");
    $pemborong         = $this->input->post("txtpemborongid");
    $mulai_karantina   = $this->input->post("txtmulaikarantina");
    $selesai_karantina = $this->input->post("txtselesaikarantina");
    $tgl_keluar        = $this->input->post("txttgldikeluarkan");
    $keterangan        = $this->input->post("txtketerangan");

    $data = array(
      'Pra_PelamarID'       => $pra_pelamarID,
      'Nama_Lengkap'        => $nama,
      'Tanggal_Lahir'       => $tgl_lahir,
      'Jenis_Kelamin'       => $jenis_kelamin,
      'Nama_Ibu_Kandung'    => $nama_ibu,
      'Nik_Ktp'             => $nik_ktp,
      'Nik_Kk'              => $nik_kk,
      'IDPemborong'         => $pemborong,
      'Mulai_Karantina'     => date('Y-m-d', strtotime($mulai_karantina)),
      'Selesai_Karantina'   => date('Y-m-d', strtotime($selesai_karantina)),
      'Tanggal_Dikeluarkan' => $tgl_keluar,
      'Blacklist'           => 1,
      'CreatedBy'           => $this->session->userdata('username'),
      'CreatedDate'         => date('Y-m-d H:i:s'),
    );

    $result = $this->M_blacklist_rsup->simpan_blacklist_pra($data);
    if (!$result) {
      redirect('Blacklist_rsup?msg=success_add');
    } else {
      redirect('Blacklist_rsup?msg=failed_add');
    }
  }
}