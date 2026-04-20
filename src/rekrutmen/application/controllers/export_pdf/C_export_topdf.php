<?php
date_default_timezone_set('Asia/Jakarta');

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_export_topdf extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model(array('M_monitor'));
        // $this->load->library(array('table', 'form_validation', 'pdf'));
        $this->load->helper('form');
        // $this->load->library('Fpdf');

        //////////////////////////////////
        /// prevent direct url accses

        /// end prevent direct url accses
        //////////////////////////////////
    }

    // function exporttopdf()
    // {
    //     $this->load->model(array('M_monitor'));
    //     $id               = $this->uri->segment(4);
    //     $key = 'your-secret-key'; // Kunci enkripsi yang sama
    //     $headerID = decrypt($id, $key);
    //     $dtdetail         = $this->M_monitor->getDataListTenakerForPBR($headerID);
    //     $data['dtdetail'] = $dtdetail;


    //     $this->load->view('monitor/listTenakerForPemborong/pdf/V_pdf', array_merge($data));
    // }

    public function exporttopdf()
    {
        $id = $this->uri->segment(4);
        $key = 'your-secret-key';
        $headerID = decrypt($id, $key);

        $dtdetail = $this->M_monitor->getDataListTenakerForPBR($headerID);

        if (!$dtdetail) {
            show_error('Data tidak ditemukan');
            return;
        }

        $data['dtdetail'] = $dtdetail;

        // Render HTML dari view
        ob_start();
        $this->load->view('monitor/listTenakerForPemborong/pdf/V_pdf', $data);
        $html = ob_get_clean();

        // Generate PDF dengan mPDF
        require_once FCPATH . 'vendor/autoload.php';

        // Folder temp mPDF
        $tempDir = APPPATH . 'cache/mpdf/';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'orientation'   => 'P',
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 15,
            'margin_bottom' => 15,
            'default_font'  => 'dejavusans',
            'tempDir'       => $tempDir,
        ]);

        $mpdf->SetTitle('SURAT KETERANGAN HASIL MCU');
        $mpdf->WriteHTML($html);
        $mpdf->Output('Form_Kontrol_Ulang_MCU.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
    }
}
