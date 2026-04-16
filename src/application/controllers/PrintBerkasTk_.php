<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PrintBerkasTk extends CI_Controller{
    
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
        
        $this->load->model(array('M_PrintBerkasTk','m_register'));
    }
    
    
    function index(){

        $data['getTenagaKerja'] = $this->M_PrintBerkasTk->get_tenagakerja();
        $data['getDepartemen'] = $this->M_PrintBerkasTk->get_departemen();
        $this->template->display('registrasi/printberkastk/index',$data);
    }

    function ajaxDept(){
        $pilih = $this->uri->segment(3);

        if($pilih == 1){
            $data['getDepartemen'] = $this->M_PrintBerkasTk->get_departemen();
        }else{
            $data['getDepartemen'] = $this->M_PrintBerkasTk->get_departemen_pam();
        }
        $this->load->view('registrasi/printberkastk/ajax/dept',$data);
    }

    function ajaxData(){
        $tanggal    = $this->uri->segment(3);
        $depttujuan = $this->uri->segment(4);

        $data['tanggal'] = $tanggal;
        $data['depttujuan'] = $depttujuan;
        $data['getTenagaKerja'] = $this->M_PrintBerkasTk->get_tenagakerja_wawancara($tanggal,$depttujuan);
        $this->load->view('registrasi/printberkastk/ajax/data',$data);
    
    }
    function ajaxDatacekfisik(){
        $tanggal    = $this->uri->segment(3);
        $depttujuan = $this->uri->segment(4);

        $data['tanggal'] = $tanggal;
        $data['depttujuan'] = $depttujuan;
        $data['getTenagaKerja'] = $this->M_PrintBerkasTk->get_tenagakerja_cekfisik();
        $this->load->view('registrasi/printberkastk/ajax/datacekFisik',$data);
    }

    function simpan(){
        $tanggal    = $this->input->post('txttanggal');
        $depttujuan = $this->input->post('txtdepttujuan');
        $pilihmemo  = $this->input->post('txtpilihmemo');
        $cek        = $this->input->post('cek');
        $jumlah     = count($cek);

        for ($i=0; $i < $jumlah; $i++) { 
            $data = array(
                'WawancaraDept'     => $depttujuan,
                'WawancaraCek'      => 1,
                'WawancaraCekBy'    => $this->session->userdata('username'), 
                'WawancaraCekDate'  => date('Y-m-d H:i:s'),
            );

            $this->M_PrintBerkasTk->simpan($cek[$i],$data);
        }
        redirect('PrintBerkasTk');
    }

    function simpancekfisik(){
        $tanggal    = $this->input->post('txttanggal');
        $depttujuan = $this->input->post('txtdepttujuan');
        $pilihmemo  = $this->input->post('txtpilihmemo');
        $cek        = $this->input->post('cek');
        $jumlah     = count($cek);

         for ($i=0; $i < $jumlah; $i++) { 
            $data = array(
                'FisikDept'     => $depttujuan,
                'FisikCek'      => 1,
                'FisikCekBy'    => $this->session->userdata('username'), 
                'FisikCekDate'  => date('Y-m-d H:i:s'),
            );

            // print_r($data);
            $this->M_PrintBerkasTk->simpan($cek[$i],$data);
        }

        redirect('PrintBerkasTk');
    }

    function open_lock(){
        $id = $this->input->get('id');

        $cek_tgl_lock = $this->m_register->cek_tgl_lock($id);
        foreach ($cek_tgl_lock as $key) {
            echo '<div class="row">
                    <div class="col-lg-12">
                        <form class="form-horizontal" role="form" name="myForm" method="POST" action="Verifikasi/simpan_open_lock">
                           <div class="form-group">
                               <label class="col-lg-3 control-label">Tanggal Lock</label>
                               <div class="col-lg-5">
                                   <input type="date" class="form-control" name="tgl_lock" value="'.$key->TanggalLock.'">
                                   <input type="hidden" class="form-control" name="pra_pelamar" value="'.$key->Pra_PelamarID.'">
                                   <input type="hidden" class="form-control" name="headerid" value="'.$key->HeaderID.'">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="col-lg-3 control-label">Open Lock</label>
                               <div class="col-lg-5">
                                   <input type="text" class="form-control" name="open_lock">
                               </div>
                           </div> 
                           <div class="form-group">
                               <label class="col-lg-3 control-label"></label>
                               <div class="col-lg-4">
                                   <input type="submit" value="Simpan" class="btn btn-sm btn-primary">
                               </div>
                           </div>  
                        </form>
                    </div>
                </div>';
        }
    }

    function simpan_open_lock(){
        $id         = $this->input->post('pra_pelamar');
        $hdrid         = $this->input->post('headerid');
        $tgl_lock   = $this->input->post('tgl_lock');
        $open_lock  = $this->input->post('open_lock');

        $lock =  date('d-m-Y', strtotime('+'.$open_lock.' days', strtotime($tgl_lock)));
        $data = array(
            'TanggalLock' => date('Y-m-d',strtotime($lock)),
        );

        $this->m_register->update_tgl_lock($id,$data);
        redirect(site_url('Verifikasi/index?msg=success2'));
    }
}