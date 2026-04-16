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
		$data['getPemborong'] = $this->M_Pra_pelamar->get_pemborong();
        $data['getPendidikan'] = $this->M_Pra_pelamar->get_pendidikan();
		$this->template->display('pra_pelamar/registrasi/index',$data);
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
		$pemborong 			= $this->input->post('selpemborong');
		$nama_lengkap 		= $this->input->post('txtnama_lengkap');
		$nik_ktp 			= $this->input->post('txtnik_ktp');
		$nik_kk 			= $this->input->post('txtnik_kk');
		$tanggal_lahir 		= $this->input->post('txttanggal_lahir');
		$nama_ibukandung 	= $this->input->post('txtnama_ibukandung');
		$tanggal_kedatangan = $this->input->post('txttanggal_kedatangan');
		$asal_kedatangan 	= $this->input->post('txtasal_kedatangan');
		$alamat_karantina 	= $this->input->post('txtalamat_karantina');
		$jenis_kelamin 		= $this->input->post('txtjenis_kelamin');
		$status 			= $this->input->post('txtstatus');
        $pendidikan         = $this->input->post('txtPendidikan');
        $jurusan            = $this->input->post('txtjurusan');


		$cekData = $this->M_Pra_pelamar->cek_dataPraPelamar($nama_lengkap,$nik_ktp);

		if($cekData == null){
			$data = array(
				'IDPemborong' 			=> $pemborong,
				'Nama_Lengkap' 			=> $nama_lengkap,
				'Nik_Ktp' 				=> $nik_ktp,
				'Nik_Kk' 				=> $nik_kk,
				'Tanggal_Lahir' 		=> $tanggal_lahir,
				'Nama_Ibu_Kandung' 		=> $nama_ibukandung,
				'Tanggal_Kedatangan' 	=> $tanggal_kedatangan,
				'Asal_Kedatangan' 	 	=> $asal_kedatangan,
				'Alamat_Karantina' 		=> $alamat_karantina,
				'Jenis_Kelamin' 		=> $jenis_kelamin,
				'Status' 				=> $status,
                'Pendidikan'            => $pendidikan,
                'Jurusan'               => $jurusan,
				'CreatedBy' 			=> $this->session->userdata('username'),
				'CreatedDate'  			=> date('Y-m-d H:i:s'),
			);

			$pra_pelamarid = $this->M_Pra_pelamar->simpan($data);
            $dataBerkas = array(
                'Pra_PelamarID' => $pra_pelamarid
            );

            $this->M_Pra_pelamar->simpanBerkas($dataBerkas);
			redirect('Pra_pelamar/registrasi/?msg=success');
		}else{
			redirect('Pra_pelamar/registrasi/?msg=failed');
		}
	}

	function uploadBerkas(){
		$pra_pelamarid 	= $this->uri->segment(3);
		$nama_lengkap 	= urldecode($this->uri->segment(4));

		$data['databerkas'] 	= $this->M_Pra_pelamar->get_berkas($pra_pelamarid);
		$data['minimalberkas'] 	= $this->M_Pra_pelamar->get_minimalberkas($pra_pelamarid);
		$data['hdrid'] 			= $pra_pelamarid;
		$data['namapelamar']	= urldecode($nama_lengkap);
        $data['errormsg']		= "";
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
        $data['databerkas'] 	= $this->M_Pra_pelamar->get_berkas($hdrid);
		$data['minimalberkas'] 	= $this->M_Pra_pelamar->get_minimalberkas($hdrid);
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
		$id 				= $this->input->post('txtid');
		$pemborong 			= $this->input->post('selpemborong');
		$nama_lengkap 		= $this->input->post('txtnama_lengkap');
		$nik_ktp 			= $this->input->post('txtnik_ktp');
		$nik_kk 			= $this->input->post('txtnik_kk');
		$tanggal_lahir 		= $this->input->post('txttanggal_lahir');
		$nama_ibukandung 	= $this->input->post('txtnama_ibukandung');
		$tanggal_kedatangan = $this->input->post('txttanggal_kedatangan');
		$asal_kedatangan 	= $this->input->post('txtasal_kedatangan');
		$alamat_karantina 	= $this->input->post('txtalamat_karantina');
		$jenis_kelamin 		= $this->input->post('txtjenis_kelamin');
		$status 			= $this->input->post('txtstatus');
        $keterangan         = $this->input->post('txtketarangan');
        $pendidikan         = $this->input->post('txtPendidikan');
        $jurusan            = $this->input->post('txtjurusan');

		$data = array(
			'IDPemborong' 			=> $pemborong,
			'Nama_Lengkap' 			=> $nama_lengkap,
			'Nik_Ktp' 				=> $nik_ktp,
			'Nik_Kk' 				=> $nik_kk,
			'Tanggal_Lahir' 		=> $tanggal_lahir,
			'Nama_Ibu_Kandung' 		=> $nama_ibukandung,
			'Tanggal_Kedatangan' 	=> $tanggal_kedatangan,
			'Asal_Kedatangan' 	 	=> $asal_kedatangan,
			'Alamat_Karantina' 		=> $alamat_karantina,
			'Jenis_Kelamin' 		=> $jenis_kelamin,
			'Status' 				=> $status,
            'Keterangan'            => $keterangan,
            'Pendidikan'            => $pendidikan,
            'Jurusan'               => $jurusan,
			'UpdateBy' 				=> $this->session->userdata('username'),
			'UpdateDate'  			=> date('Y-m-d H:i:s'),
		);

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
			'VerifikasiPraBy'    => $this->session->userdata('username'),
			'VerifikasiPraDate'  => date('Y-m-d H:i:s'),
			'Komplit'            => NULL,
			'KomplitBy'          => NULL,
			'KomplitDate'        => NULL,
            'Tanggal_Kedatangan' => NULL,
            'Alamat_Karantina'   => NULL,    
		);

        $this->M_Pra_pelamar->update($id,$data);

        $dataHistory = array(
            'Nama_Lengkap' => $Nama ,
            'Nik_Ktp' => $Nik_ktp ,
            'Nik_Kk' => $Nik_kk ,
            'Tanggal_Lahir' => $Tgl_lahir ,
        );
		// redirect('Pra_pelamar/verifikasi');
	}

    function monitoring(){

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

        $data['user'] = $this->session->userdata('userid');
        $data['pemborong'] = $this->M_Pra_pelamar->getMstPemborong();
		$data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamar();
		$this->template->display('pra_pelamar/registrasi/verifikasi',$data);
	}

    function ajaxData(){
        $tgl_awal = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);
        $pbr = $this->uri->segment(5);

        // echo $tgl_awal.'/'.$tgl_akhir;
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['user'] = $this->session->userdata('userid');
        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamarbyRange($tgl_awal,$tgl_akhir,$pbr);
        $this->load->view('pra_pelamar/registrasi/ajax/getDataRange',$data);
    }

    function ajaxDataAll(){
        $tgl_awal = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        $data['user'] = $this->session->userdata('userid');
        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamarRangeAll($tgl_awal,$tgl_akhir);
        $this->load->view('pra_pelamar/registrasi/ajax/getDataRange',$data);
    }

    function ExportExcellRange(){
        $tgl_awal = $this->uri->segment(3);
        $tgl_akhir = $this->uri->segment(4);

        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamarRangeAll($tgl_awal,$tgl_akhir);
        $this->load->view('pra_pelamar/registrasi/excelrangeall',$data);
    }

	function viewDocs(){
        if('IS_AJAX') {
            $userID=$this->input->post('kode');
            $berkas=$this->input->post('nama');
            // echo $userID.'/'.$berkas;
            $data['_jenisBerkas'] = $berkas;
            $data['_getViewDocs'] = $this->M_Pra_pelamar->getDocs($userID);
            $this->load->view('pra_pelamar/registrasi/viewDocs',$data);
        }
    }

    function cekPra(){
    	$id = $this->input->get('id');

    	$cekpra = $this->M_Pra_pelamar->cek_pra($id);
    	foreach ($cekpra as $key) {
    		$nama 		= $key->Nama_Lengkap;
    		$tgllahir 	= $key->Tanggal_Lahir;
    		$namaibu 	= $key->Nama_Ibu_Kandung;
    		if($key->Pemborong == 'RSUP'){
    			$data['getCatatan'] = $this->M_Pra_pelamar->get_catatan($id);
    			$data['getdata'] = $this->M_Pra_pelamar->get_dataK($nama,$tgllahir,$namaibu);
    			$this->load->view('pra_pelamar/registrasi/ajax/cekprak',$data);
    		}else{
    			$data['getCatatan'] = $this->M_Pra_pelamar->get_catatan($id);
    			$data['getdata'] = $this->M_Pra_pelamar->get_dataTK($nama,$tgllahir,$namaibu);
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

        // echo "<pre>";
        // print_r($info);
        // echo "</pre>";

    	$data = array(
    		'InfoKePmh_Kantin' => $info,
    	);

        // echo $info.'/'.$id;
    	$this->M_Pra_pelamar->update($id,$data);
    }

     function selesai($hdrid){

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

        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamar();
        $this->template->display('pra_pelamar/registrasi/upload_berkas',$data);
    }

    function mulai_karantina(){
        $karantina  = $this->uri->segment(3);
        $id         = $this->uri->segment(4);

        $data = array(
            'MulaiKarantina' => $karantina
        );
        $this->M_Pra_pelamar->update($id,$data);
    }

    function export(){

        $data['_getData'] = $this->M_Pra_pelamar->get_dataPraPelamar();
        $this->load->view('pra_pelamar/registrasi/excel',$data);
    }

    function upload_cekSuhu(){

        $this->template->display('pra_pelamar/upload_file/upload_ceksuhu');
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

        $this->template->display('pra_pelamar/setting_target/index');                      
    }

    function get_list_tanggal(){
        $bulan = $this->input->post('Bulan');
        $tahun = $this->input->post('Tahun');

        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['tanggal'] = $tanggal;
        $this->load->view('pra_pelamar/setting_target/ajax/list',$data);
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
}