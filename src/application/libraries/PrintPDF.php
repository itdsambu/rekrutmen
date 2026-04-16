<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PrintPDF {
    
    function getFile($url){
        ob_start();
        include(dirname(__FILE__).site_url('$url'));
        $content = ob_get_clean();

        // convert in PDF
        require_once(dirname(__FILE__).''.base_url().'assets/html2pdf/html2pdf.class.php');
        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    //      $html2pdf->setModeDebug();
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('exemple00.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }

    }
}