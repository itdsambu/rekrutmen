<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class Issue extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        // if ($status = 1 && $this->session->userdata('userid') !== 'riyan') {
        //     redirect(site_url('maintenanceControl'));
        // }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }

        $this->load->model('m_issue');
    }

    function boronganIndex()
    {
        $data['getDept']     = $this->m_issue->getDept();
        $data['getPemb']     = $this->m_issue->getPemborong();
        $data['getPend']     = $this->m_issue->getPendidikan();
        $data['getJurs']     = $this->m_issue->getJurusan();
        $data['getSKwn']     = $this->m_issue->getStatusKawin();
        $data['_getJabatan'] = $this->m_issue->getJabatanPsgBor();
        $data['_getTargetBongkar'] = $this->m_issue->getTargetBongkar();
        $data['targetBongkar'] = $this->m_issue->getTargetBongkarMst(1);

        // print_r($this->session->userdata());
        // die;
        // if ($this->session->userdata('userid') == 'KIKI' || $this->session->userdata('userid') == 'YULI1234') {
        //     $this->template->display('transaksi/issue_permintaan/borongan/index_dev', $data);
        // } else {

        // }
        $this->template->display('transaksi/issue_permintaan/borongan/index', $data);
    }

    function getDept()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->m_issue->getDept();
            $html = '';
            foreach ($data as $dt) {
                $html .= '<option value="' . $dt->IDDept . '">' . $dt->DeptAbbr . '</option>';
            }
            if ($data) {
                $res = [
                    'status' => 200,
                    'data' => $html,
                ];
            } else {
                $res = [
                    'status' => 404,
                    'data' => null,
                ];
            }
            echo json_encode($res);
        }
    }

    function getDeptPayroll()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->m_issue->getDeptPayroll();
            $html = '';
            foreach ($data as $dt) {
                $html .= '<option value="' . $dt->DeptID . '">' . $dt->DeptAbbr . '</option>';
            }
            if ($data) {
                $res = [
                    'status' => 200,
                    'data' => $html,
                ];
            } else {
                $res = [
                    'status' => 404,
                    'data' => null,
                ];
            }
            echo json_encode($res);
        }
    }

    function get_jabatan_payroll()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->m_issue->getJabatanPayroll();
            $html = '';
            foreach ($data as $dt) {
                $html .= '<option value="' . $dt->JabatanID . ',' . $dt->JabatanName . '">' . $dt->JabatanName . '</option>';
            }

            if ($data) {
                $res = [
                    'status' => 200,
                    'data' => $html,
                ];
            } else {
                $res = [
                    'status' => 404,
                    'data' => null,
                ];
            }
            echo json_encode($res);
        }
    }

    function get_sub_jabatan()
    {
        if ($this->input->is_ajax_request()) {
            $id_jabatan = $this->input->post('idJabatan');
            $data = $this->m_issue->getSubJabatanPayroll($id_jabatan);
            $html = '';
            foreach ($data as $dt) {
                $html .= '<option value="' . $dt->SubJabatanID . ',' . $dt->SubJabatanName . '">' . $dt->SubJabatanName . '</option>';
            }

            if ($data) {
                $res = [
                    'status' => 200,
                    'data' => $html,
                ];
            } else {
                $res = [
                    'status' => 404,
                    'data' => null,
                ];
            }
            echo json_encode($res);
        }
    }

    function getBagian()
    {
        if ('IS_AJAX') {
            $dept   = $this->input->post('dept');
            $data['_getBagian'] = $this->m_issue->getPekerjaan($dept);
            $this->load->view('transaksi/issue_permintaan/borongan/getBagian', $data);
        }
    }

    function karyawanIndex()
    {
        // $data['getDept'] = $this->m_issue->getDept();
        $data['getDept'] = $this->m_issue->getDeptPayroll();
        // $data['getJabt'] = $this->m_issue->getJabatan();
        $data['getJabt'] = $this->m_issue->getJabatanPayroll();
        $data['getPend'] = $this->m_issue->getPendidikan();
        $data['getJurs'] = $this->m_issue->getJurusan();
        $data['getSKwn'] = $this->m_issue->getStatusKawin();
        $data['_getTargetBongkar'] = $this->m_issue->getTargetBongkar();
        $data['targetBongkar'] = $this->m_issue->getTargetBongkarMst(1);
        // print_r($this->session->userdata());
        // die;
        // if ($this->session->userdata('userid') == 'KIKI' || $this->session->userdata('userid') == 'YULI1234') {            // Custom logic for KIKI user
        //     $this->template->display('transaksi/issue_permintaan/karyawan/index_dev', $data);
        // } else {
        // }
        $this->template->display('transaksi/issue_permintaan/karyawan/index', $data);
    }
    function updateTargetBongkar()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $idTargetBongkar = $this->input->post('idTargetBongkar');

            $data = array(
                'id_master_bongkar_kelapa' => $idTargetBongkar,
                'updated_by' => $this->session->userdata('userid'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $isUpdated = $this->m_issue->updateTargetBongkar($id, $data);

            if ($isUpdated) {
                echo json_encode(['status' => true,]);
            } else {
                echo json_encode(['status' => false,]);
            }
        }
    }

    function cekfirstbor()
    {
        // $idSubJabatan = $this->input->post('txtSubJabatan');
        // $ids =  explode(",", $idSubJabatan);
        // $idsub = $ids[0];
        // print_r()
        $idSubJabatan = $this->input->post('txtSubJabatan');

        // bersihin dulu semua karakter aneh
        $idSubJabatan = preg_replace('/[\x00-\x1F\x7F\xA0\xC2\xA0\xEF\xBB\xBF]/u', '', $idSubJabatan);

        $ids = explode(",", trim($idSubJabatan));

        // pastikan tiap elemen bersih juga
        $ids = array_map(function ($v) {
            return trim(preg_replace('/[\x00-\x1F\x7F\xA0\xC2\xA0\xEF\xBB\xBF]/u', '', $v));
        }, $ids);

        $idsub = $ids[0] ?? null;
        $data = array(
            'SubJabatanID'   => $idsub,
            'DeptID'        => $this->input->post('comboDept'),
            'Pemborong'     => $this->input->post('txtPemborong'),
            'PekerjaanID'   => $this->input->post('comboTansaksi'),
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal' => $this->input->post('comboStatus'),
            'CreatedBy'     => $this->session->userdata('username'),
            'CreatedDate'   => date('Y-m-d H:i:s'),
        );


        // var_dump($ids);
        // var_dump($idsub);
        // die;



        $cek = 0;
        $msg = '';
        $cek  = $this->m_issue->isValidPermintaanBorongan($data);
        if ($cek['error'] == 1) {
            $msg = 'Jumlah permintaan melebihi batas ideal,' .
                ' total permintaan dalam proses ' . $cek['psb'] . ' org, proses cancel';
        } elseif ($cek['error'] == 2) {
            $msg = 'Jumlah permintaan <= 0, proses cancel';
        } elseif ($cek['error'] > 0) {
            $msg = 'Jumlah permintaan melebihi batas ideal, proses cancel';
        }
        echo json_encode(array('Err' => $cek['error'], 'Msg' => $msg));
    }

    function cekfirstbor_()
    {

        $idSubJabatan = $this->input->post('txtSubJabatan');

        // bersihin dulu semua karakter aneh
        $idSubJabatan = preg_replace('/[\x00-\x1F\x7F\xA0\xC2\xA0\xEF\xBB\xBF]/u', '', $idSubJabatan);

        $ids = explode(",", trim($idSubJabatan));

        // pastikan tiap elemen bersih juga
        $ids = array_map(function ($v) {
            return trim(preg_replace('/[\x00-\x1F\x7F\xA0\xC2\xA0\xEF\xBB\xBF]/u', '', $v));
        }, $ids);

        $idsub = $ids[0] ?? null;
        $data = array(
            'SubJabatanID'   => $idsub,
            'DeptID'        => $this->input->post('comboDept'),
            'Pemborong'     => $this->input->post('txtPemborong'),
            'PekerjaanID'   => $this->input->post('comboTansaksi'),
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal' => $this->input->post('comboStatus'),
            'StatusPersonal' => $this->input->post('comboStatus'),
            'id_target_bongkar' => $this->input->post('comboTargetBongkar'),
            'CreatedBy'     => $this->session->userdata('username'),
            'CreatedDate'   => date('Y-m-d H:i:s'),
        );





        $cek = 0;
        $msg = '';
        $cek  = $this->m_issue->isValidPermintaanBorongan_($data);
        if ($cek['error'] == 1) {
            $msg = 'Jumlah permintaan melebihi batas ideal,' .
                ' total permintaan dalam proses ' . $cek['psb'] . ' org, proses cancel';
        } elseif ($cek['error'] == 2) {
            $msg = 'Jumlah permintaan <= 0, proses cancel';
        } elseif ($cek['error'] > 0) {
            $msg = 'Jumlah permintaan melebihi batas ideal, proses cancel';
        }
        echo json_encode(array('Err' => $cek['error'], 'Msg' => $msg));
    }

    function cekfirstkar()
    {
        $idSubJabatan = $this->input->post('txtSubJabatan');

        // bersihin dulu semua karakter aneh
        $idSubJabatan = preg_replace('/[\x00-\x1F\x7F\xA0\xC2\xA0\xEF\xBB\xBF]/u', '', $idSubJabatan);

        $ids = explode(",", trim($idSubJabatan));

        // pastikan tiap elemen bersih juga
        $ids = array_map(function ($v) {
            return trim(preg_replace('/[\x00-\x1F\x7F\xA0\xC2\xA0\xEF\xBB\xBF]/u', '', $v));
        }, $ids);

        $idsub = $ids[0] ?? null;
        $data = array(
            'SubJabatanID'   => $idsub,
            'id_target_bongkar' => $this->input->post('comboTargetBongkar'),
            'DeptID'        => $this->input->post('comboDept'),
            'Pemborong'     => $this->input->post('txtPemborong'),
            'PekerjaanID'   => $this->input->post('comboTansaksi'),
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal' => $this->input->post('comboStatus'),
            'CreatedBy'     => $this->session->userdata('username'),
            'CreatedDate'   => date('Y-m-d H:m:i')
        );

        $cek = 0;
        $msg = '';

        // $cek  = $this->m_issue->isValidPermintaanKaryawan_($data);
        $cek  = $this->m_issue->isValidPermintaanKaryawan_new($data);
        if ($cek['error'] == 1) {
            $msg = 'Jumlah permintaan melebihi batas ideal,' .
                ' total permintaan dalam proses ' . $cek['psb'] . ' org, proses cancel';
        } elseif ($cek['error'] == 2) {
            $msg = 'Jumlah permintaan <= 0, proses cancel';
        } elseif ($cek['error'] > 0) {
            $msg = 'Jumlah total permintaan melebihi batas, cancel permintaan anda sebelumnya.';
        }
        echo json_encode(array('Err' => $cek['error'], 'Msg' => $msg));
    }

    function get_idealkry()
    {
        $id = $this->input->get('id');
        $row = $this->m_issue->getdatakuotakry($id);
        echo json_encode(array('ideal' => $row->IKry, 'real' => $row->RKry));
    }

    function get_idealkry_()
    {
        $id = $this->input->get('id');
        $row = $this->m_issue->getdatakuotakry_($id);
        // echo json_encode(array('ideal' => $row->IKry, 'real' => $row->RKry));
        if ($row) {
            $res = [
                'status' => 200,
                'ideal' => $row->IKry, 'real' => $row->RKry
            ];
        } else {
            $res = ['status' => 404,];
        }
        echo json_encode($res);
    }

    function get_idealkry_new()
    {
        $id = $this->input->get('id');
        $subJabatanID = $this->input->get('subJabatanID');
        $id_targetBongkar = $this->input->get('targetBongkar');
        $row = $this->m_issue->getdatakuotakry_new($id, $subJabatanID, $id_targetBongkar);
        // echo json_encode(array('ideal' => $row->IKry, 'real' => $row->RKry));
        if ($row) {
            $res = [
                'status' => 200,
                'ideal' => $row->IKry, 'real' => $row->TotalKryTk
            ];
        } else {
            $res = ['status' => 404,];
        }
        echo json_encode($res);
    }

    function get_idealbor()
    {
        $id = $this->input->get('id');
        $row = $this->m_issue->getdatakuotabor($id);
        echo json_encode(array('ideal' => $row->IBor, 'real' => $row->RBor));
    }

    function get_idealbor_()
    {
        $id = $this->input->post('id');
        $subJabatanID = $this->input->post('subJabatanID');
        $row = $this->m_issue->getdatakuotabor_($id, $subJabatanID);
        if ($row) {
            $res = [
                'status' => 200,
                'ideal' => $row->IBor, 'real' => $row->RBor
            ];
        } else {
            $res = ['status' => 404,];
        }
        echo json_encode($res);
    }

    function get_idealbor_new()
    {
        $id = $this->input->post('id');
        $subJabatanID = $this->input->post('subJabatanID');
        $idTargetBongkar = $this->input->post('idTargetBongkar');
        // $row = $this->m_issue->getdatakuotabor_($id, $subJabatanID);
        $row = $this->m_issue->getdatakuotabor_new($id, $subJabatanID, $idTargetBongkar);
        if ($row) {
            $res = [
                'status' => 200,
                'ideal' => $row->IKry, 'real' => $row->TotalKryTk
            ];
        } else {
            $res = ['status' => 404,];
        }
        echo json_encode($res);
    }

    function saveIssue()
    {

        $Jabatan = $this->input->post('txtJabatan');
        if ($Jabatan != '') {
            $JabatanArray = explode(",", $Jabatan);
            $JabatanID = intval($JabatanArray[0]); // ubah ke int
            $JabatanName = $JabatanArray[1];
        } else {
            $JabatanID = NULL;
            $JabatanName = NULL;
        }


        $SubJabatan = $this->input->post('txtSubJabatan');
        if ($SubJabatan != '') {
            $SubJabatanArray = explode(",", $SubJabatan);

            $SubJabatanID = intval($SubJabatanArray[0]);
            $SubJabatanName = $SubJabatanArray[1];
        } else {
            $SubJabatanID = NULL;
            $SubJabatanName = NULL;
        }
        $aksi = $this->uri->segment(3);
        if ($aksi == 'borongan') {
            $statusKar = 0;
        } else {
            $statusKar = 1;
        }
        $data = array(
            'DeptID'         => $this->input->post('comboDept'),
            'Pemborong'      => $this->input->post('txtPemborong'),
            'PekerjaanID'    => $this->input->post('comboTansaksi'),
            'TKTarget'       => $this->input->post('txtPermintaan'),     //$this->input->post('txtTarget'),
            'TKSedia'        => 0,                                       //$this->input->post('txtTersedia')
            'TKPermintaan'   => $this->input->post('txtPermintaan'),
            'IssueRemark'    => $this->input->post('txtKeterangan'),
            'Umur'           => $this->input->post('txtUmur'),
            'Pendidikan'     => $this->input->post('comboPendidikan'),
            'Jurusan'        => $this->input->post('comboJurusan'),
            'JenisKelamin'   => $this->input->post('comboJekel'),
            'StatusPersonal' => $this->input->post('comboStatus'),
            'CreatedBy'      => $this->session->userdata('username'),
            'CreatedDate'    => date('Y-m-d H:m:i'),
            'JabatanID'      => $JabatanID,
            'JabatanName'    => $JabatanName,
            'SubJabatanID'   => $SubJabatanID,
            'SubJabatanName' => $SubJabatanName,
            'statusKar'      => $statusKar,
        );

        // print_r($data);
        // die;
        $mdata = $data;



        $aksi = $this->uri->segment(3);
        if ($aksi == 'borongan') {
            $cek  = $this->m_issue->isValidPermintaanBorongan($data);
            if ($cek['error'] > 0) {
                echo 'error';
                return;
            }
        } else {
            $cek  = $this->m_issue->isValidPermintaanKaryawan_($data);
            if ($cek['error'] > 0) {
                echo 'error';
                return;
            }
        }


        $this->m_issue->saveIssue($mdata);
        //return;
        $aksi = $this->uri->segment(3);
        if ($aksi == 'borongan') {
            redirect(site_url('issue/boronganIndex/success'));
        } elseif ($aksi == 'karayawan') {
            redirect(site_url('issue/karyawanIndex/success'));
        }
    }

    function saveIssue_()
    {

        $Jabatan = $this->input->post('txtJabatan');
        if ($Jabatan != '') {
            $JabatanArray = explode(",", $Jabatan);
            $JabatanID = intval($JabatanArray[0]); // ubah ke int
            $JabatanName = $JabatanArray[1];
        } else {
            $JabatanID = NULL;
            $JabatanName = NULL;
        }


        $SubJabatan = $this->input->post('txtSubJabatan');
        if ($SubJabatan != '') {
            $SubJabatanArray = explode(",", $SubJabatan);

            $SubJabatanID = intval($SubJabatanArray[0]);
            $SubJabatanName = $SubJabatanArray[1];
        } else {
            $SubJabatanID = NULL;
            $SubJabatanName = NULL;
        }
        $aksi = $this->uri->segment(3);
        if ($aksi == 'borongan') {
            $statusKar = 0;
        } else {
            $statusKar = 1;
        }
        $data = array(
            'DeptID'            => $this->input->post('comboDept'),
            'Pemborong'         => $this->input->post('txtPemborong'),
            // 'PekerjaanID'       => $this->input->post('comboTansaksi'),
            'PekerjaanID'       => $aksi == 'borongan' ? $this->input->post('comboTansaksi') : $JabatanID,
            'TKTarget'          => $this->input->post('txtPermintaan'),        //$this->input->post('txtTarget'),
            'TKSedia'           => 0,                                          //$this->input->post('txtTersedia')
            'TKPermintaan'      => $this->input->post('txtPermintaan'),
            'IssueRemark'       => $this->input->post('txtKeterangan'),
            'Umur'              => $this->input->post('txtUmur'),
            'Pendidikan'        => $this->input->post('comboPendidikan'),
            'Jurusan'           => $this->input->post('comboJurusan'),
            'JenisKelamin'      => $this->input->post('comboJekel'),
            'StatusPersonal'    => $this->input->post('comboStatus'),
            'CreatedBy'         => $this->session->userdata('username'),
            'CreatedDate'       => date('Y-m-d H:m:i'),
            'JabatanID'         => $JabatanID,
            'JabatanName'       => $JabatanName,
            'SubJabatanID'      => $SubJabatanID,
            'SubJabatanName'    => $SubJabatanName,
            'statusKar'         => $statusKar,
            'id_target_bongkar' => $this->input->post('comboTargetBongkar'),
        );
        $mdata = $data;



        $aksi = $this->uri->segment(3);
        if ($aksi == 'borongan') {
            $cek  = $this->m_issue->isValidPermintaanBorongan_($data);
            if ($cek['error'] > 0) {
                echo 'error';
                return;
            }
        } else {
            $cek  = $this->m_issue->isValidPermintaanKaryawan_new($data);
            if ($cek['error'] > 0) {
                echo 'error';
                return;
            }
        }

        $this->m_issue->saveIssue($mdata);
        $aksi = $this->uri->segment(3);
        if ($aksi == 'borongan') {
            redirect(site_url('issue/boronganIndex/success'));
        } elseif ($aksi == 'karayawan') {
            redirect(site_url('issue/karyawanIndex/success'));
        }
    }

    function editIssue()
    {
        $data['_getIssue'] = $this->m_issue->getIssue();
        $this->template->display('transaksi/issue_permintaan/edit_issue/index', $data);
    }

    function viewEditIssue()
    {
        if ('IS_AJAX') {
            $id = $this->input->post('kode');
            $data['getDept'] = $this->m_issue->getDept();
            $data['getJbtn'] = $this->m_issue->getJabatan();
            $data['getPemb'] = $this->m_issue->getPemborongAll();
            $data['getPend'] = $this->m_issue->getPendidikan();
            $data['getJurs'] = $this->m_issue->getJurusan();
            $data['getSKwn'] = $this->m_issue->getStatusKawin();
            $data['getTran'] = $this->m_issue->setInfoTranEdit($id)->result();
            $row = $this->m_issue->setInfoTranEdit($id)->row();
            $idDept          = $row->DeptID;
            $data['getKrj']  = $this->m_issue->getPekerjaan($idDept);
            $this->load->view('transaksi/issue_permintaan/edit_issue/editIssue', $data);
        }
    }

    function doEditIssue()
    {
        $id = $this->input->post('txtID');

        if ($this->input->post('comboPemborong') == 'PSG') {
            $idKerja    = $this->input->post('comboJabatan');
        } else {
            $idKerja    = $this->input->post('comboTansaksi');
        }
        $data = array(
            'DeptID'        => $this->input->post('comboDept'),
            'Pemborong'     => $this->input->post('comboPemborong'),
            'PekerjaanID'   => $idKerja,
            'TKTarget'      => $this->input->post('txtTarget'),
            'TKSedia'       => $this->input->post('txtTersedia'),
            'TKPermintaan'  => $this->input->post('txtPermintaan'),
            'IssueRemark'   => $this->input->post('txtKeterangan'),
            'Umur'          => $this->input->post('txtUmur'),
            'Pendidikan'    => $this->input->post('comboPendidikan'),
            'Jurusan'       => $this->input->post('comboJurusan'),
            'JenisKelamin'  => $this->input->post('comboJekel'),
            'StatusPersonal' => $this->input->post('comboStatus'),
            'UpdatedBy'     => $this->session->userdata('username'),
            'UpdatedDate'   => date('Y-m-d H:m:i')
        );
        $this->m_issue->updateTran($id, $data);
        redirect(site_url('issue/editIssue'));
    }

    function get_jabatan()
    {
        $id_dept = $this->input->post('id');

        $data = $this->m_issue->getJabatanPsgBor($id_dept);
        if ($data) {
            $html = '<option value="">-- Pilih</option>';
            foreach ($data as $dt) {
                $html .= '<option value="' . $dt->IDJabatan . ',' . $dt->Jabatan . '" data-id-jabatan="' . $dt->IDJabatan . '">' . $dt->Jabatan . '</option>';
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

    function getSubJabatan()
    {
        $idJabatan = $this->input->post('idJabatan');
        $dept = $this->input->post('dept');
        $data = $this->m_issue->getSubJabatan($idJabatan, $dept);
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
