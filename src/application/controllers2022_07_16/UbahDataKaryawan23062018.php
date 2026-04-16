<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class UbahDataKaryawan extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        
        $this->load->model(array('m_update_karyawan','m_register'));
    }
    
    public function index(){
        $hdrID = $this->uri->segment(3);		
        $data['_getData']   = $this->m_update_karyawan->getTK($hdrID);
        $data['_getDataAnak']   = $this->m_update_karyawan->getAnakTK($hdrID);
        $data['_getDataKel']    = $this->m_update_karyawan->getKelTK($hdrID)->result();
        $getKel = $this->m_update_karyawan->getKelTK($hdrID);
        if($getKel->num_rows() > 0 ){
            $setKel = "ADA";
        }  else {
            $setKel = "TIDAK";
        }
        $data['_gelKel']    = $setKel;
		$data['_getprovinsi']= $this->m_register->getProvinsi();
		$data['_getkabupaten']= $this->m_register->getKabupaten($data['_getData'][0]->ProvinsiID)->result();
		$data['_getkecamatan']= $this->m_register->getkecamatan($data['_getData'][0]->ProvinsiID,
		                                                        $data['_getData'][0]->KabKotaID)->result();
        
        $data['_getSuku']   = $this->m_update_karyawan->getSuku();
        $data['_getAgama']  = $this->m_update_karyawan->getAgama();
        $data['_getStatus'] = $this->m_update_karyawan->getStatusKawin();
        $data['_getPendidikan'] = $this->m_update_karyawan->getPendidikan();
        $data['_getJurusan']    = $this->m_update_karyawan->getJurusan();
        $idpemborong = $this->session->userdata('idpemborong');
        $data['_getPSGPemborong'] = $this->m_register->m_register->getPSGPemborong($idpemborong);
        $this->template->display('registrasi/register/editData/ubahData',$data);
    }
    
    function selectPemborong(){
        $this->load->model('m_register');
        if('IS_AJAX') {
            $data['namapt'] = $this->m_register->getPemborong();
            $this->load->view('registrasi/register/editData/perusahaan',$data);
        }
    }
    
    function updateData(){
        // ===== Cek Pemborong
        if($this->input->post('txtPerusahaan') == ''){
            $cv = $this->input->post('txtPerusahaanOld');
            $pbr= $this->input->post('txtPemborongOld');
        }else{
            $cv = $this->input->post('txtPerusahaan');
            $pbr= $this->input->post('txtPemborong');
        }
        
        // ===== cek KeadaanFisik
        if ($this->input->post('txtKeadaanFisik') === 'CACAT'){
                $cacatapa = strtoupper($this->input->post('txtCacatApa'));
        }else{
                $cacatapa = 'TIDAK ADA';
        }
        // ===== cek Penyakit
        if ($this->input->post('txtPernahPenyakit') === 'YA'){
            $penyakitapa = strtoupper($this->input->post('txtPenyakit'));
        }else{
            $penyakitapa = 'TIDAK ADA';
        }
        // ===== cek Kriminalitas
        if ($this->input->post('txtPernahKriminal') === 'YA'){
            $perkaraapa = strtoupper($this->input->post('txtKriminal'));
        }else{
            $perkaraapa = 'TIDAK ADA';
        }
        // ===== cek Tato
        if ($this->input->post('txtBertato') === 'YA'){
                $tatoDimana = strtoupper($this->input->post('txtTatoDimana'));
        }else{
                $tatoDimana = 'TIDAK ADA';
        }
        // ===== cek Jurusan
        $pen    = $this->input->post('txtPendidikan');
        if ($pen == 'TIDAK SEKOLAH' || $pen == 'SD' || $pen == 'SMP' || $pen == 'MTS'){
            $jurusan = '-';
        }else{
            $jurusan = strtoupper($this->input->post('txtJurusan'));
        }
                
        if(strtoupper($this->input->post('txtStatusPersonal'))=='BUJANG' || strtoupper($this->input->post('txtStatusPersonal'))=='GADIS'){
            $tglPasangan = NULL;
        }else{
            $tglPasangan = date('Y-m-d', strtotime($this->input->post('txtTglLahirPasangan')));
        }
        
        if($this->input->post('txtShcool')==""){
            $univ   = $this->input->post('txtUniv');
        }  else {
            $univ   = $this->input->post('txtShcool');
        }
        
        if($this->input->post('txtNilai')==""){
            $ipk    = $this->input->post('txtIPK');
        }  else {
            $ipk    = $this->input->post('txtNilai');
        }
        
        $hrdID  = $this->input->post('txtHeaderID');
        $info   = array(
            'CVNama'                    => $cv,
            'Pemborong'                 => $pbr,
            'Nama'                      => strtoupper($this->input->post('txtNamalengkap')),
            'No_Ktp'                    => strtoupper($this->input->post('txtNoKTP')),
            'Alamat'                    => strtoupper($this->input->post('txtAlamat')),
            'RT'                        => $this->input->post('txtRT'),
            'RW'                        => $this->input->post('txtRW'),
            'Tempat_Lahir'              => strtoupper($this->input->post('txtTempatLahir')),
            'Tgl_Lahir'                 => date("Y-m-d", strtotime($this->input->post('txtTanggalLahir'))),
            'Jenis_Kelamin'             => strtoupper($this->input->post('txtJekel')),
            'NoHP'                      => $this->input->post('txtNoPonsel'),
            'TinggalDengan'             => strtoupper($this->input->post('txtTinggalDengan')),
            'HubunganDenganTK'          => strtoupper($this->input->post('txtHubungan')),
            'TinggiBadan'               => $this->input->post('txtTinggiBadan'),
            'BeratBadan'                => $this->input->post('txtBeratBadan'),
            'Suku'                      => strtoupper($this->input->post('txtSuku')),
            'Daerah_Asal'               => strtoupper($this->input->post('txtDaerahAsal')),
            'BahasaDaerah'              => strtoupper($this->input->post('txtBahasaDaerah')),
            'Agama'                     => strtoupper($this->input->post('txtAgama')),
            'Status_Personal'           => strtoupper($this->input->post('txtStatusPersonal')),
            
            'NamaSuamiIstri'            => strtoupper($this->input->post('txtNamaPasangan')),
            'TglLahirSuamiIstri'        => $tglPasangan,
            'PekerjaanSuamiIstri'       => strtoupper($this->input->post('txtPekerjaanPasangan')),
            'AlamatSuamiIstri'          => strtoupper($this->input->post('txtAlamatPasangan')),
            
            'NamaBapak'                 => strtoupper($this->input->post('txtNamaBapak')),
            'NamaIbuKandung'            => strtoupper($this->input->post('txtNamaIbu')),
            'ProfesiOrangTua'           => strtoupper($this->input->post('txtPekerjaanOrtu')),
            'JumlahSaudara'             => $this->input->post('txtJumlahSaudara'),
            'AnakKe'                    => $this->input->post('txtAnakKe'),
            
            'Pendidikan'                => $pen,
            'Jurusan'                   => $jurusan,
            'Universitas'               => $univ,
            'IPK'                       => $ipk,
            'TahunMasuk'                => $this->input->post('txtTahunMasuk'),
            'TahunLulus'                => $this->input->post('txtTahunLulus'),
            
            'PengalamanKerja'           => strtoupper($this->input->post('txtPengalamanKerja')),
            'Keahlian'                  => strtoupper($this->input->post('txtKeahlian')),
            'PernahKerjaDiSambu'        => strtoupper($this->input->post('txtPernahSambu')),
            'KerjadiBagian'             => strtoupper($this->input->post('txtBagian')),
            
            'Hobby'                     => strtoupper($this->input->post('txtHobby')),
            'KegiatanEkstra'            => strtoupper($this->input->post('txtKegiatanEkstra')),
            'KegiatanOrganisasi'        => strtoupper($this->input->post('txtOrganisasi')),
            'KeadaanFisik'              => strtoupper($this->input->post('txtKeadaanFisik')),
            'CacatApa'                  => $cacatapa,
            'PernahIdapPenyakit'        => strtoupper($this->input->post('txtIdapPenyakit')),
            'PenyakitApa'               => $penyakitapa,
            'Kriminal'                  => strtoupper($this->input->post('txtKriminal')),
            'PerkaraApa'                => $perkaraapa,
            'Bertato'                   => strtoupper($this->input->post('txtBertato')),
            'TatoDimana'                => $tatoDimana,
            'Bertindik'                 => strtoupper($this->input->post('txtBertindik')),
            'SediaPotongRambut'         => strtoupper($this->input->post('txtRambutPendek')),
            'Sediadiberhentikan'        => strtoupper($this->input->post('txtReadyStop')),
            'UpdatedBy'                 => strtoupper($this->session->userdata('username')),
            'UpdatedDate'               => date('Y-m-d H:i:s'),
			'ProvinsiID'				=> $this->input->post('txtProvinsi'),
			'KabKotaID'					=> $this->input->post('txtKabupaten'),
			'KecamatanID'				=> $this->input->post('txtKecamatan'),
        );
        
        $this->m_update_karyawan->updateData($hrdID,$info);
        
        redirect("ubahDataKaryawan/index/".$hrdID."?msg=Success");
    }
            
    function anak(){
        $hdrID  = $this->uri->segment(3);
        $id     = $this->uri->segment(4);
        $data['_getData']   = $this->m_update_karyawan->getTK($hdrID);
        $data['_getAnak']   = $this->m_update_karyawan->getAnak($id);
        $this->template->display('registrasi/register/editData/ubahAnak',$data);
    }
    
    function updateAnak(){
        $id     = $this->input->post("detailID");
        $hdrID  = $this->input->post("txtHdrID");
        $detail = array(
            'Nama'          => strtoupper($this->input->post('txtNamaAnak')),
            'JenisKelamin'  => $this->input->post('txtJekelAnak'),
            'TempatLahir'   => strtoupper($this->input->post('txtTmpLahirAnak')),
            'TglLahir'      => date("d-m-Y", strtotime($this->input->post('txtTglLahirAnak'))),
            'Alamat'        => strtoupper($this->input->post('txtAlamatAnak')),
            'UpdatedBy'     => strtoupper($this->session->userdata('username')),
            'UpdatedDate'   => date('Y-m-d H:i:s')
        );
        $this->m_update_karyawan->updateAnak($id,$detail);

        redirect('ubahDataKaryawan/index/'.$hdrID.'?msg=UpdateAnakOK');
    }
    
    function keluarga(){
        if('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['_getKel']   = $this->m_update_karyawan->getKel($kode);
            $this->load->view('registrasi/register/editData/ubahKeluarga',$data);
        }
    }
    
    function updateKeluarga(){
        $id     = $this->input->post("detailID");
        $hdrID  = $this->input->post("txtHdrID");
        $detail = array(
            'Nama'              => strtoupper($this->input->post('txtNamaKel')),
            'Departemen'        => strtoupper($this->input->post('txtDepartemen')),
            'Pemborong'         => strtoupper($this->input->post('txtPemborong')),
            'HubunganKeluarga'  => strtoupper($this->input->post('txtHubungan')),
            'Alamat'            => strtoupper($this->input->post('txtAlamat'))
        );
        $this->m_update_karyawan->updateKeluarga($id,$detail);

        redirect('ubahDataKaryawan/index/'.$hdrID.'?msg=UpdateKelOK');
    }
}