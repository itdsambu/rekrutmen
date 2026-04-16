<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Pra_pelamar extends CI_Controller
{
    
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
        $this->load->model('M_Pra_pelamar');
        $this->load->library('Excel/PHPExcel');
    }

    function registrasi(){
        $data['_getFormID']      = $this->input->get('id');
        $data['getPemborong'] = $this->M_Pra_pelamar->get_pemborong();
        $data['getPendidikan'] = $this->M_Pra_pelamar->get_pendidikan();
        $data['GetStatusKawin'] = $this->M_Pra_pelamar->getStatusKawin();

        $this->template->display('pra_pelamar/registrasi/index',$data);
    }

    function ajax_pemborong(){
        $pbr = $this->uri->segment(3);
        if($pbr == 15){
            $data['pemborong'] = $pbr;
            $data['getPemborong'] = $this->M_Pra_pelamar->get_pemborong();
            $data['getPendidikan'] = $this->M_Pra_pelamar->get_pendidikan();
            $data['getjurusan'] = $this->M_Pra_pelamar->get_jurusan();
            $data['GetStatusKawin'] = $this->M_Pra_pelamar->getStatusKawin();
            $this->load->view('pra_pelamar/registrasi/ajax_input',$data);
        }else{

            $data['pemborong'] = $pbr;
            $data['getPemborong'] = $this->M_Pra_pelamar->get_pemborong();
            $data['getPendidikan'] = $this->M_Pra_pelamar->get_pendidikan();
            $data['getjurusan'] = $this->M_Pra_pelamar->get_jurusan();
            $data['GetStatusKawin'] = $this->M_Pra_pelamar->getStatusKawin();
            $this->load->view('pra_pelamar/registrasi/ajax_input_hb',$data);
        }
    }

    function pilih_calon_pelamar(){
        $id = $this->input->post('id');

        $data['_getCalonPelamar'] = $this->M_Pra_pelamar->_getCalonPelamar($id);
        $data['getPendidikan'] = $this->M_Pra_pelamar->get_pendidikan();
        $data['getjurusan'] = $this->M_Pra_pelamar->get_jurusan();
        $data['getMess'] = $this->M_Pra_pelamar->get_mess();
        $this->load->view('pra_pelamar/registrasi/ajax_input_get',$data);
    }

    function getPraPelamar(){
        $id = $this->input->post("id");

        $data['_getCalonPelamar'] = $this->M_Pra_pelamar->_getCalonPelamar($id);
        $this->load->view('pra_pelamar/registrasi/cariid',$data);
    }

    function ajax_jurusan(){
        $pendid = str_replace('%20',' ',$this->uri->segment(3));

        if($pendid == 'TIDAK SEKOLAH' || $pendid == 'SD' || $pendid == 'SMP' || $pendid == 'MTS'){
            $this->load->view('pra_pelamar/registrasi/ajax/jurusan2');
        }else{
            $data['getjurusan'] = $this->M_Pra_pelamar->get_jurusan();
            $this->load->view('pra_pelamar/registrasi/ajax/jurusan',$data);
        }
    }

    function simpan(){
        $calonid            = $this->input->post("txtCalonPelamarID");
        $intrviewid         = $this->input->post("txtInterviewID");
        $pemborong          = $this->input->post('selpemborong');
        $nama_lengkap       = $this->input->post('txtnama_lengkap');
        $nik_ktp            = $this->input->post('txtnik_ktp');
        $nik_kk             = $this->input->post('txtnik_kk');
        $tanggal_lahir      = $this->input->post('txttanggal_lahir');
        $nama_ibukandung    = $this->input->post('txtnama_ibukandung');
        $tanggal_kedatangan = $this->input->post('txttanggal_kedatangan');
        $asal_kedatangan    = $this->input->post('txtasal_kedatangan');
        $alamat_karantina   = $this->input->post('txtalamat_karantina');
        $jenis_kelamin      = $this->input->post('txtjenis_kelamin');
        $status             = $this->input->post('txtstatus');
        $pendidikan         = $this->input->post('txtPendidikan');
        $jurusan            = $this->input->post('txtjurusan');
        $statusAktif        = $this->input->post('txtStatusAktif');
        $StatusKawin        = $this->input->post('txtStatusKawin');

        if($tanggal_kedatangan != '1970-01-01'){
            $tgl_kedatangan = date('Y-m-d',strtotime($tanggal_kedatangan)) ;
        }else{
            $tgl_kedatangan = '';
        }

        $data = array(
            'CalonPelamarID'        => $calonid,
            'IDInterview'           => $intrviewid,
            'IDPemborong'           => $pemborong,
            'Nama_Lengkap'          => $nama_lengkap,
            'Nik_Ktp'               => $nik_ktp,
            'Nik_Kk'                => $nik_kk,
            'Tanggal_Lahir'         => date('Y-m-d',strtotime($tanggal_lahir)),
            'Nama_Ibu_Kandung'      => $nama_ibukandung,
            'Tanggal_Kedatangan'    => $tgl_kedatangan,
            'Asal_Kedatangan'       => $asal_kedatangan,
            'Alamat_Karantina'      => $alamat_karantina,
            'Jenis_Kelamin'         => $jenis_kelamin,
            'Status'                => $status,
            'Pendidikan'            => $pendidikan,
            'Jurusan'               => $jurusan,
            'StatusAktif'           => $statusAktif,
            'StatusPernikahan'      => $StatusKawin,
            'CreatedBy'             => $this->session->userdata('username'),
            'CreatedDate'           => date('Y-m-d H:i:s'),
        );
        
        $cek_prapelamar = $this->M_Pra_pelamar->cek_dataPraPelamar($nama_lengkap,$nama_ibukandung,$tanggal_lahir);
        if($cek_prapelamar != NULL){
            foreach ($cek_prapelamar as $key) {
               if($key->IDPemborong == $pemborong){
                    //*echo "pemborong yang sama *//
                    if($key->Tanggal_Kedatangan == NULL && $key->RentangWaktuReg <= '1'){
                        //* jika belum di input tanggal kedatangan dan masih dalam masa jeda *//
                         redirect('Pra_pelamar/registrasi/?msg=failed');

                    }elseif($key->Tanggal_Kedatangan == '1900-01-01' && $key->RentangWaktuReg < '1'){
                        //* jika tanggal kedatangan sudah pernah diisi dan masih dalam massa jeda *//
                         redirect('Pra_pelamar/registrasi/?msg=failed3');
                        // echo "tanggal kedatang 1900";
                    }elseif($key->Tanggal_Kedatangan != NULL && $key->RentangWaktuReg <= '1'){
                        //* jika tanggal kedatangan sudah pernah diisi dan masih dalam massa jeda *//
                         redirect('Pra_pelamar/registrasi/?msg=failed3');
                    }elseif($key->Tanggal_Kedatangan != NULL && $key->RentangWaktuKedatangan <= '1'){
                        redirect('Pra_pelamar/registrasi/?msg=failed3');
                    }else{
                        //* Jika tanggal kedatangan terisi dan sudah lewat masa jeda *//
                        $cek_tkaktif = $this->M_Pra_pelamar->cek_tenagakerja_aktif($nama_lengkap,$nama_ibukandung,$tanggal_lahir);
                        
                        if($cek_tkaktif == NULL){
                            //* jika belum pernah terregistrasi *//
                                 $pra_pelamarid = $this->M_Pra_pelamar->simpan($data);
                                 $dataBerkas = array(
                                     'Pra_PelamarID' => $pra_pelamarid
                                 );
                                 $this->M_Pra_pelamar->simpanBerkas($dataBerkas);
                                 redirect('Pra_pelamar/uploadBerkas/'.$pra_pelamarid.'/'.$nama_lengkap);
                        }else{
                            foreach($cek_tkaktif as $get){
                                if($get->TanggalKeluar != NULL && $get->Blacklist == '1'){
                                     redirect('Pra_pelamar/registrasi/?msg=failed2');
                                 }elseif($get->TanggalKeluar != NULL && $get->ketKeluar == 'Diskualifikasi' && $get->RentangWaktuKeluar < '3'){
                                     redirect('Pra_pelamar/registrasi/?msg=failed3');
                                 }elseif($get->TanggalKeluar != NULL && $get->ketKeluar == 'UNDUR DIRI' && $get->RentangWaktuKeluar <= '1'){
                                     redirect('Pra_pelamar/registrasi/?msg=failed3');
                                 }elseif($get->TanggalKeluar != NULL && $get->ketKeluar == 'BELUM 2 BULAN KERJA DI DEPT MP'){
                                     redirect('Pra_pelamar/registrasi/?msg=failed2');
                                 }else{
                                     $pra_pelamarid = $this->M_Pra_pelamar->simpan($data);
                                     $dataBerkas = array(
                                         'Pra_PelamarID' => $pra_pelamarid
                                     );
                                     $this->M_Pra_pelamar->simpanBerkas($dataBerkas);
                                     redirect('Pra_pelamar/uploadBerkas/'.$pra_pelamarid.'/'.$nama_lengkap);
                                 }
                            }
                        }
                    }
               }else{
                // echo "hahah";
                    if($key->Tanggal_Kedatangan == NULL && $key->RentangWaktuReg <= '1'){
                        //* jika belum di input tanggal kedatangan dan masih dalam masa jeda *//
                         redirect('Pra_pelamar/registrasi/?msg=failed3');

                    }elseif($key->Tanggal_Kedatangan == '1900-01-01' && $key->RentangWaktuReg < '1'){
                        //* jika tanggal kedatangan sudah pernah diisi dan masih dalam massa jeda *//
                         // redirect('Pra_pelamar/registrasi/?msg=failed3');
                        echo "tanggal kedatang 1900";
                    }elseif($key->Tanggal_Kedatangan != NULL && $key->RentangWaktuReg <= '1'){
                        //* jika tanggal kedatangan sudah pernah diisi dan masih dalam massa jeda *//
                         redirect('Pra_pelamar/registrasi/?msg=failed3');
                    }elseif($key->Tanggal_Kedatangan != NULL && $key->RentangWaktuKedatangan <= '1'){
                        redirect('Pra_pelamar/registrasi/?msg=failed3');
                    }else{
                        //* Jika tanggal kedatangan terisi dan sudah lewat masa jeda *//
                        $cek_tkaktif = $this->M_Pra_pelamar->cek_tenagakerja_aktif($nama_lengkap,$nama_ibukandung,$tanggal_lahir);
                        
                        if($cek_tkaktif == NULL){
                            //* jika belum pernah terregistrasi *//
                                 $pra_pelamarid = $this->M_Pra_pelamar->simpan($data);
                                 $dataBerkas = array(
                                     'Pra_PelamarID' => $pra_pelamarid
                                 );
                                 $this->M_Pra_pelamar->simpanBerkas($dataBerkas);
                                redirect('Pra_pelamar/uploadBerkas/'.$pra_pelamarid.'/'.$nama_lengkap);
                        }else{
                            foreach($cek_tkaktif as $get){
                                if($get->TanggalKeluar != NULL && $get->Blacklist == '1'){
                                     redirect('Pra_pelamar/registrasi/?msg=failed2');
                                 }elseif($get->TanggalKeluar != NULL && $get->ketKeluar == 'Diskualifikasi' && $get->RentangWaktuKeluar < '3'){
                                     redirect('Pra_pelamar/registrasi/?msg=failed3');
                                 }elseif($get->TanggalKeluar != NULL && $get->ketKeluar == 'UNDUR DIRI' && $get->RentangWaktuKeluar <= '1'){
                                     redirect('Pra_pelamar/registrasi/?msg=failed3');
                                 }elseif($get->TanggalKeluar != NULL && $get->ketKeluar == 'BELUM 2 BULAN KERJA DI DEPT MP'){
                                     redirect('Pra_pelamar/registrasi/?msg=failed2');
                                 }else{
                                     $pra_pelamarid = $this->M_Pra_pelamar->simpan($data);
                                     $dataBerkas = array(
                                         'Pra_PelamarID' => $pra_pelamarid
                                     );
                                     $this->M_Pra_pelamar->simpanBerkas($dataBerkas);
                                     redirect('Pra_pelamar/uploadBerkas/'.$pra_pelamarid.'/'.$nama_lengkap);
                                 }
                            }
                        }
                    }
               }
            }

        }else{
            $pra_pelamarid = $this->M_Pra_pelamar->simpan($data);
            $dataBerkas = array(
                'Pra_PelamarID' => $pra_pelamarid
            );
            $this->M_Pra_pelamar->simpanBerkas($dataBerkas);
            redirect('Pra_pelamar/uploadBerkas/'.$pra_pelamarid.'/'.$nama_lengkap);
        }
    }
    
    function uploadBerkas(){
        $pra_pelamarid  = $this->uri->segment(3);
        $nama_lengkap   = urldecode($this->uri->segment(4));

        $data['databerkas']     = $this->M_Pra_pelamar->get_berkas($pra_pelamarid);
        $data['minimalberkas']  = $this->M_Pra_pelamar->get_minimalberkas($pra_pelamarid);
        $data['hdrid']          = $pra_pelamarid;
        $data['namapelamar']    = urldecode($nama_lengkap);
        $data['errormsg']       = "";
        $this->template->display('pra_pelamar/registrasi/upload',$data);
    }

    function uploadarea(){
        $tipe                   = $this->input->post("tipe");
        $data["hdrid"]          = $this->input->post("hdrid");
        $data["namapelamar"]    = $this->input->post("nama");
        $data['errormsg']       = "";

        switch ($tipe) {
            case 'ktp':
                $namaberkas = "KTP";
                break;
            case 'suratsehat':
                $namaberkas = "Surat Sehat";
                break;
            case 'domisili':
                $namaberkas = "Domisili";
                break;
            case 'suratguguscovid':
                $namaberkas = "Surat Gugus Covid";             
                break;
             case 'kartukeluarga':
                $namaberkas = "Kartu Keluarga";                
                break;
            case 'vaksin':
                $namaberkas = "Vaksin";                
                break;
            case 'foto':
                $namaberkas = "foto_pra";                
                break;
            default:
                $this->template->display('pra_pelamar/registrasi/upload',$data);
                break;
        }

        $data['jenisberkas']    = $tipe;
        $data['namaberkas']     = $namaberkas;
        if ($tipe == "ktp"){
            $this->load->view('pra_pelamar/registrasi/formKTP',$data);
        }else{
            $this->load->view('pra_pelamar/registrasi/formUpload',$data);
        }
    }

    function do_upload($berkas){
        switch ($berkas) {
            case "ktp":
                $url = './dataupload/berkas_pra/ktp';
                $namaberkas = "KTP";
                break;          
            case "kartukeluarga":
                $url = './dataupload/berkas_pra/kartukeluarga';
                $namaberkas = "Kartu Keluarga";
                break;
            case "suratsehat":
                $url = './dataupload/berkas_pra/suratsehat';
                $namaberkas = "Surat Sehat";
                break;
            case "domisili":
                $url = './dataupload/berkas_pra/domisili';
                $namaberkas = "Domisili";
                break;
            case "suratguguscovid":
                $url = './dataupload/berkas_pra/suratguguscovid';
                $namaberkas = "Cek List Gugus Covid";
                break;
            case "vaksin":
                $url = './dataupload/berkas_pra/vaksin';
                $namaberkas = "Bukti Vaksinasi";
                break;
            case "foto":
                $url = './dataupload/berkas_pra/foto_pra';
                $namaberkas = "Foto";
                break;
            default:
                $url = './dataupload/berkas_pra';
                $namaberkas = "Lain-Lain";
                break;
        }

        $hdrid = $this->input->post("txthdrid");
        $namapelamar = $this->input->post("txtnamapelamar");
        $namafile = $hdrid.'_'.$berkas;
        // echo $hdrid.'/'.$namapelamar;
        $data['namapelamar']        = $namapelamar;
        $config['upload_path']      = $url;
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['file_name']        = $namafile.'.jpg';
        $config['max_size']         = '3072';

        $this->load->library('upload');
        $this->upload->initialize($config);
        if( $this->upload->do_upload('txtfile')){
            $this->upload->data();
            $data['errormsg']="<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Berhasil</strong></div>";
            $this->M_Pra_pelamar->update_db_berkas($hdrid,$berkas,$url.'/'.$namafile.'.jpg');
            // echo 'HAHAHAHA';
        }else{
            $error = $this->upload->display_errors();
            $data['errormsg']="<div class='alert alert-danger'><a class='close' data-dismiss='alert'><i class='fa fa-times'>&nbsp;</i></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Gagal</strong><br/>$error</div>";
            // echo "ckckckckck";
        }
        $data['databerkas']     = $this->M_Pra_pelamar->get_berkas($hdrid);
        $data['minimalberkas']  = $this->M_Pra_pelamar->get_minimalberkas($hdrid);
        $data['hdrid']  = $hdrid;
        $this->template->display('pra_pelamar/registrasi/upload',$data);
    }

    function edit(){
        $id = $this->uri->segment(3);
        $data['id'] = $id;
        $data['getPemborong'] = $this->M_Pra_pelamar->get_pemborong();
        $data['getMess'] = $this->M_Pra_pelamar->get_mess();
        $data['getPendidikan'] = $this->M_Pra_pelamar->get_pendidikan();
        $this->template->display('pra_pelamar/registrasi/edit',$data);
    }

    function ajaxEdit(){
        $id = $this->uri->segment(3);
        $data['getData'] = $this->M_Pra_pelamar->get_pelamar_by_id($id);
        $data['getPemborong'] = $this->M_Pra_pelamar->get_pemborong();
        $data['getMess'] = $this->M_Pra_pelamar->get_mess();
        $data['getPendidikan'] = $this->M_Pra_pelamar->get_pendidikan();
        $data['getjurusan'] = $this->M_Pra_pelamar->get_jurusan();
        $this->load->view('pra_pelamar/registrasi/ajax/ajaxEdit',$data);
    }

    function update(){
        $hdrid              = $this->input->post('txtHeaderID');
        $id                 = $this->input->post('txtid');
        $pemborong          = $this->input->post('selpemborong');
        $nama_lengkap       = $this->input->post('txtnama_lengkap');
        $nik_ktp            = $this->input->post('txtnik_ktp');
        $nik_kk             = $this->input->post('txtnik_kk');
        $tanggal_lahir      = $this->input->post('txttanggal_lahir');
        $nama_ibukandung    = $this->input->post('txtnama_ibukandung');
        $tanggal_kedatangan = $this->input->post('txttanggal_kedatangan');
        $asal_kedatangan    = $this->input->post('txtasal_kedatangan');
        $alamat_karantina   = $this->input->post('txtalamat_karantina');
        $jenis_kelamin      = $this->input->post('txtjenis_kelamin');
        $status             = $this->input->post('txtstatus');
        $keterangan         = $this->input->post('txtketarangan');
        $pendidikan         = $this->input->post('txtPendidikan');
        $jurusan            = $this->input->post('txtjurusan');

        $tgl_selesai_karantina  = date('d-m-Y', strtotime('+14 days', strtotime($tanggal_kedatangan)));
        $tgl_lock               = date('d-m-Y',strtotime('+3 days',strtotime($tgl_selesai_karantina)));

        $data = array(
            'IDPemborong'           => $pemborong,
            'Nama_Lengkap'          => $nama_lengkap,
            'Nik_Ktp'               => $nik_ktp,
            'Nik_Kk'                => $nik_kk,
            'Tanggal_Lahir'         => date('Y-m-d',strtotime($tanggal_lahir)),
            'Nama_Ibu_Kandung'      => $nama_ibukandung,
            'Tanggal_Kedatangan'    => $tanggal_kedatangan,
            'Asal_Kedatangan'       => $asal_kedatangan,
            'Alamat_Karantina'      => $alamat_karantina,
            'Jenis_Kelamin'         => $jenis_kelamin,
            'Status'                => $status,
            'Keterangan'            => $keterangan,
            'Pendidikan'            => $pendidikan,
            'Jurusan'               => $jurusan,
            'TanggalLock'           => date('Y-m-d',strtotime($tgl_lock)),
            'UpdateBy'              => $this->session->userdata('username'),
            'UpdateDate'            => date('Y-m-d H:i:s'),
        );

        if($pemborong != 15){ // Tidak Rsup
            $cekBerkas = $this->M_Pra_pelamar->cek_berkas($id);
                if($cekBerkas == NULL){
                    $result = $this->M_Pra_pelamar->update($id,$data);
                    $databerkas = array(
                        'Pra_PelamarID' => $id,
                    );
                    $result = $this->M_Pra_pelamar->simpanBerkas($databerkas);
                    if(!$result){
                        redirect('Pra_pelamar/uploadBerkas/'.$id.'/'.urldecode($nama_lengkap));
                    }else{
                        redirect('Pra_pelamar/edit/id?msg=failed');
                    }
                }else{
                    $result = $this->M_Pra_pelamar->update($id,$data);
                    if(!$result){
                        redirect('Pra_pelamar/uploadBerkas/'.$id.'/'.urldecode($nama_lengkap));
                    }else{
                        redirect('Pra_pelamar/edit/id?msg=failed');
                    }
                }
        }else{ // RSUP
            $cekBerkas = $this->M_Pra_pelamar->cek_berkas($id);
                if($cekBerkas == NULL){
                    $result = $this->M_Pra_pelamar->update($id,$data);

                    $data_regcalon = array(
                        'No_Ktp'         => $nik_ktp,
                        'No_kk'          => $nik_kk,
                        'NamaIbuKandung' => $nama_ibukandung,
                        'Tgl_Lahir'      => date('Y-m-d',strtotime($tanggal_lahir)),
                        'Jenis_Kelamin'  => $jenis_kelamin,
                        'Pendidikan'     => $pendidikan
                    );

                    $this->M_Pra_pelamar->update_registrasi($hdrid,$data_regcalon);

                    $databerkas = array(
                        'Pra_PelamarID' => $id,
                    );
                    $result = $this->M_Pra_pelamar->simpanBerkas($databerkas);
                    if(!$result){
                        redirect('Pra_pelamar/uploadBerkas/'.$id.'/'.urldecode($nama_lengkap));
                    }else{
                        redirect('Pra_pelamar/edit/id?msg=failed');
                    }
                }else{
                    $this->M_Pra_pelamar->update($id,$data);
                    $data_regcalon = array(
                        'No_Ktp'         => $nik_ktp,
                        'No_kk'          => $nik_kk,
                        'NamaIbuKandung' => $nama_ibukandung,
                        'Tgl_Lahir'      => date('Y-m-d',strtotime($tanggal_lahir)),
                        'Jenis_Kelamin'  => $jenis_kelamin,
                        'Pendidikan'     => $pendidikan
                    );

                    $result = $this->M_Pra_pelamar->update_registrasi($hdrid,$data_regcalon);
                    if(!$result){
                        redirect('Pra_pelamar/uploadBerkas/'.$id.'/'.urldecode($nama_lengkap));
                    }else{
                        redirect('Pra_pelamar/edit/id?msg=failed');
                    }
                }
        }
        
    }
    
    function Komplit(){
        $id = $this->uri->segment(3);

        $data = array(
            'Komplit' => 1,
            'KomplitBy' => $this->session->userdata('username'),
            'KomplitDate' => date('Y-m-d H:i:s'),
            'VerifikasiPra' => 1,
            'VerifikasiPraBy' => $this->session->userdata('username'),
            'VerifikasiPraDate' => date('Y-m-d H:i:s'),
        );

        $result = $this->M_Pra_pelamar->update($id,$data);
        if(!$result){
            redirect('Pra_pelamar/verifikasi?msg=komplit');
        }else{
            redirect('Pra_pelamar/edit/id?msg=failed');
        }
    }

    function batalverifikasipra(){
        $Id               = $this->input->post('txtPra_pelamarid');
        $Nama             = $this->input->post('txtNama');
        $Nik_ktp          = $this->input->post('txtNik_ktp');
        $Nik_kk           = $this->input->post('txtNik_kk');
        $Tgl_lahir        = $this->input->post('txtTgl_lahir');
        $Jenis_kelamin    = $this->input->post('txtJenis_kelamin');
        $Nama_ibu         = $this->input->post('txtNama_ibu');
        $Tgl_kedatangan   = $this->input->post('txtTgl_kedatangan');
        $Asal_kedatangan  = $this->input->post('txtAsal_kedatangan');
        $Alamat_karantina = $this->input->post('txtAlamat_karantina');

        $data = array(
            'VerifikasiPra'      => 0,
            'Komplit'            => NULL,
            'KomplitBy'          => NULL,
            'KomplitDate'        => NULL,
            'Tanggal_Kedatangan' => NULL,
            'Alamat_Karantina'   => NULL,    
        );

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        $this->M_Pra_pelamar->update($Id,$data);

        $dataHistory = array(
            'Pra_PelamarID' => $Id,
            'Nama_Lengkap' => $Nama,
            'Nik_Ktp' => $Nik_ktp,
            'Nik_Kk' => $Nik_kk,
            'Tanggal_Lahir' => $Tgl_lahir,
            'Jenis_Kelamin' => $Jenis_kelamin,
            'Nama_Ibu_Kandung' => $Nama_ibu,
            'Tanggal_Kedatangan' => $Tgl_kedatangan,
            'Asal_Kedatangan' => $Asal_kedatangan,
            'Alamat_Karantina' => $Alamat_karantina,
            'CreatedHistoryBy' => $this->session->userdata('username'),
            'CreatedHistoryDate' => date('Y-m-d H:i:s')
        );

        $this->M_Pra_pelamar->simpan_history_prapelamar($dataHistory);
        redirect('Pra_pelamar/verifikasi');
    }

    function monitoring(){

        $data['_getFormID']      = $this->input->get('id');
        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamar();
        $this->template->display('pra_pelamar/monitoring/index',$data);
    }

    ///////////////// Rekap Data ////////////
    function ajaxCari(){
        $cari   = $this->uri->segment(3);
        $data['cari'] = $cari;
        $this->load->view('pra_pelamar/monitoring/ajax/cari',$data);
    }

    function ajaxCariSudahKarantina(){
        $kategori = $this->uri->segment(3);

        $data['kategori'] = $kategori;
        // $data['getData'] = $this->M_Pra_pelamar->get_dataSudahKarantinaPerTanggal();
        $this->load->view('pra_pelamar/monitoring/ajax/ajax_sudah_karantina',$data);
    }

    function getDataSudahKarantinaPerTanggal(){
        $tanggal = $this->uri->segment(3);

        $data['_getData'] = $this->M_Pra_pelamar->get_dataSudahKarantinaPerTanggal($tanggal);
        $this->load->view('pra_pelamar/monitoring/ajax/sudah_karantina',$data);
    }

    function getDataSudahKarantinaPerRange(){
        $tgl_awal = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);

        $data['_getData'] = $this->M_Pra_pelamar->get_dataSudahKarantinaPerRange($tgl_awal,$tgl_akhir);
        $this->load->view('pra_pelamar/monitoring/ajax/sudah_karantina',$data);
    }

    function getDataBelumKarantinaPerRange(){
        $tgl_awal = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['_getData'] = $this->M_Pra_pelamar->get_dataBelumKarantinaPerRange($tgl_awal,$tgl_akhir);
        $this->load->view('pra_pelamar/monitoring/ajax/ajax_belumkarantina',$data);
    }

    function getDatacekSuhu(){
        $tanggal = $this->uri->segment(3);

        $data['getTanggal'] = $this->M_Pra_pelamar->get_tanggalceksuhu($tanggal);
        $data['getSuhu'] = $this->M_Pra_pelamar->get_suhu($tanggal);
        $data['tanggal'] = $tanggal;
        $this->load->view('pra_pelamar/monitoring/ajax/ajax_ceksuhunew',$data);

    }

    function ExportExcelCekSuhu(){
        $tanggal = $this->uri->segment(3);

        $data['tanggal'] = $this->M_Pra_pelamar->get_tanggal($tanggal);
        $data['_getData'] = $this->M_Pra_pelamar->get_suhu($tanggal);
        $this->load->view('pra_pelamar/monitoring/cetak/excel_cek_suhu',$data);

    }

    function getRekapPraPertanggal(){
        $bulan = $this->uri->segment(3);
        $tahun = $this->uri->segment(4);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['_getData'] = $this->M_Pra_pelamar->get_datapertanggal($bulan,$tahun);
        $this->load->view('pra_pelamar/monitoring/ajax/ajax_rekappertanggal',$data);
    }

    function ExportExcelRekapPertanggal(){
        $bulan = $this->uri->segment(3);
        $tahun = $this->uri->segment(4);


        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['tanggal'] = $tanggal;
        $data['_getData'] = $this->M_Pra_pelamar->get_datapertanggal($bulan,$tahun);
        $this->load->view('pra_pelamar/monitoring/cetak/cetak_pertanggal',$data);
    }

    ///////////////End//////////////

    function verifikasi(){

        $data['_getFormID']      = $this->input->get('id');
        $data['user'] = $this->session->userdata('userid');
        $data['pemborong'] = $this->M_Pra_pelamar->getMstPemborong();
        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamar();
        $this->template->display('pra_pelamar/registrasi/verifikasi',$data);
    }

     function ajaxCariTgl(){
        $cari = $this->uri->segment(3);

        $data['cari'] = $cari;
        $data['pemborong'] = $this->M_Pra_pelamar->getMstPemborong();
        $this->load->view('pra_pelamar/registrasi/ajax/cari',$data);

    }

    function ajaxCariTglmulaikarantina(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $cari      = $this->uri->segment(5);

        $data['user']       = $this->session->userdata('userid');
        $data['cari']       = $cari;
        $data['tgl_awal']   = $tgl_awal;
        $data['tgl_akhir']  = $tgl_akhir;
        $data['_getData']   = $this->M_Pra_pelamar->get_datapertanggalkarantina($tgl_awal,$tgl_akhir);
        $this->load->view('pra_pelamar/registrasi/ajax/getDataRange',$data);
    }

    function exportExcel_mulaiKarantina(){
        $tgl_awal  = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);

        $data['_getData']   = $this->M_Pra_pelamar->get_datapertanggalkarantina($tgl_awal,$tgl_akhir);
        $this->load->view('pra_pelamar/registrasi/print/excel',$data);
    }

    function ajaxData(){
        $tgl_awal   = $this->uri->segment(3);
        $tgl_akhir  = $this->uri->segment(4);
        $pbr        = $this->uri->segment(5);
        $cari       = $this->uri->segment(6);

        $data['user']       = $this->session->userdata('userid');
        $data['cari']       = $cari;
        $data['pbr']        = $pbr;
        $data['tgl_awal']   = $tgl_awal;
        $data['tgl_akhir']  = $tgl_akhir;
        $data['_getData']   = $this->M_Pra_pelamar->get_dataPraPelamarbyRange($tgl_awal,$tgl_akhir,$pbr);
        $this->load->view('pra_pelamar/registrasi/ajax/getDataRange',$data);
    }

    function exportExcel_registerpbr(){
        $tgl_awal   = $this->uri->segment(3);
        $tgl_akhir  = $this->uri->segment(4);
        $pbr        = $this->uri->segment(5);

        $data['_getData']   = $this->M_Pra_pelamar->get_dataPraPelamarbyRange($tgl_awal,$tgl_akhir,$pbr);
        $this->load->view('pra_pelamar/registrasi/print/excel',$data);

    }

    function ajaxDataAll(){
        $tgl_awal   = $this->uri->segment(3);
        $tgl_akhir  = $this->uri->segment(4);
        $pbr        = $this->uri->segment(5);
        $cari       = $this->uri->segment(6);

        // echo $tgl_awal.'/'.$tgl_akhir.'/'.$pbr.'/'.$cari;
        $data['user']       = $this->session->userdata('userid');
        $data['cari']       = $cari;
        $data['pbr']        = $pbr;
        $data['tgl_awal']   = $tgl_awal;
        $data['tgl_akhir']  = $tgl_akhir;
        $data['_getData']   = $this->M_Pra_pelamar->get_dataPraPelamarRangeAll($tgl_awal,$tgl_akhir);
        $this->load->view('pra_pelamar/registrasi/ajax/getDataRange',$data);
    }

    function exportExcel_registerall(){
        $tgl_awal = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);

        $data['_getData']   = $this->M_Pra_pelamar->get_dataPraPelamarRangeAll($tgl_awal,$tgl_akhir);
        $this->load->view('pra_pelamar/registrasi/print/excel',$data);
    }


    function ExportExcellRange(){
        $tgl_awal = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);

        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamarRangeAll($tgl_awal,$tgl_akhir);
        $this->load->view('pra_pelamar/registrasi/excelrangeall',$data);
    }

    // function viewDocs(){
    //     if('IS_AJAX') {
    //         $userID=$this->input->post('kode');
    //         $berkas=$this->input->post('nama');
    //         // echo $userID.'/'.$berkas;
    //         $data['_jenisBerkas'] = $berkas;
    //         $data['_getViewDocs'] = $this->M_Pra_pelamar->getDocs($userID);
    //         $this->load->view('pra_pelamar/registrasi/viewDocs',$data);
    //     }
    // }
    function viewDocs(){
        if('IS_AJAX') {
            $userID=$this->input->post('kode');
            $berkas=$this->input->post('nama');
            // echo $userID.'/'.$berkas;
            $cek = $this->M_Pra_pelamar->get_pelamar_by_id($userID);
            if($cek[0]->IDPemborong == 15){
                $data['_jenisBerkas'] = $berkas;
                $data['_getViewDocs'] = $this->M_Pra_pelamar->getDocs($userID);
                $this->load->view('pra_pelamar/registrasi/viewDocsKry',$data);
            }else{
                $data['_jenisBerkas'] = $berkas;
                $data['_getViewDocs'] = $this->M_Pra_pelamar->getDocs($userID);
                $this->load->view('pra_pelamar/registrasi/viewDocs',$data);
            }
            
        }
    }

    function cekPra(){
        $id = $this->input->get('id');

        $cekpra = $this->M_Pra_pelamar->cek_pra($id);
        foreach ($cekpra as $key) {
            $nama       = $key->Nama_Lengkap;
            $tgllahir   = $key->Tanggal_Lahir;
            $namaibu    = $key->Nama_Ibu_Kandung;
            if($key->Pemborong == 'RSUP'){
                $data['getCatatan'] = $this->M_Pra_pelamar->get_catatan($id);
                $data['getdata'] = $this->M_Pra_pelamar->get_dataK($nama,$tgllahir,$namaibu);
                $data['cekblacklistK'] = $this->M_Pra_pelamar->cek_blacklistK($nama,$tgllahir,$namaibu);
                $this->load->view('pra_pelamar/registrasi/ajax/cekprak',$data);
            }else{
                $data['getCatatan'] = $this->M_Pra_pelamar->get_catatan($id);
                $data['getdata'] = $this->M_Pra_pelamar->get_dataTK($nama,$tgllahir,$namaibu);
                $data['cekblacklistTK'] = $this->M_Pra_pelamar->cek_blacklistTK($nama,$tgllahir,$namaibu);
                 $data['cekblacklistTKDuaBulan'] = $this->M_Pra_pelamar->cek_blacklistTKDuaBulan($nama,$tgllahir,$namaibu);
                $this->load->view('pra_pelamar/registrasi/ajax/cekpratk',$data);
            }
        }
    }

    function simpanCatatan(){

        $id = $this->input->post('txtHeaderID');
        $catatan = $this->input->post('txtCatatan');

        $data = array(
            'Catatan' => $catatan,
        );

        // echo "hahahahah";
        $this->M_Pra_pelamar->update($id,$data);
        redirect('Pra_pelamar/verifikasi');
    }

    function infokepmh(){
        $info  = $this->uri->segment(3);
        $id    = $this->uri->segment(4);

        $data = array(
            'InfoKePmh_Kantin' => $info,
        );
        $this->M_Pra_pelamar->update($id,$data);
    }

     function selesai($hdrid){
        $id = $this->uri->segment(3);

         $data['getPra'] = $this->M_Pra_pelamar->cek_pra($hdrid);
         //updatestatusAktif untuk data karyawan
             $data = array(
                'StatusAktif' => 1,
            );
            $this->M_Pra_pelamar->update($id,$data);
        $data['getPra'] = $this->M_Pra_pelamar->cek_pra($hdrid);
         $this->template->display('pra_pelamar/registrasi/hasil',$data);
     }

     function verifikasi_ktp(){
        $id = $this->uri->segment(3);

        $data = array(
            'KTPVerifed' => 1,
            'KTPVerifedBy' => $this->session->userdata('username'), 
            'KTPVerifedDate' => date('Y-m-d H:i:s')
        );

        $this->M_Pra_pelamar->update_berkas($id,$data);
        redirect('Pra_pelamar/verifikasi');
     }

     function verifikasi_suratsehat(){
        $id = $this->uri->segment(3);

        $data = array(
            'SuratSehatVerifed' => 1,
            'SuratSehatVerifedBy' =>$this->session->userdata('username'), 
            'SuratSehatVerifedDate' => date('Y-m-d H:i:s')
        );

        $this->M_Pra_pelamar->update_berkas($id,$data);
        redirect('Pra_pelamar/verifikasi');
     }

     function verifikasi_domisili(){
        $id = $this->uri->segment(3);

        $data = array(
            'DomisiliVerifed' => 1,
            'DomisiliVerifedBy' => $this->session->userdata('username'), 
            'DomisiliVerifedDate' => date('Y-m-d H:i:s')
        );

        $this->M_Pra_pelamar->update_berkas($id,$data);
        redirect('Pra_pelamar/verifikasi');
     }

     function verifikasi_suratguguscovid(){
        $id = $this->uri->segment(3);

        $data = array(
            'GugusCovidVerifed' => 1,
            'GugusCovidVerifedBy' => $this->session->userdata('username'), 
            'GugusCovidVerifedDate' => date('Y-m-d H:i:s')
        );

        $this->M_Pra_pelamar->update_berkas($id,$data);
        redirect('Pra_pelamar/verifikasi');
     }

     function verifikasi_kartukeluarga(){
        $id = $this->uri->segment(3);

        $data = array(
            'KartuKeluargaVerifed' => 1,
            'KartuKeluargaVerifedBy' => $this->session->userdata('username'),
            'KartuKeluargaVerifedDate' =>  date('Y-m-d H:i:s')
        );

        $this->M_Pra_pelamar->update_berkas($id,$data);
        redirect('Pra_pelamar/verifikasi');
     }

     function verifikasi_vaksin(){
        $id = $this->uri->segment(3);

        $data = array(
            'VaksinVerifed' => 1,
            'VaksinVerifedBy' => $this->session->userdata('username'),
            'VaksinVerifedDate' =>  date('Y-m-d H:i:s')
        );

        $this->M_Pra_pelamar->update_berkas($id,$data);
        redirect('Pra_pelamar/verifikasi');
     }

     function hapusberkas(){
        $jenisberkas = $this->uri->segment(3);
        $id = $this->uri->segment(4);

        switch ($jenisberkas) {
            case "ktp":
                $url = 'dataupload/berkas_pra/ktp';
                $namaberkas = "KTP";
                break;          
            case "kartukeluarga":
                $url = 'dataupload/berkas_pra/kartukeluarga';
                $namaberkas = "Kartu Keluarga";
                break;
            case "suratsehat":
                $url = 'dataupload/berkas_pra/suratsehat';
                $namaberkas = "Surat Sehat";
                break;
            case "domisili":
                $url = 'dataupload/berkas_pra/domisili';
                $namaberkas = "Domisili";
                break;
            case "suratguguscovid":
                $url = 'dataupload/berkas_pra/suratguguscovid';
                $namaberkas = "Cek List Gugus Covid";
                break;
            default:
                $url = 'dataupload/berkas_pra';
                $namaberkas = "Lain-Lain";
                break;
        }



        $namafile = $id.'_'.$jenisberkas;
        // echo $namafile;
        $path = base_url($url.'/'.$jenisberkas.'/'.$namafile.'.jpg');
        // echo $path;
        // echo $url;
       
        if ($jenisberkas == 'ktp') {
             unlink($path);
            $data = array(
                'KTP' => NULL,
                'KTPVerifed' => NULL,
                'KTPVerifedBy' => NULL, 
                'KTPVerifedDate' => NULL
            );
            $this->M_Pra_pelamar->update_berkas($id,$data);
            redirect('Pra_pelamar/verifikasi');
        }elseif ($jenisberkas == 'kartukeluarga') {
            unlink($path);
           $data = array(
                'KartuKeluarga' => NULL,
                'KartuKeluargaVerifed' => NULL,
                'KartuKeluargaVerifedBy' => NULL,
                'KartuKeluargaVerifedDate' => NULL,
            );
           // print_r($data);
            $this->M_Pra_pelamar->update_berkas($id,$data);
            redirect('Pra_pelamar/verifikasi');
        }elseif ($jenisberkas == 'suratsehat') {
             unlink($path);
            $data = array (
                'SuratSehat' => NULL,
                'SuratSehatVerifed' => NULL,
                'SuratSehatVerifedBy' => NULL,
                'SuratSehatVerifedDate' => NULL,
            );
            $this->M_Pra_pelamar->update_berkas($id,$data);
            redirect('Pra_pelamar/verifikasi');
        }elseif ($jenisberkas == 'domisili') {
             unlink($path);
            $data = array (
                  'Domisili' => NULL,
                  'DomisiliVerifed' => NULL,
                  'DomisiliVerifedBy' => NULL,
                  'DomisiliVerifedDate' => NULL,
            );
            $this->M_Pra_pelamar->update_berkas($id,$data);
            redirect('Pra_pelamar/verifikasi');
        }elseif ($jenisberkas == 'suratguguscovid') {
             unlink($path);
             $data = array (
                 'SuratGugusCovid' => NULL,
                  'GugusCovidVerifed' => NULL,
                  'GugusCovidVerifedBy' => NULL,
                  'GugusCovidVerifedDate' => NULL,
            );
             $this->M_Pra_pelamar->update_berkas($id,$data);
            redirect('Pra_pelamar/verifikasi');
        }
    }

    function upload_berkas(){

        $data['_getFormID']      = $this->input->get('id');
        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamarupload();
        $this->template->display('pra_pelamar/registrasi/upload_berkas',$data);
    }

    function mulai_karantina(){
        $karantina  = $this->uri->segment(3);
        $id         = $this->uri->segment(4);

        if($karantina == '2'){
            $cek = $this->M_Pra_pelamar->cek_tenagakerja($id);
            if($cek != NULL){
                $data = array(
                    'MulaiKarantina' => $karantina
                );
                $this->M_Pra_pelamar->update($id,$data);
                $this->M_Pra_pelamar->delete_medical($cek[0]['HeaderID']);
            }else{
                $data = array(
                    'MulaiKarantina' => $karantina
                );
                $this->M_Pra_pelamar->update($id,$data);
            }
        }else{
            $data = array(
                'MulaiKarantina' => $karantina
            );
            $this->M_Pra_pelamar->update($id,$data);
        }
    }

    function export(){

        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamar();
        $this->load->view('pra_pelamar/registrasi/excel',$data);
    }

    function upload_cekSuhu(){

        $data['_getFormID']      = $this->input->get('id');
        $this->template->display('pra_pelamar/upload_file/upload_ceksuhu',$data);
    }

    function simpan_ceksuhu(){
        if(isset($_FILES["userfile"]["name"]))
        {
            $path           = $_FILES["userfile"]["tmp_name"];
            $object         = PHPExcel_IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet)
            {
                $highestRow     = $worksheet->getHighestRow();
                $highestColumn  = $worksheet->getHighestColumn();

                for($row=7; $row<=$highestRow; $row++)
                {   

                    $id                 = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $harikesatu_1       = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $harikesatu_2       = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $harikedua_1        = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $harikedua_2        = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $hariketiga_1       = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $hariketiga_2       = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $harikeempat_1       = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $harikeempat_2       = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $harikelima_1       = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                    $harikelima_2       = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                    $harikeenam_1       = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                    $harikeenam_2       = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                    $hariketujuh_1       = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                    $hariketujuh_2       = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                    $harikedelapan_1       = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                    $harikedelapan_2       = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                    $harikesembilan_1       = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
                    $harikesembilan_2       = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                    $harikesepuluh_1       = $worksheet->getCellByColumnAndRow(26, $row)->getValue();
                    $harikesepuluh_2       = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
                    $harikesebelas_1       = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
                    $harikesebelas_2       = $worksheet->getCellByColumnAndRow(29, $row)->getValue();
                    $harikeduabelas_1       = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
                    $harikeduabelas_2       = $worksheet->getCellByColumnAndRow(31, $row)->getValue();
                    $hariketigabelas_1       = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
                    $hariketigabelas_2       = $worksheet->getCellByColumnAndRow(33, $row)->getValue();
                    $harikeempatbelas_1       = $worksheet->getCellByColumnAndRow(34, $row)->getValue();
                    $harikeempatbelas_2       = $worksheet->getCellByColumnAndRow(35, $row)->getValue();

                    $cek = $this->M_Pra_pelamar->cek_dataceksuhu($id);
                    if($cek <= 0){
                       $data = array(
                        'Pra_PelamarID' => $id,
                        'HariKeSatu_1'  => $harikesatu_1,   
                        'HariKeSatu_2' => $harikesatu_2,
                        'HariKeDua_1' => $harikedua_1,
                        'HariKeDua_2' => $harikedua_2,
                        'HariKeTiga_1' => $hariketiga_1,
                        'HariKeTiga_2' => $hariketiga_2,
                        'HariKeEmpat_1' => $harikeempat_1,
                        'HariKeEmpat_2' => $harikeempat_2,
                        'HariKeLima_1' => $harikelima_1,
                        'HariKeLima_2' => $harikelima_2,
                        'HariKeEnam_1' => $harikeenam_1,
                        'HariKeEnam_2' => $harikeenam_2,
                        'HariKeTujuh_1' => $hariketujuh_1,
                        'HariKeTujuh_2' => $hariketujuh_2,
                        'HariKeDelapan_1' => $harikedelapan_1,
                        'HariKeDelapan_2' => $harikedelapan_2,
                        'HariKeSembilan_1' => $harikesembilan_1,
                        'HariKeSembilan_2' => $harikesembilan_2,
                        'HariKeSepuluh_1' => $harikesepuluh_1,
                        'HariKeSepuluh_2' => $harikesepuluh_2,
                        'HariKeSebelas_1' => $harikesebelas_1,
                        'HariKeSebelas_2' => $harikesebelas_2,
                        'HariKeDuabelas_1' => $harikeduabelas_1,
                        'HariKeDuabelas_2' => $harikeduabelas_2,
                        'HariKeTigabelas_1' => $hariketigabelas_1,
                        'HariKeTigabelas_2' => $hariketigabelas_2,
                        'HariKeEmpatbelas_1' => $harikeempatbelas_1,
                        'HariKeEmpatbelas_2' => $harikeempatbelas_2,
                        'CreatedBy' => $this->session->userdata('username'),
                        'CreatedDate' => date('Y-m-d H:i:s')
                    );

                    $this->M_Pra_pelamar->inputlistceksuhu($data);
                    }else{
                        $data = array(
                        'HariKeSatu_1'  => $harikesatu_1,
                        'HariKeSatu_2' => $harikesatu_2,
                        'HariKeDua_1' => $harikedua_1,
                        'HariKeDua_2' => $harikedua_2,
                        'HariKeTiga_1' => $hariketiga_1,
                        'HariKeTiga_2' => $hariketiga_2,
                        'HariKeEmpat_1' => $harikeempat_1,
                        'HariKeEmpat_2' => $harikeempat_2,
                        'HariKeLima_1' => $harikelima_1,
                        'HariKeLima_2' => $harikelima_2,
                        'HariKeEnam_1' => $harikeenam_1,
                        'HariKeEnam_2' => $harikeenam_2,
                        'HariKeTujuh_1' => $hariketujuh_1,
                        'HariKeTujuh_2' => $hariketujuh_2,
                        'HariKeDelapan_1' => $harikedelapan_1,
                        'HariKeDelapan_2' => $harikedelapan_2,
                        'HariKeSembilan_1' => $harikesembilan_1,
                        'HariKeSembilan_2' => $harikesembilan_2,
                        'HariKeSepuluh_1' => $harikesepuluh_1,
                        'HariKeSepuluh_2' => $harikesepuluh_2,
                        'HariKeSebelas_1' => $harikesebelas_1,
                        'HariKeSebelas_2' => $harikesebelas_2,
                        'HariKeDuabelas_1' => $harikeduabelas_1,
                        'HariKeDuabelas_2' => $harikeduabelas_2,
                        'HariKeTigabelas_1' => $hariketigabelas_1,
                        'HariKeTigabelas_2' => $hariketigabelas_2,
                        'HariKeEmpatbelas_1' => $harikeempatbelas_1,
                        'HariKeEmpatbelas_2' => $harikeempatbelas_2,
                        'CreatedBy' => $this->session->userdata('username'),
                        'CreatedDate' => date('Y-m-d H:i:s')
                    );

                    $this->M_Pra_pelamar->update_inputlistceksuhu($id,$data);
                    }
                }
            }
        }else{
            echo "string";
        } 

        redirect('Pra_pelamar/upload_cekSuhu?msg=success');
    }


    ///////////////// Modul Setting Target Pra Pelamar ////////////////

    function setting_target(){
         $data['_getFormID']      = $this->input->get('id');

        $this->template->display('pra_pelamar/setting_target/index',$data);                      
    }

    function get_list_tanggal(){
        $bulan = $this->input->post('Bulan');
        $tahun = $this->input->post('Tahun');

        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        $cek = $this->M_Pra_pelamar->cek($bulan,$tahun);
        if($cek == NULL){
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['tanggal'] = $tanggal;
            $this->load->view('pra_pelamar/setting_target/ajax/list',$data);
        }else{
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['tanggal'] = $tanggal;    
            $data['getTarget'] = $this->M_Pra_pelamar->get_target($bulan,$tahun);
            $this->load->view('pra_pelamar/setting_target/ajax/list_update',$data);
        }
    }

    function simpan_target(){
        $tanggal = $this->input->post('txtTanggal');
        $target = $this->input->post('txtTarget');
        $hitung = count($target);

        for ($i=0; $i < $hitung; $i++) { 
            // echo $hitung;
            $data = array(
                'Tanggal' => $tanggal[$i],
                'Target'  => $target[$i],
                'CreatedBy' => $this->session->userdata('username'),
                'CreatedDate' => date('Y-m-d H:i:s')
            );
            // print_r($data);
            $this->M_Pra_pelamar->simpan_target($data);
        }
        redirect('Pra_pelamar/setting_target');
    }

    function update_target(){
        $tanggal = $this->input->post('txtTanggal');
        $target  = $this->input->post('txtTarget');
        $id  = $this->input->post('txtid');
        $jml = count($tanggal);
        for ($i=0; $i < $jml; $i++) { 
            $cek_target = $this->M_Pra_pelamar->cek_target($id[$i]);
            foreach ($cek_target as $key) {
                $target1 = $key->Target;
                 if($target1 != $target[$i]){
                    $data = array(
                         'Tanggal'    => $tanggal[$i],
                         'Target'     => $target[$i],
                         'UpdateBy'   => $this->session->userdata('username'),
                         'UpdateDate' => date('Y-m-d H:i:s')
                    );
                    $this->M_Pra_pelamar->update_target($id[$i],$data);
                    $data2 = array(
                         'TargetID'      => $id[$i],
                         'Tanggal'       => $tanggal[$i],
                         'Target'        => $target1,
                         'CreatedBy'     => $this->session->userdata('username'),
                         'CreatedDate'   => date('Y-m-d H:i:s')
                     );

                     $this->M_Pra_pelamar->simpan_history($data2);
                }
            }
        }
         redirect('Pra_pelamar/setting_target');
    }


    function getCalonTenagaKerja(){
        $id = $this->input->get('id');
        $data['idpra'] = $id;
        $this->load->view('pra_pelamar/registrasi/ajax/calon_tenagakerja',$data);
    }

    function ajaxCalonTenagaKerjaID(){
         $id    = $this->input->post('id');
         $idpra = $this->input->post('idpra');


         $data['_getData'] = $this->M_Pra_pelamar->get_idcalontenagakerja($id);
         $data['idcalon'] = $id;
         $data['idpra'] = $idpra;
        $this->load->view('pra_pelamar/registrasi/ajax/get_idcalontk',$data);
    }

    function simpanidcalon(){
        $calonid = $this->uri->segment(3);
        $praid   = $this->uri->segment(4);

        $data = array(
            'Pra_PelamarID' => $praid
        );

        $this->M_Pra_pelamar->updatecalonid($calonid,$data);
        redirect('Pra_pelamar/verifikasi');
    }

    function tatalaksana(){
        $tatalaksana = $this->uri->segment(3);
        $id = $this->uri->segment(4);

        $data = array(
            'TipeTatalaksana' => $tatalaksana,
        );

        $this->M_Pra_pelamar->update($id,$data);
    }

    ///Modul Target Calon Karantina/////

    function setting_target_karantina(){
        $data['_getFormID']      = $this->input->get('id');
        $data['getData'] = $this->M_Pra_pelamar->getkuota();

        $this->template->display('pra_pelamar/setting_target_karantina/index',$data);
    }

    function ajaxTanggal()
    {
        $tanggal  = $this->uri->segment(3);

        $data['user']       = $this->session->userdata('userid');
        $data['tanggal']  = $tanggal;
        $data['_getData']   = $this->M_Pra_pelamar->kuotaByTanggal($tanggal);
        $this->load->view('pra_pelamar/setting_target_karantina/ajax/GetDataKuota',$data);
    }

    function inputTarget()
    {
        $data['Pemborong'] = $this->M_Pra_pelamar->get_pemborong();

        $this->template->display('pra_pelamar/setting_target_karantina/input',$data);
    }

    function simpanKuota()
    {
            $tanggal        = $this->input->post('txtTanggal');
            $pemborong      = $this->input->post('selpemborong');
            $kuota          = $this->input->post('txtkuota');
            $status         = $this->input->post('txtStatus');

            $data = array(
                'tanggalKarantina'      => $tanggal,
                'IDPemborong'           => $pemborong,
                'kuota'                 => $kuota,
                'Status'                => $status,
                'CreatedBy'             => $this->session->userdata('username'),
                'CreatedDate'           => date('Y-m-d H:i:s'),
            );
            $this->M_Pra_pelamar->simpan_kuota($data);

            redirect('Pra_pelamar/setting_target_karantina');
    }

    function InputKuota()
    {
        $data['_getFormID']      = $this->input->get('id');
        
        $data['kuota'] = $this->M_Pra_pelamar->kuota();        

        // echo"<pre>";
        // print_r($data['kuota']);
        // echo"</pre>";
        $this->template->display('pra_pelamar/setting_target_karantina/InputTKB',$data);
    }

    function ajaxKuota()
    {
        $tanggal = $this->uri->segment('3');

        $data['user']       = $this->session->userdata('userid');
        $data['tanggal']  = $tanggal;
        $data['_getData']   = $this->M_Pra_pelamar->getkuotaKarantina($tanggal);

        $this->load->view('pra_pelamar/setting_target_karantina/ajaxKuota',$data);
    }

    function TenagaKerjaTerdaftar()
    {
        $id_hdr = $this->input->get('id_hdr');

        $data['id_hdr'] = $id_hdr;
        $data['getData'] = $this->M_Pra_pelamar->JumlahTKBTerdaftar($id_hdr);

        // echo"<pre>";
        // print_r($data['getData']);
        // echo"</pre>";
        $this->template->display('pra_pelamar/setting_target_karantina/ajaxTenagakerjaTerdaftar',$data);
    }

    function inputTenagaKerja()
    {
        $id_hdr                  = $this->input->get('id_hdr');
        $id_pbr                  = $this->input->get('id_pbr');
        $tgl_karantina           = $this->input->get('tgl_karantina');
        $data['_getFormID']      = $this->input->get('id');
        // echo $id_hdr;
        $data['id_hdr'] = $id_hdr;
        $data['id_pbr'] = $id_pbr;
        $data['tgl_karantina'] = $tgl_karantina;
        $data['gettenaga'] = $this->M_Pra_pelamar->getTKB($id_hdr);
        // echo $tgl_karantina;

        $this->template->display('pra_pelamar/setting_target_karantina/InputTK',$data);
    }

    function CariCalonTk()
    {
        $idPra = $this->input->post('Pra_PelamarID');

        $data['_getTK'] = $this->M_Pra_pelamar->GetCalonTenagaKerja($idPra);

        
        $this->load->view('pra_pelamar/setting_target_karantina/ajax',$data);
    }

    function simpanTKB()
    {
        $id               = $this->input->post('txt_hdrid');
        $tanggalKarantina = $this->input->post('txt_tglkarantina');
        $IDPemborong      = $this->input->post('txt_pbrid');

        $Pra_pelamarID    = $this->input->post('idPra');
        $NamaLengkap      = $this->input->post('NamaID');
        $tanggalLahir     = $this->input->post('TglLahir');
        $NamaIbu          = $this->input->post('NamaIbu');

        $data = array(
            'ID'            => $id,
            'tanggalKarantina' => $tanggalKarantina,
            'IDPemborong'   => $IDPemborong,
            'Pra_PelamarID' => $Pra_pelamarID,
            'Nama'          => $NamaLengkap,
            'TanggalLahir'  => $tanggalLahir,
            'NamaIbu'       => $NamaIbu,
            'CreatedBy'     => $this->session->userdata('username'),
            'CreatedDate'   => date('Y-m-d H:i:s'),
        );

        $this->M_Pra_pelamar->simpan_namaTKB($data);
        redirect('Pra_pelamar/InputKuotaKarantina');
    }

    #VerifikasiPrioritas

    function Prioritas()
    {
                $data['groupid'] = $this->session->userdata('groupuser');

        $data['getData'] = $this->M_Pra_pelamar->getprioritasverifikasi();
        $this->template->display('pra_pelamar/Prioritas/Index',$data);
    }

    function ajaxMntSudahProses(){
        $cari = $this->uri->segment(3);
        $this->load->view('pra_pelamar/Prioritas/tanggal');
    }

    function AjaxPemborong()
    {
        $cari = $this->uri->segment(3);
        $this->load->view('pra_pelamar/Prioritas/pemborong');
    }

    function PrioritasPemborong()
    {
        $pemborong = $this->uri->segment(3);

        $data['groupid'] = $this->session->userdata('groupuser');
        $data['getData'] = $this->M_Pra_pelamar->getprioritasbypemborong($pemborong);
        $this->load->view('pra_pelamar/Prioritas/Ajax',$data);

    }

    function PrioritasByKosong()
    {
        $data['groupid'] = $this->session->userdata('groupuser');
        $data['getData'] = $this->M_Pra_pelamar->getprioritasBelumCatatan();
        $this->load->view('pra_pelamar/Prioritas/Ajax',$data);    
    }

    function PrioritasByAll()
    {
        $data['groupid'] = $this->session->userdata('groupuser');
        $data['getData'] = $this->M_Pra_pelamar->getprioritasAll();
        $this->load->view('pra_pelamar/Prioritas/Ajax',$data);
    }

    function PrioritasSudahProses()
    {
        $tglawal = $this->uri->segment(3);
        $tglakhir = $this->uri->segment(4);

        $data['groupid'] = $this->session->userdata('groupuser');
        $data['getData'] = $this->M_Pra_pelamar->getprioritasverifikasiSudahProses($tglawal,$tglakhir);
        $this->load->view('pra_pelamar/Prioritas/Ajax',$data);
    }

    function PrioritasByGagal()
    {
        $data['groupid'] = $this->session->userdata('groupuser');
        $data['getData'] = $this->M_Pra_pelamar->getprioritasgagal();
        $this->load->view('pra_pelamar/Prioritas/Ajax',$data);
    }

    function PrioritasBelumProses()
    {
        $data['groupid'] = $this->session->userdata('groupuser');
        $data['getData'] = $this->M_Pra_pelamar->getprioritasverifikasi();
        $this->load->view('pra_pelamar/Prioritas/Ajax',$data);    
    }

    function getPraPelamarPrioritas()
    {
        $idpra               = $this->input->post('txtRegisterID');

        $cekdata = $this->M_Pra_pelamar->getPrioritas($idpra);
        $data = array(
                'Pra_PelamarID' => $idpra,
                'CreatedBy'     => $this->session->userdata('username'),
                'CreatedDate'   => date('Y-m-d H:i:s'),
            );
        if($cekdata != NULL){
             
            redirect('Pra_pelamar/Prioritas?msg=failed2');
        }else{
            $this->M_Pra_pelamar->simpanDataPrioritas($data);
            redirect('Pra_pelamar/Prioritas?msg=success');
        }

    }

    function InputCatatan(){
        $id = $this->input->get('id');

        $data['id'] = $id;
        $data['getCatatan'] = $this->M_Pra_pelamar->getCatatan($id);
        $this->load->view("pra_pelamar/Prioritas/catatan",$data);
    }

    function simpan_catatan(){
        $ID = $this->input->post("txtID");
        $catatan = $this->input->post("txtCatatan");

        $data = array(
            'Catatan'       => $catatan,
            'CatatanBy'     => $this->session->userdata('username'),
            'CatatanDate'   => date('Y-m-d H:i:s')
        );

        $this->M_Pra_pelamar->update_catatan($ID,$data);
        redirect(site_url('Pra_pelamar/Prioritas'));
    }

    function UpdatePrioritas(){
        $info  = $this->uri->segment(3);
        $id    = $this->uri->segment(4);

        $data = array(
            'StatusPrioritas' => $info,
            'PrioritasBy'     => $this->session->userdata('username'),
            'PrioritasDate'   => date('Y-m-d H:i:s')
        );
        $this->M_Pra_pelamar->update($id,$data);
    }
}