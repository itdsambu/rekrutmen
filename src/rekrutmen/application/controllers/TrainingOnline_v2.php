<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TrainingOnline_v2 extends CI_Controller
// class TrainingOnline_v2s extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("M_TrainingOnline");

        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
        $id = $this->uri->segment(3);

        $data['linkSoal']   = $this->M_TrainingOnline->UnikSoal($id);

        $id_dept        = $data['linkSoal']->DeptID;
        $jenis_id       = $data['linkSoal']->JenisSoal;
        $materi         = $data['linkSoal']->IKPMateriDtl;
        $idHdrSoal      = $data['linkSoal']->IdMstSoalHdr;

        $data['_dept']        = $this->M_TrainingOnline->_getDept($id_dept);
        $data['jenis_soal']   = $jenis_id;
        $data['materi']       = $this->M_TrainingOnline->_getMateri($materi, $id_dept, $idHdrSoal);
        $data['getSoal']      = $this->M_TrainingOnline->_getSoal($idHdrSoal);
        $data['_getWaktu']    = $this->M_TrainingOnline->getWaktu($idHdrSoal);

        // http://192.168.3.5/rekrutmen/


        // echo "<pre>";
        // print_r (base_url());
        // echo "</pre>";
        // exit();


        // print_r($data['linkSoal']); die();
        $this->load->view("training_online/moduleElc", $data);
    }

    public function getTenagaKerja()
    {
        $nik    = $this->input->post('nik');
        $deptid = $this->input->post('dept');

        $req = $this->M_TrainingOnline->_getTenagaKerjaKaryawan($nik, $deptid);

        if (count($req) > 0) {
            $get = array(
                'status'  => true,
                'vstatus' => 'berhasil',
                'pesan'   => "Berhasil Memuat data ...!!",
                'data'    => $req,
            );
        } else {
            $get = array(
                'status'  => false,
                'vstatus' => 'gagal',
                'pesan'   => "Data detail tidak ditemukan ...!!",
            );
        }

        echo json_encode($get);
    }

    public function getKategoriMateri()
    {
        $status_tk = $this->input->post('data');
        $materidtl = $this->input->post('materidtl');

        if ($status_tk == '1') {
            $req = $this->M_TrainingOnline->getMstKategoriMateri_tk();
        } else {
            $req = $this->M_TrainingOnline->getMstKategoriMateri_nonTK();
        }

        $req = $this->M_TrainingOnline->getMstKategoriMateri($status_tk);

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

    public function getCalonTk()
    {
        $HeaderID   = $this->input->post('id_register');
        $DeptTujuan = $this->input->post('dept_text');

        $req = $this->M_TrainingOnline->getIdRegisterTkb($HeaderID, $DeptTujuan);

        if (count($req) > 0) {
            $get = array(
                'status'  => true,
                'vstatus' => 'berhasil',
                'pesan'   => "Berhasil Memuat data...!!",
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

    public function getDataSoal()
    {
        $materi               = $this->uri->segment(3);
        $idKategory           = $this->uri->segment(4);
        $jenis_id             = $this->uri->segment(5);
        $idHdrSoal            = $this->uri->segment(6);
        $nik_id               = trim($this->uri->segment(7));
        $fixreg               = $this->uri->segment(8);



        $jml = strLen($nik_id);

        if ($jml == 5) {
            $karyawan   = $this->M_TrainingOnline->_getTenagaKerjaKaryawan_elc($nik_id);
            $regfix     = $karyawan->RegFixno;
            $nama       = $karyawan->Nama;
        } else {
            $harbor   = $this->M_TrainingOnline->_getTenagaKerjaKaryawan_elc($nik_id);
            // $regfix   = $harbor->Fixno;
            $regfix   = $fixreg;
            $nama     = $harbor->Nama;
        }

        $dataHdr = array(
            'RegFix'             => $regfix,
            'KategoriMateri'    => $idKategory,
            'CreatedBy'         => $nama,
            'CreatedDate'       => date('Y-m-d H:i:s')
        );

        $hdrid = $this->M_TrainingOnline->simpanHdr($dataHdr);

        $getSoal = $this->M_TrainingOnline->_getSoal($idHdrSoal);
        $jml_soal = count($getSoal);
        for ($i = 0; $i < $jml_soal; $i++) {
            $dataDtl = array(
                'HeaderID' => $hdrid,
                'IDSoal'   => $getSoal[$i]->IDSoal,
            );

            $this->M_TrainingOnline->simpanDtl($dataDtl);
        }


        $data['jenis_soal']   = $jenis_id;
        $data['idHdrSoal']    = $idHdrSoal;
        $data['getSoal']      = $this->M_TrainingOnline->_getSoalAwal($idHdrSoal, $hdrid);
        $data['_getWaktu']    = $this->M_TrainingOnline->getWaktu($idHdrSoal);
        $data['hdrid']        = $hdrid;

        $this->load->view('training_online/view_soal', $data);
    }

    public function getDataSoal2()
    {
        $materi               = $this->uri->segment(3);
        $position             = $this->uri->segment(4);
        $jenis_id             = $this->uri->segment(5);
        $idHdrSoal            = $this->uri->segment(6);
        $id_register          = $this->uri->segment(7);
        $idKategory           = $this->uri->segment(8);

        $sendData   = 'id mtr: ' . $materi . ' posisi pkb: ' . $position . ' jenis_id: ' . $jenis_id . ' id soal: ' . $idHdrSoal . ' id register: ' . $id_register;

        $cekCalonKar    =  $this->M_TrainingOnline->getCalonTenagaKerja($id_register);
        $nama           = $cekCalonKar->Nama;

        $dataHdr = array(
            'IDNonTK'           => $id_register,
            'KategoriMateri'    => $idKategory,
            'CreatedBy'         => $nama,
            'CreatedDate'       => date('Y-m-d H:i:s')
        );


        $hdrid   = $this->M_TrainingOnline->simpanHdr($dataHdr);

        $getSoal = $this->M_TrainingOnline->_getSoal($idHdrSoal);

        $jml_soal = count($getSoal);
        for ($i = 0; $i < $jml_soal; $i++) {
            $dataDtl = array(
                'HeaderID' => $hdrid,
                'IDSoal'   => $getSoal[$i]->IDSoal,
            );
            $this->M_TrainingOnline->simpanDtl($dataDtl);
        }

        $data['jenis_soal']   = $jenis_id;
        $data['idHdrSoal']    = $idHdrSoal;
        $data['getSoal']      = $this->M_TrainingOnline->_getSoalAwal($idHdrSoal, $hdrid);
        $data['_getWaktu']    = $this->M_TrainingOnline->getWaktu($idHdrSoal);
        $data['hdrid']        = $hdrid;

        // echo json_encode($dataDtl);
        $this->load->view('training_online/view_soal', $data);
    }

    public function simpan()
    {
        $nik_id           = $this->input->post("nik_id");
        $idPerson         = $this->input->post("idPerson");
        $karyawanSt       = $this->input->post("karyawanSt");
        $dept             = $this->input->post("dept");
        $bagianID         = $this->input->post("bagianID");
        $jenis_soal       = $this->input->post("jenis_soal");
        $materidtl_id     = $this->input->post("materidtl_id");
        $ruangan          = $this->input->post("ruangan");
        $nama_lengkap     = $this->input->post("nama_lengkap");
        $txtHdrSoal       = $this->input->post("txtHdrSoal");
        $hdrid_jawaban    = $this->input->post("hdrid_jawaban");

        $nik = $nik_id;
        $jml = strLen($nik);
        if ($jml == 5) {
            $karyawan   = $this->M_TrainingOnline->_getTenagaKerjaKaryawan_elc($nik_id);
            $regfix     = $karyawan->RegFixno;
            $nama       = $karyawan->Nama;
        } else {
            $harbor     = $this->M_TrainingOnline->_getTenagaKerjaKaryawan_elc($nik_id);
            $regfix     = $harbor->RegFixno;
            $nama       = $harbor->Nama;
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
                    $upload_dir =  FCPATH . "backup/regno/";
                } else if ($karyawanSt == 2) {
                    // $upload_dir =  "assets/ttdtraining/Fixno/";
                    $upload_dir =  FCPATH . "backup/fixno/";
                } else {
                    $upload_dir =  FCPATH . "backup/";
                }

                $img    = $this->input->post('hidden_data');
                $img    = str_replace('data:image/png;base64,', '', $img);
                $img    = str_replace(' ', '+', $img);
                $data   = base64_decode($img);

                $file   = $upload_dir . $this->input->post('fixreg') . ".png";

                // file_put_contents($file, $data);

                $dataHdr = array(
                    'PersonID'     => $idPerson,
                    'Remedial'     => "0",
                    'Status'       => $karyawanSt,
                    'DeptID'       => $dept,
                    'JenisSoal'    => $jenis_soal,
                    'IKPMateriDtl' => $materidtl_id,
                    'Lokasi'       => $ruangan,
                    'IDMstSoalHdr' => $txtHdrSoal,
                    'UpdateBy'     => $nama,
                    'UpdateDate'   => date('Y-m-d H:i:s')
                );

                // echo json_encode($dataHdr);
                $this->M_TrainingOnline->UpdateHdr($hdrid_jawaban, $dataHdr);

                /* Detail */
                $data = $this->input->post("data_jawaban");

                $jmlDtl = count($data);
                $success = 0;
                for ($i = 0; $i < $jmlDtl; $i++) {
                    $dataDtl = array(
                        'IDSoal'         => $data[$i]["soal_id"],
                        'IDObjectif'     => $data[$i]["jawaban"],
                    );

                    //echo $hdrid;
                    $this->M_TrainingOnline->updateDtl($data[$i]["detailid"], $dataDtl);
                    $success++;
                }
                echo json_encode($success);
            }
        }
    }

    public function simpan_nontk()
    {
        /* Header */
        $dept             = $this->input->post("dept");
        $bagianID         = $this->input->post("bagianID");
        $jenis_soal       = $this->input->post("jenis_soal");
        $materidtl_id     = $this->input->post("materidtl_id");
        $ruangan          = $this->input->post("ruangan");
        $nama_lengkap     = $this->input->post("nama_lengkap");
        $txtHdrSoal       = $this->input->post("txtHdrSoal");
        $hdrid_jawaban    = $this->input->post("hdrid_jawaban");
        $id_register      = $this->input->post("id_register");

        // $idPerson, $karyawanSt, $dept, $bagianID, $jenis_soal, $materidtl_id, $ruangan, $nama_lengkap, $txtHdrSoal, $hdrid_jawaban, $id_register

        $cekCalonKar    =  $this->M_TrainingOnline->getCalonTenagaKerja($id_register);
        $nama           = $cekCalonKar->Nama;
        $headerID       = $cekCalonKar->HeaderID;

        if ($dept != 13) {
            $error1 = 'notelc';
            echo json_encode($error1);
        } else {
            // cekHeaderID
            $cekID = $this->M_TrainingOnline->cekHeaderID($id_register, $txtHdrSoal);
            if ($cekID->HeaderID == 3) {
                $error = 'lebih3x';
                echo json_encode($error);
            } else {
                // $upload_dir = "assets/ttdtraining/NonTK/";
                $upload_dir =  FCPATH . "backup/nontk/";


                $img    = $this->input->post('hidden_data');
                $img    = str_replace('data:image/png;base64,', '', $img);
                $img    = str_replace(' ', '+', $img);
                $data   = base64_decode($img);

                $file   = $upload_dir . $this->input->post('id_register') . ".png";
                // $file   = $upload_dir . $this->input->post('id_register') . ".png";

                // file_put_contents($file, $data);

                $dataHdr = array(
                    'DeptID'         => $dept,
                    'JenisSoal'     => $jenis_soal,
                    'IKPMateriDtl'     => $materidtl_id,
                    'Lokasi'         => $ruangan,
                    'IDMstSoalHdr'    => $txtHdrSoal,
                    'UpdateBy'         => $nama,
                    'UpdateDate'     => date('Y-m-d H:i:s')
                );
                $this->M_TrainingOnline->UpdateHdr($hdrid_jawaban, $dataHdr);

                // /* Detail */
                $data = $this->input->post("data_jawaban");

                $jmlDtl = count($data);
                $success = 0;
                for ($i = 0; $i < $jmlDtl; $i++) {
                    $dataDtl = array(
                        'IDSoal'         => $data[$i]["soal_id"],
                        'IDObjectif'     => $data[$i]["jawaban"],
                    );

                    // echo $hdrid;
                    $this->M_TrainingOnline->updateDtl($data[$i]["detailid"], $dataDtl);
                    $success++;
                }
                echo json_encode($success);
            }
        }
    }

    public function lihat_hasil()
    {
        $hdrid        = $this->input->get('hdrid');
        $status       = $this->input->get('status');
        $fixregno     = $this->input->get('fixregno');
        $nama         = $this->input->get('nama');
        $nik          = $this->input->get('nik');
        $position     = $this->input->get('position');
        $status_tk    = $this->input->get('status_tk');
        $id_dept      = $this->input->get('dept');



        if ($status == 1) {
            $get_data = $this->M_TrainingOnline->_getTenagaKerjaHasilK($hdrid, $status);
            $data['_getData'] = $get_data;
        } else {
            $get_data = $this->M_TrainingOnline->_getTenagaKerjaHasilH($hdrid, $status);
            $data['_getData'] = $get_data;
        }

        // print_r($get_data);
        // die;

        $data['_getSoal']   = $this->M_TrainingOnline->_getSoalAwal($get_data[0]->IDMstSoalHdr, $hdrid);
        $data['hdrid']      = $hdrid;
        $data['status']     = $status;
        $data['fixregno']   = $fixregno;
        $data['nama']       = $nama;
        $data['nik']        = $nik;
        $data['position']   = $position;
        $data['status_tk']  = $status_tk;
        $data['_dept']      = $this->M_TrainingOnline->_getDept($id_dept);

        // print_r($data); die();
        $this->load->view('training_online/listHasilElc', $data);
    }

    public function lihat_hasil_nonTK()
    {
        $hdrid          = $this->input->get('hdrid');
        $nama           = $this->input->get('nama');
        $id_register    = $this->input->get('id_register');
        $position       = $this->input->get('position');
        $status_tk      = $this->input->get('status_tk');

        // _getNonTenagaKerjaHasil

        $get_data = $this->M_TrainingOnline->_getNonTenagaKerjaHasil($hdrid);
        $data['_getData']         = $get_data;

        $data['_getSoal']         = $this->M_TrainingOnline->_getSoalAwal($get_data[0]->IDMstSoalHdr, $hdrid);
        $data['hdrid']            = $hdrid;
        $data['nama']             = $nama;
        $data['nik']              = $nik;
        $data['id_register']      = $id_register;
        $data['status_tk']        = $status_tk;
        $data['position']         = $position;
        $data['status_tk']        = $status_tk;

        // print_r($data); die();
        $this->load->view('training_online/listHasilElc', $data);
    }

    // public function success() {
    //     $this->load->view("training_online/moduleElc", $data);
    // }
}
