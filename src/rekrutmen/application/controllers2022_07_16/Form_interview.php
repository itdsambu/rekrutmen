<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Form_interview extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
//        $status = 1;
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        
        $this->load->model(array('M_form_interview'));
    }
    
    public function index(){
        $data['getListTK'] = $this->M_form_interview->getListTK();
        $this->template->display('registrasi/form_interview/index',$data);
    }
    
    function verifiAksi(){
        if(isset($_POST['Verifi'])){
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->M_form_interview->updateVerified($checked[$i]);
            }
            redirect(site_url('form_interview/index'));
        }
        elseif (isset($_POST['Cancel'])) {
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for($i=0; $i<$itung; $i++){
                $this->M_form_interview->batalVerified($checked[$i]);
            }
            redirect(site_url('form_interview/index'));
        }
    }
    
    function detailtk(){
        if('IS_AJAX') {
            $kode=$this->input->post('kode');
            $data['datatk'] = $this->M_form_interview->get_detailtk($kode)->result();
            foreach ($this->M_form_interview->get_detailtk($kode)->result() as $row):
                $tglLahir   = $row->Tgl_Lahir;
            endforeach;
            $data['_umur']  = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
            $this->load->view('registrasi/form_interview/detail',$data);
        }
    }
    
    function closeTenaker(){
        $hdrID = $this->input->post('txtHeaderID');
        $remark= $this->input->post('txtRemarkClose');
        $this->M_form_interview->closeTenaker($hdrID,$remark);
        redirect(site_url('form_interview/index'));
    }

    function hitungUmur($tglLahir = "1991-02-01"){
        $thn    = substr($tglLahir, 0, 4);
        $bln    = substr($tglLahir, 5, 2);
        $day    = substr($tglLahir, 8, 2);
        
        $nowY   = date("Y");
        $nowM   = date("m");
        $nowD   = date("d");
        
        $hariLahir  = gregoriantojd($bln, $day, $thn);
        $today      = gregoriantojd($nowM, $nowD, $nowY);
        
        $umur   = $today-$hariLahir;
        $tahun  = substr($umur/365, 0, 2);
        
        return $tahun;
    }

    public function cetakpdf(){
        $data['title'] = 'Form Interview'; //judul title
        $data['qbarang'] = $this->M_form_interview->getAllItem(); //query model semua barang
 
        $this->load->view('print/pf_interview');
        $paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
    }
}

/* End of file form_interview.php */
/* Location: ./application/controllers/form_interview.php */