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
        $this->load->library(array('table', 'form_validation', 'pdf'));
        $this->load->helper('form');
        // $this->load->library('Fpdf');

        //////////////////////////////////
        /// prevent direct url accses

        /// end prevent direct url accses
        //////////////////////////////////
    }

    function exporttopdf()
    {
        $this->load->model(array('M_monitor'));
        $id               = $this->uri->segment(4);
        $key = 'your-secret-key'; // Kunci enkripsi yang sama
        $headerID = decrypt($id, $key);
        $dtdetail         = $this->M_monitor->getDataListTenakerForPBR($headerID);
        $data['dtdetail'] = $dtdetail;


        $this->load->view('monitor/listTenakerForPemborong/pdf/V_pdf', array_merge($data));
    }
}
