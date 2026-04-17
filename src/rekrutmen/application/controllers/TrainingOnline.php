<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class TrainingOnline extends CI_Controller
class TrainingOnlinexx extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 * Ifa Sonia Istifarani
	 * ITD 24
	 */

	function __construct()
	{
		parent::__construct();
		$this->load->model("M_TrainingOnline");

		date_default_timezone_set("Asia/Jakarta");
	}

	public function index()
	{

		$ip = $this->session->userdata('ipaddress');

		$id = $this->uri->segment(3);

		$data['linkSoal'] = $this->M_TrainingOnline->UnikSoal($id);

		$id_dept   		= $data['linkSoal']->DeptID;
		$jenis_id     	= $data['linkSoal']->JenisSoal;
		$materi       	= $data['linkSoal']->IKPMateriDtl;
		$idHdrSoal    	= $data['linkSoal']->IdMstSoalHdr;

		$data['_dept']        = $this->M_TrainingOnline->_getDept($id_dept);
		$data['jenis_soal']   = $jenis_id;
		$data['materi']       = $this->M_TrainingOnline->_getMateri($materi, $id_dept, $idHdrSoal);

		$data['getSoal']      = $this->M_TrainingOnline->_getSoal($idHdrSoal);
		$data['_getWaktu']    = $this->M_TrainingOnline->getWaktu($idHdrSoal);

		if ($ip != '192.168.0.194') {
			$this->template->display('training_online/index_old', $data);
		} else {
			$this->template->display('training_online/index_old', $data);
		}
	}
	function get_tanda_tangan()
	{
		$this->load->view('training_online/view_TandaTangan');
	}
	function simpan_ttd()
	{
		$dt_karyawanSt = $this->input->post('txtkaryawanSt');

		if ($dt_karyawanSt == 1) {
			// $upload_dir = "assets/ttdtraining/Regno/";
			$upload_dir = FCPATH . "backup/regno/";
		} else if ($dt_karyawanSt == 2) {
			// $upload_dir = "assets/ttdtraining/Fixno/";
			$upload_dir =  FCPATH . "backup/fixno/";
		}

		$img = $this->input->post('hidden_data');
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);

		$file = $upload_dir . $this->input->post('txtfixreg') . ".png";

		$success = file_put_contents($file, $data);
		// print $success ? $data : $file.' Unable to save the file.';
	}

	public function getRuangan()
	{
		$ruangan = $this->uri->segment(3);
		if ($ruangan == 3) {
			echo '<input type="text" name="txtNamaRuangan" id="nama_ruangan" class="form-control" placeholder="Input Ruangan/Lokasi" required>';
		} else {
			echo '<input type="hidden" name="txtNamaRuangan" id="nama_ruangan" class="form-control">';
		}
	}

	public function getDataSoal()
	{
		$materi               = $this->uri->segment(3);
		$jenis_id             = $this->uri->segment(4);
		$idHdrSoal            = $this->uri->segment(5);
		$nik_id               = $this->uri->segment(6);

		$jml = strLen($nik_id);
		if ($jml == 5) {
			$karyawan = $this->M_TrainingOnline->_getTenagaKerjaKaryawan($nik_id);
			$regfix = $karyawan->RegFixno;
			$nama = $karyawan->Nama;
		} else {
			$harbor = $this->M_TrainingOnline->_getTenagaKerjaKaryawan($nik_id);
			$regfix = $harbor->Fixno;
			$nama = $harbor->Nama;
		}

		$dataHdr = array(
			'RegFix' 		=> $regfix,
			'CreatedBy'     => $nama,
			'CreatedDate'   => date('Y-m-d H:i:s')
		);

		$hdrid = $this->M_TrainingOnline->simpanHdr($dataHdr);

		$getSoal = $this->M_TrainingOnline->_getSoal($idHdrSoal);
		$jml_soal = count($getSoal);
		for ($i = 0; $i < $jml_soal; $i++) {
			// echo $jml_soal[$i];
			$dataDtl = array(
				'HeaderID' => $hdrid,
				'IDSoal'   => $getSoal[$i]->IDSoal,
			);

			// echo "<pre>";
			// print_r($dataDtl);
			$this->M_TrainingOnline->simpanDtl($dataDtl);
		}


		$data['jenis_soal'] = $jenis_id;
		$data['idHdrSoal']  = $idHdrSoal;
		$data['getSoal']    = $this->M_TrainingOnline->_getSoalAwal($idHdrSoal, $hdrid);
		$data['_getWaktu'] = $this->M_TrainingOnline->getWaktu($idHdrSoal);
		$data['hdrid'] = $hdrid;

		// echo "<pre>";
		// print_r($data['getSoal']);
		$this->load->view('training_online/getDataSoal', $data);
	}

	public function cari_tenaga_kerja()
	{
		$nik 		= $this->uri->segment(3);
		$deptid		= $this->uri->segment(4);

		$data['status_tk']			= $this->uri->segment(5);
		$data['_getTenagaKerjaKar'] = $this->M_TrainingOnline->_getTenagaKerjaKaryawan($nik, $deptid);

		if ($data['_getTenagaKerjaKar'] != '') {
			$this->load->view('training_online/getDataDiriKar', $data);
		} else {
			echo "";
		}
	}

	public function get_tenaga_kerja()
	{
		$nik    = $this->input->post('nik');
		$deptid = $this->input->post('dept');
		// $status_tk    = $this->input->post('status_tk');

		$req          = $this->M_TrainingOnline->_getTenagaKerjaKaryawan($nik, $deptid);

		if (count($req) > 0) {
			$get = array(
				'status'  => true,
				'vstatus' => 'berhasil',
				'pesan'   => "Berhasil Memuat data, \nSilahkan simpan\nTerlebih dahulu!",
				'data'    => $req,
			);
		} else {
			$get = array(
				'status'  => false,
				'vstatus' => 'gagal',
				'pesan'   => "Data detail tidak ditemukan!!!",
			);
		}

		echo json_encode($get);
	}

	public function get_calon_tk()
	{
		$HeaderID   = $this->input->post('id_register');
		$DeptTujuan = $this->input->post('dept_text');

		$req = $this->M_TrainingOnline->getIdRegisterTkb($HeaderID, $DeptTujuan);

		if (count($req) > 0) {
			$get = array(
				'status'  => true,
				'vstatus' => 'berhasil',
				'pesan'   => "Berhasil Memuat data, \nSilahkan simpan\nTerlebih dahulu!",
				'data'    => $req,
			);
		} else {
			$get = array(
				'status'  => false,
				'vstatus' => 'gagal',
				'pesan'   => "Data detail tidak ditemukan!!!",
			);
		}

		echo json_encode($get);
	}

	public function getKategoriMateri()
	{
		$status_tk = $this->input->post('data');

		$req          = $this->M_TrainingOnline->getMstKategoriMateri($status_tk);

		if (count($req) > 0) {
			$get = array(
				'status'  => true,
				'vstatus' => 'berhasil',
				'pesan'   => "Berhasil Memuat data!",
				'data'    => $req,
			);
		} else {
			$get = array(
				'status'  => false,
				'vstatus' => 'gagal',
				'pesan'   => "Data Materi tidak ditemukan!!!",
			);
		}

		echo json_encode($get);
	}

	public function get_data()
	{
		$nik 	= $this->uri->segment(3);
		$status = $this->uri->segment(4);

		// echo $nik;

		if ($status == 0) {
			$data['_getTenagaKerjaKar'] = $this->M_TrainingOnline->_getTenagaKerjaKaryawan($nik);
			$this->load->view('training_online/getDataDiriKar', $data);
		} else {
			// echo "har";
			$data['_getTenagaKerjaHar'] = $this->M_TrainingOnline->_getTenagaKerjaHarian($nik);
			$this->load->view('training_online/getDataDiriHar', $data);
		}
	}

	function simpan()
	{
		/* Header */
		$nik_id           = $this->input->post("nik_id");
		$idPerson         = $this->input->post("idPerson");
		$karyawanSt       = $this->input->post("karyawanSt");
		$dept             = $this->input->post("dept");
		$bagianID         = $this->input->post("bagianID");
		$jenis_soal       = $this->input->post("jenis_soal");
		$materidtl_id     = $this->input->post("materidtl_id");
		$ruangan          = $this->input->post("ruangan");
		//$nama_ruangan 	= $this->input->post("nama_ruangan");
		$nama_lengkap     = $this->input->post("nama_lengkap");
		$txtHdrSoal       = $this->input->post("txtHdrSoal");
		$hdrid_jawaban    = $this->input->post("hdrid_jawaban");

		$nik = $nik_id;
		$jml = strLen($nik);
		if ($jml == 5) {
			$karyawan = $this->M_TrainingOnline->_getTenagaKerjaKaryawan($nik);
			$regfix   = $karyawan->RegFixno;
			$nama     = $karyawan->Nama;
		} else {
			$harbor   = $this->M_TrainingOnline->_getTenagaKerjaKaryawan($nik);
			$regfix   = $harbor->RegFixno;
			$nama     = $harbor->Nama;
		}


		if ($bagianID != $dept) {
			$error1 = 'bedadept';
			echo json_encode($error1);
		} else {
			$cekNofix = $this->M_TrainingOnline->cekNofix($regfix, $txtHdrSoal);
			if ($cekNofix->nofix == 3) {
				$error = 'lebih3x';
				echo json_encode($error);
			} else {

				if ($karyawanSt == 1) {
					// $upload_dir = "assets/ttdtraining/Regno/";
					$upload_dir = FCPATH . "backup/regno/";
				} else if ($karyawanSt == 2) {
					// $upload_dir = "assets/ttdtraining/Fixno/";
					$upload_dir = FCPATH . "backup/fixno/";
				}

				$img = $this->input->post('hidden_data');
				$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);

				$file = $upload_dir . $this->input->post('fixreg') . ".png";

				file_put_contents($file, $data);

				$dataHdr = array(
					'PersonID' 		=> $idPerson,
					'Status' 		=> $karyawanSt,
					'DeptID' 		=> $dept,
					'JenisSoal' 	=> $jenis_soal,
					'IKPMateriDtl' 	=> $materidtl_id,
					'Lokasi' 		=> $ruangan,
					//'NamaRuangan'	=> $nama_ruangan,
					'IDMstSoalHdr'	=> $txtHdrSoal,
					'UpdateBy' 		=> $nama,
					'UpdateDate' 	=> date('Y-m-d H:i:s')
				);

				//echo json_encode($dataHdr);
				$this->M_TrainingOnline->UpdateHdr($hdrid_jawaban, $dataHdr);

				// // /* Detail */

				$data 			= $this->input->post("data_jawaban");

				$jmlDtl = count($data);
				$success = 0;
				for ($i = 0; $i < $jmlDtl; $i++) {
					$dataDtl = array(
						'IDSoal' 		=> $data[$i]["soal_id"],
						'IDObjectif' 	=> $data[$i]["jawaban"],
					);

					//echo $hdrid;
					$this->M_TrainingOnline->updateDtl($data[$i]["detailid"], $dataDtl);
					$success++;
				}
				echo json_encode($success);
			}
		}


		// echo json_encode($dataDtl);
		// echo "<pre>";
		// print_r($dataDtl);
	}


	// BEGIN HASIL TRAINING ONLINE 

	function lihat_hasil()
	{
		$hdrid    = $this->input->get('hdrid');
		$status   = $this->input->get('status');
		$fixregno = $this->input->get('fixregno');
		$nama     = $this->input->get('nama');

		if ($status == 1) {
			// echo "karyawan";
			$get_data = $this->M_TrainingOnline->_getTenagaKerjaHasilK($hdrid, $status);
			$data['_getData'] = $get_data;
		} else {
			// echo "harian/borongan";
			$get_data = $this->M_TrainingOnline->_getTenagaKerjaHasilH($hdrid, $status);
			$data['_getData'] = $get_data;
		}

		$data['_getSoal']   = $this->M_TrainingOnline->_getSoalAwal($get_data[0]->IDMstSoalHdr, $hdrid);
		$data['hdrid']      = $hdrid;
		$data['status']     = $status;
		$data['fixregno']   = $fixregno;
		$data['nama']       = $nama;
		// echo "<pre>";
		// print_r($data['_getSoal']); die();

		$this->template->display('training_online/lihat_hasil', $data);
	}

	// END HASIL TRAINING ONLINE
}
