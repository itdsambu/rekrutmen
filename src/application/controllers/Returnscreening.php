<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Returnscreening extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }

        $this->load->model('m_returnscreening');
    }

    function index()
    {
        $data['periodeaktif'] = "";
        $data['getdata'] = "";
        $data['getttd'] = $this->m_returnscreening->getdatattdtk();
        $this->template->display('registrasi/returnscreening/index', $data);
    }

    function getdataperperiode()
    {
        $periode = $this->input->post('txtPeriode');
        $data['periodeaktif'] = $periode;
        $data['getdata'] = $this->m_returnscreening->getdatascreening($periode);
        $this->template->display('registrasi/returnscreening/index', $data);
    }

    function savescreening()
    {
        if ($this->input->post('Submit') == 'Simpan') {
            $id = $this->input->post('HeaderID');
            $data   = array(
                'SpecialScreening'          => null,
                'SpecialScreeningDate'      => null,
                'ScreeningComplete'         => 1,
                'ScreeningHasil'            => 1,
                'GeneralStatus'             => 0,
                'SpecialScreeningHostname'  => $this->session->userdata('hostname'),
                'SpecialScreeningIpAddress' => $this->session->userdata('ipaddress')
            );
            // $data   = array(
            //     'SpecialScreening'          => 1,
            //     'SpecialScreeningDate'      => date('Y-m-d H:i:s'),
            //     'ScreeningComplete'         => 1,
            //     'ScreeningHasil'            => 1,
            //     'GeneralStatus'             => 0,
            //     'SpecialScreeningHostname'  => $this->session->userdata('hostname'),
            //     'SpecialScreeningIpAddress' => $this->session->userdata('ipaddress')
            // ); 
            $this->m_returnscreening->screenByPsn($id, $data);
            redirect('Returnscreening/index');
        }
    }

    // function replacephoto(){
    //     $chk = $this->input->post('checkbox');
    //     $img = $this->input->post('ttdtenaker');
    //     $fixno = $this->input->post('txtfixno');
    //     $upload_dir = "dataupload/datakar/TTD_TK/";
    //     for ($i=0; $i < count($chk); $i++) {
    //         $file = $upload_dir . $fixno[$i] . ".png";
    //         $imges = str_replace('data:image/png;base64,', '', $img[$i]);
    //         $imge = str_replace(' ', '+', $imges);
    //         $image = base64_decode($imge);
    //         $success = file_put_contents($file,$image);

    //         // $data = array(
    //         //     'ttd' => file_put_contents($upload_dir.$fixno[$i].".png",base64_decode($ttd[$i]))
    //         // );
    //         print_r($success.' ,');
    //     }
    // }
}


// $file = $upload_dir . $file_fix[$i] . ".png";
// $imges = str_replace('data:image/png;base64,', '', $ttd[$i]);
// $imge = str_replace(' ', '+', $imges);
// $image = base64_decode($imge);
// $success = file_put_contents($file,$image);
// 
//                 base64_decode(file_put_contents($upload_dir . $fixno[$i] . ".png",$ttd[$i]))