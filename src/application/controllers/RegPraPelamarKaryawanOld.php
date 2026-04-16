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
        
        $this->load->model(array('M_RegPraPelamarKaryawan','M_monitoringInterview'));
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
        $usia           = $this->input->post('txtusia');
        $gaji           = $this->input->post('txtgaji');

        $data = array(
            'Nama'          => $nama,
            'JenisKelamin'  => $jenis_kelamain,
            'Usia'          => $usia,
            'Pendidikan'    => $pendidikan,
            'Jurusan'       => $jurusan,
            'Gaji'          => str_replace(".","",$gaji),
            'CreatedBy'     => $this->session->userdata("username"),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        $id = $this->M_RegPraPelamarKaryawan->simpan($data);

        $dataIntr = array(
            'CalonPelamarID' => $id,
            'CreatedBy'     => $this->session->userdata("username"),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        $this->M_RegPraPelamarKaryawan->simpan_interview($dataIntr);

        $dataBerkas = array(
            'CalonPelamarID' => $id,
            'CreatedBy'     => $this->session->userdata("username"),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        $result = $this->M_RegPraPelamarKaryawan->simpan_berkas($dataBerkas);

        if(!$result){
            redirect("RegPraPelamarKaryawan/upload_berkas?calonid=".$id);
        }else{
            redirect("RegPraPelamarKaryawan?msg=failed");
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

    function upload_berkas(){
        $id = $this->input->get('calonid');
        
        $data['hdrid'] = $id;
        $data['_getCalon']  = $this->M_RegPraPelamarKaryawan->_getCalon($id);
        $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($id);
        $data['minimalberkas'] = $this->M_RegPraPelamarKaryawan->minimal_berkas($id);
        $this->template->display("calon_pelamar/upload_berkas/upload2",$data);
    }

    function pilih_type_berkas(){
        $typeid = $this->uri->segment(3);
        $id     = $this->uri->segment(4);

        // echo  $typeid.'/'.$id;

        if($typeid == 1){
            // echo "hahaa";
            $data['calonid'] = $id;
            $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($id);
            $data['minimalberkas']  = $this->M_RegPraPelamarKaryawan->minimal_berkas($id);
            $this->load->view('calon_pelamar/upload_berkas/berkasWord',$data);
        }elseif($typeid == 2){
            $data['calonid'] = $id;
            $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($id);
            $data['minimalberkas']  = $this->M_RegPraPelamarKaryawan->minimal_berkas($id);
            $this->load->view('calon_pelamar/upload_berkas/berkasPDF',$data);
        }else{
            $data['calonid'] = $id;
            $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($id);
            $data['minimalberkas']  = $this->M_RegPraPelamarKaryawan->minimal_berkas($id);
            $this->load->view('calon_pelamar/upload_berkas/berkasImage',$data);
        }
    }

    function uploadareaWord(){

        // echo "wkwks";
        $tipe                   = $this->input->post("tipe");
        $data["hdrid"]          = $this->input->post("hdrid");
        $data['calonid']        = $this->input->post("hdrid");
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
                $this->template->display('calon_pelamar/upload_berkas/upload2',$data);
                break;
        }

        $data['jenisberkas']    = $tipe;
        $data['namaberkas']     =$namaberkas;
        if ($tipe === "ktp"){
                $this->load->view('calon_pelamar/upload_berkas/formKTPWord',$data);
        }else{
                $this->load->view('calon_pelamar/upload_berkas/formUploadWord',$data);
        }
    }

    function do_uploadWord($berkas){
        switch ($berkas) {
            case "ktp":
                $url = './dataupload/berkas_pra_kry/ktp';
                $namaberkas = "KTP";
                break;          
            case "cv":
                $url = './dataupload/berkas_pra_kry/cv';
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case "lamaran":
                $url = './dataupload/berkas_pra_kry/lamaran';
                $namaberkas = "Surat Lamaran";
                break;
            case "ijazah":
                $url = './dataupload/berkas_pra_kry/ijazah';
                $namaberkas = "Ijazah";
                break;
            case "transkrip":
                $url = './dataupload/berkas_pra_kry/transkrip';
                $namaberkas = "Transkrip Nilai";
                break;
            case "kartukeluarga":
                $url = './dataupload/berkas_pra_kry/kartukeluarga';
                $namaberkas = "Kartu Keluarga";
                break;
            default:
                $url = './dataupload/berkas_pra_kry';
                $namaberkas = "Lain-Lain";
                break;
        }

        // echo $berkas;
        
        $hdrid = $this->input->post("txthdrid");
        // echo $hdrid;
        // $namapelamar = $this->input->post("txtnamapelamar");
        $namafile = $hdrid.'_'.$berkas;
        // echo $namafile;

        // $data['namapelamar']        = $namapelamar;
        $config['upload_path']      = $url;
        $config['allowed_types']    = 'doc|docx';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['file_name']        = $namafile;
        $config['max_size']         = '3072';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if( $this->upload->do_upload('txtfile')){
            $this->upload->data();
            $data['errormsg']="<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Berhasil</strong></div>";
            $this->M_RegPraPelamarKaryawan->update_db_berkas($hdrid,$berkas,$url.'/'.$namafile.'.docx');
            redirect('RegPraPelamarKaryawan/upload_berkas?calonid='.$hdrid);
        }else{
            $error = $this->upload->display_errors();
            $data['errormsg']="<div class='alert alert-danger'><a class='close' data-dismiss='alert'><i class='fa fa-times'>&nbsp;</i></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Gagal</strong><br/>$error</div>";
        }

        $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($hdrid);
        $data['minimalberkas']  = $this->M_RegPraPelamarKaryawan->minimal_berkas($hdrid);
        $data['_getCalon']  = $this->M_RegPraPelamarKaryawan->_getCalon($hdrid);
        $data['hdrid']  = $hdrid;
        $this->template->display('calon_pelamar/upload_berkas/upload2',$data);
    }

    function uploadareaPDF(){

        // echo "wkwks";
        $tipe                   = $this->input->post("tipe");
        $data["hdrid"]          = $this->input->post("hdrid");
        $data['calonid']        = $this->input->post("hdrid");
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
                $this->template->display('calon_pelamar/upload_berkas/upload2',$data);
                break;
        }

        $data['jenisberkas']    = $tipe;
        $data['namaberkas']     =$namaberkas;
        if ($tipe === "ktp"){
                $this->load->view('calon_pelamar/upload_berkas/formKTPPDF',$data);
        }else{
                $this->load->view('calon_pelamar/upload_berkas/formUploadPDF',$data);
        }
    }

    function do_uploadPDF($berkas){
        switch ($berkas) {
            case "ktp":
                $url = './dataupload/berkas_pra_kry/ktp';
                $namaberkas = "KTP";
                break;          
            case "cv":
                $url = './dataupload/berkas_pra_kry/cv';
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case "lamaran":
                $url = './dataupload/berkas_pra_kry/lamaran';
                $namaberkas = "Surat Lamaran";
                break;
            case "ijazah":
                $url = './dataupload/berkas_pra_kry/ijazah';
                $namaberkas = "Ijazah";
                break;
            case "transkrip":
                $url = './dataupload/berkas_pra_kry/transkrip';
                $namaberkas = "Transkrip Nilai";
                break;
            case "kartukeluarga":
                $url = './dataupload/berkas_pra_kry/kartukeluarga';
                $namaberkas = "Kartu Keluarga";
                break;
            default:
                $url = './dataupload/berkas_pra_kry';
                $namaberkas = "Lain-Lain";
                break;
        }

        // echo $berkas;
        
        $hdrid = $this->input->post("txthdrid");
        // echo $hdrid;
        // $namapelamar = $this->input->post("txtnamapelamar");
        $namafile = $hdrid.'_'.$berkas;
        // echo $namafile;

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
            $data['errormsg']="<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Berhasil</strong></div>";
            $this->M_RegPraPelamarKaryawan->update_db_berkas($hdrid,$berkas,$url.'/'.$namafile.'.pdf');
            redirect('RegPraPelamarKaryawan/upload_berkas?calonid='.$hdrid);
        }else{
            $error = $this->upload->display_errors();
            $data['errormsg']="<div class='alert alert-danger'><a class='close' data-dismiss='alert'><i class='fa fa-times'>&nbsp;</i></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Gagal</strong><br/>$error</div>";
        }

        $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($hdrid);
        $data['minimalberkas']  = $this->M_RegPraPelamarKaryawan->minimal_berkas($hdrid);
        $data['_getCalon']  = $this->M_RegPraPelamarKaryawan->_getCalon($hdrid);
        $data['hdrid']  = $hdrid;
        $this->template->display('calon_pelamar/upload_berkas/upload2',$data);
    }

    function uploadareaImage(){

        // echo "wkwks";
        $tipe                   = $this->input->post("tipe");
        $data["hdrid"]          = $this->input->post("hdrid");
        $data['calonid']        = $this->input->post("hdrid");
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
                $this->template->display('calon_pelamar/upload_berkas/upload2',$data);
                break;
        }

        $data['jenisberkas']    = $tipe;
        $data['namaberkas']     =$namaberkas;
        if ($tipe === "ktp"){
                $this->load->view('calon_pelamar/upload_berkas/formKTPImage',$data);
        }else{
                $this->load->view('calon_pelamar/upload_berkas/formUploadImage',$data);
        }
    }

    function do_uploadImage($berkas){
        switch ($berkas) {
            case "ktp":
                $url = './dataupload/berkas_pra_kry/ktp';
                $namaberkas = "KTP";
                break;          
            case "cv":
                $url = './dataupload/berkas_pra_kry/cv';
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case "lamaran":
                $url = './dataupload/berkas_pra_kry/lamaran';
                $namaberkas = "Surat Lamaran";
                break;
            case "ijazah":
                $url = './dataupload/berkas_pra_kry/ijazah';
                $namaberkas = "Ijazah";
                break;
            case "transkrip":
                $url = './dataupload/berkas_pra_kry/transkrip';
                $namaberkas = "Transkrip Nilai";
                break;
            case "kartukeluarga":
                $url = './dataupload/berkas_pra_kry/kartukeluarga';
                $namaberkas = "Kartu Keluarga";
                break;
            default:
                $url = './dataupload/berkas_pra_kry';
                $namaberkas = "Lain-Lain";
                break;
        }

        // echo $berkas;
        
        $hdrid = $this->input->post("txthdrid");
        // echo $hdrid;
        // $namapelamar = $this->input->post("txtnamapelamar");
        $namafile = $hdrid.'_'.$berkas;
        // echo $namafile;

        // $data['namapelamar']        = $namapelamar;
        $config['upload_path']      = $url;
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['file_name']        = $namafile;
        $config['max_size']         = '3072';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if( $this->upload->do_upload('txtfile')){
            $this->upload->data();
            $data['errormsg']="<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Berhasil</strong></div>";
            $this->M_RegPraPelamarKaryawan->update_db_berkas($hdrid,$berkas,$url.'/'.$namafile.'.jpg');
            redirect('RegPraPelamarKaryawan/upload_berkas?calonid='.$hdrid);
        }else{
            $error = $this->upload->display_errors();
            $data['errormsg']="<div class='alert alert-danger'><a class='close' data-dismiss='alert'><i class='fa fa-times'>&nbsp;</i></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Gagal</strong><br/>$error</div>";
        }

        $data['databerkas']     = $this->M_RegPraPelamarKaryawan->get_db_berkas($hdrid);
        $data['minimalberkas']  = $this->M_RegPraPelamarKaryawan->minimal_berkas($hdrid);
        $data['_getCalon']  = $this->M_RegPraPelamarKaryawan->_getCalon($hdrid);
        $data['hdrid']  = $hdrid;
        $this->template->display('calon_pelamar/upload_berkas/upload2',$data);
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
            $this->load->view('calon_pelamar/upload_berkas/viewDoc',$data);
        }
    }


    // BEGIN :: FILTER PENCARIAN

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
        }else{
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
}