<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class calonKandidat extends CI_Controller
{
    var $API = "";
    function __construct()
    {
        parent::__construct();
        $this->API = "http://222.124.139.234/APIRekrutmen";

        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }
        $this->load->helper(array('url', 'form'));
        $this->load->model('m_calonKandidat');
    }

    function index()
    {
        $data['_getFormID']       = $this->input->get('id');
        $data['_getDept']          = $this->m_calonKandidat->get_departemen();
        $data['getPendidikan']    = $this->m_calonKandidat->get_pendidikan();
        $data['getSuku']          = $this->m_calonKandidat->get_suku();
        $this->template->display('registrasi/calon_kandidat/index', $data);
    }

    function ajaxDivisi()
    {
        $deptid = $this->uri->segment(3);

        $data['getDivisi'] = $this->m_calonKandidat->get_divisi($deptid);
        $this->load->view('registrasi/calon_kandidat/ajax/ajx_divisi', $data);
    }

    function ajaxPendidikan()
    {
        $pendid = $this->uri->segment(3);

        $data['id']     = $pendid;
        $data['getJurusan'] = $this->m_calonKandidat->get_jurusan();
        $this->load->view('registrasi/calon_kandidat/ajax/ajx_jurusan', $data);
    }

    function simpanData()
    {
        $nama           = $this->input->post('txtNama');
        $jeniskelamin   = $this->input->post('txtJeniskelamin');
        $tempatlahir    = $this->input->post('txtTempatlahir');
        $tanggallahir   = $this->input->post('txtTanggallahir');
        $noktp          = $this->input->post('txtNoktp');
        $notelp         = $this->input->post('txtNotelp');
        $email          = $this->input->post('txtEmail');
        $posisi         = $this->input->post('txtPosisi');
        $lavel          = $this->input->post('txtLavel');
        $dept           = $this->input->post('txtDept');
        $pendidikan     = $this->input->post('txtPendidikan');
        $jurusan        = $this->input->post('txtJurusan');
        $jadwaltes      = $this->input->post('txtJadwaltes');
        $status         = $this->input->post('txtStatus');
        $statustes      = $this->input->post('txtStatustes');
        $transport      = $this->input->post('txtTransport');
        $biayatransport = $this->input->post('txtBiaya');
        $sumberpelamar  = $this->input->post('txtSumberpelamar');
        $ketarangan     = $this->input->post('txtKeterangan');
        $tglInterview   = $this->input->post('txtTanggalInterview');
        $suku           = $this->input->post('txtSuku');
        $daerahasal     = $this->input->post('txtDaerahasal');
        $tes            = $this->input->post('txtTest');
        $interview      = $this->input->post('txtInterview');
        $tglKedatangan  = $this->input->post('txtTanggalkedatangan');
        $universitas    = $this->input->post('txtuniversitas');

        $data = array(
            'Nama'              => $nama,
            'JenisKelamin'      => $jeniskelamin,
            'TempatLahir'       => $tempatlahir,
            'Tanggallahir'      => $tanggallahir,
            'NoKTP'             => $noktp,
            'NoTelp'            => $notelp,
            'SukuID'            => $suku,
            'DaerahAsal'        => $daerahasal,
            'Email'             => $email,
            'Posisi'            => $posisi,
            'LavelCalon'        => $lavel,
            'IssueID'           => $dept,
            'PendidikanID'      => $pendidikan,
            'Universitas'       => $universitas,
            'JurusanID'         => $jurusan,
            'JadwalTes'         => $jadwaltes,
            'Tes'               => $tes,
            'Interview'         => $interview,
            'TanggalInterview'  => $tglInterview,
            'Status'            => $status,
            'StatusTes'         => $statustes,
            'Tgl_kedatangan'    => $tglKedatangan,
            'Transport'         => $transport,
            'BiayaTransport'    => $biayatransport,
            'SumberPelamar'     => $sumberpelamar,
            'Keterangan'        => $ketarangan,
            'CreatedBy'         => $this->session->userdata('username'),
            'CreatedDate'       => date('Y-m-d H:i:s'),
        );

        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";

        // $this->m_calonKandidat->simpan($data);
        $result = $this->m_calonKandidat->simpan($data);
        if (!$result) {
            redirect('calonKandidat/?msg=success');
        } else {
            redirect('calonKandidat/?msg=failed');
        }
    }

    function monitorCalonKandidatRsup()
    {

        $data['_getFormID']         = $this->input->get('id');
        $data['getData']        = $this->m_calonKandidat->get_CalonkandidatRsup();
        $data['getDept']        = $this->m_calonKandidat->get_deptIssue();
        $data['getDataCalon']   = $this->m_calonKandidat->getCalonKandidat();
        $data['getPendidikan']  = $this->m_calonKandidat->get_pendidikan();
        $data['getSuku']        = $this->m_calonKandidat->get_suku();
        $data['getDept']        = $this->m_calonKandidat->get_departemen();
        // print_r($data['getData']);
        $this->template->display('monitor/calon_kandidat/ck_rsup/index', $data);
    }

    function viewDetail()
    {
        $id = $this->input->get('id');

        $data['getData']    = $this->m_calonKandidat->get_dataCalonKandidatRsupId($id);
        $this->load->view('monitor/calon_kandidat/ck_rsup/detail', $data);
    }

    function progresData()
    {
        $id = $this->input->get('id');

        $data['id'] = $id;
        $this->load->view('monitor/calon_kandidat/ck_rsup/progres', $data);
    }

    function editData()
    {
        $id = $this->input->get('id');

        $data['getDept']        = $this->m_calonKandidat->get_departemen();
        $data['getPendidikan']  = $this->m_calonKandidat->get_pendidikan();
        $data['getData']        = $this->m_calonKandidat->get_dataCalonkandidat($id);
        $data['getSuku']        = $this->m_calonKandidat->get_suku();
        $this->load->view('registrasi/calon_kandidat/update', $data);
    }

    function updateData()
    {
        $calonid        = $this->input->post('txtCalonid');
        $nama           = $this->input->post('txtNama');
        $jeniskelamin   = $this->input->post('txtJeniskelamin');
        $tempatlahir    = $this->input->post('txtTempatlahir');
        $tanggallahir   = $this->input->post('txtTanggallahir');
        $noktp          = $this->input->post('txtNoktp');
        $notelp         = $this->input->post('txtNotelp');
        $email          = $this->input->post('txtEmail');
        $posisi         = $this->input->post('txtPosisi');
        $lavel          = $this->input->post('txtLavel');
        $dept           = $this->input->post('txtDept');
        $pendidikan     = $this->input->post('txtPendidikan');
        $jurusan        = $this->input->post('txtJurusan');
        $jadwaltes      = $this->input->post('txtJadwaltes');
        $status         = $this->input->post('txtStatus');
        $statustes      = $this->input->post('txtStatustes');
        $transport      = $this->input->post('txtTransport');
        $biayatransport = $this->input->post('txtBiaya');
        $sumberpelamar  = $this->input->post('txtSumberpelamar');
        $ketarangan     = $this->input->post('txtKeterangan');
        $tglInterview   = $this->input->post('txtTanggalInterview');
        $suku           = $this->input->post('txtSuku');
        $daerahasal     = $this->input->post('txtDaerahasal');
        $tes            = $this->input->post('txtTest');
        $interview      = $this->input->post('txtInterview');
        $tglKedatangan  = $this->input->post('txtTanggalkedatangan');
        $universitas    = $this->input->post('txtuniversitas');

        $data = array(
            'Nama'              => $nama,
            'JenisKelamin'      => $jeniskelamin,
            'TempatLahir'       => $tempatlahir,
            'Tanggallahir'      => $tanggallahir,
            'NoKTP'             => $noktp,
            'NoTelp'            => $notelp,
            'SukuID'            => $suku,
            'DaerahAsal'        => $daerahasal,
            'Email'             => $email,
            'Posisi'            => $posisi,
            'LavelCalon'        => $lavel,
            'IssueID'           => $dept,
            'PendidikanID'      => $pendidikan,
            'Universitas'       => $universitas,
            'JurusanID'         => $jurusan,
            'JadwalTes'         => $jadwaltes,
            'Tes'               => $tes,
            'Interview'         => $interview,
            'TanggalInterview'  => $tglInterview,
            'Status'            => $status,
            'StatusTes'         => $statustes,
            'Tgl_kedatangan'    => $tglKedatangan,
            'Transport'         => $transport,
            'BiayaTransport'    => $biayatransport,
            'SumberPelamar'     => $sumberpelamar,
            'Keterangan'        => $ketarangan,
            'UpdateBy'          => $this->session->userdata('username'),
            'UpdateDate'        => date('Y-m-d H:i:s'),
        );

        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";
        $this->m_calonKandidat->update($calonid, $data);
        redirect('calonKandidat/monitorCalonKandidatRsup');
    }

    function exportExcel()
    {
        $this->load->library("Excel/PHPExcel");
        $bulan  = $this->uri->segment(3);
        $tahun  = $this->uri->segment(4);
        $status = $this->uri->segment(5);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        if ($bulan != NULL && $tahun != NULL && $status != NULL) {
            $data['getData'] = $this->m_calonKandidat->get_ajaxCalonKandidat1($bulan, $tahun, $status);
        } else {
            $data['getData'] = $this->m_calonKandidat->get_ajaxCalonKandidat2($bulan, $tahun);
        }

        $this->load->view('monitor/calon_kandidat/ck_rsup/excel', $data);
    }

    function monitorCalonKandidatPsg()
    {
        $data['_getFormID']         = $this->input->get('id');
        $data['getData'] = json_decode($this->curl->simple_get($this->API . '/Karyawan/getAll'));

        // print_r($data['getData']) ;
        $this->template->display('monitor/calon_kandidat/ck_psg/index', $data);
    }

    function updateProgres()
    {
        $id     = $this->input->post('txtcalonid');
        $status = $this->input->post('txtStatusprogres');
        $ket    = $this->input->post('txtCatatanProgres');

        $data = array(
            'Progres'       => $status,
            'KetProgres'    => $ket,
        );

        // echo "<pre>";
        // print_r($data);
        // echo "<pre>";
        $this->m_calonKandidat->update($id, $data);
        redirect('calonKandidat/monitorCalonKandidatRsup');
    }

    function tidakLulus()
    {
        $id     = $this->uri->segment(3);

        $data = array(
            'AssessmentHasil' => 0,
        );

        $this->m_calonKandidat->update($id, $data);
        redirect('calonKandidat/monitorCalonKandidatRsup');
    }

    function lulus()
    {
        $id     = $this->uri->segment(3);

        $data = array(
            'AssessmentHasil' => 1,
        );

        $this->m_calonKandidat->update($id, $data);
        redirect('calonKandidat/monitorCalonKandidatRsup');
    }

    // Filter Data

    function filterData()
    {
        $suku = $this->uri->segment(3);
        $pend = $this->uri->segment(5);
        $issue = $this->uri->segment(6);
        $tglAwal = $this->uri->segment(7);
        $tglAkhir = $this->uri->segment(8);

        if ($suku != NULL && $tglAkhir == NULL && $tglAkhir == NULL && $pend == NULL && $issue = NULL) {
            echo 'hahahahha';
            $data['getData'] = $this->m_calonKandidat->getData1($suku);
            $this->load->view('monitor/calon_kandidat/ck_rsup/ajax/data1', $data);
        } elseif ($suku != NULL && $tglAkhir != NULL && $tglAkhir != NULL && $pend == NULL && $issue = NULL) {
            echo "wkwkwkwkwkwk";
            $data['getData'] = $this->m_calonKandidat->getData2($suku, $tglAwal, $tglAkhir);
            $this->load->view('monitor/calon_kandidat/ck_rsup/ajax/data2', $data);
        } else {
            echo '';
        }
    }
}
