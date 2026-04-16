<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Test extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    echo base_url();
    // $this->load->model('darurat');
    // $this->load->model('m_register');
    // // $status = 1;
    // $status = $this->darurat->getStatus();
    // if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
    //   redirect(site_url('maintenanceControl'));
    // }

    // date_default_timezone_set("Asia/Jakarta");
    // if (!$this->session->userdata('userid')) {
    //   redirect('login');
    // }
    // $this->load->library(array('template', 'form_validation'));
  }

  function index()
  {
    // $this->load->model('m_register');

    // $data['_getprovinsi']    = $this->m_register->getProvinsi();
    // $data['_getSuku']        = $this->m_register->getSuku();
    // $data['_getAgama']       = $this->m_register->getAgama();
    // $data['_getJurusan']     = $this->m_register->getJurusan();
    // $data['_getPendidikan']  = $this->m_register->getPendidikan();
    // $data['_getStatusKawin'] = $this->m_register->getStatusKawin();
    // $idpemborong             = $this->session->userdata('idpemborong');
    // //    $data['_getPemborong']= $this->m_register->get_pemborong_bygroup($idpemborong)->result();
    // $data['_getPSGPemorong'] = $this->m_register->getPSGPemborong($idpemborong);
    // $data['idpemborong']     = $idpemborong;

    // // print_r($this->session->userdata());
    // // die;

    // $this->session->set_flashdata("regid", 0);
    // //echo $idpemborong;
    // $this->template->display('registrasi/register/index', $data);
    // echo base_url();
  }

  function registrasi_dev()
  {
    $this->load->model('m_register');

    $data['_getprovinsi']    = $this->m_register->getProvinsi();
    $data['_getSuku']        = $this->m_register->getSuku();
    $data['_getAgama']       = $this->m_register->getAgama();
    $data['_getJurusan']     = $this->m_register->getJurusan();
    $data['_getPendidikan']  = $this->m_register->getPendidikan();
    $data['_getStatusKawin'] = $this->m_register->getStatusKawin();
    $idpemborong             = $this->session->userdata('idpemborong');
    //    $data['_getPemborong']= $this->m_register->get_pemborong_bygroup($idpemborong)->result();
    $data['_getPSGPemorong'] = $this->m_register->getPSGPemborong($idpemborong);
    $data['idpemborong']     = $idpemborong;

    $this->session->set_flashdata("regid", 0);
    //echo $idpemborong;
    $this->template->display('registrasi/register/index_dev', $data);
  }


  function indexNew()
  {
    $this->load->model('m_register');

    $data['_getprovinsi']    = $this->m_register->getProvinsi();
    $data['_getSuku']        = $this->m_register->getSuku();
    $data['_getAgama']       = $this->m_register->getAgama();
    $data['_getJurusan']     = $this->m_register->getJurusan();
    $data['_getPendidikan']  = $this->m_register->getPendidikan();
    $data['_getStatusKawin'] = $this->m_register->getStatusKawin();
    $idpemborong             = $this->session->userdata('idpemborong');
    //    $data['_getPemborong']= $this->m_register->get_pemborong_bygroup($idpemborong)->result();
    $data['_getPSGPemorong'] = $this->m_register->getPSGPemborong($idpemborong);
    $data['idpemborong']     = $idpemborong;
    // print_r($data['_getprovinsi']);
    // die();
    $this->session->set_flashdata("regid", 0);
    //echo $idpemborong;
    $this->template->display('registrasi/register/indexNew', $data);
  }

  function index2()
  {
    $this->load->model('m_register');

    $data['_getprovinsi']    = $this->m_register->getProvinsi();
    $data['_getSuku']        = $this->m_register->getSuku();
    $data['_getAgama']       = $this->m_register->getAgama();
    $data['_getJurusan']     = $this->m_register->getJurusan();
    $data['_getPendidikan']  = $this->m_register->getPendidikan();
    $data['_getStatusKawin'] = $this->m_register->getStatusKawin();
    $idpemborong             = $this->session->userdata('idpemborong');
    //        $data['_getPemborong']= $this->m_register->get_pemborong_bygroup($idpemborong)->result();
    $data['_getPSGPemorong'] = $this->m_register->getPSGPemborong($idpemborong);

    $this->session->set_flashdata("regid", 0);
    //echo $idpemborong;
    $this->template->display('registrasi/register/index2', $data);
  }

  //てり　らま
  function PilihCTKB_()
  {

    // if ($this->session->userdata('userid') != 'KIKI') {
    //     echo 'Perbaikan by Programmer .. ! (akan dibuka pukul 16.00 WIB)';
    //     die;
    // }

    $data['keterangan'] = $this->input->post('keterangan') ?? '';
    $data['proses']     = $this->input->post('proses') ?? '';

    if (!empty($this->input->post('end_date')) && date('Y-m-d', strtotime($this->input->post('end_date'))) >= '2021-01-01') {
      $data['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
    } else {
      $data['end_date'] = date('Y-m-t');
    }

    if (!empty($this->input->post('start_date')) && date('Y-m-d', strtotime($this->input->post('start_date'))) <= $data['end_date']) {
      $data['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
    } else {
      $data['start_date'] = date('Y-m-d', strtotime($data['end_date'] . ' -3 months'));
    }

    $idpemborong               = $this->session->userdata('idpemborong');
    $data['_getTenaker']       = $this->m_register->PilihCTKB($data['start_date'], $data['end_date'], $idpemborong);
    $data['_getTenakerProses'] = $this->m_register->PilihCTKBProses($data['start_date'], $data['end_date'], $idpemborong);

    if ($this->session->userdata('userid') == 'kiki' || $this->session->userdata('userid') == 'KIKI') {
      $data['idpemborong'] = 13;
      $idpemborong = 13;
      // print_r($idpemborong);
      // die;

      $this->template->display('transaksi/PendaftaranCTKB/PilihCTKB_backup', $data);
    } else {

      $this->template->display('transaksi/PendaftaranCTKB/PilihCTKB', $data);
    }
  }

  function PilihCTKB()
  {
    $data['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
    $data['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
    $this->template->display('transaksi/PendaftaranCTKB/PilihCTKB', $data);
  }

  function updateProses()
  {
    $headerID   = $this->input->post('headerID');
    $keterangan = $this->input->post('keterangan');
    $proses     = $this->input->post('proses');

    $result           = array();
    $cekqueryBlaclist = array();
    $i                = 0;
    foreach ($headerID as $key => $val) {

      //  insert tbltrnblaclist
      if (trim($keterangan[$key]) == 'blacklist' || trim($keterangan[$key]) == 'blacklist_2_bln') {
        if ($keterangan[$key] == 'blacklist_2_bln') {
          $statusBL = 1;
        } else {
          $statusBL = 0;
        }
        $hdrid                = $headerID[$key];
        $insertToTblBlacklist = $this->m_register->sendToBlacklist($hdrid, $keterangan[$key], $this->session->userdata('username'), date('Y-m-d'), $statusBL);
        array_push($cekqueryBlaclist, $insertToTblBlacklist);
      }

      // proses
      if ($proses[$key] == 'proses') {
        $StatusDaftar    = 1;
        $Proses          = $proses[$key];
        $keteranganKirim = $keterangan[$key];
      } elseif ($proses[$key] == 'belum') {
        $StatusDaftar    = NULL;
        $Proses          = NULL;
        $keteranganKirim = $keterangan[$key];
      } else {
        $StatusDaftar    = 0;
        $Proses          = $proses[$key];
        $keteranganKirim = $keterangan[$key];
      }

      $result[] = array(
        'HeaderID'        => $headerID[$key],
        'StatusDaftar'    => $StatusDaftar,
        'DiprosesBy'      => $this->session->userdata('username'),
        'DiprosesDate'    => date('Y-m-d H: m: i'),
        'Proses'          => $proses[$key],
        'KeteranganKirim' => $keteranganKirim,
      );
      $i++;
    }
    $feedback = $this->m_register->updateDikirim($result);

    if ($feedback == 1) {

      $msg = [
        'type' => 'success',
        'msg'  => 'Berhasil',

      ];
    } else {
      $msg = [
        'type' => 'error',
        'msg'  => 'Gagal',
      ];
    }
    echo json_encode($msg);
  }

  function updateJdwlInterview()
  {

    $headerID        = $this->input->post('headerID');
    $jadwalInterview = $this->input->post('jadwalInterview');


    $result = array();
    foreach ($headerID as $key => $val) {

      $result[] = array(
        'HeaderID'        => $headerID[$key],
        'jadwalInterview' => date('Y-m-d H: m: i', strtotime($jadwalInterview)),
      );
    }


    $feedback = $this->m_register->updateDikirim($result);
    // print_r($feedback);
    // die;

    if ($feedback == 1) {
      $msg = [
        'type' => 'success',
        'msg'  => 'Berhasil',
      ];
    } else {
      $msg = [
        'type' => 'error',
        'msg'  => 'Gagal',
      ];
    }
    echo json_encode($msg);
  }

  function updateJdwlMCU()
  {

    $headerID        = $this->input->post('headerID');
    $jadwalMCU = $this->input->post('jadwal_mcu');


    $result = array();
    foreach ($headerID as $key => $val) {

      $result[] = array(
        'HeaderID'        => $headerID[$key],
        'mcu_date' => date('Y-m-d H: m: i', strtotime($jadwalMCU)),
        'mcu_update_by' => $this->session->userdata('username'),
      );
    }


    $feedback = $this->m_register->updateMCUDate($result);

    if ($feedback == 1) {
      $msg = [
        'type' => 'success',
        'msg'  => 'Berhasil',
      ];
    } else {
      $msg = [
        'type' => 'error',
        'msg'  => 'Gagal',
      ];
    }
    echo json_encode($msg);
  }

  function TransaksiPBR()
  {
    $idpemborong         = $this->session->userdata('idpemborong');
    $data['_getTenaker'] = $this->m_register->listByPBR($idpemborong);
    $this->template->display('registrasi/register/transPBR', $data);
  }

  function updateDikirim()
  {
    $ide          = $this->input->post('headerID');
    $StatusDaftar = 0;
    $result       = array();
    foreach ($ide as $key => $val) {
      $result[] = array(
        'HeaderID'        => $ide[$key],
        'StatusDaftar'    => $StatusDaftar,
        'DikirimBy'       => $this->session->userdata('username'),
        'DikirimDate'     => date('Y-m-d H: m: i'),
        'KeteranganKirim' => NULL,
        'Proses'          => NULL,
        'JadwalInterview' => NULL,
      );
    }
    $num = $this->m_register->updateDikirim($result);

    if ($num == 1) {
      $msg = [
        'type' => 'success',
        'msg'  => 'Berhasil',
      ];
    } else {
      $msg = [
        'type' => 'error',
        'msg'  => 'Gagal',
      ];
    }
    echo json_encode($msg);
  }

  function indexByPass()
  {
    $this->load->model('m_register');

    $data['_getprovinsi']    = $this->m_register->getProvinsi();
    $data['_getSuku']        = $this->m_register->getSuku();
    $data['_getAgama']       = $this->m_register->getAgama();
    $data['_getJurusan']     = $this->m_register->getJurusan();
    $data['_getPendidikan']  = $this->m_register->getPendidikan();
    $data['_getStatusKawin'] = $this->m_register->getStatusKawin();
    $idpemborong             = $this->session->userdata('idpemborong');
    //        $data['_getPemborong']= $this->m_register->get_pemborong_bygroup($idpemborong)->result();
    $data['_getPSGPemorong'] = $this->m_register->getPSGPemborong($idpemborong);

    $this->session->set_flashdata("regid", 0);
    $this->template->display('registrasi/register/index-bypass', $data);
  }

  function selectPemborong()
  {
    $this->load->model('m_register');
    if ('IS_AJAX') {
      $data['namapt'] = $this->m_register->getPemborong();
      $this->load->view('registrasi/register/perusahaan', $data);
    }
  }

  function selectSubPemborong()
  {
    $this->load->model('m_register');
    if ('IS_AJAX') {

      $subpemborong      = $this->input->post('subpemborong');
      $data['namasubpt'] = $this->m_register->getSubPemborong($subpemborong);
      $this->load->view('registrasi/register/subperusahaan', $data);
    }
  }

  function cekAnak($namaAnak)
  {
    $jml_isi = 0;
    for ($a = 0; $a < count($namaAnak); $a++) {
      if ($namaAnak[$a] != NULL) {
        $jml_isi++;
      }
    }
    return $jml_isi;
  }
  //------------------------------------------てり　らま--------------------------------//
  //Function ini berfungsi untuk mengecek CTKB yang tidak bisa melamar atau meregistrasi
  function validasi_register_pelamar()
  {
    $nama      = " MUHAMMAD ERWIN";
    $namaTK    = TRIM(preg_replace("/[^a-zA-Z]/", " ", $nama));
    $pemborong = TRIM("PT PULAU SAMBU");
    $tglLahir  = TRIM("2003-12-25 ");
    $namaIbu   = TRIM(preg_replace("/[^a-zA-Z]/", " ", "KASNILA"));
    $namaAyah  = TRIM(preg_replace("/[^a-zA-Z]/", " ", "JOKO SUSENO"));
    // $nama = " 123NITA SARI#@";
    // $namaTK =  TRIM(preg_replace("/[^a-zA-Z]/", " ", $nama));
    // $pemborong = TRIM("MUKHTAR");
    // $tglLahir = TRIM("1999-05-01");
    // $namaIbu = TRIM(preg_replace("/[^a-zA-Z]/", " ", "NURLAILA"));
    // $namaAyah = TRIM(preg_replace("/[^a-zA-Z]/", " ", "DONI"));


    echo $namaTK;
    echo "<pre>";

    // 1. cek apakah user ada di list blacklist atau tidak
    // $cek_black_list1 = $this->m_register->cekTK1(array('Nama' => $namaTK, 'NamaIbuKandung' => $namaIbu));
    $cek_black_list = $this->m_register->cekTK($namaTK, $namaIbu);

    // 2. cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
    $cekScreen = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);

    // 3.  cek Pernah Masih Aktif sebagai karyawan atau tidak
    $cekTKAktif = $this->m_register->cekRegAktif($namaTK, $tglLahir, $namaIbu, $namaAyah);

    // // 4.  cek masih dalam masa jeda (TanggalKeluarTemporary) 
    // $cekInTemp  = $this->m_register->cekRegInTemp($tglLahir, $namaIbu, $namaAyah);

    // 4.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang sama) 
    $cekRegInTempSamePemborong = $this->m_register->cekRegInTempSamePemborong($tglLahir, $namaIbu, $namaAyah, $pemborong);

    // 5.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang berbeda) 
    $cekRegInTempDiffPemborong = $this->m_register->cekRegInTempDiffPemborong($tglLahir, $namaIbu, $namaAyah, $pemborong);

    // 6. cek apakah tk sudah pernah melamar di pemborong ini ?
    $cekTKPem = $this->m_register->cekRegTKPem($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);

    // 7. Cek TK apakah sudah pernah melamar di pemborong lain ?
    //!! TODO: query cek tk ke pemborong lain
    $cekTK = $this->m_register->cekRegTK($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);


    if ($cek_black_list) {
      redirect('registrasi/rejected_new/1/' . $namaTK);
    }

    if ($cekScreen) {
      redirect('registrasi/rejected_new/2/' . $namaTK);
    }

    if ($cekTKAktif) {
      redirect('registrasi/rejected_new/3/' . $namaTK);
    }
    if ($cekRegInTempSamePemborong) {
      redirect('registrasi/rejected_new/4/' . $namaTK);
    }
    if ($cekRegInTempDiffPemborong) {
      redirect('registrasi/rejected_new/5/' . $namaTK);
    }

    if ($cekTKPem) {
      redirect('registrasi/rejected_new/6/' . $namaTK);
    }

    if ($cekTK) {
      redirect('registrasi/rejected_new/7/' . $namaTK);
    }



    // if ($cek_black_list) {
    //     // $this->session->set_flashdata("namatk", $namaTK);
    //     // redirect('registrasi/rejected/4');
    //     echo "pelamar di blacklist";
    //     exit();
    // }

    // if ($cekScreen) {
    //     echo "pelamar sudah pernah melamar tidak lulus";
    //     exit();
    // }

    // if ($cekTKAktif) {
    //     echo "pelamar masih bekerja";
    //     exit();
    // }

    // if ($cekInTemp) {
    //     echo "pelamar masih dalam masa jeda";
    //     exit();
    // }

    // if ($cekTKPem) {
    //     echo "sudah terdaftar di pemborong ini";
    //     exit();
    // }

    // if ($cekTK) {
    //     echo "sudah terdaftar di pemborong lain";
    //     exit();
    // }

    // echo "lolos";
    // exit();

    // else if ($cekScreen == true) {
    //     $this->session->set_flashdata("namatk", $namaTK);
    //     redirect('registrasi/rejected_new/2');
    // } elseif ($cekTKAktif == true) {
    //     $this->session->set_flashdata("namatk", $namaTK);
    //     redirect('registrasi/rejected_new/3');
    // } elseif ($cekInTemp == true) {
    //     $this->session->set_flashdata("namatk", $namaTK);
    //     redirect('registrasi/rejected_new/4');
    // } elseif ($cekTKPem == true) {
    //     $this->session->set_flashdata("namatk", $namaTK);
    //     redirect('registrasi/rejected_new/5');
    // } elseif ($cekTK == true) {
    //     $this->session->set_flashdata("namatk", $namaTK);
    //     redirect('registrasi/rejected_new/6');
    // }
  }

  function rejected_new($pesan_id, $namaTk)
  {
    $namaTk = urldecode($namaTk);
    switch ($pesan_id) {
      case '1':
        // blacklist
        $data['pesan'] = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>telah masuk ke dalam TK bermasalah!!</small>';
        break;
      case '2':
        //TIDAK LULUS
        $data['pesan'] = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>telah/pernah mendaftar dan ditolak!!</small>';
        break;
        // Masih Aktif
      case '3':
        $data['pesan'] = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>masih aktif sebagai Tenaga Kerja!!</small>';
        break;
        //dalam masa jeda Pemborng yang sama
      case '4':
        $data['pesan'] = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>masih dalam waktu tenggang tanggal dia keluar Di pemborong ini!! </small>';
        break;
        //dalam masa jeda pemborong yang berbeda
      case '5':
        $data['pesan'] = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>masih dalam waktu tenggang tanggal dia keluar Di pemborong lain!! </small>';
        break;
        //pernah melamar dipemborong ini
      case '6':
        $data['pesan'] = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>sudah pernah melamar dipemborong ini!!</small>';
        break;
        //pernah melamar dipemborong lain
      case '7':
        $data['pesan'] = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>sudah pernah melamar dipemborong lain!!</small>';
        break;
      case '8':
        $data['pesan'] = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>CTKB masuk kategoii Cancel !!</small>';
        break;
    }

    $this->template->display("registrasi/register/tolak_new", $data);
  }
  //---------------------------------------------------------------//

  function simpanReg()
  {
    $this->load->model('m_register');

    $this->_set_rules();

    if ($this->form_validation->run() == FALSE) {
      $data['message'] = 'Silahkan Input Calon Tenaga Kerja';
      $this->template->display('registrasi/register/index', $data);
      exit;
    }

    $confirm = $this->input->post('txtConfirm'); // ===== deklarasi Confrim Text
    $nama    = trim(strtoupper($this->input->post('txtNama'))); // ===== deklarasi Nama Pelamar
    $namaTK  = TRIM(preg_replace("/[^a-zA-Z]/", " ", $nama));

    // ===== cek KeadaanFisik
    if ($this->input->post('txtKeadaanFisik') === 'CACAT' || $this->input->post('txtKeadaanFisik') === 'cacat') {
      $cacatapa = strtoupper($this->input->post('txtCacatApa'));
    } else {
      $cacatapa = 'TIDAK ADA';
    }
    // ===== cek Penyakit
    if ($this->input->post('txtPernahPenyakit') === 'YA') {
      $penyakitapa = strtoupper($this->input->post('txtPenyakit'));
    } else {
      $penyakitapa = 'TIDAK ADA';
    }
    // ===== cek Tato
    if ($this->input->post('txtBertato') === 'YA') {
      $tatoDimana = strtoupper($this->input->post('txtTatoDimana'));
    } else {
      $tatoDimana = 'TIDAK ADA';
    }
    // ===== cek Kriminal
    if ($this->input->post('txtPernahKriminal') === 'YA') {
      $perkaraapa = strtoupper($this->input->post('txtKriminal'));
    } else {
      $perkaraapa = 'TIDAK ADA';
    }
    // ===== cek Jumlah Anak
    if ($this->input->post('txtJumlahAnak') === '') {
      $jumlahanak = '';
    } else {
      $jumlahanak = $this->input->post('txtJumlahAnak');
    }
    // ===== cek Jurusan
    if ($this->input->post('txtJurusan') == '') {
      $jurusan = '-';
    } else {
      $jurusan = strtoupper($this->input->post('txtJurusan'));
    }
    // ===== cek Vaksin
    $TanggalVaksin  = $this->input->post('txtTanggalVaksin');
    $TanggalVaksin2 = $this->input->post('txtTanggalVaksin2');
    $TanggalVaksin3 = $this->input->post('txtTanggalVaksin3');

    if ($this->input->post('txtVaksin') === 'SUDAH') {
      $Vaksin      = $this->input->post('txtVaksin');
      $JenisVaksin = strtoupper($this->input->post('txtJenisVaksin'));
      if ($TanggalVaksin != '') {
        $TanggalVaksin = date('Y-m-d', strtotime($TanggalVaksin));
      } else {
        $TanggalVaksin = NULL;
      }

      if ($TanggalVaksin2 != '') {
        $TanggalVaksin2 = date('Y-m-d', strtotime($TanggalVaksin2));
      } else {
        $TanggalVaksin2 = NULL;
      }

      if ($TanggalVaksin3 != '') {
        $TanggalVaksin3 = date('Y-m-d', strtotime($TanggalVaksin3));
      } else {
        $TanggalVaksin3 = NULL;
      }
    } else {
      $Vaksin         = 'BELUM';
      $JenisVaksin    = 'TIDAK ADA';
      $TanggalVaksin  = NULL;
      $TanggalVaksin2 = NULL;
      $TanggalVaksin3 = NULL;
    }

    $namaAnak  = $this->input->post('txtNamaAnak');
    $itungAnak = $this->cekAnak($namaAnak);
    $jmlAnak   = $this->input->post('txtJumlahAnak');

    if ($jmlAnak == "") {
      if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
        $anak = 0;
      } elseif ($namaAnak == "") {
        $anak = 0;
      } elseif ($itungAnak > 0) {
        $anak = $itungAnak;
      } else {
        $anak = 0;
      }
    } elseif ($jmlAnak > 0) {
      if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
        $anak = 0;
      } elseif ($namaAnak == "") {
        $anak = 0;
      } else {
        $anak = $itungAnak;
      }
    } else {
      $anak = $itungAnak;
    }

    $pasangan = $this->input->post('txtNamaPasangan');
    if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS' || $pasangan == '') {
      $tglPasangan = NULL;
    } else {
      $tglPasangan = date('Y-m-d', strtotime($this->input->post('txtTglLahirPasangan')));
    }

    if ($this->input->post('txtShcool') == "") {
      $univ = $this->input->post('txtUniv');
    } else {
      $univ = $this->input->post('txtShcool');
    }

    if ($this->input->post('txtNilai') == "") {
      $ipk = $this->input->post('txtIPK');
    } else {
      $ipk = $this->input->post('txtNilai');
    }

    if (strtoupper($this->input->post('txtPendidikan')) == 'TIDAK SEKOLAH') {
      $pendidikan = "NaN";
    } else {
      $pendidikan = strtoupper($this->input->post('txtPendidikan'));
    }
    $pisah          = explode(',', $this->input->post('txtSubPemborong'));
    $subpemborong   = trim($pisah[0]);
    $idsubpemborong = trim($pisah[1]);

    $agamaValue            = $this->input->post('txtAgama');
    list($IDAgama, $Agama) = explode(',', $agamaValue);

    $info = array(
      'CVNama'              => $this->input->post('txtPerusahaan'),
      'Pemborong'           => $this->input->post('txtPemborong'),
      'IDPemborong'         => $this->input->post('txtIDPemborong'),
      'SubPemborong'        => $subpemborong,
      'IDSubPemborong'      => $idsubpemborong,
      'Nama'                => str_replace("'", "`", trim(strtoupper($this->input->post('txtNama')))),
      'Tgl_Lahir'           => date('Y-m-d', strtotime($this->input->post('txtTanggalLahir'))),
      'Tempat_Lahir'        => str_replace("'", "`", strtoupper($this->input->post('txtTempatLahir'))),
      'NamaIbuKandung'      => strtoupper($this->input->post('txtNamaIbu')),
      'BeratBadan'          => $this->input->post('txtBeratBadan'),
      'TinggiBadan'         => $this->input->post('txtTinggiBadan'),
      'IDAgama'             => $IDAgama,
      'Agama'               => $Agama,
      // 'IDAgama'             => $this->input->post('txtAgama'),
      // 'Agama'               => strtoupper($this->input->post('txtAgama')),
      'Suku'                => strtoupper($this->input->post('txtSuku')),
      'Jenis_Kelamin'       => strtoupper($this->input->post('txtJekel')),
      'Pendidikan'          => $pendidikan,
      'Jurusan'             => $jurusan,
      'Universitas'         => $univ,
      'IPK'                 => $ipk,
      'Status_Personal'     => strtoupper($this->input->post('txtStatus')),
      'No_Ktp'              => $this->input->post('txtNoKTP'),
      'No_KK'               => $this->input->post('txtNoKK'),
      'Alamat_KTP'          => strtoupper($this->input->post('txtAlamatKTP')),
      'Alamat'              => strtoupper($this->input->post('txtAlamat')),
      'RT'                  => $this->input->post('txtRT'),
      'RW'                  => $this->input->post('txtRW'),
      'TinggalDengan'       => $this->input->post('txtTinggalDengan'),
      'HubunganDenganTK'    => $this->input->post('txtHubungan'),
      'NoHP'                => $this->input->post('txtNoPonsel'),
      'Daerah_Asal'         => strtoupper($this->input->post('txtDaerahAsal')),
      'PernahKerja'         => strtoupper($this->input->post('txtPernahRSUP')),
      'KerjaDi'             => strtoupper($this->input->post('txtBagian')),
      'Kriminal'            => $this->input->post('txtPernahKriminal'),
      'PerkaraApa'          => $perkaraapa,
      'JumlahAnak'          => $anak,
      'NamaSuamiIstri'      => str_replace("'", "`", strtoupper($this->input->post('txtNamaPasangan'))),
      'TglLahirSuamiIstri'  => $tglPasangan,
      'PekerjaanSuamiIstri' => strtoupper($this->input->post('txtPekerjaanPasangan')),
      'AlamatSuamiIstri'    => strtoupper($this->input->post('txtAlamatPasangan')),
      'NamaBapak'           => str_replace("'", "`", strtoupper($this->input->post('txtNamaBapak'))),
      'ProfesiOrangTua'     => strtoupper($this->input->post('txtPekerjaanOrtu')),
      'JumlahSaudara'       => $this->input->post('txtJumlahSaudara'),
      'AnakKe'              => $this->input->post('txtAnakKe'),
      'BahasaDaerah'        => strtoupper($this->input->post('txtBahasaDaerah')),
      'TahunMasuk'          => $this->input->post('txtTahunMasuk'),
      'TahunLulus'          => $this->input->post('txtTahunLulus'),
      'Hobby'               => strtoupper($this->input->post('txtHobby')),
      'KegiatanEkstra'      => $this->input->post('txtKegiatanEkstra'),
      'KegiatanOrganisasi'  => $this->input->post('txtOrgnanisasi'),
      'KeadaanFisik'        => $this->input->post('txtKeadaanFisik'),
      'CacatApa'            => $cacatapa,
      'PernahIdapPenyakit'  => $this->input->post('txtPernahPenyakit'),
      'PenyakitApa'         => $penyakitapa,
      'PengalamanKerja'     => $this->input->post('txtPengalamanKerja'),
      'Keahlian'            => $this->input->post('txtKeahlian'),
      'PernahKerjaDiSambu'  => $this->input->post('txtPernahRSUP'),
      'KerjadiBagian'       => strtoupper($this->input->post('txtBagian')),
      'Bertato'             => $this->input->post('txtBertato'),
      'TatoDimana'          => $tatoDimana,
      'Bertindik'           => $this->input->post('txtBertindik'),
      'SediaPotongRambut'   => $this->input->post('txtRambutPendek'),
      'Sediadiberhentikan'  => $this->input->post('txtBerhentikan'),
      'AccountFacebook'     => $this->input->post('txtFacebook'),
      'AccountTwitter'      => $this->input->post('txtTwitter'),
      'Account_email'       => $this->input->post('txtgmail'),
      'CreatedBy'           => strtoupper($this->session->userdata('username')),
      'CreatedDate'         => date('Y-m-d H:i:s'),
      'InputOnline'         => 1,
      'RegisteredBy'        => strtoupper($this->session->userdata('userid')),
      'RegisteredDate'      => date('Y-m-d H:i:s'),
      'ProvinsiID'          => $this->input->post('txtProvinsi'),
      'KabKotaID'           => $this->input->post('txtKabupaten'),
      'KecamatanID'         => $this->input->post('txtKecamatan'),
      'Kerabat_Nama'        => str_replace("'", "`", $this->input->post('txtkerabatterdekat')),
      'Kerabat_Telepon'     => $this->input->post('txtnohpkerabat'),
      'Kerabat_Hubungan'    => $this->input->post('txthubungan'),
      'Kerabat_Alamat'      => $this->input->post('txtAlamatKerabat'),
      'AhliWaris_Nama'      => str_replace("'", "`", $this->input->post('txtAhliWaris')),
      'AhliWaris_Jekel'     => $this->input->post('txtJekelAhliWaris'),
      'AhliWaris_Hubungan'  => $this->input->post('txtHubunganAhliWaris'),
      'AhliWaris_NoHP'      => $this->input->post('txtnohpkerabatAhliWaris'),
      'AhliWaris_Alamat'    => $this->input->post('txtAlamatAhliWaris'),
      'Kelurahan'           => strtoupper($this->input->post('txtKelurahan')),
      'Vaksin'              => $Vaksin,
      'JenisVaksin'         => $JenisVaksin,
      'TanggalVaksin'       => $TanggalVaksin,
      'TanggalVaksin2'      => $TanggalVaksin2,
      'TanggalVaksin3'      => $TanggalVaksin3,
    );

    $adaKeluarga = $this->input->post('txtAdaKeluarga');
    if ($adaKeluarga == 'YA') {
      $jumkel = count($this->input->post('kelnama'));
    } else {
      $jumkel = 0;
    }
    $kelnama      = $this->input->post('kelnama');
    $kelbagian    = $this->input->post('kelbagian');
    $kelpemborong = $this->input->post('kelpemborong');
    $kelhubungan  = $this->input->post('kelhubungan');
    $kelalamat    = $this->input->post('kelalamat');

    $annama         = $this->input->post('txtNamaAnak');
    $antempatlahir  = $this->input->post('txtTempatLahirAnak');
    $antgllahir     = $this->input->post('txtTanggalLahirAnak');
    $anjeniskelamin = $this->input->post('txtJekelAnak');
    $analamat       = $this->input->post('txtAlamatAnak');

    $pemborong = strtoupper($this->input->post('txtPemborong'));
    $tglLahir  = TRIM(date('Y-m-d', strtotime($this->input->post('txtTanggalLahir'))));
    // $namaIbu                          = strtoupper($this->input->post('txtNamaIbu'));
    $namaIbu = TRIM(preg_replace("/[^a-zA-Z]/", " ", $this->input->post('txtNamaIbu')));
    // $namaAyah                         = strtoupper($this->input->post('txtNamaBapak'));
    $namaAyah = TRIM(preg_replace("/[^a-zA-Z]/", " ", $this->input->post('txtNamaBapak')));

    $noKTP             = trim($this->input->post('txtNoKTP'));


    // ====== KONFIRMASI
    if ($confirm == 0) {

      // 1. cek apakah user ada di list blacklist atau tidak
      // $cek_black_list1 = $this->m_register->cekTK1(array('Nama' => $namaTK, 'NamaIbuKandung' => $namaIbu));
      $cek_black_list = $this->m_register->cekTK($namaTK, $namaIbu);;

      // 2. cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
      $cekScreen = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);

      // 3.  cek Pernah Masih Aktif sebagai karyawan atau tidak
      $cekTKAktif = $this->m_register->cekRegAktif($namaTK, $tglLahir, $namaIbu, $namaAyah);

      // // 4.  cek masih dalam masa jeda (TanggalKeluarTemporary) 
      // $cekInTemp  = $this->m_register->cekRegInTemp($tglLahir, $namaIbu, $namaAyah);

      // 4.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang sama) 
      $cekRegInTempSamePemborong = $this->m_register->cekRegInTempSamePemborong($tglLahir, $namaIbu, $namaAyah, $pemborong);

      // 5.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang berbeda) 
      $cekRegInTempDiffPemborong = $this->m_register->cekRegInTempDiffPemborong($tglLahir, $namaIbu, $namaAyah, $pemborong);

      // 6. cek apakah tk sudah pernah melamar di pemborong ini ?
      $cekTKPem = $this->m_register->cekRegTKPem($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);

      // 7. Cek TK apakah sudah pernah melamar di pemborong lain ?
      //!! TODO: query cek tk ke pemborong lain
      $cekTK = $this->m_register->cekRegTK($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);

      // 8. Cek TK apakah sedang diblacklist 3 bulan karena pernah mendaftar tapi cancel sendiri
      $cekTKCancel = $this->m_register->cekBlacklistByCancel($noKTP);


      if ($cek_black_list) {
        redirect('registrasi/rejected_new/1/' . $namaTK);
      }

      if ($cekScreen) {
        redirect('registrasi/rejected_new/2/' . $namaTK);
      }

      if ($cekTKAktif) {
        redirect('registrasi/rejected_new/3/' . $namaTK);
      }
      if ($cekRegInTempSamePemborong) {
        redirect('registrasi/rejected_new/4/' . $namaTK);
      }
      if ($cekRegInTempDiffPemborong) {
        redirect('registrasi/rejected_new/5/' . $namaTK);
      }

      if ($cekTKPem) {
        redirect('registrasi/rejected_new/6/' . $namaTK);
      }

      if ($cekTK) {
        redirect('registrasi/rejected_new/7/' . $namaTK);
      }

      if ($cekTKCancel) {
        redirect('registrasi/rejected_new/8/' . $namaTK);
      }
      // // cek pernah melamar atau tidak di pemborong yang sama
      // $cekTK  = $this->m_register->cekRegTK($pemborong, $tglLahir, $namaIbu, $namaAyah);
      // // cek masih aktif atau tidak sebagai karyawan
      // $cekTKAktif = $this->m_register->cekRegAktif($tglLahir, $namaIbu, $namaAyah);
      // // cek pernar melamar atau tidak pemborong lainnya
      // $cekTKPem   = $this->m_register->cekRegTKPem($pemborong, $tglLahir, $namaIbu, $namaAyah);
      // // cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
      // $cekScreen   = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);
      // // cek masih dalam masa jeda (TanggalKeluarTemporary) 
      // $cekInTemp  = $this->m_register->cekRegInTemp($tglLahir, $namaIbu, $namaAyah);

      // if ($cekScreen == true) {
      //     $this->session->set_flashdata("namatk", $namaTK);
      //     redirect('registrasi/rejected/4');
      // } elseif ($cekTKAktif == true) {
      //     $this->session->set_flashdata("namatk", $namaTK);
      //     redirect('registrasi/rejected/2');
      // } elseif ($cekInTemp == true) {
      //     $this->session->set_flashdata("namatk", $namaTK);
      //     redirect('registrasi/rejected/3');
      // } elseif ($cekTK == true) {
      //     $this->session->set_flashdata("namatk", $namaTK);
      //     redirect('registrasi/rejected/1');
      // } 
      if ($cekTKPem == TRUE) {
        $hdridtemp = $this->m_register->simpanTKTemp($info);

        for ($i = 0; $i < $jumkel; $i++) {
          $infokel = array(
            'HeaderID'         => 0,
            'HeaderIDTemp'     => $hdridtemp,
            'Nama'             => str_replace("'", "`", strtoupper($kelnama[$i])),
            'Departemen'       => strtoupper($kelbagian[$i]),
            'Pemborong'        => strtoupper($kelpemborong[$i]),
            'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
            'Alamat'           => strtoupper($kelalamat[$i]),
          );
          if (!$kelnama[$i] == '') {
            $this->simpan_datakeluarga(0, $hdridtemp, $kelnama[$i], $infokel);
          }
        }

        for ($i = 0; $i < $anak; $i++) {
          if (is_array($annama) && array_key_exists($i, $annama)) {
            $infoanak = array(
              'HeaderID'     => 0,
              'HeaderIDTemp' => $hdridtemp,
              'Nama'         => str_replace("'", "`", strtoupper($annama[$i])),
              'TempatLahir'  => strtoupper($antempatlahir[$i]),
              'TglLahir'     => date('Y-m-d', strtotime($antgllahir[$i])),
              'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
              'Alamat'       => strtoupper($analamat[$i]),
              'CreatedBy'    => strtoupper($this->session->userdata('userid')),
              'CreatedDate'  => date('Y-m-d H:i:s'),
            );
            if (!$annama[$i] == '') {
              $this->simpan_dataanak(0, $hdridtemp, $annama[$i], $infoanak);
            }
          }
        }
        $this->session->set_flashdata('hdrIDTemp', $hdridtemp);
        redirect('registrasi/konfirmasi/' . $hdridtemp);
      } else {
        $this->load->model('m_register');
        $hdrID = $this->m_register->simpanTK($info);

        // === Cek Data Anak, Jika Ada Disimpan
        for ($i = 0; $i < $anak; $i++) {
          if (is_array($annama) && array_key_exists($i, $annama)) {
            $infoanak = array(
              'HeaderID'     => $hdrID,
              'HeaderIDTemp' => 0,
              'Nama'         => str_replace("'", "`", strtoupper($annama[$i])),
              'TempatLahir'  => strtoupper($antempatlahir[$i]),
              'TglLahir'     => date('Y-m-d', strtotime($antgllahir[$i])),
              'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
              'Alamat'       => strtoupper($analamat[$i]),
              'CreatedBy'    => strtoupper($this->session->userdata('userid')),
              'CreatedDate'  => date('Y-m-d H:i:s'),
            );
            if (!$annama[$i] == '') {
              $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
            }
          }
        }
        // === Cek Data Keluarga, Jika Ada Simpan
        for ($i = 0; $i < $jumkel; $i++) {
          $infokel = array(
            'HeaderID'         => $hdrID,
            'HeaderIDTemp'     => 0,
            'Nama'             => str_replace("'", "`", strtoupper($kelnama[$i])),
            'Departemen'       => strtoupper($kelbagian[$i]),
            'Pemborong'        => strtoupper($kelpemborong[$i]),
            'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
            'Alamat'           => strtoupper($kelalamat[$i]),
          );
          if (!$kelnama[$i] == '') {
            $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
          }
        }

        $this->load->model('m_upload_berkas');
        $berkas   = 'ktp';
        $url      = './dataupload/berkas/ktp';
        $namafile = $hdrID . '_' . $berkas . '.pdf';

        // Konfigurasi upload
        $config['upload_path']    = $url;
        $config['allowed_types']  = 'pdf';
        $config['allow_scale_up'] = TRUE;
        $config['overwrite']      = TRUE;
        $config['file_name']      = $namafile;
        $config['max_size']       = '5120';
        // print_r($this->input->post('txtPerusahaan'));
        // die;
        if ($this->input->post('txtPerusahaan') == 'PT PULAU SAMBU') {
          $dataBerkas = array(
            'HeaderID' => $hdrID,
            $berkas    => '',
          );
          $result     = $this->m_upload_berkas->insert_db_berkas($dataBerkas);
        } else {
          // Inisialisasi dan melakukan upload
          $this->load->library('upload', $config);
          if ($this->upload->do_upload('txtFileKTP')) {
            $uploadData = $this->upload->data();

            $relativePath = $url . '/' . $uploadData['file_name'];

            $dataBerkas = array(
              'HeaderID' => $hdrID,
              $berkas    => $relativePath,
            );
            $result     = $this->m_upload_berkas->insert_db_berkas($dataBerkas);

            if ($result === 0) {
              $data['errormsg'] = "<div class='alert alert-danger'>Gagal menyimpan data berkas. Berkas dengan HeaderID yang sama sudah ada.</div>";
            } else {
              $data['errormsg'] = "<div class='alert alert-success'>Berkas berhasil diunggah dan disimpan.</div>";
            }
          } else {
            $error            = $this->upload->display_errors();
            $data['errormsg'] = "<div class='alert alert-danger'>Gagal mengunggah berkas: $error</div>";
          }
        }

        $this->session->set_flashdata("regid", $hdrID);
        $this->session->set_flashdata("regnama", $namaTK);
        redirect('registrasi/uploadFoto');
      }
    } elseif ($confirm == 1) {
      $this->load->model('m_register');
      $hdrID     = $this->m_register->simpanTK($info);
      $hdridtemp = '';

      // === Cek Data Anak, Jika Ada Disimpan
      for ($i = 0; $i < $anak; $i++) {
        if (is_array($annama) && array_key_exists($i, $annama)) {
          $infoanak = array(
            'HeaderID'     => $hdrID,
            'HeaderIDTemp' => $hdridtemp,
            'Nama'         => str_replace("'", "`", strtoupper($annama[$i])),
            'TempatLahir'  => strtoupper($antempatlahir[$i]),
            'TglLahir'     => $antgllahir[$i],
            'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
            'Alamat'       => strtoupper($analamat[$i]),
            'CreatedBy'    => strtoupper($this->session->userdata('userid')),
            'CreatedDate'  => date('Y-m-d H:i:s'),
          );
          if (!$annama[$i] == '') {
            $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
          }
        }
      }
      // === Cek Data Keluarga, Jika Ada Simpan
      for ($i = 0; $i < $jumkel; $i++) {
        $infokel = array(
          'HeaderID'         => $hdrID,
          'HeaderIDTemp'     => $hdridtemp,
          'Nama'             => str_replace("'", "`", strtoupper($kelnama[$i])),
          'Departemen'       => strtoupper($kelbagian[$i]),
          'Pemborong'        => strtoupper($kelpemborong[$i]),
          'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
          'Alamat'           => strtoupper($kelalamat[$i]),
        );
        if (!$kelnama[$i] == '') {
          $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
        }
      }

      $this->load->model('m_upload_berkas');
      $berkas   = 'ktp';
      $url      = './dataupload/berkas/ktp';
      $namafile = $hdrID . '_' . $berkas . '.pdf';

      // Konfigurasi upload
      $config['upload_path']    = $url;
      $config['allowed_types']  = 'pdf';
      $config['allow_scale_up'] = TRUE;
      $config['overwrite']      = TRUE;
      $config['file_name']      = $namafile;
      $config['max_size']       = '5120';
      // print_r($this->input->post('txtPerusahaan'));
      // die;
      if ($this->input->post('txtPerusahaan') == 'PT PULAU SAMBU') {
        $dataBerkas = array(
          'HeaderID' => $hdrID,
          $berkas    => '',
        );
        $this->m_upload_berkas->insert_db_berkas($dataBerkas);
      } else {
        // Inisialisasi dan melakukan upload
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('txtFileKTP')) {
          $uploadData = $this->upload->data();

          $relativePath = $url . '/' . $uploadData['file_name'];

          $dataBerkas = array(
            'HeaderID' => $hdrID,
            $berkas    => $relativePath,
          );
          $result     = $this->m_upload_berkas->insert_db_berkas($dataBerkas);

          if ($result === 0) {
            $data['errormsg'] = "<div class='alert alert-danger'>Gagal menyimpan data berkas. Berkas dengan HeaderID yang sama sudah ada.</div>";
          } else {
            $data['errormsg'] = "<div class='alert alert-success'>Berkas berhasil diunggah dan disimpan.</div>";
          }
        } else {
          $error            = $this->upload->display_errors();
          $data['errormsg'] = "<div class='alert alert-danger'>Gagal mengunggah berkas: $error</div>";
        }
      }

      $this->session->set_flashdata("regid", $hdrID);
      $this->session->set_flashdata("regnama", $namaTK);

      $hdridtemp = $this->input->post('txtHeaderIDTemp');
      $this->m_register->update_datakeluarga_fromtemp($hdrID, $hdridtemp);
      $this->m_register->update_dataanak_fromtemp($hdrID, $hdridtemp);
      $this->m_register->update_headeridtemp_formtemp($hdrID, $hdridtemp);

      redirect('registrasi/uploadFoto');
    }
  }

  function simpanReg_dev()
  {
    $this->load->model('m_register');

    $this->_set_rules();

    if ($this->form_validation->run() == FALSE) {
      $data['message'] = 'Silahkan Input Calon Tenaga Kerja';
      $this->template->display('registrasi/register/index', $data);
      exit;
    }

    $confirm = $this->input->post('txtConfirm'); // ===== deklarasi Confrim Text
    $nama    = trim(strtoupper($this->input->post('txtNama'))); // ===== deklarasi Nama Pelamar
    $namaTK  = TRIM(preg_replace("/[^a-zA-Z]/", " ", $nama));

    // ===== cek KeadaanFisik
    if ($this->input->post('txtKeadaanFisik') === 'CACAT' || $this->input->post('txtKeadaanFisik') === 'cacat') {
      $cacatapa = strtoupper($this->input->post('txtCacatApa'));
    } else {
      $cacatapa = 'TIDAK ADA';
    }
    // ===== cek Penyakit
    if ($this->input->post('txtPernahPenyakit') === 'YA') {
      $penyakitapa = strtoupper($this->input->post('txtPenyakit'));
    } else {
      $penyakitapa = 'TIDAK ADA';
    }
    // ===== cek Tato
    if ($this->input->post('txtBertato') === 'YA') {
      $tatoDimana = strtoupper($this->input->post('txtTatoDimana'));
    } else {
      $tatoDimana = 'TIDAK ADA';
    }
    // ===== cek Kriminal
    if ($this->input->post('txtPernahKriminal') === 'YA') {
      $perkaraapa = strtoupper($this->input->post('txtKriminal'));
    } else {
      $perkaraapa = 'TIDAK ADA';
    }
    // ===== cek Jumlah Anak
    if ($this->input->post('txtJumlahAnak') === '') {
      $jumlahanak = '';
    } else {
      $jumlahanak = $this->input->post('txtJumlahAnak');
    }
    // ===== cek Jurusan
    if ($this->input->post('txtJurusan') == '') {
      $jurusan = '-';
    } else {
      $jurusan = strtoupper($this->input->post('txtJurusan'));
    }
    // ===== cek Vaksin
    $TanggalVaksin  = $this->input->post('txtTanggalVaksin');
    $TanggalVaksin2 = $this->input->post('txtTanggalVaksin2');
    $TanggalVaksin3 = $this->input->post('txtTanggalVaksin3');

    if ($this->input->post('txtVaksin') === 'SUDAH') {
      $Vaksin      = $this->input->post('txtVaksin');
      $JenisVaksin = strtoupper($this->input->post('txtJenisVaksin'));
      if ($TanggalVaksin != '') {
        $TanggalVaksin = date('Y-m-d', strtotime($TanggalVaksin));
      } else {
        $TanggalVaksin = NULL;
      }

      if ($TanggalVaksin2 != '') {
        $TanggalVaksin2 = date('Y-m-d', strtotime($TanggalVaksin2));
      } else {
        $TanggalVaksin2 = NULL;
      }

      if ($TanggalVaksin3 != '') {
        $TanggalVaksin3 = date('Y-m-d', strtotime($TanggalVaksin3));
      } else {
        $TanggalVaksin3 = NULL;
      }
    } else {
      $Vaksin         = 'BELUM';
      $JenisVaksin    = 'TIDAK ADA';
      $TanggalVaksin  = NULL;
      $TanggalVaksin2 = NULL;
      $TanggalVaksin3 = NULL;
    }

    $namaAnak  = $this->input->post('txtNamaAnak');
    $itungAnak = $this->cekAnak($namaAnak);
    $jmlAnak   = $this->input->post('txtJumlahAnak');

    if ($jmlAnak == "") {
      if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
        $anak = 0;
      } elseif ($namaAnak == "") {
        $anak = 0;
      } elseif ($itungAnak > 0) {
        $anak = $itungAnak;
      } else {
        $anak = 0;
      }
    } elseif ($jmlAnak > 0) {
      if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
        $anak = 0;
      } elseif ($namaAnak == "") {
        $anak = 0;
      } else {
        $anak = $itungAnak;
      }
    } else {
      $anak = $itungAnak;
    }

    $pasangan = $this->input->post('txtNamaPasangan');
    if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS' || $pasangan == '') {
      $tglPasangan = NULL;
    } else {
      $tglPasangan = date('Y-m-d', strtotime($this->input->post('txtTglLahirPasangan')));
    }

    if ($this->input->post('txtShcool') == "") {
      $univ = $this->input->post('txtUniv');
    } else {
      $univ = $this->input->post('txtShcool');
    }

    if ($this->input->post('txtNilai') == "") {
      $ipk = $this->input->post('txtIPK');
    } else {
      $ipk = $this->input->post('txtNilai');
    }

    if (strtoupper($this->input->post('txtPendidikan')) == 'TIDAK SEKOLAH') {
      $pendidikan = "NaN";
    } else {
      $pendidikan = strtoupper($this->input->post('txtPendidikan'));
    }
    $pisah          = explode(',', $this->input->post('txtSubPemborong'));
    $subpemborong   = trim($pisah[0]);
    $idsubpemborong = trim($pisah[1]);

    $agamaValue            = $this->input->post('txtAgama');
    list($IDAgama, $Agama) = explode(',', $agamaValue);

    $info = array(
      'CVNama'              => $this->input->post('txtPerusahaan'),
      'Pemborong'           => $this->input->post('txtPemborong'),
      'IDPemborong'         => $this->input->post('txtIDPemborong'),
      'SubPemborong'        => $subpemborong,
      'IDSubPemborong'      => $idsubpemborong,
      'Nama'                => str_replace("'", "`", trim(strtoupper($this->input->post('txtNama')))),
      'Tgl_Lahir'           => date('Y-m-d', strtotime($this->input->post('txtTanggalLahir'))),
      'Tempat_Lahir'        => str_replace("'", "`", strtoupper($this->input->post('txtTempatLahir'))),
      'NamaIbuKandung'      => strtoupper($this->input->post('txtNamaIbu')),
      'BeratBadan'          => $this->input->post('txtBeratBadan'),
      'TinggiBadan'         => $this->input->post('txtTinggiBadan'),
      'IDAgama'             => $IDAgama,
      'Agama'               => $Agama,
      // 'IDAgama'             => $this->input->post('txtAgama'),
      // 'Agama'               => strtoupper($this->input->post('txtAgama')),
      'Suku'                => strtoupper($this->input->post('txtSuku')),
      'Jenis_Kelamin'       => strtoupper($this->input->post('txtJekel')),
      'Pendidikan'          => $pendidikan,
      'Jurusan'             => $jurusan,
      'Universitas'         => $univ,
      'IPK'                 => $ipk,
      'Status_Personal'     => strtoupper($this->input->post('txtStatus')),
      'No_Ktp'              => $this->input->post('txtNoKTP'),
      'No_KK'               => $this->input->post('txtNoKK'),
      'Alamat_KTP'          => strtoupper($this->input->post('txtAlamatKTP')),
      'Alamat'              => strtoupper($this->input->post('txtAlamat')),
      'RT'                  => $this->input->post('txtRT'),
      'RW'                  => $this->input->post('txtRW'),
      'TinggalDengan'       => $this->input->post('txtTinggalDengan'),
      'HubunganDenganTK'    => $this->input->post('txtHubungan'),
      'NoHP'                => $this->input->post('txtNoPonsel'),
      'Daerah_Asal'         => strtoupper($this->input->post('txtDaerahAsal')),
      'PernahKerja'         => strtoupper($this->input->post('txtPernahRSUP')),
      'KerjaDi'             => strtoupper($this->input->post('txtBagian')),
      'Kriminal'            => $this->input->post('txtPernahKriminal'),
      'PerkaraApa'          => $perkaraapa,
      'JumlahAnak'          => $anak,
      'NamaSuamiIstri'      => str_replace("'", "`", strtoupper($this->input->post('txtNamaPasangan'))),
      'TglLahirSuamiIstri'  => $tglPasangan,
      'PekerjaanSuamiIstri' => strtoupper($this->input->post('txtPekerjaanPasangan')),
      'AlamatSuamiIstri'    => strtoupper($this->input->post('txtAlamatPasangan')),
      'NamaBapak'           => str_replace("'", "`", strtoupper($this->input->post('txtNamaBapak'))),
      'ProfesiOrangTua'     => strtoupper($this->input->post('txtPekerjaanOrtu')),
      'JumlahSaudara'       => $this->input->post('txtJumlahSaudara'),
      'AnakKe'              => $this->input->post('txtAnakKe'),
      'BahasaDaerah'        => strtoupper($this->input->post('txtBahasaDaerah')),
      'TahunMasuk'          => $this->input->post('txtTahunMasuk'),
      'TahunLulus'          => $this->input->post('txtTahunLulus'),
      'Hobby'               => strtoupper($this->input->post('txtHobby')),
      'KegiatanEkstra'      => $this->input->post('txtKegiatanEkstra'),
      'KegiatanOrganisasi'  => $this->input->post('txtOrgnanisasi'),
      'KeadaanFisik'        => $this->input->post('txtKeadaanFisik'),
      'CacatApa'            => $cacatapa,
      'PernahIdapPenyakit'  => $this->input->post('txtPernahPenyakit'),
      'PenyakitApa'         => $penyakitapa,
      'PengalamanKerja'     => $this->input->post('txtPengalamanKerja'),
      'Keahlian'            => $this->input->post('txtKeahlian'),
      'PernahKerjaDiSambu'  => $this->input->post('txtPernahRSUP'),
      'KerjadiBagian'       => strtoupper($this->input->post('txtBagian')),
      'Bertato'             => $this->input->post('txtBertato'),
      'TatoDimana'          => $tatoDimana,
      'Bertindik'           => $this->input->post('txtBertindik'),
      'SediaPotongRambut'   => $this->input->post('txtRambutPendek'),
      'Sediadiberhentikan'  => $this->input->post('txtBerhentikan'),
      'AccountFacebook'     => $this->input->post('txtFacebook'),
      'AccountTwitter'      => $this->input->post('txtTwitter'),
      'Account_email'       => $this->input->post('txtgmail'),
      'CreatedBy'           => strtoupper($this->session->userdata('username')),
      'CreatedDate'         => date('Y-m-d H:i:s'),
      'InputOnline'         => 1,
      'RegisteredBy'        => strtoupper($this->session->userdata('userid')),
      'RegisteredDate'      => date('Y-m-d H:i:s'),
      'ProvinsiID'          => $this->input->post('txtProvinsi'),
      'KabKotaID'           => $this->input->post('txtKabupaten'),
      'KecamatanID'         => $this->input->post('txtKecamatan'),
      'Kerabat_Nama'        => str_replace("'", "`", $this->input->post('txtkerabatterdekat')),
      'Kerabat_Telepon'     => $this->input->post('txtnohpkerabat'),
      'Kerabat_Hubungan'    => $this->input->post('txthubungan'),
      'Kerabat_Alamat'      => $this->input->post('txtAlamatKerabat'),
      'AhliWaris_Nama'      => str_replace("'", "`", $this->input->post('txtAhliWaris')),
      'AhliWaris_Jekel'     => $this->input->post('txtJekelAhliWaris'),
      'AhliWaris_Hubungan'  => $this->input->post('txtHubunganAhliWaris'),
      'AhliWaris_NoHP'      => $this->input->post('txtnohpkerabatAhliWaris'),
      'AhliWaris_Alamat'    => $this->input->post('txtAlamatAhliWaris'),
      'Kelurahan'           => strtoupper($this->input->post('txtKelurahan')),
      'Vaksin'              => $Vaksin,
      'JenisVaksin'         => $JenisVaksin,
      'TanggalVaksin'       => $TanggalVaksin,
      'TanggalVaksin2'      => $TanggalVaksin2,
      'TanggalVaksin3'      => $TanggalVaksin3,
    );

    $adaKeluarga = $this->input->post('txtAdaKeluarga');
    if ($adaKeluarga == 'YA') {
      $jumkel = count($this->input->post('kelnama'));
    } else {
      $jumkel = 0;
    }
    $kelnama      = $this->input->post('kelnama');
    $kelbagian    = $this->input->post('kelbagian');
    $kelpemborong = $this->input->post('kelpemborong');
    $kelhubungan  = $this->input->post('kelhubungan');
    $kelalamat    = $this->input->post('kelalamat');

    $annama         = $this->input->post('txtNamaAnak');
    $antempatlahir  = $this->input->post('txtTempatLahirAnak');
    $antgllahir     = $this->input->post('txtTanggalLahirAnak');
    $anjeniskelamin = $this->input->post('txtJekelAnak');
    $analamat       = $this->input->post('txtAlamatAnak');

    $pemborong = strtoupper($this->input->post('txtPemborong'));
    $tglLahir  = TRIM(date('Y-m-d', strtotime($this->input->post('txtTanggalLahir'))));
    // $namaIbu                          = strtoupper($this->input->post('txtNamaIbu'));
    $namaIbu = TRIM(preg_replace("/[^a-zA-Z]/", " ", $this->input->post('txtNamaIbu')));
    // $namaAyah                         = strtoupper($this->input->post('txtNamaBapak'));
    $namaAyah = TRIM(preg_replace("/[^a-zA-Z]/", " ", $this->input->post('txtNamaBapak')));


    // ====== KONFIRMASI
    if ($confirm == 0) {

      // 1. cek apakah user ada di list blacklist atau tidak
      // $cek_black_list1 = $this->m_register->cekTK1(array('Nama' => $namaTK, 'NamaIbuKandung' => $namaIbu));
      $cek_black_list = $this->m_register->cekTK($namaTK, $namaIbu);;

      // 2. cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
      $cekScreen = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);

      // 3.  cek Pernah Masih Aktif sebagai karyawan atau tidak
      $cekTKAktif = $this->m_register->cekRegAktif($namaTK, $tglLahir, $namaIbu, $namaAyah);

      // // 4.  cek masih dalam masa jeda (TanggalKeluarTemporary) 
      // $cekInTemp  = $this->m_register->cekRegInTemp($tglLahir, $namaIbu, $namaAyah);

      // 4.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang sama) 
      $cekRegInTempSamePemborong = $this->m_register->cekRegInTempSamePemborong($tglLahir, $namaIbu, $namaAyah, $pemborong);

      // 5.  cek masih dalam masa jeda (TanggalKeluarTemporary di pemborong yang berbeda) 
      $cekRegInTempDiffPemborong = $this->m_register->cekRegInTempDiffPemborong($tglLahir, $namaIbu, $namaAyah, $pemborong);

      // 6. cek apakah tk sudah pernah melamar di pemborong ini ?
      $cekTKPem = $this->m_register->cekRegTKPem($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);

      // 7. Cek TK apakah sudah pernah melamar di pemborong lain ?
      //!! TODO: query cek tk ke pemborong lain
      $cekTK = $this->m_register->cekRegTK($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);


      if ($cek_black_list) {
        redirect('registrasi/rejected_new/1/' . $namaTK);
      }

      if ($cekScreen) {
        redirect('registrasi/rejected_new/2/' . $namaTK);
      }

      if ($cekTKAktif) {
        redirect('registrasi/rejected_new/3/' . $namaTK);
      }
      if ($cekRegInTempSamePemborong) {
        redirect('registrasi/rejected_new/4/' . $namaTK);
      }
      if ($cekRegInTempDiffPemborong) {
        redirect('registrasi/rejected_new/5/' . $namaTK);
      }

      if ($cekTKPem) {
        redirect('registrasi/rejected_new/6/' . $namaTK);
      }

      if ($cekTK) {
        redirect('registrasi/rejected_new/7/' . $namaTK);
      }
      // // cek pernah melamar atau tidak di pemborong yang sama
      // $cekTK  = $this->m_register->cekRegTK($pemborong, $tglLahir, $namaIbu, $namaAyah);
      // // cek masih aktif atau tidak sebagai karyawan
      // $cekTKAktif = $this->m_register->cekRegAktif($tglLahir, $namaIbu, $namaAyah);
      // // cek pernar melamar atau tidak pemborong lainnya
      // $cekTKPem   = $this->m_register->cekRegTKPem($pemborong, $tglLahir, $namaIbu, $namaAyah);
      // // cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
      // $cekScreen   = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);
      // // cek masih dalam masa jeda (TanggalKeluarTemporary) 
      // $cekInTemp  = $this->m_register->cekRegInTemp($tglLahir, $namaIbu, $namaAyah);

      // if ($cekScreen == true) {
      //     $this->session->set_flashdata("namatk", $namaTK);
      //     redirect('registrasi/rejected/4');
      // } elseif ($cekTKAktif == true) {
      //     $this->session->set_flashdata("namatk", $namaTK);
      //     redirect('registrasi/rejected/2');
      // } elseif ($cekInTemp == true) {
      //     $this->session->set_flashdata("namatk", $namaTK);
      //     redirect('registrasi/rejected/3');
      // } elseif ($cekTK == true) {
      //     $this->session->set_flashdata("namatk", $namaTK);
      //     redirect('registrasi/rejected/1');
      // } 

      print_r("ok");
      exit();

      if ($cekTKPem == TRUE) {
        $hdridtemp = $this->m_register->simpanTKTemp($info);

        for ($i = 0; $i < $jumkel; $i++) {
          $infokel = array(
            'HeaderID'         => 0,
            'HeaderIDTemp'     => $hdridtemp,
            'Nama'             => str_replace("'", "`", strtoupper($kelnama[$i])),
            'Departemen'       => strtoupper($kelbagian[$i]),
            'Pemborong'        => strtoupper($kelpemborong[$i]),
            'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
            'Alamat'           => strtoupper($kelalamat[$i]),
          );
          if (!$kelnama[$i] == '') {
            $this->simpan_datakeluarga(0, $hdridtemp, $kelnama[$i], $infokel);
          }
        }

        for ($i = 0; $i < $anak; $i++) {
          if (is_array($annama) && array_key_exists($i, $annama)) {
            $infoanak = array(
              'HeaderID'     => 0,
              'HeaderIDTemp' => $hdridtemp,
              'Nama'         => str_replace("'", "`", strtoupper($annama[$i])),
              'TempatLahir'  => strtoupper($antempatlahir[$i]),
              'TglLahir'     => date('Y-m-d', strtotime($antgllahir[$i])),
              'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
              'Alamat'       => strtoupper($analamat[$i]),
              'CreatedBy'    => strtoupper($this->session->userdata('userid')),
              'CreatedDate'  => date('Y-m-d H:i:s'),
            );
            if (!$annama[$i] == '') {
              $this->simpan_dataanak(0, $hdridtemp, $annama[$i], $infoanak);
            }
          }
        }
        $this->session->set_flashdata('hdrIDTemp', $hdridtemp);
        redirect('registrasi/konfirmasi/' . $hdridtemp);
      } else {
        $this->load->model('m_register');
        $hdrID = $this->m_register->simpanTK($info);

        // === Cek Data Anak, Jika Ada Disimpan
        for ($i = 0; $i < $anak; $i++) {
          if (is_array($annama) && array_key_exists($i, $annama)) {
            $infoanak = array(
              'HeaderID'     => $hdrID,
              'HeaderIDTemp' => 0,
              'Nama'         => str_replace("'", "`", strtoupper($annama[$i])),
              'TempatLahir'  => strtoupper($antempatlahir[$i]),
              'TglLahir'     => date('Y-m-d', strtotime($antgllahir[$i])),
              'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
              'Alamat'       => strtoupper($analamat[$i]),
              'CreatedBy'    => strtoupper($this->session->userdata('userid')),
              'CreatedDate'  => date('Y-m-d H:i:s'),
            );
            if (!$annama[$i] == '') {
              $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
            }
          }
        }
        // === Cek Data Keluarga, Jika Ada Simpan
        for ($i = 0; $i < $jumkel; $i++) {
          $infokel = array(
            'HeaderID'         => $hdrID,
            'HeaderIDTemp'     => 0,
            'Nama'             => str_replace("'", "`", strtoupper($kelnama[$i])),
            'Departemen'       => strtoupper($kelbagian[$i]),
            'Pemborong'        => strtoupper($kelpemborong[$i]),
            'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
            'Alamat'           => strtoupper($kelalamat[$i]),
          );
          if (!$kelnama[$i] == '') {
            $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
          }
        }

        $this->load->model('m_upload_berkas');
        $berkas   = 'ktp';
        $url      = './dataupload/berkas/ktp';
        $namafile = $hdrID . '_' . $berkas . '.pdf';

        // Konfigurasi upload
        $config['upload_path']    = $url;
        $config['allowed_types']  = 'pdf';
        $config['allow_scale_up'] = TRUE;
        $config['overwrite']      = TRUE;
        $config['file_name']      = $namafile;
        $config['max_size']       = '5120';
        // print_r($this->input->post('txtPerusahaan'));
        // die;
        if ($this->input->post('txtPerusahaan') == 'PT PULAU SAMBU') {
          $dataBerkas = array(
            'HeaderID' => $hdrID,
            $berkas    => '',
          );
          $result     = $this->m_upload_berkas->insert_db_berkas($dataBerkas);
        } else {
          // Inisialisasi dan melakukan upload
          $this->load->library('upload', $config);
          if ($this->upload->do_upload('txtFileKTP')) {
            $uploadData = $this->upload->data();

            $relativePath = $url . '/' . $uploadData['file_name'];

            $dataBerkas = array(
              'HeaderID' => $hdrID,
              $berkas    => $relativePath,
            );
            $result     = $this->m_upload_berkas->insert_db_berkas($dataBerkas);

            if ($result === 0) {
              $data['errormsg'] = "<div class='alert alert-danger'>Gagal menyimpan data berkas. Berkas dengan HeaderID yang sama sudah ada.</div>";
            } else {
              $data['errormsg'] = "<div class='alert alert-success'>Berkas berhasil diunggah dan disimpan.</div>";
            }
          } else {
            $error            = $this->upload->display_errors();
            $data['errormsg'] = "<div class='alert alert-danger'>Gagal mengunggah berkas: $error</div>";
          }
        }

        $this->session->set_flashdata("regid", $hdrID);
        $this->session->set_flashdata("regnama", $namaTK);
        redirect('registrasi/uploadFoto');
      }
    } elseif ($confirm == 1) {
      $this->load->model('m_register');
      $hdrID     = $this->m_register->simpanTK($info);
      $hdridtemp = '';

      // === Cek Data Anak, Jika Ada Disimpan
      for ($i = 0; $i < $anak; $i++) {
        if (is_array($annama) && array_key_exists($i, $annama)) {
          $infoanak = array(
            'HeaderID'     => $hdrID,
            'HeaderIDTemp' => $hdridtemp,
            'Nama'         => str_replace("'", "`", strtoupper($annama[$i])),
            'TempatLahir'  => strtoupper($antempatlahir[$i]),
            'TglLahir'     => $antgllahir[$i],
            'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
            'Alamat'       => strtoupper($analamat[$i]),
            'CreatedBy'    => strtoupper($this->session->userdata('userid')),
            'CreatedDate'  => date('Y-m-d H:i:s'),
          );
          if (!$annama[$i] == '') {
            $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
          }
        }
      }
      // === Cek Data Keluarga, Jika Ada Simpan
      for ($i = 0; $i < $jumkel; $i++) {
        $infokel = array(
          'HeaderID'         => $hdrID,
          'HeaderIDTemp'     => $hdridtemp,
          'Nama'             => str_replace("'", "`", strtoupper($kelnama[$i])),
          'Departemen'       => strtoupper($kelbagian[$i]),
          'Pemborong'        => strtoupper($kelpemborong[$i]),
          'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
          'Alamat'           => strtoupper($kelalamat[$i]),
        );
        if (!$kelnama[$i] == '') {
          $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
        }
      }

      $this->load->model('m_upload_berkas');
      $berkas   = 'ktp';
      $url      = './dataupload/berkas/ktp';
      $namafile = $hdrID . '_' . $berkas . '.pdf';

      // Konfigurasi upload
      $config['upload_path']    = $url;
      $config['allowed_types']  = 'pdf';
      $config['allow_scale_up'] = TRUE;
      $config['overwrite']      = TRUE;
      $config['file_name']      = $namafile;
      $config['max_size']       = '5120';
      // print_r($this->input->post('txtPerusahaan'));
      // die;
      if ($this->input->post('txtPerusahaan') == 'PT PULAU SAMBU') {
        $dataBerkas = array(
          'HeaderID' => $hdrID,
          $berkas    => '',
        );
        $this->m_upload_berkas->insert_db_berkas($dataBerkas);
      } else {
        // Inisialisasi dan melakukan upload
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('txtFileKTP')) {
          $uploadData = $this->upload->data();

          $relativePath = $url . '/' . $uploadData['file_name'];

          $dataBerkas = array(
            'HeaderID' => $hdrID,
            $berkas    => $relativePath,
          );
          $result     = $this->m_upload_berkas->insert_db_berkas($dataBerkas);

          if ($result === 0) {
            $data['errormsg'] = "<div class='alert alert-danger'>Gagal menyimpan data berkas. Berkas dengan HeaderID yang sama sudah ada.</div>";
          } else {
            $data['errormsg'] = "<div class='alert alert-success'>Berkas berhasil diunggah dan disimpan.</div>";
          }
        } else {
          $error            = $this->upload->display_errors();
          $data['errormsg'] = "<div class='alert alert-danger'>Gagal mengunggah berkas: $error</div>";
        }
      }

      $this->session->set_flashdata("regid", $hdrID);
      $this->session->set_flashdata("regnama", $namaTK);

      $hdridtemp = $this->input->post('txtHeaderIDTemp');
      $this->m_register->update_datakeluarga_fromtemp($hdrID, $hdridtemp);
      $this->m_register->update_dataanak_fromtemp($hdrID, $hdridtemp);
      $this->m_register->update_headeridtemp_formtemp($hdrID, $hdridtemp);

      redirect('registrasi/uploadFoto');
    }
  }

  function simpanRegByPass()
  {
    $this->load->model('m_register');

    $this->_set_rules();
    if ($this->form_validation->run() == FALSE) {
      $data['message'] = '';
      $this->template->display('registrasi/register/index', $data);
    }

    $confirm = $this->input->post('txtConfirm'); // ===== deklarasi Confrim Text
    $namaTK  = LTRIM(strtoupper($this->input->post('txtNama'))); // ===== deklarasi Nama Pelama)r

    // ===== cek KeadaanFisik
    if ($this->input->post('txtKeadaanFisik') === 'CACAT' || $this->input->post('txtKeadaanFisik') === 'cacat') {
      $cacatapa = strtoupper($this->input->post('txtCacatApa'));
    } else {
      $cacatapa = 'TIDAK ADA';
    }
    // ===== cek Penyakit
    if ($this->input->post('txtPernahPenyakit') === 'YA') {
      $penyakitapa = strtoupper($this->input->post('txtPenyakit'));
    } else {
      $penyakitapa = 'TIDAK ADA';
    }
    // ===== cek Tato
    if ($this->input->post('txtBertato') === 'YA') {
      $tatoDimana = strtoupper($this->input->post('txtTatoDimana'));
    } else {
      $tatoDimana = 'TIDAK ADA';
    }
    // ===== cek Kriminal
    if ($this->input->post('txtPernahKriminal') === 'YA') {
      $perkaraapa = strtoupper($this->input->post('txtKriminal'));
    } else {
      $perkaraapa = 'TIDAK ADA';
    }
    // ===== cek Jumlah Anak
    if ($this->input->post('txtJumlahAnak') === '') {
      $jumlahanak = '';
    } else {
      $jumlahanak = $this->input->post('txtJumlahAnak');
    }
    // ===== cek Jurusan
    if ($this->input->post('txtJurusan') == '') {
      $jurusan = '-';
    } else {
      $jurusan = strtoupper($this->input->post('txtJurusan'));
    }

    $namaAnak  = str_replace("'", "`", $this->input->post('txtNamaAnak'));
    $itungAnak = $this->cekAnak($namaAnak);
    $jmlAnak   = $this->input->post('txtJumlahAnak');

    if ($jmlAnak == "") {
      if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
        $anak = 0;
      } elseif ($namaAnak == "") {
        $anak = 0;
      } elseif ($itungAnak > 0) {
        $anak = $itungAnak;
      } else {
        $anak = 0;
      }
    } elseif ($jmlAnak > 0) {
      if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
        $anak = 0;
      } elseif ($namaAnak == "") {
        $anak = 0;
      } else {
        $anak = $itungAnak;
      }
    } else {
      $anak = $itungAnak;
    }

    $pasangan = $this->input->post('txtNamaPasangan');
    if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS' || $pasangan == '') {
      $tglPasangan = NULL;
    } else {
      $tglPasangan = date('Y-m-d', strtotime($this->input->post('txtTglLahirPasangan')));
    }

    if ($this->input->post('txtShcool') == "") {
      $univ = $this->input->post('txtUniv');
    } else {
      $univ = $this->input->post('txtShcool');
    }

    if ($this->input->post('txtNilai') == "") {
      $ipk = $this->input->post('txtIPK');
    } else {
      $ipk = $this->input->post('txtNilai');
    }

    if (strtoupper($this->input->post('txtPendidikan')) == 'TIDAK SEKOLAH') {
      $pendidikan = "NaN";
    } else {
      $pendidikan = strtoupper($this->input->post('txtPendidikan'));
    }

    // ===== cek Vaksin
    $TanggalVaksin  = $this->input->post('txtTanggalVaksin');
    $TanggalVaksin2 = $this->input->post('txtTanggalVaksin2');
    $TanggalVaksin3 = $this->input->post('txtTanggalVaksin3');
    if ($this->input->post('txtVaksin') === 'SUDAH') {
      $Vaksin      = $this->input->post('txtVaksin');
      $JenisVaksin = strtoupper($this->input->post('txtJenisVaksin'));
      if ($TanggalVaksin != '') {
        $TanggalVaksin = date('Y-m-d', strtotime($TanggalVaksin));
      } else {
        $TanggalVaksin = NULL;
      }
      if ($TanggalVaksin2 != '') {
        $TanggalVaksin2 = date('Y-m-d', strtotime($TanggalVaksin2));
      } else {
        $TanggalVaksin2 = NULL;
      }
      if ($TanggalVaksin3 != '') {
        $TanggalVaksin3 = date('Y-m-d', strtotime($TanggalVaksin3));
      } else {
        $TanggalVaksin3 = NULL;
      }
    } else {
      $Vaksin         = 'BELUM';
      $JenisVaksin    = 'TIDAK ADA';
      $TanggalVaksin  = NULL;
      $TanggalVaksin2 = NULL;
      $TanggalVaksin3 = NULL;
    }

    $agamaValue            = $this->input->post('txtAgama');
    list($IDAgama, $Agama) = explode(',', $agamaValue);

    $info = array(
      'CVNama'              => $this->input->post('txtPerusahaan'),
      'Pemborong'           => $this->input->post('txtPemborong'),
      // 'SubPemborong'        => $this->input->post('txtSubPemborong'),
      'Nama'                => str_replace("'", "`", LTRIM(strtoupper($this->input->post('txtNama')))),
      'Tgl_Lahir'           => date('Y-m-d', strtotime($this->input->post('txtTanggalLahir'))),
      'Tempat_Lahir'        => strtoupper($this->input->post('txtTempatLahir')),
      'NamaIbuKandung'      => str_replace("'", "`", strtoupper($this->input->post('txtNamaIbu'))),
      'BeratBadan'          => $this->input->post('txtBeratBadan'),
      'TinggiBadan'         => $this->input->post('txtTinggiBadan'),
      'IDAgama'             => $IDAgama,
      'Agama'               => $Agama,
      // 'Agama'               => strtoupper($this->input->post('txtAgama')),
      'Suku'                => strtoupper($this->input->post('txtSuku')),
      'Jenis_Kelamin'       => strtoupper($this->input->post('txtJekel')),
      'Pendidikan'          => $pendidikan,
      'Jurusan'             => $jurusan,
      'Universitas'         => $univ,
      'IPK'                 => $ipk,
      'Status_Personal'     => strtoupper($this->input->post('txtStatus')),
      'No_Ktp'              => $this->input->post('txtNoKTP'),
      'No_KK'               => $this->input->post('txtNoKK'),
      'Alamat_KTP'          => strtoupper($this->input->post('txtAlamatKTP')),
      'Alamat'              => strtoupper($this->input->post('txtAlamat')),
      'RT'                  => $this->input->post('txtRT'),
      'RW'                  => $this->input->post('txtRW'),
      'Kelurahan'           => strtoupper($this->input->post('txtKelurahan')),
      'TinggalDengan'       => $this->input->post('txtTinggalDengan'),
      'HubunganDenganTK'    => $this->input->post('txtHubungan'),
      'NoHP'                => $this->input->post('txtNoPonsel'),
      'Daerah_Asal'         => strtoupper($this->input->post('txtDaerahAsal')),
      'PernahKerja'         => strtoupper($this->input->post('txtPernahRSUP')),
      'KerjaDi'             => strtoupper($this->input->post('txtBagian')),
      'Kriminal'            => $this->input->post('txtPernahKriminal'),
      'PerkaraApa'          => $perkaraapa,
      'JumlahAnak'          => $anak,
      'NamaSuamiIstri'      => str_replace("'", "`", strtoupper($this->input->post('txtNamaPasangan'))),
      'TglLahirSuamiIstri'  => $tglPasangan,
      'PekerjaanSuamiIstri' => strtoupper($this->input->post('txtPekerjaanPasangan')),
      'AlamatSuamiIstri'    => strtoupper($this->input->post('txtAlamatPasangan')),
      'NamaBapak'           => str_replace("'", "`", strtoupper($this->input->post('txtNamaBapak'))),
      'ProfesiOrangTua'     => strtoupper($this->input->post('txtPekerjaanOrtu')),
      'JumlahSaudara'       => $this->input->post('txtJumlahSaudara'),
      'AnakKe'              => $this->input->post('txtAnakKe'),
      'BahasaDaerah'        => strtoupper($this->input->post('txtBahasaDaerah')),
      'TahunMasuk'          => $this->input->post('txtTahunMasuk'),
      'TahunLulus'          => $this->input->post('txtTahunLulus'),
      'Hobby'               => strtoupper($this->input->post('txtHobby')),
      'KegiatanEkstra'      => $this->input->post('txtKegiatanEkstra'),
      'KegiatanOrganisasi'  => $this->input->post('txtOrgnanisasi'),
      'KeadaanFisik'        => $this->input->post('txtKeadaanFisik'),
      'CacatApa'            => $cacatapa,
      'PernahIdapPenyakit'  => $this->input->post('txtPernahPenyakit'),
      'PenyakitApa'         => $penyakitapa,
      'PengalamanKerja'     => $this->input->post('txtPengalamanKerja'),
      'Keahlian'            => $this->input->post('txtKeahlian'),
      'PernahKerjaDiSambu'  => $this->input->post('txtPernahRSUP'),
      'KerjadiBagian'       => strtoupper($this->input->post('txtBagian')),
      'Bertato'             => $this->input->post('txtBertato'),
      'TatoDimana'          => $tatoDimana,
      'Bertindik'           => $this->input->post('txtBertindik'),
      'SediaPotongRambut'   => $this->input->post('txtRambutPendek'),
      'Sediadiberhentikan'  => $this->input->post('txtBerhentikan'),
      'AccountFacebook'     => $this->input->post('txtFacebook'),
      'AccountTwitter'      => $this->input->post('txtTwitter'),
      'Account_email'       => $this->input->post('txtgmail'),
      'CreatedBy'           => strtoupper($this->session->userdata('username')),
      'CreatedDate'         => date('Y-m-d H:i:s'),
      'InputOnline'         => 1,
      'RegisteredBy'        => strtoupper($this->session->userdata('userid')),
      'RegisteredDate'      => date('Y-m-d H:i:s'),
      'ProvinsiID'          => $this->input->post('txtProvinsi'),
      'KabKotaID'           => $this->input->post('txtKabupaten'),
      'KecamatanID'         => $this->input->post('txtKecamatan'),
      'Kerabat_Nama'        => $this->input->post('txtkerabatterdekat'),
      'Kerabat_Telepon'     => $this->input->post('txtnohpkerabat'),
      'Kerabat_Hubungan'    => $this->input->post('txthubungan'),
      'AhliWaris_Nama'      => $this->input->post('txtAhliWaris'),
      'AhliWaris_Jekel'     => $this->input->post('txtJekelAhliWaris'),
      'AhliWaris_Hubungan'  => $this->input->post('txtHubunganAhliWaris'),
      'AhliWaris_NoHP'      => $this->input->post('txtnohpkerabatAhliWaris'),
      'AhliWaris_Alamat'    => $this->input->post('txtAlamatAhliWaris'),
      'Vaksin'              => $Vaksin,
      'JenisVaksin'         => $JenisVaksin,
      'TanggalVaksin'       => $TanggalVaksin,
      'TanggalVaksin2'      => $TanggalVaksin2,
      'TanggalVaksin3'      => $TanggalVaksin3,
    );

    $adaKeluarga = $this->input->post('txtAdaKeluarga');
    if ($adaKeluarga == 'YA') {
      $jumkel = count($this->input->post('kelnama'));
    } else {
      $jumkel = 0;
    }
    $kelnama      = $this->input->post('kelnama');
    $kelbagian    = $this->input->post('kelbagian');
    $kelpemborong = $this->input->post('kelpemborong');
    $kelhubungan  = $this->input->post('kelhubungan');
    $kelalamat    = $this->input->post('kelalamat');

    $annama         = $this->input->post('txtNamaAnak');
    $antempatlahir  = $this->input->post('txtTempatLahirAnak');
    $antgllahir     = $this->input->post('txtTanggalLahirAnak');
    $anjeniskelamin = $this->input->post('txtJekelAnak');
    $analamat       = $this->input->post('txtAlamatAnak');

    $pemborong = strtoupper($this->input->post('txtPemborong'));
    $tglLahir  = date('Y-m-d', strtotime($this->input->post('txtTanggalLahir')));
    $namaIbu   = strtoupper($this->input->post('txtNamaIbu'));
    $namaAyah  = strtoupper($this->input->post('txtNamaBapak'));


    // ====== KONFIRMASI
    if ($confirm == 0) {
      $cekTK      = $this->m_register->cekRegTK($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);
      $cekTKAktif = $this->m_register->cekRegAktif($namaTK, $tglLahir, $namaIbu, $namaAyah);
      $cekTKPem   = $this->m_register->cekRegTKPem($namaTK, $pemborong, $tglLahir, $namaIbu, $namaAyah);
      $cekScreen  = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);
      $cekInTemp  = $this->m_register->cekRegInTemp($tglLahir, $namaIbu, $namaAyah);

      if ($cekScreen == TRUE) {
        $this->session->set_flashdata("namatk", $namaTK);
        redirect('registrasi/rejected/4');
      }
      /*elseif ($cekTKAktif == true){
                $this->session->set_flashdata("namatk",$namaTK);
                redirect('registrasi/rejected/2');

            }elseif($cekInTemp == true){
                $this->session->set_flashdata("namatk",$namaTK);
                redirect('registrasi/rejected/3');

            }
            elseif ($cekTK == true) {
                $this->session->set_flashdata("namatk",$namaTK);
                redirect('registrasi/rejected/1');
            }*/ elseif ($cekTKPem == TRUE) {
        $hdridtemp = $this->m_register->simpanTKTemp($info);

        for ($i = 0; $i < $jumkel; $i++) {
          $infokel = array(
            'HeaderID'         => 0,
            'HeaderIDTemp'     => $hdridtemp,
            'Nama'             => strtoupper($kelnama[$i]),
            'Departemen'       => strtoupper($kelbagian[$i]),
            'Pemborong'        => strtoupper($kelpemborong[$i]),
            'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
            'Alamat'           => strtoupper($kelalamat[$i]),
          );
          if (!$kelnama[$i] == '') {
            $this->simpan_datakeluarga(0, $hdridtemp, $kelnama[$i], $infokel);
          }
        }

        for ($i = 0; $i < $anak; $i++) {
          if (is_array($annama) && array_key_exists($i, $annama)) {
            $infoanak = array(
              'HeaderID'     => 0,
              'HeaderIDTemp' => $hdridtemp,
              'Nama'         => strtoupper($annama[$i]),
              'TempatLahir'  => strtoupper($antempatlahir[$i]),
              'TglLahir'     => date('Y-m-d', strtotime($antgllahir[$i])),
              'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
              'Alamat'       => strtoupper($analamat[$i]),
              'CreatedBy'    => strtoupper($this->session->userdata('userid')),
              'CreatedDate'  => date('Y-m-d H:i:s'),
            );
            if (!$annama[$i] == '') {
              $this->simpan_dataanak(0, $hdridtemp, $annama[$i], $infoanak);
            }
          }
        }
        $this->session->set_flashdata('hdrIDTemp', $hdridtemp);
        redirect('registrasi/konfirmasi/' . $hdridtemp);
      } else {
        $this->load->model('m_register');
        $hdrID = $this->m_register->simpanTK($info);

        // === Cek Data Anak, Jika Ada Disimpan
        for ($i = 0; $i < $anak; $i++) {
          if (is_array($annama) && array_key_exists($i, $annama)) {
            $infoanak = array(
              'HeaderID'     => $hdrID,
              'HeaderIDTemp' => 0,
              'Nama'         => strtoupper($annama[$i]),
              'TempatLahir'  => strtoupper($antempatlahir[$i]),
              'TglLahir'     => date('Y-m-d', strtotime($antgllahir[$i])),
              'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
              'Alamat'       => strtoupper($analamat[$i]),
              'CreatedBy'    => strtoupper($this->session->userdata('userid')),
              'CreatedDate'  => date('Y-m-d H:i:s'),
            );
            if (!$annama[$i] == '') {
              $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
            }
          }
        }
        // === Cek Data Keluarga, Jika Ada Simpan
        for ($i = 0; $i < $jumkel; $i++) {
          $infokel = array(
            'HeaderID'         => $hdrID,
            'HeaderIDTemp'     => 0,
            'Nama'             => strtoupper($kelnama[$i]),
            'Departemen'       => strtoupper($kelbagian[$i]),
            'Pemborong'        => strtoupper($kelpemborong[$i]),
            'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
            'Alamat'           => strtoupper($kelalamat[$i]),
          );
          if (!$kelnama[$i] == '') {
            $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
          }
        }

        $this->session->set_flashdata("regid", $hdrID);
        $this->session->set_flashdata("regnama", $namaTK);
        $this->load->model('m_upload_berkas');
        $berkas     = 'ktp';
        $dataBerkas = array(
          'HeaderID' => $hdrID,
          $berkas    => '',
        );
        $this->m_upload_berkas->insert_db_berkas($dataBerkas);
        // $this->m_upload_berkas->insert_db_berkas($hdrID);

        redirect('registrasi/uploadFoto');
      }
    } elseif ($confirm == 1) {
      $this->load->model('m_register');
      $hdrID     = $this->m_register->simpanTK($info);
      $hdridtemp = '';

      // === Cek Data Anak, Jika Ada Disimpan
      for ($i = 0; $i < $anak; $i++) {
        if (is_array($annama) && array_key_exists($i, $annama)) {
          $infoanak = array(
            'HeaderID'     => $hdrID,
            'HeaderIDTemp' => $hdridtemp,
            'Nama'         => strtoupper($annama[$i]),
            'TempatLahir'  => strtoupper($antempatlahir[$i]),
            'TglLahir'     => $antgllahir[$i],
            'JenisKelamin' => strtoupper($anjeniskelamin[$i]),
            'Alamat'       => strtoupper($analamat[$i]),
            'CreatedBy'    => strtoupper($this->session->userdata('userid')),
            'CreatedDate'  => date('Y-m-d H:i:s'),
          );
          if (!$annama[$i] == '') {
            $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
          }
        }
      }
      // === Cek Data Keluarga, Jika Ada Simpan
      for ($i = 0; $i < $jumkel; $i++) {
        $infokel = array(
          'HeaderID'         => $hdrID,
          'HeaderIDTemp'     => $hdridtemp,
          'Nama'             => strtoupper($kelnama[$i]),
          'Departemen'       => strtoupper($kelbagian[$i]),
          'Pemborong'        => strtoupper($kelpemborong[$i]),
          'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
          'Alamat'           => strtoupper($kelalamat[$i]),
        );
        if (!$kelnama[$i] == '') {
          $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
        }
      }


      $this->session->set_flashdata("regid", $hdrID);
      $this->session->set_flashdata("regnama", $namaTK);

      $this->load->model('m_upload_berkas');
      $berkas     = 'ktp';
      $dataBerkas = array(
        'HeaderID' => $hdrID,
        $berkas    => '',
      );
      $this->m_upload_berkas->insert_db_berkas($dataBerkas);
      // $this->m_upload_berkas->insert_db_berkas($hdrID);

      $hdridtemp = $this->input->post('txtHeaderIDTemp');
      $this->m_register->update_datakeluarga_fromtemp($hdrID, $hdridtemp);
      $this->m_register->update_dataanak_fromtemp($hdrID, $hdridtemp);
      $this->m_register->update_headeridtemp_formtemp($hdrID, $hdridtemp);

      redirect('registrasi/uploadFoto');
    }
  }

  function rejected()
  {
    $msg = $this->uri->segment(3);
    if ($msg == 1) {
      $data['pesan'] = 'anotherPemborong';
    } elseif ($msg == 2) {
      $data['pesan'] = 'karyawanAktif';
    } elseif ($msg == 3) {
      $data['pesan'] = 'calonInTemp';
    } elseif ($msg == 4) {
      $data['pesan'] = 'calonGagalScreen';
    }

    $data['namatk'] = $this->session->flashdata("namatk");
    $this->session->keep_flashdata("namatk");

    $this->template->display("registrasi/register/tolak", $data);
  }

  function konfirmasi($hdridtemp)
  {
    $this->load->model('m_register');
    $hdridtemp = $this->session->flashdata('hdrIDTemp');
    $this->session->keep_flashdata("hdrIDTemp");
    $datatk_temp           = $this->m_register->get_datatk_temp($hdridtemp)->result();
    $agamaValue            = $this->input->post('txtAgama');
    list($IDAgama, $Agama) = explode(',', $agamaValue);
    foreach ($datatk_temp as $row) :
      $arrhidden = array(
        'txtConfirm'           => "1",
        'txtHeaderIDTemp'      => $row->HeaderIDTemporary,
        'txtPerusahaan'        => $row->CVNama,
        'txtPemborong'         => $row->Pemborong,
        'txtSubPemborong'      => $row->SubPemborong,
        'txtNama'              => $row->Nama,
        'txtTanggalLahir'      => $row->Tgl_Lahir,
        'txtTempatLahir'       => $row->Tempat_Lahir,
        'txtNamaIbu'           => $row->NamaIbuKandung,
        'txtBeratBadan'        => $row->BeratBadan,
        'txtTinggiBadan'       => $row->TinggiBadan,
        $Agama                 => $row->Agama,
        'txtSuku'              => $row->Suku,
        'txtJekel'             => $row->Jenis_Kelamin,
        'txtPendidikan'        => $row->Pendidikan,
        'txtJurusan'           => $row->Jurusan,
        'txtStatus'            => $row->Status_Personal,
        'txtNoKTP'             => $row->No_Ktp,
        'txtNoKK'              => $row->No_KK,
        'txtAlamat'            => $row->Alamat,
        'txtRT'                => $row->RT,
        'txtRW'                => $row->RW,
        'txtKelurahan'         => $row->Kelurahan,
        'txtTinggalDengan'     => $row->TinggalDengan,
        'txtHubungan'          => $row->HubunganDenganTK,
        'txtNoPonsel'          => $row->NoHP,
        'txtDaerahAsal'        => $row->Daerah_Asal,
        'txtPernahRSUP'        => $row->PernahKerja,
        'txtBagian'            => $row->KerjaDi,
        'txtPernahKriminal'    => $row->Kriminal,
        'txtKriminal'          => $row->PerkaraApa,
        'txtJumlahAnak'        => $row->JumlahAnak,
        'txtNamaPasangan'      => $row->NamaSuamiIstri,
        'txtTglLahirPasangan'  => $row->TglLahirSuamiIstri,
        'txtPekerjaanPasangan' => $row->PekerjaanSuamiIstri,
        'txtAlamatPasangan'    => $row->AlamatSuamiIstri,
        'txtNamaBapak'         => $row->NamaBapak,
        'txtPekerjaanOrtu'     => $row->ProfesiOrangTua,
        'txtJumlahSaudara'     => $row->JumlahSaudara,
        'txtAnakKe'            => $row->AnakKe,
        'txtBahasaDaerah'      => $row->BahasaDaerah,
        'txtTahunMasuk'        => $row->TahunMasuk,
        'txtTahunLulus'        => $row->TahunLulus,
        'txtHobby'             => $row->Hobby,
        'txtKegiatanEkstra'    => $row->KegiatanEkstra,
        'txtOrgnanisasi'       => $row->KegiatanOrganisasi,
        'txtKeadaanFisik'      => $row->KeadaanFisik,
        'txtCacatApa'          => $row->CacatApa,
        'txtPernahPenyakit'    => $row->PernahIdapPenyakit,
        'txtPenyakit'          => $row->PenyakitApa,
        'txtPengalamanKerja'   => $row->PengalamanKerja,
        'txtKeahlian'          => $row->Keahlian,
        'txtPernahRSUP'        => $row->PernahKerjaDiSambu,
        'txtBagian'            => $row->KerjadiBagian,
        'txtBertato'           => $row->Bertato,
        'txtTatoDimana'        => $row->TatoDimana,
        'txtBertindik'         => $row->Bertindik,
        'txtRambutPendek'      => $row->SediaPotongRambut,
        'txtBerhentikan'       => $row->Sediadiberhentikan,
        'txtFacebook'          => $row->AccountFacebook,
        'txtTwitter'           => $row->AccountTwitter,
        'txtgmail'             => $row->Account_email,
      );

      $namaIBU  = strtoupper($row->NamaIbuKandung);
      $tglLahir = $row->Tgl_Lahir;
      $namaTK   = $row->Nama;
    endforeach;

    $data['title']     = "Register Tenaga Kerja Baru";
    $data['hdridtemp'] = $hdridtemp;
    $data['arrhidden'] = $arrhidden;

    $data['datapelamar'] = $this->m_register->pernahReg($tglLahir, $namaIBU)->result();
    $data['nama']        = $namaTK;
    $this->template->display('registrasi/register/konfirmasi', $data);
  }

  function confrimCancel($hdrtempid)
  {
    $this->load->model('m_register');
    $this->m_register->hapusTKTemp($hdrtempid);
    redirect('registrasi');
  }

  function simpan_datakeluarga($hdrID, $hdridtemp, $kelnama, $infokel)
  {
    $detailid = $this->m_register->cek_datakeluarga($hdrID, $hdridtemp, $kelnama);

    if ($detailid == 0) {
      $this->m_register->simpan_datakeluarga($infokel);
    } else {
      $this->m_register->update_datakeluarga($detailid, $infokel);
    }
  }

  function simpan_dataanak($hdrID, $hdridtemp, $anaknama, $infoanak)
  {
    $detailid = $this->m_register->cek_dataanak($hdrID, $hdridtemp, $anaknama);

    if ($detailid == 0) {
      $this->m_register->simpan_dataanak($infoanak);
    } else {
      $this->m_register->update_dataanak($detailid, $infoanak);
    }
  }

  function uploadFoto()
  {
    //$this->load->model('m_registrasi');
    $hdrID = $this->session->flashdata("regid");
    $nama  = $this->session->flashdata("regnama");

    $this->session->keep_flashdata("regid");
    $this->session->keep_flashdata("regnama");
    $data['hdrid']       = $hdrID;
    $data['namapelamar'] = $nama;
    $data['errormsg']    = "";

    $this->template->display('registrasi/register/upload_foto', $data);
  }

  function uploadAksi()
  {
    $this->load->model('m_register');
    $this->load->library('image_moo');

    $url         = './dataupload/foto/';
    $hdrID       = $this->input->post("txtHeaderID");
    $namapelamar = $this->input->post("txtNamaPelamar");
    $filefoto    = $hdrID;

    $config['upload_path']    = $url;
    $config['allowed_types']  = 'jpeg|jpg|png|gif';
    $config['allow_scale_up'] = TRUE;
    $config['overwrite']      = TRUE;
    $config['max_size']       = '0';
    $config['file_name']      = $filefoto . '.jpg';    //Filename harus pakai headerID pelamar

    $font        = "./assets/DroidSans.ttf";
    $watermarkbg = "./assets/watermarkbg.png";

    $this->load->library('upload');
    $this->upload->initialize($config);

    if ($this->upload->do_upload('fileFoto1') == "") {
      $file = $this->upload->do_upload('fileFoto2');
    } else {
      $file = $this->upload->do_upload('fileFoto1');
    }
    if ($file) {
      $files          = $this->upload->data();
      $fileNameResize = $config['upload_path'] . $files['file_name'];


      # $this->image_moo
      #     ->load($fileNameResize)
      #     ->resize(300,300)
      #     ->round(10)
      #     ->load_watermark($watermarkbg,0,0)
      #     ->watermark(2,-1)
      #     ->make_watermark_text("REQ.".$filefoto,$font,14,"#FFFF00")
      #     ->watermark(2)
      #     ->save($fileNameResize,true)
      #     ;

      $this->image_moo
        ->load($fileNameResize)
        ->resize(480, 480)
        ->round(10)
        ->save($fileNameResize, TRUE);

      if ($this->image_moo->errors) {
        $error               = $files['file_name'] . "<br/>" . $this->image_moo->display_errors();
        $data['errormsg']    = "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Image Moo Failed</strong><br/>$error</div>";
        $data['hdrid']       = $hdrID;
        $data['namapelamar'] = $namapelamar;

        $this->template->display('registrasi/register/upload_foto', $data);
      } else {
        $this->m_register->update_status_foto($hdrID);
        $this->image_moo->clear();
        $this->session->set_flashdata("regid", $hdrID);
        $this->session->set_flashdata("regnama", $namapelamar);

        //                redirect("registrasi/uploadFoto/success");
        //jika success, redirect ke Upload berkas
        redirect("UploadBerkas/index");
      }
    } else {
      $error               = $this->upload->display_errors();
      $data['errormsg']    = "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Unggah Foto Gagal</strong><br/>$error</div>";
      $data['hdrid']       = $hdrID;
      $data['namapelamar'] = $namapelamar;

      $this->template->display('registrasi/register/upload_foto', $data);
    }

    $this->image_moo->clear();
  }

  function upload_berkas()
  {
  }

  function screening($screeningby)
  {
    if ($screeningby === 'psn') {
      $this->template->display('registrasi/screening/psn');
    } else {
      $this->template->display('registrasi/screening/tim');
    }
  }

  function tujuan_wawancara()
  {
    $this->template->display('registrasi/tujuan_wawancara/index');
  }

  function proses_wawancara()
  {
    $this->template->display('registrasi/proses_wawancara/index');
  }

  function posting_tk()
  {
  }

  function _set_rules()
  {
    $this->form_validation->set_rules('txtPemborong', 'Nama Pemborong', 'required|max_length[50]');
    $this->form_validation->set_rules('txtSubPemborong', 'Nama Sub Pemborong', 'required|max_length[50]');
    $this->form_validation->set_rules('txtPerusahaan', 'Perusahaan', 'required|max_length[50]');
    $this->form_validation->set_rules('txtNama', 'Nama', 'required|max_length[50]');
    $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>", "</div>");
  }

  function getkabupaten()
  {
    $this->load->model('m_register');
    $prov = $this->input->get('idprov');
    $data = $this->m_register->getKabupaten($prov);
    echo json_encode(array('data' => $data->result_array(), 'err' => 0));
  }

  function getkecamatan()
  {
    $this->load->model('m_register');
    $prov = $this->input->get('idprov');
    $kab  = $this->input->get('idkab');
    $data = $this->m_register->getkecamatan($prov, $kab);
    echo json_encode(array('data' => $data->result_array(), 'err' => 0));
  }

  function getDept()
  {
    $this->load->model('m_register');
    $div  = $this->input->get('iddiv');
    $data = $this->m_register->getDept1($div);
    echo json_encode(array('data' => $data->result_array(), 'err' => 0));
  }

  function calonkandidat()
  {
    $this->load->model('m_register');
    $data['_getDept']       = $this->m_register->getDept();
    $data['_getDiv']        = $this->m_register->getDept();
    $data['_getPendidikan'] = $this->m_register->getPendidikan();
    $data['_getJurusan']    = $this->m_register->getJurusan();
    $data['_addjs']         = array('plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.js');
    $this->template->display('registrasi/calon_kandidat/index', $data);
  }

  function simpanCK()
  {
    $nama          = TRIM(strtoupper($this->input->post('txtNama')));
    $jk            = $this->input->post('selJK');
    $tmplahir      = strtoupper($this->input->post('txtTempatL'));
    $tgllahir      = date('Y-m-d', strtotime($this->input->post('txtTglL')));
    $noktp         = $this->input->post('txtNo_Ktp');
    $nohp          = $this->input->post('txtNoHP');
    $email         = $this->input->post('txtEmail');
    $pendidikan    = $this->input->post('selPendidikan');
    $jurusan       = $this->input->post('selJurusan');
    $jadwaltest    = $this->input->post('txtJadwal');
    $keterangan    = $this->input->post('txtKeterangan');
    $status        = $this->input->post('selSts');
    $ststest       = $this->input->post('selStsT');
    $transport     = $this->input->post('selTransport');
    $biaya         = $this->input->post('txtBiaya');
    $sumberpelamar = $this->input->post('txtSumberPelamar');
    $posisi        = $this->input->post('txtPosisi');
    $level         = $this->input->post('txtLevel');
    $dept          = $this->input->post('selDept');
    $divisi        = $this->input->post('selDivisi');
    $creteby       = strtoupper($this->session->userdata('username'));
    $cretedate     = date('Y-m-d H:i:s');

    $data   = array(
      'Nama'          => $nama,
      'JK'            => $jk,
      'Tempat_Lhr'    => $tmplahir,
      'Tanggal_Lhr'   => $tgllahir,
      'NoKTP'         => $noktp,
      'NoHP'          => $nohp,
      'Email'         => $email,
      'Pendidikan'    => $pendidikan,
      'Jurusan'       => $jurusan,
      'JadwalTest'    => $jadwaltest,
      'Keterangan'    => $keterangan,
      'Status'        => $status,
      'StsTest'       => $ststest,
      'Transport'     => $transport,
      'Biaya'         => $biaya,
      'SumberPelamar' => $sumberpelamar,
      'Posisi'        => $posisi,
      'Level'         => $level,
      'Dept'          => $dept,
      'Divisi'        => $divisi,
      'CreatedBy'     => $creteby,
      'CreatedDate'   => $cretedate,
    );
    $header = $this->m_register->saveCK($data);
    if ($header['status'] == FALSE) {
      $this->session->set_flashdata('_message', $header['data']);
      redirect(base_url('Registrasi/calonkandidat?err=header'));
      return;
    }
    $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
    redirect(base_url('Registrasi/calonkandidat?success=ok'));
  }



  function editDataCK()
  {
    if ('IS_AJAX') {
      $kode = $this->input->post('kode');
      $this->load->model('m_register');
      $data['_getDept']       = $this->m_register->getDept();
      $data['_getDiv']        = $this->m_register->getDept();
      $data['_getPendidikan'] = $this->m_register->getPendidikan();
      $data['_getJurusan']    = $this->m_register->getJurusan();
      $data['_addjs']         = array('plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.js');
      $data['data']           = $this->m_register->getDataCK($kode)->result();
      $this->load->view('registrasi/calon_kandidat/edit', $data);
    }
  }

  function updateDataCK()
  {
    $data  = array(
      'Nama'          => LTRIM(strtoupper($this->input->post('txtNama'))),
      'JK'            => $this->input->post('selJK'),
      'Tempat_Lhr'    => strtoupper($this->input->post('txtTempatL')),
      'Tanggal_Lhr'   => date('Y-m-d', strtotime($this->input->post('txtTglL'))),
      'NoKTP'         => $this->input->post('txtNo_Ktp'),
      'NoHP'          => $this->input->post('txtNoHP'),
      'Email'         => $this->input->post('txtEmail'),
      'Pendidikan'    => $this->input->post('selPendidikan'),
      'Jurusan'       => $this->input->post('selJurusan'),
      'JadwalTest'    => $this->input->post('txtJadwal'),
      'Keterangan'    => $this->input->post('txtKeterangan'),
      'Status'        => $this->input->post('selSts'),
      'StsTest'       => $this->input->post('selStsT'),
      'Transport'     => $this->input->post('selTransport'),
      'Biaya'         => $this->input->post('txtBiaya'),
      'Posisi'        => $this->input->post('txtPosisi'),
      'Level'         => $this->input->post('txtLevel'),
      'Dept'          => $this->input->post('selDept'),
      'Divisi'        => $this->input->post('selDivisi'),
      'SumberPelamar' => $this->input->post('txtSumberPelamar'),
      'Keterangan'    => $this->input->post('txtKeterangan'),
      'UpdatedBy'     => strtoupper($this->session->userdata('username')),
      'UpdatedDate'   => date('Y-m-d H:i:s'),
    );
    $id_ck = array('id' => $this->input->get('id'));
    $this->load->model('m_register');
    $header = $this->m_register->updateCK($id_ck, $data);

    if ($header) {
      redirect('Monitor/calonkandidat?msg=success_edit');
    } else {
      redirect('Monitor/calonkandidat?msg=failed_edit');
    }
  }

  function cekTK()
  {
    $nama  = TRIM(preg_replace('/\s\s+/', ' ', $this->input->post('nama')));
    $nama1 = TRIM(preg_replace('/[^a-zA-Z]/', ' ', $nama)); // Nama sudah clean dari karakter selain alphabet
    $ibu   = TRIM($this->input->post('ibu'));
    // $cekNama = $this->m_register->cekNama($nama1);

    // $where    = array('Nama' => $nama, 'NamaIbuKandung' => $ibu);
    // $data     = $this->m_register->cekTK($where);
    $data = $this->m_register->cekTK($nama1, $ibu);

    $response = '';
    foreach ($data as $key) {
      $response .= '<tr>
                            <th >#</th>
                            <th >' . $key->Nama . '</th> 
                            <th>' . $key->TglKeluar . '</th>
                          </tr>';
    }
    echo $response;
  }

  public function show_main()
  {
    // access_check();
    if ($this->input->is_ajax_request()) {
      $list = $this->m_register->get_datatables('vwListTenakerForPemborong');
      $data = array();
      $no   = $_POST['start'];
      foreach ($list as $field) {

        $checkBox = '<div class="checkbox">
                        <label class="pos-rel">
                            <input name="chkPosting[]" id="chkPosting" class="chkPosting" type="checkbox" value="' . $field->HeaderID . '">
                            <span class="lbl"></span>
                        </label>
                    </div>';

        if ($field->Pemborong == 'YAO HSING') {
          $Pemborong = $field->Pemborong;
          $Pemborong .= '<input name="txtTipe[]" type="hidden" value="1" readonly="">';
        } else {
          $Pemborong = $field->Pemborong;
          $Pemborong .= '<input name="txtTipe[]" type="hidden" value="0" readonly="">';
        }
        if ($field->Jenis_Kelamin == 'M' || $field->Jenis_Kelamin == 'LAKI-LAKI') {
          $gender = 'Laki-laki';
        } elseif ($field->Jenis_Kelamin == 'F' || $field->Jenis_Kelamin == 'PEREMPUAN') {
          $gender = 'Perempuan';
        } else {
          $gender = '';
        }

        $register = ' <div class="text-left">' . $field->RegisteredBy . '</div>
                      <div class="text-right smaller-90">' . $field->RegisteredDate . '</div>';

        if ($field->Vaksin == 'SUDAH') {
          $vaksin = '<span class="badge badge-success">' . $field->Vaksin . '</span>';
        } else {
          $vaksin = '<span class="badge badge-danger">' . $field->Vaksin . '</span>';
        }

        $berkas = '<div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                      Berkas
                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-default">';
        if ($field->KTP != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KTP" data-tk="' . ucwords(strtolower($field->Nama)) . '">KTP</a></li>';
        } else {
          $berkas .= '<li><a><small><i>KTP is NULL</i></small></a></li>';
        }
        if ($field->KK != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KK" data-tk="' . ucwords(strtolower($field->Nama)) . '">KK</a></li>';
        } else {
          $berkas .= '<li><a><small><i>KK is NULL</i></small></a></li>';
        }
        if ($field->SKCK != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="SKCK" data-tk="' . ucwords(strtolower($field->Nama)) . '">SKCK</a></li>';
        } else {
          $berkas .= '<li><a><small><i>SKCK is NULL</i></small></a></li>';
        }
        if ($field->Lamaran != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Lamaran" data-tk="' . ucwords(strtolower($field->Nama)) . '">Lamaran</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Lamaran is NULL</i></small></a></li>';
        }
        if ($field->CV != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="CV" data-tk="' . ucwords(strtolower($field->Nama)) . '">CV</a></li>';
        } else {
          $berkas .= '<li><a><small><i>CV is NULL</i></small></a></li>';
        }
        if ($field->Ijazah != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Ijazah" data-tk="' . ucwords(strtolower($field->Nama)) . '">Ijazah</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Ijazah is NULL</i></small></a></li>';
        }
        if ($field->Transkrip != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Transkrip" data-tk="' . ucwords(strtolower($field->Nama)) . '">Transkip</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Transkrip is NULL</i></small></a></li>';
        }
        if ($field->Vaksin1 != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin1" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 1</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Vaksin1 is NULL</i></small></a></li>';
        }
        if ($field->Vaksin2 != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin2" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 2</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Vaksin2 is NULL</i></small></a></li>';
        }

        if ($field->Vaksin3 != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin3" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 3</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Vaksin3 is NULL</i></small></a></li>';
        }
        $berkas .= '</ul>
                    </div>
                    <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInfo btn btn-minier btn-round btn-primary">
                        <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                    </a>';

        $keterangan = ' <select class="form-control keterangan" name="keterangan" id="keterangan">
                          <option value="">-- Pilih --</option>';
        $keterangan .= '<option value="belum_3_bln" ' . ($field->KeteranganKirim == "belum_3_bln" ? "selected" : "") . '>Daftar 2 CV belum 3 bulan</option>';
        $keterangan .= '<option value="belum_1_bln" ' . ($field->KeteranganKirim == "belum_1_bln" ? "selected" : "") . '>Daftar di CV yang sama belum 1 bulan</option>';
        $keterangan .= '<option value="belum_ada_lowongan" ' . ($field->KeteranganKirim == "belum_ada_lowongan" ? "selected" : "") . '>Belum sesuai kualifikasi/belum ada lowongan</option>';
        $keterangan .= '<option value="blacklist" ' . ($field->KeteranganKirim == "blacklist" ? "selected" : "") . '>Blacklist</option>';
        $keterangan .= '<option value="nik_tidak_valid" ' . ($field->KeteranganKirim == "nik_tidak_valid" ? "selected" : "") . '>NIK Tidak valid</option>';
        $keterangan .= '<option value="blacklist_2_bln" ' . ($field->KeteranganKirim == "blacklist_2_bln" ? "selected" : "") . '>Blacklist 2 bulan</option>';

        $keterangan .= '</select>';

        $proses = ' <select class="form-control proses" name="proses" id="proses" required>
                      <option value="">-- Pilih --</option>';
        $proses .= '<option value="proses" ' . ($field->Proses == "proses" ? "selected" : "") . '>Proses</option>';
        $proses .= '<option value="belum" ' . ($field->Proses == "belum" ? "selected" : "") . '>Belum Bisa Proses</option>';
        $proses .= '<option value="tidak" ' . ($field->Proses == "tidak" ? "selected" : "") . '>Tidak Bisa Proses</option>';
        $proses .= '</select>';

        $kualifikasi = '';
        if (isset($field->Kualifikasi)) {
          $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi" value="' . $field->Kualifikasi . '">' . $field->Kualifikasi . '</textarea><br>';
        } else {
          $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi"></textarea><br>';
        }

        $kualifikasi .= '<button type="button" name="simpan" id="simpan" class="simpan btn btn-primary btn-round btn-minier">Simpan</button>';




        $no++;
        $row   = array();
        $row[] = $checkBox;
        $row[] = $field->HeaderID;
        $row[] = $field->Nama;
        $row[] = $Pemborong;
        $row[] = $field->SubPemborong;
        $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
        $row[] = $gender;
        $row[] = $register;
        $row[] = $field->DikirimDate ? date('d-m-Y', strtotime($field->DikirimDate)) : '';
        $row[] = $vaksin;
        $row[] = $berkas;
        $row[] = $keterangan;
        $row[] = $proses;
        $row[] = $kualifikasi;

        $data[] = $row;
      }

      $output = array(
        "draw"            => $_POST['draw'],
        "recordsTotal"    => $this->m_register->count_all('vwListTenakerForPemborong'),
        "recordsFiltered" => $this->m_register->count_filtered('vwListTenakerForPemborong'),
        "data"            => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    }
  }
  public function show_main_pbr()
  {
    // access_check();
    if ($this->input->is_ajax_request()) {
      $list = $this->m_register->get_datatables('vwListTenakerForPemborong');
      $data = array();
      $no   = $_POST['start'];
      foreach ($list as $field) {

        $checkBox = '<div class="checkbox">
                        <label class="pos-rel">
                            <input name="chkPosting[]" id="chkPosting" class="chkPosting" type="checkbox" value="' . $field->HeaderID . '">
                            <span class="lbl"></span>
                        </label>
                    </div>';

        if ($field->Pemborong == 'YAO HSING') {
          $Pemborong = $field->Pemborong;
          $Pemborong .= '<input name="txtTipe[]" type="hidden" value="1" readonly="">';
        } else {
          $Pemborong = $field->Pemborong;
          $Pemborong .= '<input name="txtTipe[]" type="hidden" value="0" readonly="">';
        }
        if ($field->Jenis_Kelamin == 'M' || $field->Jenis_Kelamin == 'LAKI-LAKI') {
          $gender = 'Laki-laki';
        } elseif ($field->Jenis_Kelamin == 'F' || $field->Jenis_Kelamin == 'PEREMPUAN') {
          $gender = 'Perempuan';
        } else {
          $gender = '';
        }

        $register = ' <div class="text-left">' . $field->RegisteredBy . '</div>
                      <div class="text-right smaller-90">' . $field->RegisteredDate . '</div>';

        if ($field->Vaksin == 'SUDAH') {
          $vaksin = '<span class="badge badge-success">' . $field->Vaksin . '</span>';
        } else {
          $vaksin = '<span class="badge badge-danger">' . $field->Vaksin . '</span>';
        }

        $no++;
        $row   = array();
        $row[] = $checkBox;
        $row[] = $field->HeaderID;
        $row[] = $field->Nama;
        $row[] = $Pemborong;
        $row[] = $field->SubPemborong;
        $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
        $row[] = $gender;
        $row[] = $register;
        $row[] = $vaksin;


        $data[] = $row;
      }

      $output = array(
        "draw"            => $_POST['draw'],
        "recordsTotal"    => $this->m_register->count_all('vwListTenakerForPemborong'),
        "recordsFiltered" => $this->m_register->count_filtered('vwListTenakerForPemborong'),
        "data"            => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    }
  }

  public function show_proses()
  {
    // access_check();
    if ($this->input->is_ajax_request()) {
      $list = $this->m_register->get_datatables('vwListTenakerForPemborong', 'proses');
      $data = array();
      $no   = $_POST['start'];
      foreach ($list as $field) {

        $checkBox = '<div class="checkbox">
                        <label class="pos-rel">
                            <input name="chkToInterview[]" id="chkToInterview" class="chkToInterview" type="checkbox" value="' . $field->HeaderID . '">
                            <span class="lbl"></span>
                        </label>
                    </div>';

        if ($field->Pemborong == 'YAO HSING') {
          $Pemborong = $field->Pemborong;
          $Pemborong .= '<input name="txtTipe[]" type="hidden" value="1" readonly="">';
        } else {
          $Pemborong = $field->Pemborong;
          $Pemborong .= '<input name="txtTipe[]" type="hidden" value="0" readonly="">';
        }
        if ($field->Jenis_Kelamin == 'M' || $field->Jenis_Kelamin == 'LAKI-LAKI') {
          $gender = 'Laki-laki';
        } elseif ($field->Jenis_Kelamin == 'F' || $field->Jenis_Kelamin == 'PEREMPUAN') {
          $gender = 'Perempuan';
        } else {
          $gender = '';
        }

        $register = ' <div class="text-left">' . $field->RegisteredBy . '</div>
                      <div class="text-right smaller-90">' . $field->RegisteredDate . '</div>';

        if ($field->Vaksin == 'SUDAH') {
          $vaksin = '<span class="badge badge-success">' . $field->Vaksin . '</span>';
        } else {
          $vaksin = '<span class="badge badge-danger">' . $field->Vaksin . '</span>';
        }

        $berkas = '<div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                      Berkas
                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-default">';
        if ($field->KTP != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KTP" data-tk="' . ucwords(strtolower($field->Nama)) . '">KTP</a></li>';
        } else {
          $berkas .= '<li><a><small><i>KTP is NULL</i></small></a></li>';
        }
        if ($field->KK != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KK" data-tk="' . ucwords(strtolower($field->Nama)) . '">KK</a></li>';
        } else {
          $berkas .= '<li><a><small><i>KK is NULL</i></small></a></li>';
        }
        if ($field->SKCK != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="SKCK" data-tk="' . ucwords(strtolower($field->Nama)) . '">SKCK</a></li>';
        } else {
          $berkas .= '<li><a><small><i>SKCK is NULL</i></small></a></li>';
        }
        if ($field->Lamaran != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Lamaran" data-tk="' . ucwords(strtolower($field->Nama)) . '">Lamaran</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Lamaran is NULL</i></small></a></li>';
        }
        if ($field->CV != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="CV" data-tk="' . ucwords(strtolower($field->Nama)) . '">CV</a></li>';
        } else {
          $berkas .= '<li><a><small><i>CV is NULL</i></small></a></li>';
        }
        if ($field->Ijazah != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Ijazah" data-tk="' . ucwords(strtolower($field->Nama)) . '">Ijazah</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Ijazah is NULL</i></small></a></li>';
        }
        if ($field->Transkrip != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Transkrip" data-tk="' . ucwords(strtolower($field->Nama)) . '">Transkip</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Transkrip is NULL</i></small></a></li>';
        }
        if ($field->Vaksin1 != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin1" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 1</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Vaksin1 is NULL</i></small></a></li>';
        }
        if ($field->Vaksin2 != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin2" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 2</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Vaksin2 is NULL</i></small></a></li>';
        }

        if ($field->Vaksin3 != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin3" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 3</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Vaksin3 is NULL</i></small></a></li>';
        }
        $berkas .= '</ul>
                    </div>
                    <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInfo btn btn-minier btn-round btn-primary">
                        <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                    </a>';

        $keterangan = ' <select class="form-control keterangan" name="keterangan" id="keterangan">
                          <option value="">-- Pilih --</option>';
        $keterangan .= '<option value="belum_3_bln" ' . ($field->KeteranganKirim == "belum_3_bln" ? "selected" : "") . '>Daftar 2 CV belum 3 bulan</option>';
        $keterangan .= '<option value="belum_1_bln" ' . ($field->KeteranganKirim == "belum_1_bln" ? "selected" : "") . '>Daftar di CV yang sama belum 1 bulan</option>';
        $keterangan .= '<option value="belum_ada_lowongan" ' . ($field->KeteranganKirim == "belum_ada_lowongan" ? "selected" : "") . '>Belum sesuai kualifikasi/belum ada lowongan</option>';
        $keterangan .= '<option value="blacklist" ' . ($field->KeteranganKirim == "blacklist" ? "selected" : "") . '>Blacklist</option>';
        $keterangan .= '<option value="nik_tidak_valid" ' . ($field->KeteranganKirim == "nik_tidak_valid" ? "selected" : "") . '>NIK Tidak valid</option>';
        $keterangan .= '<option value="blacklist_2_bln" ' . ($field->KeteranganKirim == "blacklist_2_bln" ? "selected" : "") . '>Blacklist 2 bulan</option>';

        $keterangan .= '</select>';

        $proses = ' <select class="form-control proses" name="proses" id="proses" required readonly disabled>
                      <option value="">-- Pilih --</option>';
        $proses .= '<option value="proses" ' . ($field->Proses == "proses" ? "selected" : "") . '>Proses</option>';
        $proses .= '<option value="belum" ' . ($field->Proses == "belum" ? "selected" : "") . '>Belum Bisa Proses</option>';
        $proses .= '<option value="tidak" ' . ($field->Proses == "tidak" ? "selected" : "") . '>Tidak Bisa Proses</option>';
        $proses .= '</select>';
        $proses = ($field->Proses == "proses" ? '<span class="badge badge-success">Proses</span>' : ($field->Proses == "belum" ? '<span class="badge badge-warning">Belum Bisa Proses</span>' : ($field->Proses == "tidak" ? '<span class="badge badge-danger">Tidak Bisa Proses</span>' : "")));


        $kualifikasi = '';
        if (isset($field->Kualifikasi)) {
          $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi" value="' . $field->Kualifikasi . '">' . $field->Kualifikasi . '</textarea><br>';
        } else {
          $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi"></textarea><br>';
        }

        $kualifikasi .= '<button type="button" name="simpan" id="simpan" class="simpan btn btn-primary btn-round btn-minier">Simpan</button>';

        if (strpos($field->kesimpulanCU, "Tidak Sehat") !== false) {
          $kesimpulanCu =   str_replace("Tidak Sehat", '<span class="badge badge-danger">Tidak Sehat</span>', $field->kesimpulanCU);
        } else {
          // $kesimpulanCu =  str_replace("Sehat", '<span class="badge badge-success">Sehat</span>', $field->kesimpulanCU);
          $kesimpulanCu =  $field->kesimpulanCU;
        }


        $no++;
        $row   = array();
        $row[] = $checkBox;
        $row[] = $field->HeaderID;
        $row[] = $field->Nama;
        $row[] = $Pemborong;
        $row[] = $field->SubPemborong;
        $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
        $row[] = $gender;
        $row[] = $register;
        $row[] = $field->DikirimDate ? date('d-m-Y', strtotime($field->DikirimDate)) : '';
        $row[] = $vaksin;
        $row[] = $berkas;
        $row[] = $kesimpulanCu;
        // $row[] = $keterangan;
        $row[] = $proses;
        $row[] = $kualifikasi;

        $data[] = $row;
      }

      $output = array(
        "draw"            => $_POST['draw'],
        "recordsTotal"    => $this->m_register->count_all('vwListTenakerForPemborong'),
        "recordsFiltered" => $this->m_register->count_filtered('vwListTenakerForPemborong'),
        "data"            => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    }
  }

  public function show_proses_to_mcu()
  {
    // access_check();
    if ($this->input->is_ajax_request()) {
      $list = $this->m_register->get_datatables('vwListTenakerForPemborong', 'mcu');
      $data = array();
      $no   = $_POST['start'];
      foreach ($list as $field) {

        $checkBox = '<div class="checkbox">
                        <label class="pos-rel">
                            <input name="chkMCU[]" id="chkMCU" class="chkMCU" type="checkbox" value="' . $field->HeaderID . '">
                            <span class="lbl"></span>
                        </label>
                    </div>';

        if ($field->Pemborong == 'YAO HSING') {
          $Pemborong = $field->Pemborong;
          $Pemborong .= '<input name="txtTipe[]" type="hidden" value="1" readonly="">';
        } else {
          $Pemborong = $field->Pemborong;
          $Pemborong .= '<input name="txtTipe[]" type="hidden" value="0" readonly="">';
        }
        if ($field->Jenis_Kelamin == 'M' || $field->Jenis_Kelamin == 'LAKI-LAKI') {
          $gender = 'Laki-laki';
        } elseif ($field->Jenis_Kelamin == 'F' || $field->Jenis_Kelamin == 'PEREMPUAN') {
          $gender = 'Perempuan';
        } else {
          $gender = '';
        }

        $register = ' <div class="text-left">' . $field->RegisteredBy . '</div>
                      <div class="text-right smaller-90">' . $field->RegisteredDate . '</div>';

        if ($field->Vaksin == 'SUDAH') {
          $vaksin = '<span class="badge badge-success">' . $field->Vaksin . '</span>';
        } else {
          $vaksin = '<span class="badge badge-danger">' . $field->Vaksin . '</span>';
        }

        $berkas = '<div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                      Berkas
                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-default">';
        if ($field->KTP != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KTP" data-tk="' . ucwords(strtolower($field->Nama)) . '">KTP</a></li>';
        } else {
          $berkas .= '<li><a><small><i>KTP is NULL</i></small></a></li>';
        }
        if ($field->KK != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KK" data-tk="' . ucwords(strtolower($field->Nama)) . '">KK</a></li>';
        } else {
          $berkas .= '<li><a><small><i>KK is NULL</i></small></a></li>';
        }
        if ($field->SKCK != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="SKCK" data-tk="' . ucwords(strtolower($field->Nama)) . '">SKCK</a></li>';
        } else {
          $berkas .= '<li><a><small><i>SKCK is NULL</i></small></a></li>';
        }
        if ($field->Lamaran != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Lamaran" data-tk="' . ucwords(strtolower($field->Nama)) . '">Lamaran</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Lamaran is NULL</i></small></a></li>';
        }
        if ($field->CV != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="CV" data-tk="' . ucwords(strtolower($field->Nama)) . '">CV</a></li>';
        } else {
          $berkas .= '<li><a><small><i>CV is NULL</i></small></a></li>';
        }
        if ($field->Ijazah != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Ijazah" data-tk="' . ucwords(strtolower($field->Nama)) . '">Ijazah</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Ijazah is NULL</i></small></a></li>';
        }
        if ($field->Transkrip != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Transkrip" data-tk="' . ucwords(strtolower($field->Nama)) . '">Transkip</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Transkrip is NULL</i></small></a></li>';
        }
        if ($field->Vaksin1 != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin1" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 1</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Vaksin1 is NULL</i></small></a></li>';
        }
        if ($field->Vaksin2 != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin2" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 2</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Vaksin2 is NULL</i></small></a></li>';
        }

        if ($field->Vaksin3 != NULL) {
          $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin3" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 3</a></li>';
        } else {
          $berkas .= '<li><a><small><i>Vaksin3 is NULL</i></small></a></li>';
        }
        $berkas .= '</ul>
                    </div>
                    <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInfo btn btn-minier btn-round btn-primary">
                        <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                    </a>';

        $keterangan = ' <select class="form-control keterangan" name="keterangan" id="keterangan">
                          <option value="">-- Pilih --</option>';
        $keterangan .= '<option value="belum_3_bln" ' . ($field->KeteranganKirim == "belum_3_bln" ? "selected" : "") . '>Daftar 2 CV belum 3 bulan</option>';
        $keterangan .= '<option value="belum_1_bln" ' . ($field->KeteranganKirim == "belum_1_bln" ? "selected" : "") . '>Daftar di CV yang sama belum 1 bulan</option>';
        $keterangan .= '<option value="belum_ada_lowongan" ' . ($field->KeteranganKirim == "belum_ada_lowongan" ? "selected" : "") . '>Belum sesuai kualifikasi/belum ada lowongan</option>';
        $keterangan .= '<option value="blacklist" ' . ($field->KeteranganKirim == "blacklist" ? "selected" : "") . '>Blacklist</option>';
        $keterangan .= '<option value="nik_tidak_valid" ' . ($field->KeteranganKirim == "nik_tidak_valid" ? "selected" : "") . '>NIK Tidak valid</option>';
        $keterangan .= '<option value="blacklist_2_bln" ' . ($field->KeteranganKirim == "blacklist_2_bln" ? "selected" : "") . '>Blacklist 2 bulan</option>';

        $keterangan .= '</select>';

        $proses = ' <select class="form-control proses" name="proses" id="proses" required readonly disabled>
                      <option value="">-- Pilih --</option>';
        $proses .= '<option value="proses" ' . ($field->Proses == "proses" ? "selected" : "") . '>Proses</option>';
        $proses .= '<option value="proses" ' . ($field->Proses == "belum" ? "selected" : "") . '>Belum Bisa Proses</option>';
        $proses .= '<option value="proses" ' . ($field->Proses == "tidak" ? "selected" : "") . '>Tidak Bisa Proses</option>';
        $proses .= '</select>';

        $proses = ($field->Proses == "proses" ? '<span class="badge badge-success">Proses</span>' : ($field->Proses == "belum" ? '<span class="badge badge-warning">Belum Bisa Proses</span>' : ($field->Proses == "tidak" ? '<span class="badge badge-danger">Tidak Bisa Proses</span>' : "")));


        $kualifikasi = '';
        if (isset($field->Kualifikasi)) {
          $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi" value="' . $field->Kualifikasi . '">' . $field->Kualifikasi . '</textarea><br>';
        } else {
          $kualifikasi .=  '<textarea name="kualifikasi" id="kualifikasi" class="kualifikasi"></textarea><br>';
        }

        $kualifikasi .= '<button type="button" name="simpan" id="simpan" class="simpan btn btn-primary btn-round btn-minier">Simpan</button>';




        $no++;
        $row   = array();
        $row[] = $checkBox;
        $row[] = $field->HeaderID;
        $row[] = $field->Nama;
        $row[] = $Pemborong;
        $row[] = $field->SubPemborong;
        $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
        $row[] = $gender;
        $row[] = $register;
        $row[] = $field->DikirimDate ? date('d-m-Y', strtotime($field->DikirimDate)) : '';
        $row[] = $vaksin;
        $row[] = $berkas;
        // $row[] = $keterangan;
        $row[] = $proses;
        $row[] = $kualifikasi;

        $data[] = $row;
      }

      $output = array(
        "draw"            => $_POST['draw'],
        "recordsTotal"    => $this->m_register->count_all('vwListTenakerForPemborong'),
        "recordsFiltered" => $this->m_register->count_filtered('vwListTenakerForPemborong'),
        "data"            => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    }
  }

  function update_input_mandiri()
  {
    $id = $this->input->post('id');
    $data = $this->m_register->update_input_mandiri($id);
    if ($data) {
      $res = [
        'status' => 200,
        'id' => $id,
      ];
    } else {
      $res = [
        'status' => 500,
      ];
    }
    echo json_encode($res);
  }
}

/* End of file registrasi.php */
/* Location: ./application/controllers/registrasi.php */