<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updatereg extends CI_Controller{
	
    public function __construct(){
        parent::__construct();
        $this->load->model(array('darurat','m_updatereg'));
        $this->load->helper(array('form', 'url', 'inflector'));


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
	
    function EditReg(){
        $hdrid = $this->uri->segment(3);
        $data['getData']            = $this->m_updatereg->getDataRegistrasi($hdrid);
        $data['_getSuku']           = $this->m_updatereg->getSuku();
        $data['_getAgama']          = $this->m_updatereg->getAgama();
        $data['_getJurusan']        = $this->m_updatereg->getJurusan();
        $data['_getPendidikan']     = $this->m_updatereg->getPendidikan();
        $data['_getStatusKawin']    = $this->m_updatereg->getStatusKawin();
        $data['_getProvinsi']       = $this->m_updatereg->get_mstProvinsi();
        $data['_getKabupatenKota']  = $this->m_updatereg->get_KabupatenKota();
        $data['_getKecamatan']      = $this->m_updatereg->get_Kecamatan();
        $idpemborong = $this->session->userdata('idpemborong');
        $data['_getPemborong']= $this->m_updatereg->get_pemborong_bygroup($idpemborong)->result();
        $data['_getDataanak']       = $this->m_updatereg->getDataanak();
        $data['_getKeluarga']       = $this->m_updatereg->get_Keluarga($hdrid);

        $this->template->display('transaksi/monitorpelamar/edit',$data);
    }

    function updateData(){
        
        $hdrid                   = $this->input->post('txtHeaderID');
        $tesmasuk                = $this->input->post('txtTesMasuk');
        $pemborongid             = $this->input->post('txtpemborongid');
        $pemborong               = $this->input->post('txtPemborong');
        $namacv                  = $this->input->post('txtPerusahaan');
        $nama                    = $this->input->post('txtNama');
        $noktp                   = $this->input->post('txtNoKTP');
        $alamat                  = $this->input->post('txtAlamat');
        $rt                      = $this->input->post('txtRT');
        $rw                      = $this->input->post('txtRW');
        $tinggaldengan           = $this->input->post('txtTinggalDengan');
        $hubdengancalonpelamar   = $this->input->post('txtHubungan');
        $nohp                    = $this->input->post('txtNoPonsel');
        $notlpalternatif         = $this->input->post('txtNoTelpAlternatif');
        $tempatlahir             = $this->input->post('txtTempatLahir');
        $tanggalLahir            = $this->input->post('txtTanggalLahir');
        $jeniskelamin            = $this->input->post('txtJekel');
        $tinggibadan             = $this->input->post('txtTinggiBadan');
        $beratbadan              = $this->input->post('txtBeratBadan');
        $suku                    = $this->input->post('txtSuku');
        $daerahasal              = $this->input->post('txtDaerahAsal');
        $kecamatanasal           = $this->input->post('txtKecamatanID');
        $kabupatenasal           = $this->input->post('txtKabupatenKotaID');
        $provinsiasal            = $this->input->post('txtProvinsiID');
        $bahasadaerah            = $this->input->post('txtBahasaDaerah');
        $agama                   = $this->input->post('txtAgama');
        $statuspersonal          = $this->input->post('txtStatus');
        $namapasangan            = $this->input->post('txtNamaPasangan');
        $tgllahirpasangan        = $this->input->post('txtTglLahirPasangan');
        $pekerjaanpasangan       = $this->input->post('txtPekerjaanPasangan');
        $alamatpasangan          = $this->input->post('txtAlamatPasangan');
        $jumlahanak              = $this->input->post('txtJumlahAnak');
        $namabpkkandung          = $this->input->post('txtNamaBapak');
        $namaibukandung          = $this->input->post('txtNamaIbu');
        $profesiorangtua         = $this->input->post('txtPekerjaanOrtu');
        $jumlahsaudara           = $this->input->post('txtJumlahSaudara');
        $anakke                  = $this->input->post('txtAnakKe');
        $pendidikan              = $this->input->post('txtPendidikan');
        $jurusan                 = $this->input->post('txtJurusan');
        $namasekolah             = $this->input->post('txtShcool');
        $nilairatarata           = $this->input->post('txtNilai');
        $namauniv                = $this->input->post('txtUniv');
        $ipk                     = $this->input->post('txtIPK');
        $thnmasuk                = $this->input->post('txtTahunMasuk');
        $thnlulus                = $this->input->post('txtTahunLulus');
        $pengalamankerja         = $this->input->post('txtPengalamanKerja');
        $keahlianktrampilan      = $this->input->post('txtKeahlian');
        $pernahkerja             = $this->input->post('txtPernahRSUP');
        $bagiandept              = $this->input->post('txtBagian');
        $hobby                   = $this->input->post('txtHobby');
        $kegiatanextra           = $this->input->post('txtKegiatanEkstra');
        $kegiatanorganisasi      = $this->input->post('txtOrgnanisasi');
        $keadaanfisik            = $this->input->post('txtKeadaanFisik');
        $mengidappenyakit        = $this->input->post('txtPernahPenyakit');
        $ketpenyakit             = $this->input->post('txtPenyakit');
        $terlibatkriminal        = $this->input->post('txtPernahKriminal');
        $ketkriminal             = $this->input->post('txtKriminal');
        $bertato                 = $this->input->post('txtBertato');
        $bertindik               = $this->input->post('txtBertindik');
        $bersediapotongrambut    = $this->input->post('txtRambutPendek');
        $bersediadiberhentikan   = $this->input->post('txtBerhentikan');
        $facebook                = $this->input->post('txtFacebook');
        $twitter                 = $this->input->post('txtTwitter');
        $instagram               = $this->input->post('txtInstagram');

        $data = array(
            'CVNama'                => $namacv,
            'IDPemborong'           => $pemborongid,
            'Pemborong'             => $pemborong,
            'Nama'                  => $nama,
            'Tgl_Lahir'             => $tanggalLahir,
            'Tempat_Lahir'          => $tempatlahir,
            'NamaIbuKandung'        => $namaibukandung,
            'BeratBadan'            => $beratbadan,
            'TinggiBadan'           => $tinggibadan,
            'Agama'                 => $agama,
            'Suku'                  => $suku,
            'Jenis_Kelamin'         => $jeniskelamin,
            'Pendidikan'            => $pendidikan,
            'Jurusan'               => $jurusan,
            'Status_Personal'       => $statuspersonal,
            'No_Ktp'                => $noktp,
            'Alamat'                => $alamat,
            'RT'                    => $rt,
            'RW'                    => $rw,
            'TinggalDengan'         => $tinggaldengan,
            'HubunganDenganTK'      => $hubdengancalonpelamar,
            'NoHP'                  => $nohp,
            'Daerah_Asal'           => $daerahasal,
            'PernahKerjaDiSambu'    => $pernahkerja,
            'KerjadiBagian'         => $bagiandept,
            'Kriminal'              => $terlibatkriminal,
            'PerkaraApa'            => $ketkriminal,
            'JumlahAnak'            => $jumlahanak,
            'NamaSuamiIstri'        => $namapasangan,
            'TglLahirSuamiIstri'    => $tgllahirpasangan,
            'PekerjaanSuamiIstri'   => $pekerjaanpasangan,
            'AlamatSuamiIstri'      => $alamatpasangan,
            'NamaBapak'             => $namabpkkandung,
            'ProfesiOrangTua'       => $profesiorangtua,
            'JumlahSaudara'         => $jumlahsaudara,
            'AnakKe'                => $anakke,
            'BahasaDaerah'          => $bahasadaerah,
            'Universitas'           => $namasekolah,
            'Universitas'           => $namauniv,
            'IPK'                   => $nilairatarata,
            'IPK'                   => $ipk,
            'TahunMasuk'            => $thnmasuk,
            'TahunLulus'            => $thnlulus,
            'Hobby'                 => $hobby,
            'KegiatanEkstra'        => $kegiatanextra,
            'KegiatanOrganisasi'    => $kegiatanorganisasi,
            'KeadaanFisik'          => $keadaanfisik,
            'PernahIdapPenyakit'    => $mengidappenyakit,
            'PenyakitApa'           => $ketpenyakit,
            'PengalamanKerja'       => $pengalamankerja,
            'Keahlian'              => $keahlianktrampilan,
            'AccountFacebook'       => $facebook,
            'AccountTwitter'        => $twitter,
            'Bertato'               => $bertato,
            'Bertindik'             => $bertindik,
            'SediaPotongRambut'     => $bersediapotongrambut,
            'Sediadiberhentikan'    => $bersediadiberhentikan,
            'AccountInstagram'      => $instagram,
            'KecamatanID'           => $kecamatanasal,
            'Kabupaten_KotaID'      => $kabupatenasal,
            'ProvinsiID'            => $provinsiasal,
            'NoTelpAlternatif'      => $notlpalternatif,
            'TesMasuk'              => $tesmasuk,
            'ketTesMasuk'           => 0,
            'UpdateBy'              => strtoupper($this->session->userdata('userid')),
            'UpdateDate'            => date('Y-m-d : H:i:s'),
        );

        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";
        $this->m_updatereg->get_DataReg($hdrid,$data);
        redirect('updatereg');
    }

    function Statuslulus($id){

        $data = array(
            'ketTesMasuk'       => '1',
            'ketTesMasukBy'     => strtoupper($this->session->userdata('userid')),
            // 'ketTesMasukDate'   => date('Y-m-d : H:i:s')
        );
        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";
        // echo $id;

        $this->m_updatereg->update_lulus($id,$data);
        redirect('verifikasi');
    }

    function StatusGagal($id){

        $data = array(
            'ketTesMasuk'       => '2',
            'ketTesMasukBy'     => strtoupper($this->session->userdata('userid')),
            // 'ketTesMasukDate'   => date('Y-m-d : H:i:s'),
        );
        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";
        // echo $id;

        $this->m_updatereg->update_Gagal($id,$data);
        redirect('Monitorpelamar');
    }

    function StatusTidakMengerjakan($id){

        $data = array(
            'ketTesMasuk'       => '3',
            'ketTesMasukBy'     => strtoupper($this->session->userdata('userid')),
            // 'ketTesMasukDate'   => date('Y-m-d : H:i:s'),
        );
        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";
        // echo $id;

        $this->m_updatereg->update_TidakMengerjakan($id,$data);
        redirect('Monitorpelamar');
    }
     function UpdateCloseData($id){
        $data  = array(
            'CloseData' => 1,
            'CloseBy'   => strtoupper($this->session->userdata('userid')),
            'CloseDate' => date('Y-m-d H:i:s'),
        );
        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";
        // echo $id;

        $this->m_updatereg->Update_CloseData($id,$data);
        redirect('Monitorpelamar');
     }

}