<?php

/* 
 * Author by ITD15
 */

class WawancaraProses extends CI_Controller{
    
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
        
        $this->load->model('m_wawancara');
    }
    
    function wawancaraHarianIndex(){
        $data['_getTenagaKerja'] = $this->m_wawancara->getTenakerHarian();
        $data['_getDept'] = $this->m_wawancara->getDepartment();
        
        $this->template->display('registrasi/proses_wawancara/wawancara_harian/index', $data);
    }
    
    function doWawancaraHarian(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->m_wawancara->getDetailTK($kode)->result();
            foreach ($this->m_wawancara->getDetailTK($kode)->result() as $row){
                $department = $row->DeptTujuan;
            }
            $data['_getKualifikasi']= $this->m_wawancara->getKualifikasiDasar();
            $data['_getPekerjaan']  = $this->m_wawancara->getPekerjaan($department);
            $this->load->view('registrasi/proses_wawancara/wawancara_harian/wawancaraHarian',$data);
        }
    }
    
    function simpanWawancaraHarian(){
        $nilai1 = $this->input->post('txtNilai1');
        $nilai2 = $this->input->post('txtNilai2');
        $nilai3 = $this->input->post('txtNilai3');
        $nilai4 = $this->input->post('txtNilai4');
        $nilai5 = $this->input->post('txtNilai5');
        $nilai6 = $this->input->post('txtNilai6');
        
        $total  = $nilai1+$nilai2+$nilai3+$nilai4+$nilai5+$nilai6;
        $rata   = $total/6;
        
        if ($rata >= 60){
            $hasil  = 1;
            $grade  = "LULUS";
        }else{
            $hasil  = 0;
            $grade  = "GAGAL";
        }
        //=====================================================================
        $data1  = array(
            'HeaderID'      => $this->input->post('HeaderID'),
            'Tanggal'       => date('Y-m-d H:i:s'),
            'Departemen'    => $this->input->post('txtDept'),
            'WawancaraBy'   => $this->session->userdata('username'),
            'HasilWawancara'=> $hasil,
            'Keterangan'    => $this->input->post('txtCatatan'),
            'TotalNilai'    => $total,
            'RataNilai'     => $rata,
            'Grade'         => $grade,
            'JenisKerja'    => $this->input->post('txtJenisKerja'),
            'KepalaShift'   => $this->input->post('txtKepala')
        );
        $this->m_wawancara->insertWawancara($data1);
        //=====================================================================
        $no = 1;
        for($i=0; $i<6; $i++){
            $data2  = array(
                'HeaderID'  => $this->input->post('HeaderID'),
                'Item'      => $i+1,
                'Nilai'     => $this->input->post("txtNilai".$no++."")
            );
            $this->m_wawancara->insertDetailWawancara($data2);
        }
        //=====================================================================
        $hrdID  = $this->input->post('HeaderID');
        $wKe    = $this->cekWawancaraKe($hrdID);
        if($hasil == 1 && $wKe == 3 || $hasil == 1 && $wKe == 2 || $hasil == 1 && $wKe == 1){
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID,$info);
        }elseif ($hasil == 0 && $wKe== 1 || $hasil == 0 && $wKe== 2) {
            $info   = array(
                'DeptTujuan'        => NULL,
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID,$info);
        }elseif ($hasil == 0 && $wKe== 3) {
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe,
                'GeneralStatus'     => 1,
                'ClosingRemark'     => 'Gagal wawancara 3 kali'
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID,$info);
        }
        
        redirect('wawancaraProses/wawancaraHarianIndex?msg=Success');
    }
    
    function cekWawancaraKe($hrdID){
        $wKe = 0;
        $cekInterview = $this->m_wawancara->getDetailTK($hrdID)->result();
        foreach ($cekInterview as $row):
            $wKe = $row->WawancaraKe+1;
        endforeach;
        
        return $wKe;
    }
    
    function cekTotalHasil($hrdID){
        $hasil  = 0;
        $cekHasil = $this->m_wawancara->getHasil($hrdID);
        foreach ($cekHasil as $row):
            $hasil = $row->Total;
        endforeach;
        
        return $hasil;
    }
            
    function wawancaraIndex(){
        $data['_getTenagaKerja'] = $this->m_wawancara->getTenaker();
        $data['_getDept'] = $this->m_wawancara->getDepartment();
        
        $this->template->display('registrasi/proses_wawancara/wawancara_karyawan/index', $data);
    }
    
    function doWawancaraKaryawan(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->m_wawancara->getDetailTK($kode)->result();
            $data['_getKualifikasi'] = $this->m_wawancara->getKualifikasiKaryawan();
            $data['_getKualifiSmu'] = $this->m_wawancara->getKualifikasiSMU();
            $cekPendidikan = $this->m_wawancara->getDetailTK($kode)->result();
            foreach ($cekPendidikan as $row){
                if($row->Pendidikan == 'D3' || $row->Pendidikan == 'S1' || $row->Pendidikan == 'S2'|| $row->Pendidikan == 'S3'){
                    $this->load->view('registrasi/proses_wawancara/wawancara_karyawan/wawancaraKaryawan',$data);
                }  else {
                    $this->load->view('registrasi/proses_wawancara/wawancara_karyawan/wawancaraSmu',$data);
                }
            }
            
        }
    }
    
    function simpanWawancaraKaryawan(){
        $nilai1 = $this->input->post('txtNilai1');
        $nilai2 = $this->input->post('txtNilai2');
        $sum1 = ($nilai1+$nilai2)/2;
        
        $nilai3 = $this->input->post('txtNilai3');
        $nilai4 = $this->input->post('txtNilai4');
        $nilai5 = $this->input->post('txtNilai5');
        $sum2 = ($nilai3+$nilai4+$nilai5)/3;
        
        $nilai6 = $this->input->post('txtNilai6');
        $nilai7 = $this->input->post('txtNilai7');
        $nilai8 = $this->input->post('txtNilai8');
        $sum3 = ($nilai6+$nilai7+$nilai8)/3;
        
        $nilai9 = $this->input->post('txtNilai9');
        $nilai10 = $this->input->post('txtNilai10');
        $sum4 = ($nilai9+$nilai10)/2;
        
        $nilai11 = $this->input->post('txtNilai11');
        $nilai12 = $this->input->post('txtNilai12');
        $sum5 = ($nilai11+$nilai12)/2;
        
        $total = $sum1+$sum2+$sum3+$sum4+$sum5;
        $rata   = $total/5;
        
        if ($rata >= 60){
            $hasil  = 1;
            $grade  = "LULUS";
        }else{
            $hasil  = 0;
            $grade  = "GAGAL";
        }
        //=====================================================================
        $data1  = array(
            'HeaderID'      => $this->input->post('HeaderID'),
            'Tanggal'       => date('Y-m-d H:i:s'),
            'Departemen'    => $this->input->post('txtDept'),
            'WawancaraBy'   => $this->session->userdata('username'),
            'HasilWawancara'=> $hasil,
            'Keterangan'    => $this->input->post('txtCatatan'),
            'TotalNilai'    => $total,
            'RataNilai'     => $rata,
            'Grade'         => $grade
        );
        $this->m_wawancara->insertWawancara($data1);
        //=====================================================================
        $no = 1;
        $ke = 1;
        for($i=0; $i<12; $i++){
            $data2  = array(
                'HeaderID'  => $this->input->post('HeaderID'),
                'Item'      => $i+1,
                'Nilai'     => $this->input->post("txtNilai".$no++.""),
                'Catatan'   => $this->input->post("txtPenjelasan".$ke++.""),
            );
            $this->m_wawancara->insertDetailWawancara($data2);
        }
        //=====================================================================
        $hrdID  = $this->input->post('HeaderID');
        $wKe    = $this->cekWawancaraKe($hrdID);
        if($hasil == 1 && $wKe == 3 || $hasil == 1 && $wKe == 2 || $hasil == 1 && $wKe == 1){
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID,$info);
        }elseif ($hasil == 0 && $wKe== 1 || $hasil == 0 && $wKe== 2) {
            $info   = array(
                'DeptTujuan'        => NULL,
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID,$info);
        }elseif ($hasil == 0 && $wKe== 3) {
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe,
                'GeneralStatus'     => 1,
                'ClosingRemark'     => 'Gagal wawancara 3 kali'
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID,$info);
        }
        
        
        redirect('wawancaraProses/wawancaraIndex?msg=Success');
    }
    function simpanWawancaraKaryawanSMU(){
        $nilai1 = $this->input->post('txtNilai1');
        $nilai2 = $this->input->post('txtNilai2');
        $nilai3 = $this->input->post('txtNilai3');
        $nilai4 = $this->input->post('txtNilai4');
        $nilai5 = $this->input->post('txtNilai5');
        $nilai6 = $this->input->post('txtNilai6');
        
        if($nilai6 == ""){
            $total  = $nilai1+$nilai2+$nilai3+$nilai4+$nilai5;
            $rata   = $total/5;
            $itung  = 5;
        }else{
            $total  = $nilai1+$nilai2+$nilai3+$nilai4+$nilai5+$nilai6;
            $rata   = $total/6;
            $itung  = 6;
        }
        
        if ($rata >= 60){
            $hasil  = 1;
            $grade  = "LULUS";
        }else{
            $hasil  = 0;
            $grade  = "GAGAL";
        }
        //=====================================================================
        $data1  = array(
            'HeaderID'      => $this->input->post('HeaderID'),
            'Tanggal'       => date('Y-m-d H:i:s'),
            'Departemen'    => $this->input->post('txtDept'),
            'WawancaraBy'   => $this->session->userdata('username'),
            'HasilWawancara'=> $hasil,
            'Keterangan'    => $this->input->post('txtCatatan'),
            'TotalNilai'    => $total,
            'RataNilai'     => $rata,
            'Grade'         => $grade
        );
        $this->m_wawancara->insertWawancara($data1);
        //=====================================================================
        $no = 1;
        for($i=0; $i<$itung; $i++){
            $data2  = array(
                'HeaderID'  => $this->input->post('HeaderID'),
                'Item'      => $i+1,
                'Nilai'     => $this->input->post("txtNilai".$no++."")
            );
            $this->m_wawancara->insertDetailWawancara($data2);
        }
        //=====================================================================
        $hrdID  = $this->input->post('HeaderID');
        $wKe    = $this->cekWawancaraKe($hrdID);
        if($hasil == 1 && $wKe == 3 || $hasil == 1 && $wKe == 2 || $hasil == 1 && $wKe == 1){
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID,$info);
        }elseif ($hasil == 0 && $wKe== 1 || $hasil == 0 && $wKe== 2) {
            $info   = array(
                'DeptTujuan'        => NULL,
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID,$info);
        }elseif ($hasil == 0 && $wKe== 3) {
            $info   = array(
                'WawancaraHasil'    => $hasil,
                'WawancaraKe'       => $wKe,
                'GeneralStatus'     => 1,
                'ClosingRemark'     => 'Gagal wawancara 3 kali'
            );
            $this->m_wawancara->updateWawancaraTenaker($hrdID,$info);
        }
        
        
        redirect('wawancaraProses/wawancaraIndex?msg=Success');
    }
}


/* End of file wawancaraProses.php */
/* Location: ./application/controllers/wawancaraProses.php */