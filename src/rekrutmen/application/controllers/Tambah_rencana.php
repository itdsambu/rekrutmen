<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tambah_rencana extends CI_Controller{
    function __construct() {
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
        
        $this->load->model('m_tambah_rencana');
    }

    function index(){
        
    }

    function karyawan(){
        $data['getDept'] = $this->m_tambah_rencana->get_DeptKaryawan();
        $data['getData'] = $this->m_tambah_rencana->get_Data();
        $data['getDataK'] = $this->m_tambah_rencana->get_DataKaryawan();
        $this->template->display('transaksi/tambah_permintaan/karyawan/index',$data);
    }

    function get_memokaryawan(){
        $id     = $this->uri->segment(3);
        $deptid = $this->uri->segment(4);

        $data['memoID'] = $id;
        $data['_getFormID']         = $this->input->get('id');
        $data['getDept']                = $this->m_tambah_rencana->get_Dept();
        $data['getData']                = $this->m_tambah_rencana->get_Data();
        $data['getDataK']               = $this->m_tambah_rencana->get_DataKaryawan();
        $data['getDatakaryawan']        = $this->m_tambah_rencana->get_RencanaKaryawan($id,$deptid);
        $data['getCekData']             = $this->m_tambah_rencana->get_cekDataK($deptid);
        $data['getTotal']               = $this->m_tambah_rencana->get_dataTotalK();
        $data['getDataRealKaryawan']    = $this->m_tambah_rencana->get_RealKaryawanlist();
        $data['get_totalsisa']          = $this->m_tambah_rencana-> get_totalsisaK();

        $this->template->display('transaksi/tambah_permintaan/karyawan/index',$data);
    }

    function simpanDataK(){
        $memoid         = $this->input->post('txtMemoID');
        $deptid         = $this->input->post('txtDept');
        $rkaryawan      = $this->input->post('txtIdealK');
        $realkaryawan   = $this->input->post('txtRealK');
        $cekData        = $this->m_tambah_rencana->cek_Data($deptid);

        if($cekData == NULL){
            $data = array(
                'DeptID'        => $deptid,
                'Idealkaryawan' => $rkaryawan,
                'RealKaryawan'  => $realkaryawan,
                'Karyawan'      => 1,
                'CreatedBy'     => $this->session->userdata('username'),
                'CreatedDate'   => date('Y-m-d H:i:s'),
                'Komputer'      => $this->session->userdata('hostname')
            );

            $this->m_tambah_rencana->simpan($data);
            redirect('tambah_rencana/get_memokaryawan');
        }else{
            $data = array(
                'DeptID'        => $deptid,
                'Idealkaryawan' => $rkaryawan,
                'RealKaryawan'  => $realkaryawan,
                'Karyawan'      => 1,
                'UpdateBy'      => $this->session->userdata('username'),
                'UpdateDate'    => date('Y-m-d H:i:s'),
                'Komputer'      => $this->session->userdata('hostname')
            );
            $this->m_tambah_rencana->updateData($deptid,$data);

            $data = array(
                'DeptID'                => $deptid,
                'JmlRencanaKarayawan'   => $rkaryawan,
                'RealKaryawan'          => $realkaryawan,
                'Karyawan'              => 1,
                'CreatedBy'             => $this->session->userdata('username'),
                'CreatedDate'           => date('Y-m-d H:i:s'),
                'Komputer'              => $this->session->userdata('hostname')
            );
            $this->m_tambah_rencana->simpanDataHistory($data);

            $data = array(
                'GeneralStatus' => 4,
            );

            $this->m_tambah_rencana->updateDataMemo($memoid,$data);

        }
        redirect('Memodept');
    }

    function borongan(){
        $data['getDept'] = $this->m_tambah_rencana->get_Dept();
        $data['getData'] = $this->m_tambah_rencana->get_Data();
        $data['getDataHB'] = $this->m_tambah_rencana->get_DataHarianBorongan();
        $this->template->display('transaksi/tambah_permintaan/borongan/index',$data);
    }

    function get_memoborongan(){
        $id     = $this->uri->segment(3);
        $deptid = $this->uri->segment(4);

        $data['memoID'] = $id;
        $data['_getFormID']         = $this->input->get('id');
        $data['getDept']            = $this->m_tambah_rencana->get_Dept();
        $data['getData']            = $this->m_tambah_rencana->get_Data();
        $data['getDataHB']          = $this->m_tambah_rencana->get_DataHarianBorongan();
        $data['getDataBorongan']    = $this->m_tambah_rencana->get_RencanaBorongan($id,$deptid);
        $data['cekDataHB']          = $this->m_tambah_rencana->get_cekDataHB($deptid);
        $data['getTotal']           = $this->m_tambah_rencana->get_dataTotal();
        $data['getRealBorongan']    = $this->m_tambah_rencana->get_DataRealBorongan();
        $data['getTotalBorongan']   = $this->m_tambah_rencana->get_dataTotalExisting();
        $data['get_total']          = $this->m_tambah_rencana->get_dataTotalBoro();
        $data['get_totalsisaBoro']  = $this->m_tambah_rencana->get_totalsisa();
        
        // echo "<pre>";
        // print_r($data['getRealBorongan']);
        // echo "<pre>";

        $jumlah = sizeof($data['getRealBorongan']);
        for($i = 0; $i < $jumlah; $i++){
            $sebelumnya = $i - 1;
            if($sebelumnya < 0){
                $data['hasil'][$i] = array(
                    'DeptID' => $data['getRealBorongan'][$i]['DeptID'],
                    'Jumlah' => $data['getRealBorongan'][$i]['Jumlah']
                );
            } else {
                if($data['getRealBorongan'][$i]['DeptID'] == $data['getRealBorongan'][$i-1]['DeptID']){
                    if($i == -1){
                        continue;
                    }
                    continue;
                }
            }
            $data['hasil'][$i] = array(
                'DeptID' => $data['getRealBorongan'][$i]['DeptID'],
                'Jumlah' => $data['getRealBorongan'][$i]['Jumlah']
            );
        }

        $this->template->display('transaksi/tambah_permintaan/borongan/index',$data);
    }

    function simpanDataHB(){
        $memoid         = $this->input->post('txtMemoID');
        $dept           = $this->input->post('txtDept');
        $rborongan      = $this->input->post('txtIdealBorongan');
        $realborongan   = $this->input->post('txtRealBorongan');
        $cekData        = $this->m_tambah_rencana->cek_Data($dept);

        if($cekData == NULL){
            $data = array(
                'DeptID'            => $dept,
                'Idealtenagakerja'  => $rborongan,
                'Realtenagakerja'   => $realborongan,
                'CreatedBy'         => $this->session->userdata('username'),
                'CreatedDate'       => date('Y-m-d H:i:s'),
                'Komputer'          => $this->session->userdata('hostname')
             );
            $this->m_tambah_rencana->simpanHB($data);
            redirect('tambah_rencana/get_memoborongan');
        }else{
            $data = array(
                'DeptID'            => $dept,
                'Idealtenagakerja'  => $rborongan,
                'Realtenagakerja'   => $realborongan,
                'UpdateBy'          => $this->session->userdata('username'),
                'UpdateDate'        => date('Y-m-d H:i:s'),
                'Komputer'          => $this->session->userdata('hostname')
             );
            $this->m_tambah_rencana->updateData($dept,$data);
            $data = array(
                'DeptID'                    => $dept,
                'JmlRencanaHarianBorongan'  => $rborongan,
                'RealHarianBorongan'        => $realborongan,
                'CreatedBy'                 => $this->session->userdata('username'),
                'CreatedDate'               => date('Y-m-d H:i:s'),
                'Komputer'                  => $this->session->userdata('hostname')
             );
             $this->m_tambah_rencana->simpanDataHistory($data);

             $data = array(
                'GeneralStatus' => 4,
            );

            $this->m_tambah_rencana->updateDataMemo($memoid,$data);
        }
        redirect('tambah_rencana/get_memoborongan');
    }
}
