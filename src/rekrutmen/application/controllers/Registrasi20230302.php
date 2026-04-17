<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Registrasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        $this->load->model('m_register');
        // $status = 1;
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }
        $this->load->library(array('template', 'form_validation'));
    }

    function index()
    {
        $this->load->model('m_register');

        $data['_getprovinsi']             = $this->m_register->getProvinsi();
        $data['_getSuku']                 = $this->m_register->getSuku();
        $data['_getAgama']                = $this->m_register->getAgama();
        $data['_getJurusan']              = $this->m_register->getJurusan();
        $data['_getPendidikan']           = $this->m_register->getPendidikan();
        $data['_getStatusKawin']          = $this->m_register->getStatusKawin();
        $idpemborong                      = $this->session->userdata('idpemborong');
        //    $data['_getPemborong']= $this->m_register->get_pemborong_bygroup($idpemborong)->result();
        $data['_getPSGPemorong']          = $this->m_register->getPSGPemborong($idpemborong);

        $this->session->set_flashdata("regid", 0);
        //echo $idpemborong;
        $this->template->display('registrasi/register/index', $data);
    }

    function index2()
    {
        $this->load->model('m_register');

        $data['_getprovinsi']             = $this->m_register->getProvinsi();
        $data['_getSuku']                 = $this->m_register->getSuku();
        $data['_getAgama']                = $this->m_register->getAgama();
        $data['_getJurusan']              = $this->m_register->getJurusan();
        $data['_getPendidikan']           = $this->m_register->getPendidikan();
        $data['_getStatusKawin']          = $this->m_register->getStatusKawin();
        $idpemborong                      = $this->session->userdata('idpemborong');
        //        $data['_getPemborong']= $this->m_register->get_pemborong_bygroup($idpemborong)->result();
        $data['_getPSGPemorong']          = $this->m_register->getPSGPemborong($idpemborong);

        $this->session->set_flashdata("regid", 0);
        //echo $idpemborong;
        $this->template->display('registrasi/register/index2', $data);
    }


    function indexByPass()
    {
        $this->load->model('m_register');

        $data['_getprovinsi']             = $this->m_register->getProvinsi();
        $data['_getSuku']                 = $this->m_register->getSuku();
        $data['_getAgama']                = $this->m_register->getAgama();
        $data['_getJurusan']              = $this->m_register->getJurusan();
        $data['_getPendidikan']           = $this->m_register->getPendidikan();
        $data['_getStatusKawin']          = $this->m_register->getStatusKawin();
        $idpemborong                      = $this->session->userdata('idpemborong');
        //        $data['_getPemborong']= $this->m_register->get_pemborong_bygroup($idpemborong)->result();
        $data['_getPSGPemorong']          = $this->m_register->getPSGPemborong($idpemborong);

        $this->session->set_flashdata("regid", 0);
        $this->template->display('registrasi/register/index-bypass', $data);
    }

    function selectPemborong()
    {
        $this->load->model('m_register');
        if ('IS_AJAX') {
            $data['namapt']   = $this->m_register->getPemborong();
            $this->load->view('registrasi/register/perusahaan', $data);
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

    function validasi_register_pelamar()
    {
        $nama = " 123NITA SARI#@";
        $namaTK =  TRIM(preg_replace("/[^a-zA-Z]/", " ", $nama));
        $pemborong = TRIM("MUKHTAR");
        $tglLahir = TRIM("1999-05-01");
        $namaIbu = TRIM(preg_replace("/[^a-zA-Z]/", " ", "NURLAILA"));
        $namaAyah = TRIM(preg_replace("/[^a-zA-Z]/", " ", "DONI"));


        echo $namaTK;
        echo "<pre>";

        // 1. cek apakah user ada di list blacklist atau tidak
        $cek_black_list = $this->m_register->cekTK(array('Nama' => $namaTK, 'NamaIbuKandung' => $namaIbu));

        // 2. cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
        $cekScreen   = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);

        // 3.  cek Pernah Masih Aktif sebagai karyawan atau tidak
        $cekTKAktif = $this->m_register->cekRegAktif($tglLahir, $namaIbu, $namaAyah);

        // 4.  cek masih dalam masa jeda (TanggalKeluarTemporary) 
        $cekInTemp  = $this->m_register->cekRegInTemp($tglLahir, $namaIbu, $namaAyah);

        // 5. cek apakah tk sudah pernah melamar di pemborong ini ?
        $cekTKPem  = $this->m_register->cekRegTKPem($pemborong, $tglLahir, $namaIbu, $namaAyah);

        // 6. Cek TK apakah sudah pernah melamar di pemborong lain ?
        //!! TODO: query cek tk ke pemborong lain
        $cekTK  = $this->m_register->cekRegTK($pemborong, $tglLahir, $namaIbu, $namaAyah);


        if ($cek_black_list) {
            redirect('registrasi/rejected_new/1/' . $namaTK);
        }

        if ($cekScreen) {
            redirect('registrasi/rejected_new/2/' . $namaTK);
        }

        if ($cekTKAktif) {
            redirect('registrasi/rejected_new/3/' . $namaTK);
        }

        if ($cekInTemp) {
            redirect('registrasi/rejected_new/4/' . $namaTK);
        }

        if ($cekTKPem) {
            redirect('registrasi/rejected_new/5/' . $namaTK);
        }

        if ($cekTK) {
            redirect('registrasi/rejected_new/6/' . $namaTK);
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
        // print_r($namaTk);
        // exit;
        switch ($pesan_id) {
            case '1':
                // blacklist
                $data['pesan']  = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>telah masuk ke dalam TK bermasalah!!</small>';
                break;
            case '2':
                //TIDAK LULUS
                $data['pesan']  = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>telah/pernah mendaftar dan ditolak!!</small>';
                break;
                // Masih Aktif
            case '3':
                $data['pesan']  = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>masih aktif sebagai Tenaga Kerja!!</small>';
                break;
                //dalam masa jeda
            case '4':
                $data['pesan']  = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>masih dalam waktu tenggang tanggal dia keluar!!</small>';
                break;
                //pernah melamar dipemborong ini
            case '5':
                $data['pesan']  = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>sudah pernah melamar dipemborong ini!!</small>';
                break;
                //pernah melamar dipemborong lain
            case '6':
                $data['pesan']  = '<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> "' . $namaTk . '" <small>sudah pernah melamar dipemborong lain!!</small>';
                break;
        }

        // if ($msg == 1) {
        //     $data['pesan']  = 'anotherPemborong';
        // } elseif ($msg == 2) {
        //     $data['pesan']   = 'karyawanAktif';
        // } elseif ($msg == 3) {
        //     $data['pesan']  = 'calonInTemp';
        // } elseif ($msg == 4) {
        //     $data['pesan'] = 'calonGagalScreen';
        // } elseif ($msg == 5) {
        //     $data['pesan'] = 'calonGagalScreen';
        // } elseif ($msg == 6) {
        //     $data['pesan'] = 'calonGagalScreen';
        // }

        $this->template->display("registrasi/register/tolak_new", $data);
    }

    function simpanReg()
    {
        $this->load->model('m_register');

        $this->_set_rules();

        if ($this->form_validation->run() == false) {
            $data['message']  = 'Silahkan Input Calon Tenaga Kerja';
            $this->template->display('registrasi/register/index', $data);
            exit;
        }

        $confirm    = $this->input->post('txtConfirm'); // ===== deklarasi Confrim Text
        $namaTK     = trim(strtoupper($this->input->post('txtNama'))); // ===== deklarasi Nama Pelamar

        // ===== cek KeadaanFisik
        if ($this->input->post('txtKeadaanFisik') === 'CACAT' || $this->input->post('txtKeadaanFisik') === 'cacat') {
            $cacatapa   = strtoupper($this->input->post('txtCacatApa'));
        } else {
            $cacatapa   = 'TIDAK ADA';
        }
        // ===== cek Penyakit
        if ($this->input->post('txtPernahPenyakit') === 'YA') {
            $penyakitapa    = strtoupper($this->input->post('txtPenyakit'));
        } else {
            $penyakitapa    = 'TIDAK ADA';
        }
        // ===== cek Tato
        if ($this->input->post('txtBertato') === 'YA') {
            $tatoDimana   = strtoupper($this->input->post('txtTatoDimana'));
        } else {
            $tatoDimana   = 'TIDAK ADA';
        }
        // ===== cek Kriminal
        if ($this->input->post('txtPernahKriminal') === 'YA') {
            $perkaraapa   = strtoupper($this->input->post('txtKriminal'));
        } else {
            $perkaraapa   = 'TIDAK ADA';
        }
        // ===== cek Jumlah Anak
        if ($this->input->post('txtJumlahAnak') === '') {
            $jumlahanak   = '';
        } else {
            $jumlahanak   = $this->input->post('txtJumlahAnak');
        }
        // ===== cek Jurusan
        if ($this->input->post('txtJurusan') == '') {
            $jurusan                      = '-';
        } else {
            $jurusan    = strtoupper($this->input->post('txtJurusan'));
        }
        // ===== cek Vaksin
        $TanggalVaksin  = $this->input->post('txtTanggalVaksin');
        $TanggalVaksin2 = $this->input->post('txtTanggalVaksin2');
        $TanggalVaksin3 = $this->input->post('txtTanggalVaksin3');

        if ($this->input->post('txtVaksin') === 'SUDAH') {
            $Vaksin                       = $this->input->post('txtVaksin');
            $JenisVaksin                  = strtoupper($this->input->post('txtJenisVaksin'));
            if ($TanggalVaksin != '') {
                $TanggalVaksin            = date('Y-m-d', strtotime($TanggalVaksin));
            } else {
                $TanggalVaksin            = NULL;
            }

            if ($TanggalVaksin2 != '') {
                $TanggalVaksin2           = date('Y-m-d', strtotime($TanggalVaksin2));
            } else {
                $TanggalVaksin2           = NULL;
            }

            if ($TanggalVaksin3 != '') {
                $TanggalVaksin3           = date('Y-m-d', strtotime($TanggalVaksin3));
            } else {
                $TanggalVaksin3           = NULL;
            }
        } else {
            $Vaksin                       = 'BELUM';
            $JenisVaksin                  = 'TIDAK ADA';
            $TanggalVaksin                = NULL;
            $TanggalVaksin2               = NULL;
            $TanggalVaksin3               = NULL;
        }

        $namaAnak                         = $this->input->post('txtNamaAnak');
        $itungAnak                        = $this->cekAnak($namaAnak);
        $jmlAnak                          = $this->input->post('txtJumlahAnak');

        if ($jmlAnak == "") {
            if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
                $anak                     = 0;
            } elseif ($namaAnak == "") {
                $anak                     = 0;
            } elseif ($itungAnak > 0) {
                $anak                     = $itungAnak;
            } else {
                $anak                     = 0;
            }
        } elseif ($jmlAnak > 0) {
            if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
                $anak                     = 0;
            } elseif ($namaAnak == "") {
                $anak                     = 0;
            } else {
                $anak                     = $itungAnak;
            }
        } else {
            $anak                         = $itungAnak;
        }

        $pasangan                         = $this->input->post('txtNamaPasangan');
        if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS' || $pasangan == '') {
            $tglPasangan                  = NULL;
        } else {
            $tglPasangan                  = date('Y-m-d', strtotime($this->input->post('txtTglLahirPasangan')));
        }

        if ($this->input->post('txtShcool') == "") {
            $univ                         = $this->input->post('txtUniv');
        } else {
            $univ                         = $this->input->post('txtShcool');
        }

        if ($this->input->post('txtNilai') == "") {
            $ipk                          = $this->input->post('txtIPK');
        } else {
            $ipk                          = $this->input->post('txtNilai');
        }

        if (strtoupper($this->input->post('txtPendidikan')) == 'TIDAK SEKOLAH') {
            $pendidikan                   = "NaN";
        } else {
            $pendidikan                   = strtoupper($this->input->post('txtPendidikan'));
        }

        $info                             = array(
            'CVNama'                    => $this->input->post('txtPerusahaan'),
            'Pemborong'                 => $this->input->post('txtPemborong'),
            'Nama'                      => trim(strtoupper($this->input->post('txtNama'))),
            'Tgl_Lahir'                 => date('Y-m-d', strtotime($this->input->post('txtTanggalLahir'))),
            'Tempat_Lahir'              => strtoupper($this->input->post('txtTempatLahir')),
            'NamaIbuKandung'            => strtoupper($this->input->post('txtNamaIbu')),
            'BeratBadan'                => $this->input->post('txtBeratBadan'),
            'TinggiBadan'               => $this->input->post('txtTinggiBadan'),
            'Agama'                     => strtoupper($this->input->post('txtAgama')),
            'Suku'                      => strtoupper($this->input->post('txtSuku')),
            'Jenis_Kelamin'             => strtoupper($this->input->post('txtJekel')),
            'Pendidikan'                => $pendidikan,
            'Jurusan'                   => $jurusan,
            'Universitas'               => $univ,
            'IPK'                       => $ipk,
            'Status_Personal'           => strtoupper($this->input->post('txtStatus')),
            'No_Ktp'                    => $this->input->post('txtNoKTP'),
            'No_KK'                     => $this->input->post('txtNoKK'),
            'Alamat_KTP'                => strtoupper($this->input->post('txtAlamatKTP')),
            'Alamat'                    => strtoupper($this->input->post('txtAlamat')),
            'RT'                        => $this->input->post('txtRT'),
            'RW'                        => $this->input->post('txtRW'),
            'TinggalDengan'             => $this->input->post('txtTinggalDengan'),
            'HubunganDenganTK'          => $this->input->post('txtHubungan'),
            'NoHP'                      => $this->input->post('txtNoPonsel'),
            'Daerah_Asal'               => strtoupper($this->input->post('txtDaerahAsal')),
            'PernahKerja'               => strtoupper($this->input->post('txtPernahRSUP')),
            'KerjaDi'                   => strtoupper($this->input->post('txtBagian')),
            'Kriminal'                  => $this->input->post('txtPernahKriminal'),
            'PerkaraApa'                => $perkaraapa,
            'JumlahAnak'                => $anak,
            'NamaSuamiIstri'            => strtoupper($this->input->post('txtNamaPasangan')),
            'TglLahirSuamiIstri'        => $tglPasangan,
            'PekerjaanSuamiIstri'       => strtoupper($this->input->post('txtPekerjaanPasangan')),
            'AlamatSuamiIstri'          => strtoupper($this->input->post('txtAlamatPasangan')),
            'NamaBapak'                 => strtoupper($this->input->post('txtNamaBapak')),
            'ProfesiOrangTua'           => strtoupper($this->input->post('txtPekerjaanOrtu')),
            'JumlahSaudara'             => $this->input->post('txtJumlahSaudara'),
            'AnakKe'                    => $this->input->post('txtAnakKe'),
            'BahasaDaerah'              => strtoupper($this->input->post('txtBahasaDaerah')),
            'TahunMasuk'                => $this->input->post('txtTahunMasuk'),
            'TahunLulus'                => $this->input->post('txtTahunLulus'),
            'Hobby'                     => strtoupper($this->input->post('txtHobby')),
            'KegiatanEkstra'            => $this->input->post('txtKegiatanEkstra'),
            'KegiatanOrganisasi'        => $this->input->post('txtOrgnanisasi'),
            'KeadaanFisik'              => $this->input->post('txtKeadaanFisik'),
            'CacatApa'                  => $cacatapa,
            'PernahIdapPenyakit'        => $this->input->post('txtPernahPenyakit'),
            'PenyakitApa'               => $penyakitapa,
            'PengalamanKerja'           => $this->input->post('txtPengalamanKerja'),
            'Keahlian'                  => $this->input->post('txtKeahlian'),
            'PernahKerjaDiSambu'        => $this->input->post('txtPernahRSUP'),
            'KerjadiBagian'             => strtoupper($this->input->post('txtBagian')),
            'Bertato'                   => $this->input->post('txtBertato'),
            'TatoDimana'                => $tatoDimana,
            'Bertindik'                 => $this->input->post('txtBertindik'),
            'SediaPotongRambut'         => $this->input->post('txtRambutPendek'),
            'Sediadiberhentikan'        => $this->input->post('txtBerhentikan'),
            'AccountFacebook'           => $this->input->post('txtFacebook'),
            'AccountTwitter'            => $this->input->post('txtTwitter'),
            'Account_email'             => $this->input->post('txtgmail'),
            'CreatedBy'                 => strtoupper($this->session->userdata('username')),
            'CreatedDate'               => date('Y-m-d H:i:s'),
            'InputOnline'               => 1,
            'RegisteredBy'              => strtoupper($this->session->userdata('userid')),
            'RegisteredDate'            => date('Y-m-d H:i:s'),
            'ProvinsiID'                => $this->input->post('txtProvinsi'),
            'KabKotaID'                 => $this->input->post('txtKabupaten'),
            'KecamatanID'               => $this->input->post('txtKecamatan'),
            'Kerabat_Nama'              => $this->input->post('txtkerabatterdekat'),
            'Kerabat_Telepon'           => $this->input->post('txtnohpkerabat'),
            'Kerabat_Hubungan'          => $this->input->post('txthubungan'),
            'Kerabat_Alamat'            => $this->input->post('txtAlamatKerabat'),
            'AhliWaris_Nama'            => $this->input->post('txtAhliWaris'),
            'AhliWaris_Jekel'           => $this->input->post('txtJekelAhliWaris'),
            'AhliWaris_Hubungan'        => $this->input->post('txtHubunganAhliWaris'),
            'AhliWaris_NoHP'            => $this->input->post('txtnohpkerabatAhliWaris'),
            'AhliWaris_Alamat'          => $this->input->post('txtAlamatAhliWaris'),
            'Kelurahan'                 => strtoupper($this->input->post('txtKelurahan')),
            'Vaksin'                    => $Vaksin,
            'JenisVaksin'               => $JenisVaksin,
            'TanggalVaksin'             => $TanggalVaksin,
            'TanggalVaksin2'            => $TanggalVaksin2,
            'TanggalVaksin3'            => $TanggalVaksin3
        );

        $adaKeluarga                      = $this->input->post('txtAdaKeluarga');
        if ($adaKeluarga == 'YA') {
            $jumkel                       = count($this->input->post('kelnama'));
        } else {
            $jumkel                       = 0;
        }
        $kelnama                          = $this->input->post('kelnama');
        $kelbagian                        = $this->input->post('kelbagian');
        $kelpemborong                     = $this->input->post('kelpemborong');
        $kelhubungan                      = $this->input->post('kelhubungan');
        $kelalamat                        = $this->input->post('kelalamat');

        $annama                           = $this->input->post('txtNamaAnak');
        $antempatlahir                    = $this->input->post('txtTempatLahirAnak');
        $antgllahir                       = $this->input->post('txtTanggalLahirAnak');
        $anjeniskelamin                   = $this->input->post('txtJekelAnak');
        $analamat                         = $this->input->post('txtAlamatAnak');

        $pemborong                        = strtoupper($this->input->post('txtPemborong'));
        $tglLahir                         = date('Y-m-d', strtotime($this->input->post('txtTanggalLahir')));
        $namaIbu                          = strtoupper($this->input->post('txtNamaIbu'));
        $namaAyah                         = strtoupper($this->input->post('txtNamaBapak'));


        // ====== KONFIRMASI
        if ($confirm == 0) {
            // cek pernah melamar atau tidak di pemborong yang sama
            $cekTK  = $this->m_register->cekRegTK($pemborong, $tglLahir, $namaIbu, $namaAyah);
            // cek masih aktif atau tidak sebagai karyawan
            $cekTKAktif = $this->m_register->cekRegAktif($tglLahir, $namaIbu, $namaAyah);
            // cek pernar melamar atau tidak pemborong lainnya
            $cekTKPem   = $this->m_register->cekRegTKPem($pemborong, $tglLahir, $namaIbu, $namaAyah);
            // cek pelamar yang pernah bekerja/melamar dan dinyatakan TIDAK LULUS
            $cekScreen   = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);
            // cek masih dalam masa jeda (TanggalKeluarTemporary) 
            $cekInTemp  = $this->m_register->cekRegInTemp($tglLahir, $namaIbu, $namaAyah);

            if ($cekScreen == true) {
                $this->session->set_flashdata("namatk", $namaTK);
                redirect('registrasi/rejected/4');
            } elseif ($cekTKAktif == true) {
                $this->session->set_flashdata("namatk", $namaTK);
                redirect('registrasi/rejected/2');
            } elseif ($cekInTemp == true) {
                $this->session->set_flashdata("namatk", $namaTK);
                redirect('registrasi/rejected/3');
            } elseif ($cekTK == true) {
                $this->session->set_flashdata("namatk", $namaTK);
                redirect('registrasi/rejected/1');
            } elseif ($cekTKPem == true) {
                $hdridtemp   = $this->m_register->simpanTKTemp($info);

                for ($i = 0; $i < $jumkel; $i++) {
                    $infokel              = array(
                        'HeaderID'          => 0,
                        'HeaderIDTemp'      => $hdridtemp,
                        'Nama'              => strtoupper($kelnama[$i]),
                        'Departemen'        => strtoupper($kelbagian[$i]),
                        'Pemborong'         => strtoupper($kelpemborong[$i]),
                        'HubunganKeluarga'  => strtoupper($kelhubungan[$i]),
                        'Alamat'            => strtoupper($kelalamat[$i])
                    );
                    if (!$kelnama[$i] == '') {
                        $this->simpan_datakeluarga(0, $hdridtemp, $kelnama[$i], $infokel);
                    }
                }

                for ($i = 0; $i < $anak; $i++) {
                    if (is_array($annama) && array_key_exists($i, $annama)) {
                        $infoanak         = array(
                            'HeaderID'      => 0,
                            'HeaderIDTemp'  => $hdridtemp,
                            'Nama'          => strtoupper($annama[$i]),
                            'TempatLahir'   => strtoupper($antempatlahir[$i]),
                            'TglLahir'      => date('Y-m-d', strtotime($antgllahir[$i])),
                            'JenisKelamin'  => strtoupper($anjeniskelamin[$i]),
                            'Alamat'        => strtoupper($analamat[$i]),
                            'CreatedBy'     => strtoupper($this->session->userdata('userid')),
                            'CreatedDate'   => date('Y-m-d H:i:s')
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
                $hdrID    = $this->m_register->simpanTK($info);

                // === Cek Data Anak, Jika Ada Disimpan
                for ($i = 0; $i < $anak; $i++) {
                    if (is_array($annama) && array_key_exists($i, $annama)) {
                        $infoanak         = array(
                            'HeaderID'      => $hdrID,
                            'HeaderIDTemp'  => 0,
                            'Nama'          => strtoupper($annama[$i]),
                            'TempatLahir'   => strtoupper($antempatlahir[$i]),
                            'TglLahir'      => date('Y-m-d', strtotime($antgllahir[$i])),
                            'JenisKelamin'  => strtoupper($anjeniskelamin[$i]),
                            'Alamat'        => strtoupper($analamat[$i]),
                            'CreatedBy'     => strtoupper($this->session->userdata('userid')),
                            'CreatedDate'   => date('Y-m-d H:i:s')
                        );
                        if (!$annama[$i] == '') {
                            $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
                        }
                    }
                }
                // === Cek Data Keluarga, Jika Ada Simpan
                for ($i = 0; $i < $jumkel; $i++) {
                    $infokel              = array(
                        'HeaderID'           => $hdrID,
                        'HeaderIDTemp'       => 0,
                        'Nama'             => strtoupper($kelnama[$i]),
                        'Departemen'       => strtoupper($kelbagian[$i]),
                        'Pemborong'           => strtoupper($kelpemborong[$i]),
                        'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
                        'Alamat'           => strtoupper($kelalamat[$i])
                    );
                    if (!$kelnama[$i] == '') {
                        $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
                    }
                }

                $this->session->set_flashdata("regid", $hdrID);
                $this->session->set_flashdata("regnama", $namaTK);

                $this->load->model('m_upload_berkas');
                $this->m_upload_berkas->insert_db_berkas($hdrID);

                redirect('registrasi/uploadFoto');
            }
        } elseif ($confirm == 1) {
            $this->load->model('m_register');
            $hdrID  = $this->m_register->simpanTK($info);
            $hdridtemp = '';

            // === Cek Data Anak, Jika Ada Disimpan
            for ($i = 0; $i < $anak; $i++) {
                if (is_array($annama) && array_key_exists($i, $annama)) {
                    $infoanak      = array(
                        'HeaderID'      => $hdrID,
                        'HeaderIDTemp'  => $hdridtemp,
                        'Nama'          => strtoupper($annama[$i]),
                        'TempatLahir'   => strtoupper($antempatlahir[$i]),
                        'TglLahir'      => $antgllahir[$i],
                        'JenisKelamin'  => strtoupper($anjeniskelamin[$i]),
                        'Alamat'        => strtoupper($analamat[$i]),
                        'CreatedBy'     => strtoupper($this->session->userdata('userid')),
                        'CreatedDate'   => date('Y-m-d H:i:s')
                    );
                    if (!$annama[$i] == '') {
                        $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
                    }
                }
            }
            // === Cek Data Keluarga, Jika Ada Simpan
            for ($i = 0; $i < $jumkel; $i++) {
                $infokel                  = array(
                    'HeaderID'         => $hdrID,
                    'HeaderIDTemp'     => $hdridtemp,
                    'Nama'             => strtoupper($kelnama[$i]),
                    'Departemen'       => strtoupper($kelbagian[$i]),
                    'Pemborong'        => strtoupper($kelpemborong[$i]),
                    'HubunganKeluarga' => strtoupper($kelhubungan[$i]),
                    'Alamat'           => strtoupper($kelalamat[$i])
                );
                if (!$kelnama[$i] == '') {
                    $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
                }
            }

            $this->session->set_flashdata("regid", $hdrID);
            $this->session->set_flashdata("regnama", $namaTK);

            $this->load->model('m_upload_berkas');
            $this->m_upload_berkas->insert_db_berkas($hdrID);

            $hdridtemp                    = $this->input->post('txtHeaderIDTemp');
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
        if ($this->form_validation->run() == false) {
            $data['message']              = '';
            $this->template->display('registrasi/register/index', $data);
            exit;
        }

        $confirm                          = $this->input->post('txtConfirm'); // ===== deklarasi Confrim Text
        $namaTK                           = LTRIM(strtoupper($this->input->post('txtNama'))); // ===== deklarasi Nama Pelama)r

        // ===== cek KeadaanFisik
        if ($this->input->post('txtKeadaanFisik') === 'CACAT' || $this->input->post('txtKeadaanFisik') === 'cacat') {
            $cacatapa                     = strtoupper($this->input->post('txtCacatApa'));
        } else {
            $cacatapa                     = 'TIDAK ADA';
        }
        // ===== cek Penyakit
        if ($this->input->post('txtPernahPenyakit') === 'YA') {
            $penyakitapa                  = strtoupper($this->input->post('txtPenyakit'));
        } else {
            $penyakitapa                  = 'TIDAK ADA';
        }
        // ===== cek Tato
        if ($this->input->post('txtBertato') === 'YA') {
            $tatoDimana                   = strtoupper($this->input->post('txtTatoDimana'));
        } else {
            $tatoDimana                   = 'TIDAK ADA';
        }
        // ===== cek Kriminal
        if ($this->input->post('txtPernahKriminal') === 'YA') {
            $perkaraapa                   = strtoupper($this->input->post('txtKriminal'));
        } else {
            $perkaraapa                   = 'TIDAK ADA';
        }
        // ===== cek Jumlah Anak
        if ($this->input->post('txtJumlahAnak') === '') {
            $jumlahanak                   = '';
        } else {
            $jumlahanak                   = $this->input->post('txtJumlahAnak');
        }
        // ===== cek Jurusan
        if ($this->input->post('txtJurusan') == '') {
            $jurusan                      = '-';
        } else {
            $jurusan                      = strtoupper($this->input->post('txtJurusan'));
        }

        $namaAnak                         = $this->input->post('txtNamaAnak');
        $itungAnak                        = $this->cekAnak($namaAnak);
        $jmlAnak                          = $this->input->post('txtJumlahAnak');

        if ($jmlAnak == "") {
            if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
                $anak                     = 0;
            } elseif ($namaAnak == "") {
                $anak                     = 0;
            } elseif ($itungAnak > 0) {
                $anak                     = $itungAnak;
            } else {
                $anak                     = 0;
            }
        } elseif ($jmlAnak > 0) {
            if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS') {
                $anak                     = 0;
            } elseif ($namaAnak == "") {
                $anak                     = 0;
            } else {
                $anak                     = $itungAnak;
            }
        } else {
            $anak                         = $itungAnak;
        }

        $pasangan                         = $this->input->post('txtNamaPasangan');
        if (strtoupper($this->input->post('txtStatus')) == 'BUJANG' || strtoupper($this->input->post('txtStatus')) == 'GADIS' || $pasangan == '') {
            $tglPasangan                  = NULL;
        } else {
            $tglPasangan                  = date('Y-m-d', strtotime($this->input->post('txtTglLahirPasangan')));
        }

        if ($this->input->post('txtShcool') == "") {
            $univ                         = $this->input->post('txtUniv');
        } else {
            $univ                         = $this->input->post('txtShcool');
        }

        if ($this->input->post('txtNilai') == "") {
            $ipk                          = $this->input->post('txtIPK');
        } else {
            $ipk                          = $this->input->post('txtNilai');
        }

        if (strtoupper($this->input->post('txtPendidikan')) == 'TIDAK SEKOLAH') {
            $pendidikan                   = "NaN";
        } else {
            $pendidikan                   = strtoupper($this->input->post('txtPendidikan'));
        }

        // ===== cek Vaksin
        $TanggalVaksin                    = $this->input->post('txtTanggalVaksin');
        $TanggalVaksin2                   = $this->input->post('txtTanggalVaksin2');
        $TanggalVaksin3                   = $this->input->post('txtTanggalVaksin3');
        if ($this->input->post('txtVaksin') === 'SUDAH') {
            $Vaksin                       = $this->input->post('txtVaksin');
            $JenisVaksin                  = strtoupper($this->input->post('txtJenisVaksin'));
            if ($TanggalVaksin != '') {
                $TanggalVaksin            = date('Y-m-d', strtotime($TanggalVaksin));
            } else {
                $TanggalVaksin            = NULL;
            }
            if ($TanggalVaksin2 != '') {
                $TanggalVaksin2           = date('Y-m-d', strtotime($TanggalVaksin2));
            } else {
                $TanggalVaksin2           = NULL;
            }
            if ($TanggalVaksin3 != '') {
                $TanggalVaksin3           = date('Y-m-d', strtotime($TanggalVaksin3));
            } else {
                $TanggalVaksin3           = NULL;
            }
        } else {
            $Vaksin                       = 'BELUM';
            $JenisVaksin                  = 'TIDAK ADA';
            $TanggalVaksin                = NULL;
            $TanggalVaksin2               = NULL;
            $TanggalVaksin3               = NULL;
        }

        $info                             = array(
            'CVNama'                        => $this->input->post('txtPerusahaan'),
            'Pemborong'                     => $this->input->post('txtPemborong'),
            'Nama'                          => LTRIM(strtoupper($this->input->post('txtNama'))),
            'Tgl_Lahir'                     => date('Y-m-d', strtotime($this->input->post('txtTanggalLahir'))),
            'Tempat_Lahir'                  => strtoupper($this->input->post('txtTempatLahir')),
            'NamaIbuKandung'                => strtoupper($this->input->post('txtNamaIbu')),
            'BeratBadan'                    => $this->input->post('txtBeratBadan'),
            'TinggiBadan'                   => $this->input->post('txtTinggiBadan'),
            'Agama'                         => strtoupper($this->input->post('txtAgama')),
            'Suku'                          => strtoupper($this->input->post('txtSuku')),
            'Jenis_Kelamin'                 => strtoupper($this->input->post('txtJekel')),
            'Pendidikan'                    => $pendidikan,
            'Jurusan'                       => $jurusan,
            'Universitas'                   => $univ,
            'IPK'                           => $ipk,
            'Status_Personal'               => strtoupper($this->input->post('txtStatus')),
            'No_Ktp'                        => $this->input->post('txtNoKTP'),
            'No_KK'                         => $this->input->post('txtNoKK'),
            'Alamat_KTP'                    => strtoupper($this->input->post('txtAlamatKTP')),
            'Alamat'                        => strtoupper($this->input->post('txtAlamat')),
            'RT'                            => $this->input->post('txtRT'),
            'RW'                            => $this->input->post('txtRW'),
            'Kelurahan'                     => strtoupper($this->input->post('txtKelurahan')),
            'TinggalDengan'                 => $this->input->post('txtTinggalDengan'),
            'HubunganDenganTK'              => $this->input->post('txtHubungan'),
            'NoHP'                          => $this->input->post('txtNoPonsel'),
            'Daerah_Asal'                   => strtoupper($this->input->post('txtDaerahAsal')),
            'PernahKerja'                   => strtoupper($this->input->post('txtPernahRSUP')),
            'KerjaDi'                       => strtoupper($this->input->post('txtBagian')),
            'Kriminal'                      => $this->input->post('txtPernahKriminal'),
            'PerkaraApa'                    => $perkaraapa,
            'JumlahAnak'                    => $anak,
            'NamaSuamiIstri'                => strtoupper($this->input->post('txtNamaPasangan')),
            'TglLahirSuamiIstri'            => $tglPasangan,
            'PekerjaanSuamiIstri'           => strtoupper($this->input->post('txtPekerjaanPasangan')),
            'AlamatSuamiIstri'              => strtoupper($this->input->post('txtAlamatPasangan')),
            'NamaBapak'                     => strtoupper($this->input->post('txtNamaBapak')),
            'ProfesiOrangTua'               => strtoupper($this->input->post('txtPekerjaanOrtu')),
            'JumlahSaudara'                 => $this->input->post('txtJumlahSaudara'),
            'AnakKe'                        => $this->input->post('txtAnakKe'),
            'BahasaDaerah'                  => strtoupper($this->input->post('txtBahasaDaerah')),
            'TahunMasuk'                    => $this->input->post('txtTahunMasuk'),
            'TahunLulus'                    => $this->input->post('txtTahunLulus'),
            'Hobby'                         => strtoupper($this->input->post('txtHobby')),
            'KegiatanEkstra'                => $this->input->post('txtKegiatanEkstra'),
            'KegiatanOrganisasi'            => $this->input->post('txtOrgnanisasi'),
            'KeadaanFisik'                  => $this->input->post('txtKeadaanFisik'),
            'CacatApa'                      => $cacatapa,
            'PernahIdapPenyakit'            => $this->input->post('txtPernahPenyakit'),
            'PenyakitApa'                   => $penyakitapa,
            'PengalamanKerja'               => $this->input->post('txtPengalamanKerja'),
            'Keahlian'                      => $this->input->post('txtKeahlian'),
            'PernahKerjaDiSambu'            => $this->input->post('txtPernahRSUP'),
            'KerjadiBagian'                 => strtoupper($this->input->post('txtBagian')),
            'Bertato'                       => $this->input->post('txtBertato'),
            'TatoDimana'                    => $tatoDimana,
            'Bertindik'                     => $this->input->post('txtBertindik'),
            'SediaPotongRambut'             => $this->input->post('txtRambutPendek'),
            'Sediadiberhentikan'            => $this->input->post('txtBerhentikan'),
            'AccountFacebook'               => $this->input->post('txtFacebook'),
            'AccountTwitter'                => $this->input->post('txtTwitter'),
            'Account_email'                 => $this->input->post('txtgmail'),
            'CreatedBy'                     => strtoupper($this->session->userdata('username')),
            'CreatedDate'                   => date('Y-m-d H:i:s'),
            'InputOnline'                   => 1,
            'RegisteredBy'                  => strtoupper($this->session->userdata('userid')),
            'RegisteredDate'                => date('Y-m-d H:i:s'),
            'ProvinsiID'                    => $this->input->post('txtProvinsi'),
            'KabKotaID'                     => $this->input->post('txtKabupaten'),
            'KecamatanID'                   => $this->input->post('txtKecamatan'),
            'Kerabat_Nama'                  => $this->input->post('txtkerabatterdekat'),
            'Kerabat_Telepon'               => $this->input->post('txtnohpkerabat'),
            'Kerabat_Hubungan'              => $this->input->post('txthubungan'),
            'AhliWaris_Nama'                => $this->input->post('txtAhliWaris'),
            'AhliWaris_Jekel'               => $this->input->post('txtJekelAhliWaris'),
            'AhliWaris_Hubungan'            => $this->input->post('txtHubunganAhliWaris'),
            'AhliWaris_NoHP'                => $this->input->post('txtnohpkerabatAhliWaris'),
            'AhliWaris_Alamat'              => $this->input->post('txtAlamatAhliWaris'),
            'Vaksin'                        => $Vaksin,
            'JenisVaksin'                   => $JenisVaksin,
            'TanggalVaksin'                 => $TanggalVaksin,
            'TanggalVaksin2'                => $TanggalVaksin2,
            'TanggalVaksin3'                => $TanggalVaksin3
        );

        $adaKeluarga                      = $this->input->post('txtAdaKeluarga');
        if ($adaKeluarga == 'YA') {
            $jumkel                       = count($this->input->post('kelnama'));
        } else {
            $jumkel                       = 0;
        }
        $kelnama                          = $this->input->post('kelnama');
        $kelbagian                        = $this->input->post('kelbagian');
        $kelpemborong                     = $this->input->post('kelpemborong');
        $kelhubungan                      = $this->input->post('kelhubungan');
        $kelalamat                        = $this->input->post('kelalamat');

        $annama                           = $this->input->post('txtNamaAnak');
        $antempatlahir                    = $this->input->post('txtTempatLahirAnak');
        $antgllahir                       = $this->input->post('txtTanggalLahirAnak');
        $anjeniskelamin                   = $this->input->post('txtJekelAnak');
        $analamat                         = $this->input->post('txtAlamatAnak');

        $pemborong                        = strtoupper($this->input->post('txtPemborong'));
        $tglLahir                         = date('Y-m-d', strtotime($this->input->post('txtTanggalLahir')));
        $namaIbu                          = strtoupper($this->input->post('txtNamaIbu'));
        $namaAyah                         = strtoupper($this->input->post('txtNamaBapak'));


        // ====== KONFIRMASI
        if ($confirm == 0) {
            $cekTK                        = $this->m_register->cekRegTK($pemborong, $tglLahir, $namaIbu, $namaAyah);
            $cekTKAktif                   = $this->m_register->cekRegAktif($tglLahir, $namaIbu, $namaAyah);
            $cekTKPem                     = $this->m_register->cekRegTKPem($pemborong, $tglLahir, $namaIbu, $namaAyah);
            $cekScreen                    = $this->m_register->cekRegScreeningReject($tglLahir, $namaIbu, $namaAyah);
            $cekInTemp                    = $this->m_register->cekRegInTemp($tglLahir, $namaIbu, $namaAyah);

            if ($cekScreen == true) {
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
            }*/ elseif ($cekTKPem == true) {
                $hdridtemp                = $this->m_register->simpanTKTemp($info);

                for ($i = 0; $i < $jumkel; $i++) {
                    $infokel              = array(
                        'HeaderID'          => 0,
                        'HeaderIDTemp'      => $hdridtemp,
                        'Nama'              => strtoupper($kelnama[$i]),
                        'Departemen'        => strtoupper($kelbagian[$i]),
                        'Pemborong'         => strtoupper($kelpemborong[$i]),
                        'HubunganKeluarga'  => strtoupper($kelhubungan[$i]),
                        'Alamat'            => strtoupper($kelalamat[$i])
                    );
                    if (!$kelnama[$i] == '') {
                        $this->simpan_datakeluarga(0, $hdridtemp, $kelnama[$i], $infokel);
                    }
                }

                for ($i = 0; $i < $anak; $i++) {
                    if (is_array($annama) && array_key_exists($i, $annama)) {
                        $infoanak         = array(
                            'HeaderID'      => 0,
                            'HeaderIDTemp'  => $hdridtemp,
                            'Nama'          => strtoupper($annama[$i]),
                            'TempatLahir'   => strtoupper($antempatlahir[$i]),
                            'TglLahir'      => date('Y-m-d', strtotime($antgllahir[$i])),
                            'JenisKelamin'  => strtoupper($anjeniskelamin[$i]),
                            'Alamat'        => strtoupper($analamat[$i]),
                            'CreatedBy'     => strtoupper($this->session->userdata('userid')),
                            'CreatedDate'   => date('Y-m-d H:i:s')
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
                $hdrID                    = $this->m_register->simpanTK($info);

                // === Cek Data Anak, Jika Ada Disimpan
                for ($i = 0; $i < $anak; $i++) {
                    if (is_array($annama) && array_key_exists($i, $annama)) {
                        $infoanak         = array(
                            'HeaderID'      => $hdrID,
                            'HeaderIDTemp'  => 0,
                            'Nama'          => strtoupper($annama[$i]),
                            'TempatLahir'   => strtoupper($antempatlahir[$i]),
                            'TglLahir'      => date('Y-m-d', strtotime($antgllahir[$i])),
                            'JenisKelamin'  => strtoupper($anjeniskelamin[$i]),
                            'Alamat'        => strtoupper($analamat[$i]),
                            'CreatedBy'     => strtoupper($this->session->userdata('userid')),
                            'CreatedDate'   => date('Y-m-d H:i:s')
                        );
                        if (!$annama[$i] == '') {
                            $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
                        }
                    }
                }
                // === Cek Data Keluarga, Jika Ada Simpan
                for ($i = 0; $i < $jumkel; $i++) {
                    $infokel              = array(
                        'HeaderID'            => $hdrID,
                        'HeaderIDTemp'        => 0,
                        'Nama'                => strtoupper($kelnama[$i]),
                        'Departemen'          => strtoupper($kelbagian[$i]),
                        'Pemborong'           => strtoupper($kelpemborong[$i]),
                        'HubunganKeluarga'    => strtoupper($kelhubungan[$i]),
                        'Alamat'              => strtoupper($kelalamat[$i])
                    );
                    if (!$kelnama[$i] == '') {
                        $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
                    }
                }

                $this->session->set_flashdata("regid", $hdrID);
                $this->session->set_flashdata("regnama", $namaTK);

                $this->load->model('m_upload_berkas');
                $this->m_upload_berkas->insert_db_berkas($hdrID);

                redirect('registrasi/uploadFoto');
            }
        } elseif ($confirm == 1) {
            $this->load->model('m_register');
            $hdrID  = $this->m_register->simpanTK($info);
            $hdridtemp = '';

            // === Cek Data Anak, Jika Ada Disimpan
            for ($i = 0; $i < $anak; $i++) {
                if (is_array($annama) && array_key_exists($i, $annama)) {
                    $infoanak             = array(
                        'HeaderID'      => $hdrID,
                        'HeaderIDTemp'  => $hdridtemp,
                        'Nama'          => strtoupper($annama[$i]),
                        'TempatLahir'   => strtoupper($antempatlahir[$i]),
                        'TglLahir'      => $antgllahir[$i],
                        'JenisKelamin'  => strtoupper($anjeniskelamin[$i]),
                        'Alamat'        => strtoupper($analamat[$i]),
                        'CreatedBy'     => strtoupper($this->session->userdata('userid')),
                        'CreatedDate'   => date('Y-m-d H:i:s')
                    );
                    if (!$annama[$i] == '') {
                        $this->simpan_dataanak($hdrID, 0, $annama[$i], $infoanak);
                    }
                }
            }
            // === Cek Data Keluarga, Jika Ada Simpan
            for ($i = 0; $i < $jumkel; $i++) {
                $infokel                  = array(
                    'HeaderID'      => $hdrID,
                    'HeaderIDTemp'    => $hdridtemp,
                    'Nama'          => strtoupper($kelnama[$i]),
                    'Departemen'    => strtoupper($kelbagian[$i]),
                    'Pemborong'     => strtoupper($kelpemborong[$i]),
                    'HubunganKeluarga'  => strtoupper($kelhubungan[$i]),
                    'Alamat'        => strtoupper($kelalamat[$i])
                );
                if (!$kelnama[$i] == '') {
                    $this->simpan_datakeluarga($hdrID, 0, $kelnama[$i], $infokel);
                }
            }

            $this->session->set_flashdata("regid", $hdrID);
            $this->session->set_flashdata("regnama", $namaTK);

            $this->load->model('m_upload_berkas');
            $this->m_upload_berkas->insert_db_berkas($hdrID);

            $hdridtemp                    = $this->input->post('txtHeaderIDTemp');
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
            $data['pesan']  = 'anotherPemborong';
        } elseif ($msg == 2) {
            $data['pesan']   = 'karyawanAktif';
        } elseif ($msg == 3) {
            $data['pesan']  = 'calonInTemp';
        } elseif ($msg == 4) {
            $data['pesan'] = 'calonGagalScreen';
        }

        $data['namatk']  = $this->session->flashdata("namatk");
        $this->session->keep_flashdata("namatk");

        $this->template->display("registrasi/register/tolak", $data);
    }

    function konfirmasi($hdridtemp)
    {
        $this->load->model('m_register');
        $hdridtemp                        = $this->session->flashdata('hdrIDTemp');
        $this->session->keep_flashdata("hdrIDTemp");
        $datatk_temp                      = $this->m_register->get_datatk_temp($hdridtemp)->result();

        foreach ($datatk_temp as $row) :
            $arrhidden                    = array(
                'txtConfirm'           => "1",
                'txtHeaderIDTemp'      => $row->HeaderIDTemporary,
                'txtPerusahaan'        => $row->CVNama,
                'txtPemborong'         => $row->Pemborong,
                'txtNama'              => $row->Nama,
                'txtTanggalLahir'      => $row->Tgl_Lahir,
                'txtTempatLahir'       => $row->Tempat_Lahir,
                'txtNamaIbu'           => $row->NamaIbuKandung,
                'txtBeratBadan'        => $row->BeratBadan,
                'txtTinggiBadan'       => $row->TinggiBadan,
                'txtAgama'             => $row->Agama,
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
                'txtgmail'             => $row->Account_email
            );

            $namaIBU                      = strtoupper($row->NamaIbuKandung);
            $tglLahir                     = $row->Tgl_Lahir;
            $namaTK                       = $row->Nama;
        endforeach;

        $data['title']                    = "Register Tenaga Kerja Baru";
        $data['hdridtemp']                = $hdridtemp;
        $data['arrhidden']                = $arrhidden;

        $data['datapelamar']              = $this->m_register->pernahReg($tglLahir, $namaIBU)->result();
        $data['nama']                     = $namaTK;
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
        $detailid                         = $this->m_register->cek_datakeluarga($hdrID, $hdridtemp, $kelnama);

        if ($detailid == 0) {
            $this->m_register->simpan_datakeluarga($infokel);
        } else {
            $this->m_register->update_datakeluarga($detailid, $infokel);
        }
    }

    function simpan_dataanak($hdrID, $hdridtemp, $anaknama, $infoanak)
    {
        $detailid                         = $this->m_register->cek_dataanak($hdrID, $hdridtemp, $anaknama);

        if ($detailid == 0) {
            $this->m_register->simpan_dataanak($infoanak);
        } else {
            $this->m_register->update_dataanak($detailid, $infoanak);
        }
    }

    function uploadFoto()
    {
        //$this->load->model('m_registrasi');
        $hdrID                            = $this->session->flashdata("regid");
        $nama                             = $this->session->flashdata("regnama");

        $this->session->keep_flashdata("regid");
        $this->session->keep_flashdata("regnama");
        $data['hdrid']                    = $hdrID;
        $data['namapelamar']              = $nama;
        $data['errormsg']                 = "";

        $this->template->display('registrasi/register/upload_foto', $data);
    }

    function uploadAksi()
    {
        $this->load->model('m_register');
        $this->load->library('image_moo');

        $url                              = './dataupload/foto/';
        $hdrID                            = $this->input->post("txtHeaderID");
        $namapelamar                      = $this->input->post("txtNamaPelamar");
        $filefoto                         = $hdrID;

        $config['upload_path']            = $url;
        $config['allowed_types']          = 'jpeg|jpg|png|gif';
        $config['allow_scale_up']         = true;
        $config['overwrite']              = true;
        $config['max_size']               = '0';
        $config['file_name']              = $filefoto . '.jpg';    //Filename harus pakai headerID pelamar

        $font                             = "./assets/DroidSans.ttf";
        $watermarkbg                      = "./assets/watermarkbg.png";

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('fileFoto1') == "") {
            $file                         = $this->upload->do_upload('fileFoto2');
        } else {
            $file                         = $this->upload->do_upload('fileFoto1');
        }
        if ($file) {
            $files                        = $this->upload->data();
            $fileNameResize               = $config['upload_path'] . $files['file_name'];


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
                ->save($fileNameResize, true);

            if ($this->image_moo->errors) {
                $error                    = $files['file_name'] . "<br/>" . $this->image_moo->display_errors();
                $data['errormsg']         = "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Image Moo Failed</strong><br/>$error</div>";
                $data['hdrid']            = $hdrID;
                $data['namapelamar']      = $namapelamar;

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
            $error                        = $this->upload->display_errors();
            $data['errormsg']             = "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Unggah Foto Gagal</strong><br/>$error</div>";
            $data['hdrid']                = $hdrID;
            $data['namapelamar']          = $namapelamar;

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
        $this->form_validation->set_rules('txtPerusahaan', 'Perusahaan', 'required|max_length[50]');
        $this->form_validation->set_rules('txtNama', 'Nama', 'required|max_length[50]');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>", "</div>");
    }

    function getkabupaten()
    {
        $this->load->model('m_register');
        $prov                             = $this->input->get('idprov');
        $data                             = $this->m_register->getKabupaten($prov);
        echo json_encode(array('data' => $data->result_array(), 'err' => 0));
    }

    function getkecamatan()
    {
        $this->load->model('m_register');
        $prov                             = $this->input->get('idprov');
        $kab                              = $this->input->get('idkab');
        $data                             = $this->m_register->getkecamatan($prov, $kab);
        echo json_encode(array('data' => $data->result_array(), 'err' => 0));
    }

    function getDept()
    {
        $this->load->model('m_register');
        $div                              = $this->input->get('iddiv');
        $data                             = $this->m_register->getDept1($div);
        echo json_encode(array('data' => $data->result_array(), 'err' => 0));
    }

    function calonkandidat()
    {
        $this->load->model('m_register');
        $data['_getDept']                 = $this->m_register->getDept();
        $data['_getDiv']                  = $this->m_register->getDept();
        $data['_getPendidikan']           = $this->m_register->getPendidikan();
        $data['_getJurusan']              = $this->m_register->getJurusan();
        $data['_addjs']                   = array('plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.js');
        $this->template->display('registrasi/calon_kandidat/index', $data);
    }

    function simpanCK()
    {
        $nama                             = TRIM(strtoupper($this->input->post('txtNama')));
        $jk                               = $this->input->post('selJK');
        $tmplahir                         = strtoupper($this->input->post('txtTempatL'));
        $tgllahir                         = date('Y-m-d', strtotime($this->input->post('txtTglL')));
        $noktp                            = $this->input->post('txtNo_Ktp');
        $nohp                             = $this->input->post('txtNoHP');
        $email                            = $this->input->post('txtEmail');
        $pendidikan                       = $this->input->post('selPendidikan');
        $jurusan                          = $this->input->post('selJurusan');
        $jadwaltest                       = $this->input->post('txtJadwal');
        $keterangan                       = $this->input->post('txtKeterangan');
        $status                           = $this->input->post('selSts');
        $ststest                          = $this->input->post('selStsT');
        $transport                        = $this->input->post('selTransport');
        $biaya                            = $this->input->post('txtBiaya');
        $sumberpelamar                    = $this->input->post('txtSumberPelamar');
        $posisi                           = $this->input->post('txtPosisi');
        $level                            = $this->input->post('txtLevel');
        $dept                             = $this->input->post('selDept');
        $divisi                           = $this->input->post('selDivisi');
        $creteby                          = strtoupper($this->session->userdata('username'));
        $cretedate                        = date('Y-m-d H:i:s');

        $data                             = array(
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
            'CreatedDate'   => $cretedate
        );
        $header                           = $this->m_register->saveCK($data);
        if ($header['status'] == FALSE) {
            $this->session->set_flashdata('_message', $header['data']);
            redirect(base_url('Registrasi/calonkandidat?err=header'));
            return;
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('Registrasi/calonkandidat?success=ok'));
    }

    // function simpanDataCK(){
    // 	$data= array(
    //            'Nama'          => LTRIM(strtoupper($this->input->post('txtNama'))),
    //            'JK'            => $this->input->post('selJK'),
    //            'Tempat_Lhr'    => strtoupper($this->input->post('txtTempatL')),
    //            'Tanggal_Lhr'   => date('Y-m-d', strtotime($this->input->post('txtTglL'))),
    //            'NoKTP'         => $this->input->post('txtNo_Ktp'),
    //            'NoHP'          => $this->input->post('txtNoHP'),
    //            'Email'         => $this->input->post('txtEmail'),
    //            'Pendidikan'    => $this->input->post('selPendidikan'),
    //            'Jurusan'       => $this->input->post('selJurusan'),
    //            'JadwalTest'    => $this->input->post('txtJadwal'),
    //            'Keterangan'    => $this->input->post('txtKeterangan'),
    //            'Status'        => $this->input->post('selSts'),
    //            'StsTest'       => $this->input->post('selStsT'),
    //            'Transport'     => $this->input->post('selTransport'),
    //            'Biaya'         => $this->input->post('txtBiaya'),
    //            'SumberPelamar' => $this->input->post('txtSumberPelamar'),
    //            'CreatedBy'     => strtoupper($this->session->userdata('username')),
    //            'CreatedDate'   => date('Y-m-d H:i:s')
    //        );
    //        $this->load->model('m_register');
    //        $header = $this->m_register->saveCK($data);
    //        if($header['status'] == FALSE){
    //            $this->session->set_flashdata('_message',$header['data']);
    //            redirect(base_url('Registrasi/calonkandidat?err=header'));
    //            return;
    //        }
    //        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
    //        redirect(base_url('Registrasi/calonkandidat?success=ok'));
    // }

    function editDataCK()
    {
        if ('IS_AJAX') {
            $kode                         = $this->input->post('kode');
            $this->load->model('m_register');
            $data['_getDept']             = $this->m_register->getDept();
            $data['_getDiv']              = $this->m_register->getDept();
            $data['_getPendidikan']       = $this->m_register->getPendidikan();
            $data['_getJurusan']          = $this->m_register->getJurusan();
            $data['_addjs']               = array('plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.js');
            $data['data']                 = $this->m_register->getDataCK($kode)->result();
            $this->load->view('registrasi/calon_kandidat/edit', $data);
        }
    }

    function updateDataCK()
    {
        $data                             = array(
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
            'UpdatedDate'   => date('Y-m-d H:i:s')
        );
        $id_ck                            = array('id' => $this->input->get('id'));
        $this->load->model('m_register');
        $header                           = $this->m_register->updateCK($id_ck, $data);

        if ($header) {
            redirect('Monitor/calonkandidat?msg=success_edit');
        } else {
            redirect('Monitor/calonkandidat?msg=failed_edit');
        }
    }

    function cekTK()
    {
        $nama    = TRIM(preg_replace('/\s\s+/', ' ', $this->input->post('nama')));
        $nama1   = TRIM(preg_replace('/[^a-zA-Z]/', ' ', $nama)); // Nama sudah clean dari karakter selain alphabet
        $ibu     = TRIM($this->input->post('ibu'));
        // $cekNama = $this->m_register->cekNama($nama1);

        $where    = array('Nama' => $nama, 'NamaIbuKandung' => $ibu);
        $data     = $this->m_register->cekTK($where);

        $response = '';
        foreach ($data as $key) {
            $response .= '<tr>
                            <th >#</th>
                            <th >' . $key->Nama . '</th> 
                            <th>' . $key->TglKeluar . '</th>
                            <th >' . $key->Remark . '</th>
                          </tr>';
        }
        echo $response;
    }
}

/* End of file registrasi.php */
/* Location: ./application/controllers/registrasi.php */