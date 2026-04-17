<?php 
defined('BASEPATH') or exit('No Direct Script access Allowed');

class RegPraPelamarKaryawan extends CI_Controller{
    
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
        
        $this->load->model(array('M_RegPraPelamarKaryawan','M_monitoringInterview','m_upload_berkas','M_Pra_pelamar'));
    }

    function index(){

        $data['_getData'] = $this->M_RegPraPelamarKaryawan->_getListData();
        $this->template->display('calon_pelamar/index',$data);
    }

    function tambah_data(){

        $data['_getMstPendidikan'] = $this->M_RegPraPelamarKaryawan->_getMstPendidikan();
        $data['_getMstJurusan'] = $this->M_RegPraPelamarKaryawan->_getMstJurusan();
        $this->template->display('calon_pelamar/tambah',$data);
    }

    function simpan(){
        $nama           = $this->input->post('txtnama');
        $jenis_kelamain = $this->input->post('txtjeniskelamin');
        $pendidikan     = $this->input->post('txtpendidikan');
        $jurusan        = $this->input->post('txtjurusan');
        $tanggal        = $this->input->post('txtTgl');
        $univ           = $this->input->post('txtuniv');
        $gaji           = $this->input->post('txtgaji');
        $suku           = $this->input->post('txtSuku');

        $data = array(
            'Nama'          => $nama,
            'JenisKelamin'  => $jenis_kelamain,
            'TanggalLahir'  => $tanggal,
            'Univ'          => $univ,
            'Pendidikan'    => $pendidikan,
            'Jurusan'       => $jurusan,
            'Gaji'          => str_replace(".","",$gaji),
            'Suku'          => $suku,
            'CreatedBy'     => $this->session->userdata("username"),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        // print_r($data);

        $id = $this->M_RegPraPelamarKaryawan->simpan($data);

        $dataIntr = array(
            'CalonPelamarID' => $id,
            'CreatedBy'     => $this->session->userdata("username"),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        // print_r($dataIntr);
        $idIntr = $this->M_RegPraPelamarKaryawan->simpan_interview($dataIntr);

        $dataCalonKarantina = array(
            'Nama_Lengkap'      => $nama,
            'Jenis_Kelamin'     => $jenis_kelamain,
            'CalonPelamarID'    => $id,
            'IDInterview'       => $idIntr,
            'IDPemborong'       => 15,
            'Pendidikan'        => $pendidikan,
            'Jurusan'           => $jurusan,
            'CreatedBy'         => $this->session->userdata('username'),
            'CreatedDate'       => date('Y-m-d H:i:s')
        );

        // print_r($dataCalonKarantina);

        $idCalonKaranitina = $this->M_RegPraPelamarKaryawan->simpan_calon_karantina($dataCalonKarantina);

        $dataRegistrasi = array(
            'Pra_PelamarID'  => $idCalonKaranitina,
            'CalonPelamarID' => $id,
            'IDInterview'    => $idIntr,
            'Nama'           => $nama,
            'CVNama'         => 'PT. RSUP - IND',
            'Pemborong'      => 'RSUP',
            'Pendidikan'     => $pendidikan,
            'Jurusan'        => $jurusan,
            'CreatedBy'     => $this->session->userdata('username'),
            'CreatedDate'    => date('Y-m-d H:i:s'),
            'RegisteredBy'   => $this->session->userdata('userid'),
            'RegisteredDate' => date('Y-m-d H:i:s')
        );

        // print_r($dataRegistrasi);
        $hdrid = $this->M_RegPraPelamarKaryawan->simpan_reg($dataRegistrasi);

        $this->m_upload_berkas->insert_db_berkas($hdrid);

        $dataBerkas = array(
            'Pra_PelamarID' => $idCalonKaranitina
        );

        // print_r($dataBerkas);

       $result = $this->M_Pra_pelamar->simpanBerkas($dataBerkas);


        if(!$result){
            redirect("RegPraPelamarKaryawan/upload_berkas?calonid=".$hdrid);
        }else{
            redirect("RegPraPelamarKaryawan?msg=failed");
        }

    }

    function upload_berkas(){
        $hdrid = $this->input->get('calonid');
        
        $data['hdrid']          = $hdrid;
        $data['_getCalon']      = $this->M_RegPraPelamarKaryawan->_getCalon($hdrid);
        $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($hdrid);
        $data['minimalberkas']  = $this->M_RegPraPelamarKaryawan->minimal_berkas($hdrid);
        $this->template->display("calon_pelamar/upload_berkas/upload",$data);
    }

    function uploadarea(){

        $tipe                   = $this->input->post("tipe");
        $data["hdrid"]          = $this->input->post("hdrid");
        $data['_getCalon']      = $this->M_RegPraPelamarKaryawan->_getCalon($this->input->post("hdrid"));
        $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($this->input->post("hdrid"));
        $data['minimalberkas']  = $this->M_RegPraPelamarKaryawan->minimal_berkas($this->input->post("hdrid"));
        $data['errormsg']       ="";

        // echo $tipe;

        switch ($tipe) {
            case 'ktp':
                $namaberkas = "KTP";
                break;
            case 'cv':
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case 'lamaran':
                $namaberkas = "Surat Lamaran";
                break;
            case 'ijazah':
                $namaberkas = "Ijazah";             
                break;
            case 'transkrip':
                $namaberkas = "Transkrip Nilai";                
                break;
             case 'kartukeluarga':
                $namaberkas = "Kartu Keluarga";                
                break;
            default:
                $this->template->display('calon_pelamar/upload_berkas/upload',$data);
                break;
        }

        $data['jenisberkas']    = $tipe;
        $data['namaberkas']     =$namaberkas;
        if ($tipe === "ktp"){
                $this->load->view('calon_pelamar/upload_berkas/formKTP',$data);
        }else{
                $this->load->view('calon_pelamar/upload_berkas/formUpload',$data);
        }
    }

    function do_upload($berkas){
        switch ($berkas) {
            case "ktp":
                $url = './dataupload/berkas/ktp';
                $namaberkas = "KTP";
                break;          
            case "cv":
                $url = './dataupload/berkas/cv';
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case "lamaran":
                $url = './dataupload/berkas/lamaran';
                $namaberkas = "Surat Lamaran";
                break;
            case "ijazah":
                $url = './dataupload/berkas/ijazah';
                $namaberkas = "Ijazah";
                break;
            case "transkrip":
                $url = './dataupload/berkas/transkrip';
                $namaberkas = "Transkrip Nilai";
                break;
            case "kartukeluarga":
                $url = './dataupload/berkas/kartukeluarga';
                $namaberkas = "Kartu Keluarga";
                break;
            default:
                $url = './dataupload/berkas';
                $namaberkas = "Lain-Lain";
                break;
        }
        
        $hdrid       = $this->input->post("txthdrid");
        $pra_id      = $this->input->post("txtKarantinaID");
        $namafile = $hdrid.'_'.$berkas;
        $namafile_pra = $pra_id.'_'.$berkas;

        // $data['namapelamar']        = $namapelamar;
        $config['upload_path']      = $url;
        $config['allowed_types']    = 'pdf';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['file_name']        = $namafile;
        $config['max_size']         = '3072';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if( $this->upload->do_upload('txtfile')){
            $this->upload->data();
            $data['errormsg']="<div class='alert alert-success'><a class='close' data-dismiss='alert'></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Berhasil</strong></div>";
            $this->m_upload_berkas->update_db_berkas($hdrid,$berkas,$url.'/'.$namafile.'.pdf');
            $this->m_upload_berkas->update_db_berkas_pra($pra_id,$berkas,$url.'/'.$namafile.'.pdf');
        }else{
            $error = $this->upload->display_errors();
            $data['errormsg']="<div class='alert alert-danger'><a class='close' data-dismiss='alert'><i class='fa fa-times'>&nbsp;</i></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Gagal</strong><br/>$error</div>";
        }
        
        $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($hdrid);
        $data['minimalberkas']  = $this->M_RegPraPelamarKaryawan->minimal_berkas($hdrid);
        $data['_getCalon']      = $this->M_RegPraPelamarKaryawan->_getCalon($hdrid);
        $data['hdrid']  = $hdrid;
        $this->template->display('calon_pelamar/upload_berkas/upload',$data);
    }

    function edit_data()
    {
        $CalonPelamarID = $this->input->get('CalonPelamarID');

        $data['_getMstPendidikan'] = $this->M_RegPraPelamarKaryawan->_getMstPendidikan();
        $data['_getMstJurusan'] = $this->M_RegPraPelamarKaryawan->_getMstJurusan();
        $data['getid'] = $this->M_RegPraPelamarKaryawan->_getByID($CalonPelamarID);

        $this->template->display('calon_pelamar/edit',$data);

    }

    function updatedata()
    {

        $calonid        = $this->input->post('txtCalonID');
        $hdrid        = $this->input->post('txtCalonTKB');
        $nama           = $this->input->post('txtnama');
        $jenis_kelamain = $this->input->post('txtjeniskelamin');
        $pendidikan     = $this->input->post('txtPendidikan');
        $jurusan        = $this->input->post('txtJurusan');
        $tanggal        = $this->input->post('txtTgl');
        $univ           = $this->input->post('txtuniv');
        $gaji           = $this->input->post('txtgaji');
        $suku           = $this->input->post('txtSuku');


        $data = array(
          'Nama'          => $nama,
            'JenisKelamin'  => $jenis_kelamain,
            'TanggalLahir'  => $tanggal,
            'Univ'          => $univ,
            'Pendidikan'    => $pendidikan,
            'Jurusan'       => $jurusan,
            'Gaji'          => str_replace(".","",$gaji),
            'Suku'          => $suku,
          'UpdateBy'        => $this->session->userdata('username'),
          'UpdateDate'      => date('Y-m-d H:i:s')
        );

        $this->M_RegPraPelamarKaryawan->update_data($calonid,$data);

        
       
        if(!$result){
            redirect("RegPraPelamarKaryawan/upload_berkas?calonid=".$hdrid);
        }else{
            redirect('RegPraPelamarKaryawan?msg=failed');
        }

    }

    function HapusData()
    {

        $calonid        = $this->input->get('CalonPelamarID');
        

        $data = array(
          
          'DeletedBy'        => $this->session->userdata('username'),
          'DeletedDate'      => date('Y-m-d H:i:s')
        );

        $this->M_RegPraPelamarKaryawan->update_data($calonid,$data);
        
       
        if(!$result){
            redirect('RegPraPelamarKaryawan?msg=success');
        }else{
            redirect('RegPraPelamarKaryawan?msg=failed');
        }

    }

    function interview(){
        $id     = $this->uri->segment(3);
        $status = $this->uri->segment(4);

        $data = array(
            'Interview' => $status,
        );

        $this->M_RegPraPelamarKaryawan->update($id,$data);
    }

    function tgl_interview(){
        $id     = $this->uri->segment(3);
        $tgl    = $this->uri->segment(4);

        $data = array(
            'Tanggal' => $tgl,
        );

        $this->M_RegPraPelamarKaryawan->update($id,$data);
    }

    function jam_interview(){
        $id     = $this->uri->segment(3);
        $jam    = $this->uri->segment(4);

        $data = array(
            'Jam' => $jam,
        );

        $this->M_RegPraPelamarKaryawan->update($id,$data);
    }

    function selesai($hdrid){
        $data['message']="<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Data dan Foto Berhasil</strong></div>";
        redirect('RegPraPelamarKaryawan');
    }

    function viewDocs(){
        if('IS_AJAX') {
            $userID = $this->input->post('kode');
            $berkas = $this->input->post('nama');
            $data['_jenisBerkas'] = $berkas;
            $data['_getViewDocs'] = $this->M_RegPraPelamarKaryawan->getDocs($userID);
            $data['_getCalonPelamar'] = $this->M_monitoringInterview->getPelamar($userID);
            // print_r($data['_getViewDocs']);
            $this->load->view('calon_pelamar/upload_berkas/viewDoc',$data);
        }
    }

    function cari_berdasarkan(){
        $cari = $this->uri->segment(3);

        // echo $cari;

        if($cari == 1){
            $_jurusan = $this->M_RegPraPelamarKaryawan->_getMstJurusan();
            echo '<div class="form-group">
                    <label class="col-lg-2 control-label">Pilih Jurusan</label>
                        <div class="col-lg-4">
                            <select class="form-control" id="jurusanid">
                                <option value="">- Pilih -</option>';
                                foreach($_jurusan as $jrs){
                                    echo '<option value="'.$jrs->Jurusan.'">'.$jrs->Jurusan.'</option>';
                                }
                            echo '</select>
                        </div>
                </div>';
        }elseif($cari == 2){
            $_gaji = $this->M_RegPraPelamarKaryawan->_getMstGaji();
           echo '<div class="form-group">
                    <label class="col-lg-2 control-label">Gaji</label>
                        <div class="col-lg-4">
                            <select class="form-control" id="gajiid">
                                <option value="">- Pilih -</option>';
                                foreach($_gaji as $key){
                                    echo '<option value="'.$key->GajiID.'">Rp. '.number_format($key->Gaji_1).' - Rp. '.number_format($key->Gaji_2).'</option>';
                                }
                            echo '</select>
                        </div>
                </div>'; 
        }else{
            echo '<div class="form-group">
                    <label class="col-lg-2 control-label">Tanggal</label>
                        <div class="col-lg-2">
                            <input type="date" class="form-control" name="tglAwal" id="tglawal">
                        </div>
                        <div class="col-lg-2">
                            <input type="date" class="form-control" name="tglAkhir" id="tglakhir">
                        </div>
                </div>'; 
        }
    }

    function list_data_berdasarkan_jurusan(){
        $jurusan = $this->uri->segment(3);

        $data['_getData'] = $this->M_RegPraPelamarKaryawan->_getListDataByJurusan($jurusan);
        $this->load->view('calon_pelamar/ajax_list',$data);
    }

    function list_data_berdasarkan_gaji(){
        $gaji = $this->uri->segment(3);

        $_getGaji = $this->M_RegPraPelamarKaryawan->_getGajiByID($gaji);
        $data['_getData'] = $this->M_RegPraPelamarKaryawan->_getListDataByGaji($_getGaji[0]->Gaji_1,$_getGaji[0]->Gaji_2);
        
        $this->load->view('calon_pelamar/ajax_list',$data);
    }

    function list_data_berdasarkan_tanggal(){
        $tglawal = $this->uri->segment(3);
        $tglakhir = $this->uri->segment(4);

        $data['_getData'] = $this->M_RegPraPelamarKaryawan->_getListDataPertanggal($tglawal,$tglakhir);
        $this->load->view('calon_pelamar/ajax_list',$data);

    }
      
    
}