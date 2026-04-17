<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrasi2 extends CI_Controller{
	
    public function __construct(){
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
        $this->load->library(array('template','form_validation'));
    }

    public function index(){
        $this->load->model('m_register2');
        $data['_getFormID']         = $this->input->get('id');
        $this->template->display('registrasi/register/uploadexcel',$data);
    }

    function save(){
        $this->load->model('m_register2');
        $this->load->library('image_moo');
        
        $url = './dataupload/excel/';
        // $hdrID = $this->input->post("txtHeaderID");
        // $namapelamar = $this->input->post("txtNamaPelamar");
        // $filefoto = $hdrID;

        $config['upload_path']      = $url;     
        $config['allowed_types']    = 'xls';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['max_size']         = '900';
        // $config['file_name']        = $filefoto.'.xls'; //Filename harus pakai headerID pelamar

        // $font = "./assets/DroidSans.ttf";
        // $watermarkbg = "./assets/watermarkbg.png";

        $this->load->library('upload');
        $this->upload->initialize($config);
        // $config['upload_path'] = './temp_upload/';
        // $config['allowed_types'] = 'xls';
                
        // $this->load->library('upload', $config);
 
        $this->upload->do_upload();
        $data = array('error' => false);
        $upload_data = $this->upload->data();

        $this->load->library('excel_reader');
        $this->excel_reader->setOutputEncoding('CP1251');

        $file =  $upload_data['full_path'];
        $this->excel_reader->read($file);
        error_reporting(E_ALL ^ E_NOTICE);

        // Sheet 1
        $data = $this->excel_reader->sheets[0] ;
        $dataexcel = Array();
        for ($i = 1; $i <= $data['numRows']; $i++) {
           if($data['cells'][$i][1] == '') break;
           // echo date('Y-m-d',strtotime($data['cells'][$i][5]));
                $dataexcel[$i-1]['CVNama'] = $data['cells'][$i][2];
                $dataexcel[$i-1]['Pemborong'] = $data['cells'][$i][3];
                $dataexcel[$i-1]['Nama'] = $data['cells'][$i][4];
                $dataexcel[$i-1]['Tgl_Lahir'] = $data['cells'][$i][5];
                $dataexcel[$i-1]['Tempat_Lahir'] = $data['cells'][$i][6];
                $dataexcel[$i-1]['NamaIbuKandung'] = $data['cells'][$i][7];
                $dataexcel[$i-1]['BeratBadan'] = $data['cells'][$i][8];
                $dataexcel[$i-1]['TinggiBadan'] = $data['cells'][$i][9];
                $dataexcel[$i-1]['Agama'] = $data['cells'][$i][10];
                $dataexcel[$i-1]['Suku'] = $data['cells'][$i][11];
                $dataexcel[$i-1]['Jenis_Kelamin'] = $data['cells'][$i][12];
                $dataexcel[$i-1]['Pendidikan'] = $data['cells'][$i][13];
                $dataexcel[$i-1]['Jurusan'] = $data['cells'][$i][14];
                $dataexcel[$i-1]['Universitas'] = $data['cells'][$i][15];
                $dataexcel[$i-1]['IPK'] = $data['cells'][$i][16];
                $dataexcel[$i-1]['Status_Personal'] = $data['cells'][$i][17];
                $dataexcel[$i-1]['No_Ktp'] = $data['cells'][$i][18];
                $dataexcel[$i-1]['Alamat'] = $data['cells'][$i][19];
                $dataexcel[$i-1]['RT'] = $data['cells'][$i][20];
                $dataexcel[$i-1]['RW'] = $data['cells'][$i][21];
                $dataexcel[$i-1]['TinggalDengan'] = $data['cells'][$i][22];
                $dataexcel[$i-1]['HubunganDenganTK'] = $data['cells'][$i][23];
                $dataexcel[$i-1]['NoHP'] = $data['cells'][$i][24];
                $dataexcel[$i-1]['Daerah_Asal'] = $data['cells'][$i][25];
                $dataexcel[$i-1]['PernahKerja'] = $data['cells'][$i][26];
                $dataexcel[$i-1]['KerjaDi'] = $data['cells'][$i][27];
                $dataexcel[$i-1]['Kriminal'] = $data['cells'][$i][28];
                $dataexcel[$i-1]['PerkaraApa'] = $data['cells'][$i][29];
                $dataexcel[$i-1]['JumlahAnak'] = $data['cells'][$i][30];
                $dataexcel[$i-1]['NamaSuamiIstri'] = $data['cells'][$i][31];
                $dataexcel[$i-1]['TglLahirSuamiIstri'] = $data['cells'][$i][32];
                $dataexcel[$i-1]['PekerjaanSuamiIstri'] = $data['cells'][$i][33];
                $dataexcel[$i-1]['AlamatSuamiIstri'] = $data['cells'][$i][34];
                $dataexcel[$i-1]['NamaBapak'] = $data['cells'][$i][35];
                $dataexcel[$i-1]['ProfesiOrangTua'] = $data['cells'][$i][36];
                $dataexcel[$i-1]['JumlahSaudara'] = $data['cells'][$i][37];
                $dataexcel[$i-1]['AnakKe'] = $data['cells'][$i][38];
                $dataexcel[$i-1]['BahasaDaerah'] = $data['cells'][$i][39];
                $dataexcel[$i-1]['TahunMasuk'] = $data['cells'][$i][40];
                $dataexcel[$i-1]['TahunLulus'] = $data['cells'][$i][41];
                $dataexcel[$i-1]['Hobby'] = $data['cells'][$i][42];
                $dataexcel[$i-1]['KegiatanEkstra'] = $data['cells'][$i][43];
                $dataexcel[$i-1]['KegiatanOrganisasi'] = $data['cells'][$i][44];
                $dataexcel[$i-1]['KeadaanFisik'] = $data['cells'][$i][45];
                $dataexcel[$i-1]['PernahIdapPenyakit'] = $data['cells'][$i][46];
                $dataexcel[$i-1]['PenyakitApa'] = $data['cells'][$i][47];
                $dataexcel[$i-1]['PengalamanKerja'] = $data['cells'][$i][48];
                $dataexcel[$i-1]['Keahlian'] = $data['cells'][$i][49];
                $dataexcel[$i-1]['PernahKerjaDiSambu'] = $data['cells'][$i][50];
                $dataexcel[$i-1]['KerjadiBagian'] = $data['cells'][$i][51];
                $dataexcel[$i-1]['AccountFacebook'] = $data['cells'][$i][52];
                $dataexcel[$i-1]['AccountTwitter'] = $data['cells'][$i][53];
                $dataexcel[$i-1]['Bertato'] = $data['cells'][$i][54];
                $dataexcel[$i-1]['Bertindik'] = $data['cells'][$i][55];
                $dataexcel[$i-1]['SediaPotongRambut'] = $data['cells'][$i][56];
                $dataexcel[$i-1]['Sediadiberhentikan'] = $data['cells'][$i][57];
        }

        $result = $this->m_register2->insert_chapter($dataexcel); 
        redirect('registrasi2');
    }
}
?>