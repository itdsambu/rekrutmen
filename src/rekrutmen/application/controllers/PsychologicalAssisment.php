<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * Author by Ifa Sonia Istifarani
 */ 

class PsychologicalAssisment extends CI_Controller{
    
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
        
        $this->load->model('m_PsychologicalAssisment');
    }
    
    //psychological Test 
    function index(){

        $this->template->display('psychological_assisment/psychologicaltest/index');
    }

    function tambahDataPsychologicaltest(){
        $data['list'] = $this->m_PsychologicalAssisment->getList();
        $this->template->display('psychological_assisment/psychologicaltest/psychological_test',$data);
    }

    function getKaryawan(){
        $nama = $this->uri->segment(3);
 
        // echo $nama;
        $data['getData']  = $this->m_PsychologicalAssisment->get_DataKaryawan($nama);
        $this->load->view('psychological_assisment/psychologicaltest/ajaxCari',$data);
    }

    function simpanData(){
        $id                      = $this->input->post('txtHeaderid');
        $nama                    = $this->input->post('txtnama');
        $tgllahir                = $this->input->post('txttgllahir');
        $umur                    = $this->input->post('txtumur');
        $pendidikan              = $this->input->post('txtpendidikan');
        $tglTes                  = $this->input->post('txttgltest');
        $tglLaporan              = $this->input->post('txttgllaporan');
        $assismentid             = $this->input->post('txtAssismentid');
        $assismentprocedure      = $this->input->post('txtKetAssismentProcedure');
        $backgroundinformation   = $this->input->post('txtBackgroundInformation');
        $resultformtesting       = 'assets/document/'.$id. '.pdf';
        $recomendation           = $this->input->post('txtRecomendation');
        $sikapwawancara          = $this->input->post('txtSikapWawancara');
        $sikapketikaberbicara    = $this->input->post('txtSikapKetikaberbicara');
        $sikaptingkatpengetahuan = $this->input->post('txtSikapTingkatpengetahuan');
        $sikapterhadapatasan     = $this->input->post('txtSikapterhadapatasan');
        $tanggapanatasenergi     = $this->input->post('txtTanggapanAtasEnergi');

       
        $config['upload_path']   = './assets/document/';
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = '2048';
        $config['file_name']        = $id;

        $this->load->library('upload');   
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('txtResultFormTesting')){
            $this->upload->display_errors();
        }else{
               $upload_data = $this->upload->data();
        }

        $CEK = $this->m_PsychologicalAssisment->cekPsychoTest($id);

        if (empty($CEK)) {
            $data = array(
                'HeaderID'                     => $id,
                'Nama'                         => $nama,
                'Tanggal_lahir'                => date('Y-m-d',strtotime($tgllahir)),
                'Umur'                         => $umur,
                'Grade'                        => $pendidikan,
                'Tanggal_test'                 => date('Y-m-d',strtotime($tglTes)),
                'Tanggal_laporan'              => date('Y-m-d',strtotime($tglLaporan)),
                'Assisment_procedures'         => $assismentid,
                'KetAssisment_procedures'      => $assismentprocedure,
                'Background_information'       => $backgroundinformation,
                'Result_formTesting'           => $resultformtesting,
                'Sikap_selamaWawancara'        => $sikapwawancara,
                'Sikap_ketikaBerbicara'        => $sikapketikaberbicara,
                'Perkiraan_tingkatPengetahuan' => $sikaptingkatpengetahuan,
                'Kemungkinan_sikap'            => $sikapterhadapatasan,
                'Tanggapan_atasEnergi'         => $tanggapanatasenergi,
                'Recomendations'               => $recomendation,
                'CreatedBy'                    => $this->session->userdata('username'),
                'CreatedDate'                  => date('Y-m-d H:i:s'),
                'Status'                       => '1'
            );

            $result = $this->m_PsychologicalAssisment->simpan($data);

        }elseif (!empty($CEK)) {
            $data = array(
                'Assisment_procedures'         => $assismentid,
                'KetAssisment_procedures'      => $assismentprocedure,
                'Background_information'       => $backgroundinformation,
                'Result_formTesting'           => $resultformtesting,
                'Recomendations'               => $recomendation,
                'Sikap_selamaWawancara'        => $sikapwawancara,
                'Sikap_ketikaBerbicara'        => $sikapketikaberbicara,
                'Perkiraan_tingkatPengetahuan' => $sikaptingkatpengetahuan,
                'Kemungkinan_sikap'            => $sikapterhadapatasan,
                'Tanggapan_atasEnergi'         => $tanggapanatasenergi,
                'UpdateBy'                     => $this->session->userdata('username'),
                'UpdateDate'                   => date('Y-m-d H:i:s')
            );
            $result = $this->m_PsychologicalAssisment->perbaharui($id,$data);
        }

        if(!$result){

            redirect('PsychologicalAssisment/tambahDataPsychologicaltest?msg=success');
        }else{
            redirect('PsychologicalAssisment/tambahDataPsychologicaltest?msg=failed');
        }
    }

    function getNama(){
        $id = $this->uri->segment(3);

        // echo $id;
        $data['getData']  = $this->m_PsychologicalAssisment->get_Data($id);
        $this->load->view('psychological_assisment/psychologicaltest/getNamaKaryawan',$data);
    }

    // Disc Assisment

    function discAssisment(){
        $data['list'] = $this->m_PsychologicalAssisment->getListdua();
        $this->template->display('psychological_assisment/disc_assisment/index',$data);
    }
    function getKaryawanDisc(){
        $nama = $this->uri->segment(3);

        // echo $nama;
        $data['getData']  = $this->m_PsychologicalAssisment->get_DataKaryawan($nama);
        $this->load->view('psychological_assisment/disc_assisment/ajaxCari',$data);
    }
    function getNamaDisc(){
        $id = $this->uri->segment(3);

        // echo $id;
        $data['getData']  = $this->m_PsychologicalAssisment->get_Data($id);
        $this->load->view('psychological_assisment/disc_assisment/getNamaKaryawan',$data);
    }
    function simpanDataDisc(){
        $id                      = $this->input->post('txtHeaderid');
        $nama                    = $this->input->post('txtnama');
        $position                = $this->input->post('txtposition');
        $organization            = $this->input->post('txtorganization');
        $date                    = $this->input->post('txtdate');
        $education               = $this->input->post('txteducation');
        $gender                  = $this->input->post('txtgender');
        $discAssisment           = $this->input->post('txtdiscArea');

        $CEK = $this->m_PsychologicalAssisment->cekDiscAsses($id);

        if (empty($CEK)) {
            $data = array(
                'HeaderID'                     => $id,
                'Nama'                         => $nama,
                'Position'                     => $position,
                'Organization'                 => $organization,
                'Date'                         => $date,
                'Education'                    => $education,
                'Gender'                       => $gender,
                'DiscAssisment'                => $discAssisment,
                'CreatedBy'                    => $this->session->userdata('username'),
                'CreatedDate'                  => date('Y-m-d H:i:s'),
                'Status'                       => '1'
            );            
            $result = $this->m_PsychologicalAssisment->save($data); 
        }elseif (!empty($CEK)) {
            $data = array(
                'DiscAssisment'               => $discAssisment,
                'UpdateBy'                    => $this->session->userdata('username'),
                'UpdateDate'                  => date('Y-m-d H:i:s')
            );
            $result = $this->m_PsychologicalAssisment->update($id,$data);
        }
        if(!$result){
            redirect('PsychologicalAssisment/discAssisment/?msg=success');
        }else{
            redirect('PsychologicalAssisment/discAssisment/?msg=failed');
        }  
    }
 
    //FIRO B

    function firoB(){
        $data['list'] = $this->m_PsychologicalAssisment->getListdua();
        $this->template->display('psychological_assisment/firo_b/index',$data);
    }
    function getKaryawanFiro(){
        $nama = $this->uri->segment(3);

        // echo $nama;
        $data['getData']  = $this->m_PsychologicalAssisment->get_DataKaryawan($nama);
        $this->load->view('psychological_assisment/firo_b/ajaxCari',$data);
    }
    function getNamaFiro(){
        $id = $this->uri->segment(3);

        $data['getData']  = $this->m_PsychologicalAssisment->get_Data($id);
        $this->load->view('psychological_assisment/firo_b/getNamaKaryawan',$data); 
    }
    function simpanDataFiro(){
        $id                      = $this->input->post('txtHeaderid');
        $nama                    = $this->input->post('txtnama');
        $position                = $this->input->post('txtposition');
        $organization            = $this->input->post('txtorganization');
        $date                    = $this->input->post('txtdate');
        $education               = $this->input->post('txteducation');
        $gender                  = $this->input->post('txtgender');
        $expInc                  = $this->input->post('txtexpressedInclusion');
        $expCon                  = $this->input->post('txtexpressedControl');
        $expAff                  = $this->input->post('txtexpressedAffection');
        $totExp                  = $this->input->post('txttotalExpressed');
        $wanInc                  = $this->input->post('txtwantedInclusion');
        $wanCon                  = $this->input->post('txtwantedControl');
        $wanAff                  = $this->input->post('txtwantedAffection');
        $wanExp                  = $this->input->post('txtwantedExpressed');
        $totInc                  = $this->input->post('txttotalInclusion');
        $totCon                  = $this->input->post('txttotalControl');
        $totAff                  = $this->input->post('txttotalAffection');
        $overall                 = $this->input->post('txtOverall');
        $expIncKlm               = $this->input->post('txtAreaexpressedInc');
        $expConKlm               = $this->input->post('txtAreaexpressedCon');
        $expAffKlm               = $this->input->post('txtAreaexpressedAff');
        $totExpKlm               = $this->input->post('txtAreaexpressedTot');
        $wanIncKlm               = $this->input->post('txtAreawantedInc');
        $wanConKlm               = $this->input->post('txtAreawantedCon');
        $wanAffKlm               = $this->input->post('txtAreawantedAff');
        $wanExpKlm               = $this->input->post('txtAreawantedExpressed');
        $totIncKlm               = $this->input->post('txtAreatotalInc');
        $totConKlm               = $this->input->post('txtAreatotalCon');
        $totAffKlm               = $this->input->post('txtAretotalAff');
        $overallKlm              = $this->input->post('txtAreaoverall');

        $CEK = $this->m_PsychologicalAssisment->cekfiroB($id);

        if (empty($CEK)) {
                $data = array(
                    'HeaderID'                     => $id,
                    'Nama'                         => $nama,
                    'Position'                     => $position,
                    'Organization'                 => $organization,
                    'Date'                         => $date,
                    'Education'                    => $education,
                    'Gender'                       => $gender,
                    'ExpressedInclusion'           => $expInc,
                    'ExpressedControl'             => $expCon,
                    'ExpressedAffection'           => $expAff,
                    'TotalExpressed'               => $totExp,
                    'WantedInclusion'              => $wanInc,
                    'WantedControl'                => $wanCon,
                    'WantedAffection'              => $wanAff,
                    'TotalWanted'                  => $wanExp,
                    'TotalInclusion'               => $totInc,
                    'TotalControl'                 => $totCon,
                    'TotalAffection'               => $totAff,
                    'Overall'                      => $overall,
                    'ExpressedInclusionKlm'        => $expIncKlm,
                    'ExpressedControlKlm'          => $expConKlm,
                    'ExpressedAffectionKlm'        => $expAffKlm,
                    'TotalExpressedKlm'            => $totExpKlm,
                    'WantedInclusionKlm'           => $wanIncKlm,
                    'WantedControlKlm'             => $wanConKlm,
                    'WantedAffectionKlm'           => $wanAffKlm,
                    'TotalWantedKlm'               => $wanExpKlm,
                    'TotalInclusionKlm'            => $totIncKlm,
                    'TotalControlKlm'              => $totConKlm,
                    'TotalAffectionKlm'            => $totAffKlm,
                    'OverallKlm'                   => $overallKlm,
                    'CreatedBy'                    => $this->session->userdata('username'),
                    'CreatedDate'                  => date('Y-m-d H:i:s'),
                    'Status'                       => '1'
                );
                $result = $this->m_PsychologicalAssisment->savefiroB($data);
            }elseif (!empty($CEK)) {
                $data = array(
                    'ExpressedInclusion'           => $expInc,
                    'ExpressedControl'             => $expCon,
                    'ExpressedAffection'           => $expAff,
                    'TotalExpressed'               => $totExp,
                    'WantedInclusion'              => $wanInc,
                    'WantedControl'                => $wanCon,
                    'WantedAffection'              => $wanAff,
                    'TotalWanted'                  => $wanExp,
                    'TotalInclusion'               => $totInc,
                    'TotalControl'                 => $totCon,
                    'TotalAffection'               => $totAff,
                    'Overall'                      => $overall,
                    'ExpressedInclusionKlm'        => $expIncKlm,
                    'ExpressedControlKlm'          => $expConKlm,
                    'ExpressedAffectionKlm'        => $expAffKlm,
                    'TotalExpressedKlm'            => $totExpKlm,
                    'WantedInclusionKlm'           => $wanIncKlm,
                    'WantedControlKlm'             => $wanConKlm,
                    'WantedAffectionKlm'           => $wanAffKlm,
                    'TotalWantedKlm'               => $wanExpKlm,
                    'TotalInclusionKlm'            => $totIncKlm,
                    'TotalControlKlm'              => $totConKlm,
                    'TotalAffectionKlm'            => $totAffKlm,
                    'OverallKlm'                   => $overallKlm,
                    'UpdateBy'                    => $this->session->userdata('username'),
                    'UpdateDate'                  => date('Y-m-d H:i:s')
                );
                $result = $this->m_PsychologicalAssisment->updatefiroB($id,$data);
            }
            if(!$result){
                redirect('PsychologicalAssisment/?msg=success');
            }else{
                redirect('PsychologicalAssisment/?msg=failed');
            }
    }

    //MBTI Test
    function MBTItest(){
        $data['list'] = $this->m_PsychologicalAssisment->getListdua();
        $this->template->display('psychological_assisment/Mbti_test/index',$data);
    }
    function getKaryawanMbti(){
        $nama = $this->uri->segment(3);
        $data['getData']  = $this->m_PsychologicalAssisment->getKaryawanMbti($nama);
        $this->load->view('psychological_assisment/Mbti_test/ajaxCari',$data);
    }

    function getNamaMbti(){
        $id = $this->uri->segment(3);
        // echo $id; 
        $data['getData']  = $this->m_PsychologicalAssisment->getDataMbti($id);
        $this->load->view('psychological_assisment/Mbti_test/getNama',$data);
    }

    function simpanDataMbti(){
        $id             = $this->input->post('txtHeaderid');
        $nama           = $this->input->post('txtnama');
        $tgl_lahir      = $this->input->post('txttgllahir');
        $tempat_lahir   = $this->input->post('txttempatlahir');
        $jeniskelamin   = $this->input->post('txtjeniskelamin');
        $perusahaan     = $this->input->post('txtperusahaan');
        $pendidikan     = $this->input->post('txtpendidikan');
        $tm            = $this->input->post('txtmbti');
        $tma            = $this->input->post('txtMbtiarea');
        $CEK = $this->m_PsychologicalAssisment->cekMbti($id);
        if (empty($CEK)) {
            $data = array(
                'HeaderID'        => $id,
                'Nama'            => $nama,
                'Tgl_Lahir'       => date('Y-m-d',strtotime($tgl_lahir)),
                'Tempat_Lahir'    => $tempat_lahir,
                'Jenis_Kelamin'   => $jeniskelamin,
                'Perusahaan'      => $perusahaan,
                'Pendidikan'      => $pendidikan,
                'Mbti'            => $tm,
                'AreaMbti_dua'    => $tma,
                'CreatedBy'       => $this->session->userdata('username'),
                'CreatedDate'     => date('Y-m-d H:i:s'),
                'Status'          => '1'
            );
            $result = $this->m_PsychologicalAssisment->simpanMbti($data);
        }elseif (!empty($CEK)) {
            $data = array(
                'Mbti'            => $tm,
                'AreaMbti_dua'    => $tma,
                'UpdateBy'        => $this->session->userdata('username'),
                'UpdateDate'      => date('Y-m-d H:i:s')
            );
            $result = $this->m_PsychologicalAssisment->perbaharuiMbti($id,$data);
        }
        if(!$result){
            redirect('PsychologicalAssisment/?msg=success');
        }else{
            redirect('PsychologicalAssisment/?msg=failed');
        }
    }
 
    //SDS Test
    function SDSTest(){
        $data['list'] = $this->m_PsychologicalAssisment->getListdua();
        $this->template->display('psychological_assisment/Sds_test/index',$data);
    }

    function getKaryawanSds(){
        $nama = $this->uri->segment(3);
        $data['getData']  = $this->m_PsychologicalAssisment->getKaryawanSds($nama);
        $this->load->view('psychological_assisment/Sds_test/ajaxCari',$data);
    }

    function getNamaSds(){
        $id = $this->uri->segment(3);
        // echo $id;
        $data['getData']  = $this->m_PsychologicalAssisment->getDataSds($id);
        $this->load->view('psychological_assisment/Sds_test/getNama',$data);
    }
    
    function simpanDataSds(){
        $id             = $this->input->post('txtHeaderid');
        $nama           = $this->input->post('txtnama');
        $tgl_lahir      = $this->input->post('txttgllahir');
        $tempat_lahir   = $this->input->post('txttempatlahir');
        $jeniskelamin   = $this->input->post('txtjeniskelamin');
        $perusahaan     = $this->input->post('txtperusahaan');
        $pendidikan     = $this->input->post('txtpendidikan');
        $ts             = $this->input->post('sds');
        $tsa            = $this->input->post('txtsdsarea');
        $CEK = $this->m_PsychologicalAssisment->cekSds($id);
        if (empty($CEK)) {
            $data = array(
                'HeaderID'        => $id,
                'Nama'            => $nama,
                'Tgl_Lahir'       => date('Y-m-d',strtotime($tgl_lahir)),
                'Tempat_Lahir'    => $tempat_lahir,
                'Jenis_Kelamin'   => $jeniskelamin,
                'Perusahaan'      => $perusahaan,
                'Pendidikan'      => $pendidikan,
                'Sds'             => $ts,
                'AreaSds'         => $tsa,
                'CreatedBy'       => $this->session->userdata('username'),
                'CreatedDate'     => date('Y-m-d H:i:s'),
                'Status'          => '1'
            );
            $result = $this->m_PsychologicalAssisment->simpanSds($data);
        }elseif (!empty($CEK)) {
            $data = array(
                'Sds'             => $ts,
                'AreaSds'         => $tsa,
                'UpdateBy'        => $this->session->userdata('username'),
                'UpdateDate'      => date('Y-m-d H:i:s')
            );
            $result = $this->m_PsychologicalAssisment->perbaharuiSds($id,$data);
        }
        if(!$result){
            redirect('PsychologicalAssisment/?msg=success');
        }else{
            redirect('PsychologicalAssisment/?msg=failed');
        }
    }

    //BELBIN Test
    function BELBINTest(){
        $data['list'] = $this->m_PsychologicalAssisment->getListdua();
        $this->template->display('psychological_assisment/Belbin_test/index',$data);
    }

    function getKaryawanBelbin(){
        $nama = $this->uri->segment(3);
        $data['getData']  = $this->m_PsychologicalAssisment->getKaryawanBelbin($nama);
        $this->load->view('psychological_assisment/Belbin_test/ajaxCari',$data);
    }

    function getNamaBelbin(){
        $id = $this->uri->segment(3);
        // echo $id;
        $data['getData']  = $this->m_PsychologicalAssisment->getDataBelbin($id);
        $this->load->view('psychological_assisment/Belbin_test/getNamaBelbin',$data);
    }

    function simpanDataBelbin(){
        $id             = $this->input->post('txtHeaderid');
        $nama           = $this->input->post('txtnama');
        $tgl_lahir      = $this->input->post('txttgllahir');
        $tempat_lahir   = $this->input->post('txttempatlahir');
        $jeniskelamin   = $this->input->post('txtjeniskelamin');
        $perusahaan     = $this->input->post('txtperusahaan');
        $pendidikan     = $this->input->post('txtpendidikan');
        $tb1            = $this->input->post('txtbelbink1');
        $tb2            = $this->input->post('txtbelbink2');
        $tb3            = $this->input->post('txtbelbink3');
        $tb4            = $this->input->post('txtbelbink4');
        $tb5            = $this->input->post('txtbelbink5');
        $tb6            = $this->input->post('txtbelbink6');
        $tb7            = $this->input->post('txtbelbink7');
        $tb8            = $this->input->post('txtbelbink8');
        $tba            = $this->input->post('txtbelbinarea');
        $CEK = $this->m_PsychologicalAssisment->cekBelbin($id);
        if (empty($CEK)) {
            $data = array(
                'HeaderID'        => $id,
                'Nama'            => $nama,
                'Tgl_Lahir'       => date('Y-m-d',strtotime($tgl_lahir)),
                'Tempat_Lahir'    => $tempat_lahir,
                'Jenis_Kelamin'   => $jeniskelamin,
                'Perusahaan'      => $perusahaan,
                'Pendidikan'      => $pendidikan,
                'Belbinksatu'     => $tb1,
                'Belbinkdua'      => $tb2,
                'Belbinktiga'     => $tb3,
                'Belbinkempat'    => $tb4,
                'Belbinklima'     => $tb5,
                'Belbinkenam'     => $tb6,
                'Belbinktujuh'    => $tb7,
                'Belbinkdelapan'  => $tb8,
                'AreaBelbin_dua'  => $tba,
                'CreatedBy'       => $this->session->userdata('username'),
                'CreatedDate'     => date('Y-m-d H:i:s'),
                'Status'          => '1'
            ); 
            $result = $this->m_PsychologicalAssisment->simpanBelbin($data);
        }elseif (!empty($CEK)) {
            $data = array(
                'Belbinksatu'     => $tb1,
                'Belbinkdua'      => $tb2,
                'Belbinktiga'     => $tb3,
                'Belbinkempat'    => $tb4,
                'Belbinklima'     => $tb5,
                'Belbinkenam'     => $tb6,
                'Belbinktujuh'    => $tb7,
                'Belbinkdelapan'  => $tb8,
                'AreaBelbin_dua'  => $tba,
                'UpdateBy'        => $this->session->userdata('username'),
                'UpdateDate'      => date('Y-m-d H:i:s')
            );
            $result = $this->m_PsychologicalAssisment->perbaharuiBelbin($id,$data);
        }
        if(!$result){
            redirect('PsychologicalAssisment/?msg=success');
        }else{
            redirect('PsychologicalAssisment/?msg=failed');
        }
    }

}