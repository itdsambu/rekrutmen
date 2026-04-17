<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class bontotal extends CI_Controller {
  
  public function __construct(){
    parent::__construct();
    
    $this->load->model('m_bonpiutang');
    $this->load->library("printPDF");

  }

  public function pdf(){
       
        $this->load->model('m_bonpiutang');
        $this->load->library("printPDF");

            $newdata = array(
                    'periode'  => $this->input->post('selectperiod'),
                    'bon'      => $this->input->post('Pemborong'),
            );

            $this->session->set_userdata($newdata);
    }
  
  public function index(){
    //-------------------- Manggil Periode ---------------------------
    $periode_bon            = $this->session->userdata('periode');
    // $periode_bon_pemborong  = date('Y-m-d', strtotime($periode_bon));

    //-------------------- Manggil Pemborong --------------------------
    $pemborong_bon    = $this->session->userdata('bon');
    $getbon           = $this->m_bonpiutang->getPemborong_totalbon($pemborong_bon);
    $namapemborong    = $getbon  ? $getbon->Pemborong : '';

    $data['periode']  = $periode_bon;
    $data['bon']      = $namapemborong;

    $data['bontk'] = $this->m_bonpiutang->total_Bon($periode_bon, $pemborong_bon);
    $this->load->view('monitor/bontk/preview', $data);
  }
  
  public function cetak(){
    ob_start();
    //-------------------- Manggil Periode ---------------------------
    $periode_bon            = $this->session->userdata('periode');
    // $periode_bon_pemborong  = date('Y-m-d', strtotime($periode_bon));

    //-------------------- Manggil Pemborong --------------------------
    $pemborong_bon    = $this->session->userdata('bon');
    $getbon           = $this->m_bonpiutang->getPemborong_totalbon($pemborong_bon);
    $namapemborong    = $getbon  ? $getbon->Pemborong : '';

    $data['periode']  = $periode_bon;
    $data['bon']      = $namapemborong;

    $data['bontk'] = $this->m_bonpiutang->total_Bon($periode_bon, $pemborong_bon);
    $this->load->view('monitor/bontk/index', $data);

    $html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
    $pdf = new HTML2PDF('P','A4','en');
    $pdf->WriteHTML($html);
    $pdf->Output('Data Bon Tenaga Kerja('.$periode_bon.').pdf', 'D');
  }
}