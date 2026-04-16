<?php

/* 
 * Author by ITD15
 */

class WawancaraProses extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }

        $this->load->model('m_wawancara');
    }

    function wawancaraHarianIndex()
    {
        $data['_getTenagaKerja'] = $this->m_wawancara->getTenakerHarian();
        $data['_getDept'] = $this->m_wawancara->getDepartment();

        // print_r($this->session->userdata());
        // die;

        $this->template->display('registrasi/proses_wawancara/wawancara_harian/index', $data);
    }

    function doWawancaraHarian()
    {
        if ('IS_AJAX') {
            $kode                      = $this->input->post('kode');
            $data['datatk']            = $this->m_wawancara->getDetailTK($kode)->result();
            $data['datatenaker']       = $this->m_wawancara->getDetailTenaker($kode)->result();
            $data['_getMP']            = $this->m_wawancara->cekMP($kode);
            $data['_getKualifikasi']   = $this->m_wawancara->getKualifikasiDasar();
            $data['_getPekerjaan']     = $this->m_wawancara->getPekerjaanGO();
            $data['_getHarian']        = $this->m_wawancara->getPekerjaanHarian();
            $data['_getJabatan']       = $this->m_wawancara->getJabatan();
            // $data['_getSubJabatan']    = $this->m_wawancara->getSubJabatan();
            $data['_getSubPekerjaan']  = $this->m_wawancara->getSubPekerjaan();
            $data['_getLiburMingguan'] = $this->m_wawancara->getLiburMingguan();
            $this->load->view('registrasi/proses_wawancara/wawancara_harian/wawancaraHarian', $data);
        }
    }

    function simpanWawancaraHarian()
    {
        // if ($this->session->userdata('userid') == 'riyan' || $this->session->userdata('userid') == 'KIKI') {
        //     die;
        // }
        $nilai1 = $this->input->post('txtNilai1');
        $nilai2 = $this->input->post('txtNilai2');
        $nilai3 = $this->input->post('txtNilai3');
        $nilai4 = $this->input->post('txtNilai4');
        $nilai5 = $this->input->post('txtNilai5');
        $nilai6 = $this->input->post('txtNilai6');

        $total  = $nilai1 + $nilai2 + $nilai3 + $nilai4 + $nilai5 + $nilai6;
        $rata   = $total / 6;

        if ($rata >= 60) {
            $hasil  = 1;
            $grade  = "LULUS";
        } else {
            $hasil  = 0;
            $grade  = "GAGAL";
        }

        $jenisKerja = $this->input->post('txtJenisKerja');
        $subkerja = $this->input->post('txtSubKerja');

        $Jabatan = $this->input->post('txtJabatan');
        if ($Jabatan != '') {
            $JabatanArray = explode(",", $Jabatan);
            $JabatanID = $JabatanArray[0];
            $JabatanName = $JabatanArray[1];
        } else {
            $JabatanID = NULL;
            $JabatanName = NULL;
        }


        $SubJabatan = $this->input->post('txtSubJabatan');
        if ($SubJabatan != '') {
            $SubJabatanArray = explode(",", $SubJabatan);

            $SubJabatanID = $SubJabatanArray[0];
            $SubJabatanName = $SubJabatanArray[1];
        } else {
            $SubJabatanID = NULL;
            $SubJabatanName = NULL;
        }


        //=====================================================================
        $data1  = array(
            'HeaderID'       => $this->input->post('HeaderID'),
            'Tanggal'        => date('Y-m-d H: i: s'),
            'Departemen'     => $this->input->post('txtDept'),
            'WawancaraBy'    => $this->session->userdata('username'),
            'HasilWawancara' => $hasil,
            'Keterangan'     => $this->input->post('txtCatatan'),
            'TotalNilai'     => $total,
            'RataNilai'      => $rata,
            'Grade'          => $grade,
            'JenisKerja'     => $jenisKerja,
            'SubPekerjaan'   => $subkerja,
            'KepalaShift'    => $this->input->post('txtKepala'),
            'Shift'          => $this->input->post('txtShift'),
            'JabatanName'    => $JabatanName,
            'JabatanID'      => $JabatanID,
            'SubJabatanID'   => $SubJabatanID,
            'SubJabatanName' => $SubJabatanName,
            'LiburMingguan'  => $this->input->post('txtLiburMingguan')
        );
        $this->m_wawancara->insertWawancara($data1);
        //=====================================================================
        $no = 1;
        for ($i = 0; $i < 6; $i++) {
            $data2  = array(
                'HeaderID'  => $this->input->post('HeaderID'),
                'Item'      => $i + 1,
                'Nilai'     => $this->input->post("txtNilai" . $no++ . "")
            );
            $this->m_wawancara->insertDetailWawancara($data2);
        }
        //=====================================================================
        $hrdID  = $this->input->post('HeaderID');
        $wKe    = $this->cekWawancaraKe($hrdID);
        if ($hasil == 1 && $wKe == 3 || $hasil == 1 && $wKe == 2 || $hasil == 1 && $wKe == 1) {
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID, $info);
        } elseif ($hasil == 0 && $wKe == 1 || $hasil == 0 && $wKe == 2) {
            $info   = array(
                'DeptTujuan'        => NULL,
                'TransID'           => NULL,
                'Transaksi'         => NULL,
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID, $info);

            $detailID  = $this->input->post('txtDetailID');
            $getDeptb = $this->m_wawancara->getDept($detailID);
            foreach ($getDeptb as $rowb) {
                $detail = $rowb->DetailID;
                $minta  = $rowb->TempSetTenaker;
            }
            $temp   = $minta - 1;
            $this->m_wawancara->updateTempMinta($detail, $temp);
        } elseif ($hasil == 0 && $wKe == 3) {
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'DeptTujuan'        => NULL,
                'TransID'           => NULL,
                'Transaksi'         => NULL,
                'WawancaraKe'       => $wKe,
                'GeneralStatus'     => 1,
                'ClosingRemark'     => 'Gagal wawancara 3 kali',
                'ClosingBy'         => $this->session->userdata('username'),
                'ClosingDate'       => date('Y-m-d H:i:s')
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID, $info);

            $detailID  = $this->input->post('txtDetailID');
            $getDeptb = $this->m_wawancara->getDept($detailID);
            foreach ($getDeptb as $rowb) {
                $detail = $rowb->DetailID;
                $minta  = $rowb->TempSetTenaker;
            }
            $temp   = $minta - 1;
            $this->m_wawancara->updateTempMinta($detail, $temp);
        }

        redirect('wawancaraProses/wawancaraHarianIndex?msg=Success');
    }

    function cekWawancaraKe($hrdID)
    {
        $wKe = 0;
        $cekInterview = $this->m_wawancara->getDetailTK($hrdID)->result();
        foreach ($cekInterview as $row) :
            $wKe = $row->WawancaraKe + 1;
        endforeach;

        return $wKe;
    }


    function cekTotalHasil($hrdID)
    {
        $hasil  = 0;
        $cekHasil = $this->m_wawancara->getHasil($hrdID);
        foreach ($cekHasil as $row) :
            $hasil = $row->Total;
        endforeach;

        return $hasil;
    }

    function wawancaraIndex()
    {
        $data['_getTenagaKerja'] = $this->m_wawancara->getTenaker();
        $data['_getDept'] = $this->m_wawancara->getDepartment();

        $this->template->display('registrasi/proses_wawancara/wawancara_karyawan/index', $data);
    }

    function doWawancaraKaryawan()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['datatk'] = $this->m_wawancara->getDetailTK($kode)->result();
            $data['datatenaker'] = $this->m_wawancara->getDetailTenaker($kode)->result();
            $data['_getKualifikasi'] = $this->m_wawancara->getKualifikasiKaryawan();
            $data['_getKualifiSmu'] = $this->m_wawancara->getKualifikasiSMU();
            $data['_getJabatan'] = $this->m_wawancara->getMstJabatanPayroll();

            $cekPendidikan = $this->m_wawancara->getDetailTK($kode)->result();
            if ($this->session->userdata('userid') == 'KIKI#') {
                $this->load->view('registrasi/proses_wawancara/wawancara_karyawan/wawancaraKaryawan', $data);
            } else {

                foreach ($cekPendidikan as $row) {
                    if ($row->Pendidikan == 'D3' || $row->Pendidikan == 'S1' || $row->Pendidikan == 'S2' || $row->Pendidikan == 'S3' || $row->Pendidikan == 'SMK') {
                        $this->load->view('registrasi/proses_wawancara/wawancara_karyawan/wawancaraKaryawan', $data);
                    } else {
                        $this->load->view('registrasi/proses_wawancara/wawancara_karyawan/wawancaraSmu', $data);
                        // $this->load->view('registrasi/proses_wawancara/wawancara_karyawan/wawancaraKaryawan', $data);
                    }
                }
            }
        }
    }

    function getSubJabatanPayroll()
    {
        $jabatan = $this->input->post('jabatan');
        $data = $this->m_wawancara->getSubJabatanPayroll_($jabatan);

        if ($data) {
            $html = '<option value="">-- Pilih</option>';

            foreach ($data as $dt) {
                $html .= '<option value="' . $dt->SubJabatanID . ',' . $dt->SubJabatanName . '">' . $dt->SubJabatanName . '</option>';
            }

            $res = [
                'status' => 200,
                'data' => $html,
            ];
        } else {
            $res = [
                'status' => 404,
            ];
        }

        echo json_encode($res);
    }

    function simpanWawancaraKaryawan()
    {
        $nilai1 = $this->input->post('txtNilai1');
        $nilai2 = $this->input->post('txtNilai2');
        $sum1 = ($nilai1 + $nilai2) / 2;

        $nilai3 = $this->input->post('txtNilai3');
        $nilai4 = $this->input->post('txtNilai4');
        $nilai5 = $this->input->post('txtNilai5');
        $sum2 = ($nilai3 + $nilai4 + $nilai5) / 3;

        $nilai6 = $this->input->post('txtNilai6');
        $nilai7 = $this->input->post('txtNilai7');
        $nilai8 = $this->input->post('txtNilai8');
        $sum3 = ($nilai6 + $nilai7 + $nilai8) / 3;

        $nilai9 = $this->input->post('txtNilai9');
        $nilai10 = $this->input->post('txtNilai10');
        $sum4 = ($nilai9 + $nilai10) / 2;

        $nilai11 = $this->input->post('txtNilai11');
        $nilai12 = $this->input->post('txtNilai12');
        $sum5 = ($nilai11 + $nilai12) / 2;

        $total = $sum1 + $sum2 + $sum3 + $sum4 + $sum5;
        $rata   = $total / 5;

        if ($rata >= 60) {
            $hasil  = 1;
            $grade  = "LULUS";
        } else {
            $hasil  = 0;
            $grade  = "GAGAL";
        }

        if ($this->input->post('txtJabatan') != '') {
            $jabatan = explode(',', $this->input->post('txtJabatan'));
            $jabatanName = $jabatan[1];
            $jabatanID = $jabatan[0];
        } else {
            $jabatanName = NULL;
            $jabatanID = NULL;
        }

        if ($this->input->post('txtSubJabatan') != '') {
            $SubjabatanArray = explode(',', $this->input->post('txtSubJabatan'));
            $SubjabatanName = $SubjabatanArray[1];
            $SubjabatanID = $SubjabatanArray[0];
        } else {
            $SubjabatanName = NULL;
            $SubjabatanID = NULL;
        }


        //=====================================================================
        $data1  = array(
            'HeaderID'       => $this->input->post('HeaderID'),
            'Tanggal'        => date('Y-m-d H: i: s'),
            'Departemen'     => $this->input->post('txtDept'),
            'WawancaraBy'    => $this->session->userdata('username'),
            'HasilWawancara' => $hasil,
            'Keterangan'     => $this->input->post('txtCatatan'),
            'TotalNilai'     => $total,
            'RataNilai'      => $rata,
            'Grade'          => $grade,
            'JabatanID'      => $jabatanID,
            'JabatanName'    => $jabatanName,
            'SubJabatanID'   => $SubjabatanID,
            'SubJabatanName' => $SubjabatanName,

        );
        $this->m_wawancara->insertWawancara($data1);
        //=====================================================================
        $no = 1;
        $ke = 1;
        for ($i = 0; $i < 12; $i++) {
            $data2  = array(
                'HeaderID'  => $this->input->post('HeaderID'),
                'Item'      => $i + 1,
                'Nilai'     => $this->input->post("txtNilai" . $no++ . ""),
                'Catatan'   => $this->input->post("txtPenjelasan" . $ke++ . ""),
            );
            $this->m_wawancara->insertDetailWawancara($data2);
        }
        //=====================================================================
        $hrdID  = $this->input->post('HeaderID');
        $wKe    = $this->cekWawancaraKe($hrdID);
        if ($hasil == 1 && $wKe == 3 || $hasil == 1 && $wKe == 2 || $hasil == 1 && $wKe == 1) {
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID, $info);
        } elseif ($hasil == 0 && $wKe == 1 || $hasil == 0 && $wKe == 2) {
            $info   = array(
                'DeptTujuan'        => NULL,
                'TransID'           => NULL,
                'Transaksi'         => NULL,
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID, $info);
        } elseif ($hasil == 0 && $wKe == 3) {
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'DeptTujuan'        => NULL,
                'TransID'           => NULL,
                'Transaksi'         => NULL,
                'WawancaraKe'       => $wKe,
                'GeneralStatus'     => 1,
                'ClosingRemark'     => 'Gagal wawancara 3 kali',
                'ClosingBy'         => $this->session->userdata('username'),
                'ClosingDate'       => date('Y-m-d H:i:s')
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID, $info);
        }


        redirect('wawancaraProses/wawancaraIndex?msg=Success');
    }
    function simpanWawancaraKaryawanSMU()
    {
        $nilai1 = $this->input->post('txtNilai1');
        $nilai2 = $this->input->post('txtNilai2');
        $nilai3 = $this->input->post('txtNilai3');
        $nilai4 = $this->input->post('txtNilai4');
        $nilai5 = $this->input->post('txtNilai5');
        $nilai6 = $this->input->post('txtNilai6');

        if ($nilai6 == "") {
            $total  = $nilai1 + $nilai2 + $nilai3 + $nilai4 + $nilai5;
            $rata   = $total / 5;
            $itung  = 5;
        } else {
            $total  = $nilai1 + $nilai2 + $nilai3 + $nilai4 + $nilai5 + $nilai6;
            $rata   = $total / 6;
            $itung  = 6;
        }

        if ($rata >= 60) {
            $hasil  = 1;
            $grade  = "LULUS";
        } else {
            $hasil  = 0;
            $grade  = "GAGAL";
        }
        //=====================================================================
        $data1  = array(
            'HeaderID'      => $this->input->post('HeaderID'),
            'Tanggal'       => date('Y-m-d H:i:s'),
            'Departemen'    => $this->input->post('txtDept'),
            'WawancaraBy'   => $this->session->userdata('username'),
            'HasilWawancara' => $hasil,
            'Keterangan'    => $this->input->post('txtCatatan'),
            'TotalNilai'    => $total,
            'RataNilai'     => $rata,
            'Grade'         => $grade
        );
        $this->m_wawancara->insertWawancara($data1);
        //=====================================================================
        $no = 1;
        for ($i = 0; $i < $itung; $i++) {
            $data2  = array(
                'HeaderID'  => $this->input->post('HeaderID'),
                'Item'      => $i + 1,
                'Nilai'     => $this->input->post("txtNilai" . $no++ . "")
            );
            $this->m_wawancara->insertDetailWawancara($data2);
        }
        //=====================================================================
        $hrdID  = $this->input->post('HeaderID');
        $wKe    = $this->cekWawancaraKe($hrdID);
        if ($hasil == 1 && $wKe == 3 || $hasil == 1 && $wKe == 2 || $hasil == 1 && $wKe == 1) {
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID, $info);
        } elseif ($hasil == 0 && $wKe == 1 || $hasil == 0 && $wKe == 2) {
            $info   = array(
                'DeptTujuan'        => NULL,
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID, $info);
        } elseif ($hasil == 0 && $wKe == 3) {
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe,
                'GeneralStatus'     => 1,
                'ClosingRemark'     => 'Gagal wawancara 3 kali',
                'ClosingBy'         => $this->session->userdata('username'),
                'ClosingDate'       => date('Y-m-d H:i:s')
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID, $info);
        }


        redirect('wawancaraProses/wawancaraIndex?msg=Success');
    }

    // Print Informasi Tenaga Kerja
    function printData($headerID)
    {
        $data['datatk']         = $this->m_wawancara->getDetailTK($headerID)->result();

        $this->load->view('registrasi/proses_wawancara/printDataTenaker', $data);
    }

    function getSubJabatan()
    {
        $idJabatan = $this->input->post('idJabatan');
        $dept = $this->input->post('dept');
        $data = $this->m_wawancara->getSubJabatan_($idJabatan, $dept);

        if ($data) {
            $html = '<option value="">-- Pilih</option>';

            foreach ($data as $dt) {
                $html .= '<option value="' . $dt->IDSubJabatan . ',' . $dt->SubJabatanName . '">' . $dt->SubJabatanName . '</option>';
            }

            $res = [
                'status' => 200,
                'data' => $html,
            ];
        } else {
            $res = [
                'status' => 404,
            ];
        }

        echo json_encode($res);
    }
}


/* End of file wawancaraProses.php */
/* Location: ./application/controllers/wawancaraProses.php */