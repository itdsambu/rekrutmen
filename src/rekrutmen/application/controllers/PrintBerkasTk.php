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
        $data['getDepartemen'] = $this->M_PrintBerkasTk->get_departemen_pam();
        $this->template->display('registrasi/printberkastk/index',$data);
    }

    function simpancekfisik(){
        $headerid = $this->input->post("ckHdrID");
        $tanggal  = $this->input->post("txttanggal");
        $dept     = $this->input->post("txtdepttujuan");
        $jml = count($headerid);

        for ($i=0; $i < $jml; $i++) { 
            $data = array(
                'FisikCek' => 1, 
                'FisikCekBy' => $this->session->userdata('username'), 
                'FisikCekDate' => date('Y-m-d H:i:s'),
                'FisikDept' => $dept, 
            );

            $this->M_PrintBerkasTk->simpan($headerid[$i],$data);
        }

        redirect('PrintBerkasTk');
    }


    // BEGIN :: OPEN LOCK 
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

    // END :: OPEN LOCK
}