<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * ITD 31
 */
class PapiKostickReport extends CI_Controller
{
	
	public function __construct(){
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
		$this->load->model('M_PapiKostickReport');
	}

	function index(){
        $data['list'] = $this->M_PapiKostickReport->getListdua();
		$this->template->display('papikostick_report/index',$data);
	}

	function getKaryawan(){
        $nama = $this->uri->segment(3);
        $data['getData']  = $this->M_PapiKostickReport->get_DataKaryawan($nama);
        $this->load->view('papikostick_report/ajaxCari',$data);
    }

    function getNama(){
        $id = $this->uri->segment(3);
        $data['getData']  = $this->M_PapiKostickReport->get_Data($id);
        $this->load->view('papikostick_report/getNamaKaryawan',$data);
    }

    function simpanData(){
    	$id 				= $this->input->post('txtHeaderid');
    	$nama 				= $this->input->post('txtnama');
    	$tgl_lahir 			= $this->input->post('txttgllahir');
    	$tempat_lahir 		= $this->input->post('txttempatlahir');
    	$jeniskelamin 		= $this->input->post('txtjeniskelamin');
    	$jabatan 			= $this->input->post('txtjabatan');
    	$pendidikan 		= $this->input->post('txtpendidikan');
    	$perusahaan 		= $this->input->post('txtperusahaan');
    	$tgllaporan 		= $this->input->post('txttgllaporan');
    	$tujuanpemeriksaan  = $this->input->post('txttujuanpemeriksaan');
    	$nwd 				= $this->input->post('txtNworkdirection');
    	$gwd 				= $this->input->post('txtGworkdirection');
    	$awd 				= $this->input->post('txtAworkdirection');
    	$ll 				= $this->input->post('txtLleadership');
    	$pl 				= $this->input->post('txtPleadership');
    	$il 				= $this->input->post('txtIleadership');
    	$ta 				= $this->input->post('txtTactivity');
    	$va 				= $this->input->post('txtVactivity');
    	$xn 				= $this->input->post('txtXnature');
    	$sn 				= $this->input->post('txtSnature');
    	$bn 				= $this->input->post('txtBnature');
    	$on 				= $this->input->post('txtOnature');
    	$rws 				= $this->input->post('txtOnature');
    	$dws 				= $this->input->post('txtDworkstyle');
    	$cws 				= $this->input->post('txtCworkstyle');
    	$zt 				= $this->input->post('txtZtemperament');
    	$et 				= $this->input->post('txtEtemperament');
    	$kt 				= $this->input->post('txtKtemperament');
    	$ff 				= $this->input->post('txtFfollowership');
    	$wf 				= $this->input->post('txtWfollowership');
        $tna                = $this->input->post('txtNarea');
        $tga                = $this->input->post('txtGarea');
        $taa                = $this->input->post('txtAarea');
        $tla                = $this->input->post('txtLarea');
        $tpa                = $this->input->post('txtParea');
        $tia                = $this->input->post('txtIarea');
        $tta                = $this->input->post('txtTarea');
        $tva                = $this->input->post('txtVarea');
        $txa                = $this->input->post('txtXarea');
        $tsa                = $this->input->post('txtSarea');
        $tba                = $this->input->post('txtBarea');
        $toa                = $this->input->post('txtOarea');
        $tra                = $this->input->post('txtRarea');
        $tda                = $this->input->post('txtDarea');
        $tca                = $this->input->post('txtCarea');
        $tza                = $this->input->post('txtZarea');
        $tea                = $this->input->post('txtEarea');
        $tka                = $this->input->post('txtKarea');
        $tfa                = $this->input->post('txtFarea');
        $twa                = $this->input->post('txtWarea');
        $CEK = $this->M_PapiKostickReport->cekPapikostick($id);
        if (empty($CEK)) {
            $data = array(
                'HeaderID'           => $id,
                'Nama'               => $nama,
                'Tgl_Lahir'          => date('Y-m-d',strtotime($tgl_lahir)),
                'Tempat_Lahir'       => $tempat_lahir,
                'Jenis_Kelamin'      => $jeniskelamin,
                'Jabatan'            => $jabatan,
                'Pendidikan'         => $pendidikan,
                'Perusahaan'         => $perusahaan,
                'Tgl_Laporan'        => date('Y-m-d',strtotime($tgllaporan)),
                'Tujuan_Pemeriksaan' => $tujuanpemeriksaan,
                'Nworkdirection'     => $nwd,
                'Gworkdirection'     => $gwd,
                'Aworkdirection'     => $awd,
                'Lleadership'        => $ll,
                'Pleadership'        => $pl,
                'Ileadership'        => $il,
                'Tactivity'          => $ta,
                'Vactivity'          => $va,
                'Xnature'            => $xn,
                'Snature'            => $sn,
                'Bnature'            => $bn,
                'Onature'            => $on,
                'Rworkstyle'         => $rws,
                'Dworkstyle'         => $dws,
                'Cworkstyle'         => $cws,
                'Ztemperament'       => $zt,
                'Etemperament'       => $et,
                'Ktemperament'       => $kt,
                'Ffollowership'      => $ff,
                'Wfollowership'      => $wf,
                'Narea'              => $tna,
                'Garea'              => $tga,
                'Aarea'              => $taa,
                'Larea'              => $tla,
                'Parea'              => $tpa,
                'Iarea'              => $tia,
                'Tarea'              => $tta,
                'Varea'              => $tva,
                'Xarea'              => $txa,
                'Sarea'              => $tsa,
                'Barea'              => $tba,
                'Oarea'              => $toa,
                'Rarea'              => $tra,
                'Darea'              => $tda,
                'Carea'              => $tca,
                'Zarea'              => $tza,
                'Earea'              => $tea,
                'Karea'              => $tka,
                'Farea'              => $tfa,
                'Warea'              => $twa,
                'CreatedBy'          => $this->session->userdata('username'),
                'CreatedDate'        => date('Y-m-d H:i:s'),
                'Status'             => '1'
            );
            $result = $this->M_PapiKostickReport->save($data);
        }elseif (!empty($CEK)) {
            $data = array(
                'Tujuan_Pemeriksaan' => $tujuanpemeriksaan,
                'Nworkdirection'     => $nwd,
                'Gworkdirection'     => $gwd,
                'Aworkdirection'     => $awd,
                'Lleadership'        => $ll,
                'Pleadership'        => $pl,
                'Ileadership'        => $il,
                'Tactivity'          => $ta,
                'Vactivity'          => $va,
                'Xnature'            => $xn,
                'Snature'            => $sn,
                'Bnature'            => $bn,
                'Onature'            => $on,
                'Rworkstyle'         => $rws,
                'Dworkstyle'         => $dws,
                'Cworkstyle'         => $cws,
                'Ztemperament'       => $zt,
                'Etemperament'       => $et,
                'Ktemperament'       => $kt,
                'Ffollowership'      => $ff,
                'Wfollowership'      => $wf,
                'Narea'              => $tna,
                'Garea'              => $tga,
                'Aarea'              => $taa,
                'Larea'              => $tla,
                'Parea'              => $tpa,
                'Iarea'              => $tia,
                'Tarea'              => $tta,
                'Varea'              => $tva,
                'Xarea'              => $txa,
                'Sarea'              => $tsa,
                'Barea'              => $tba,
                'Oarea'              => $toa,
                'Rarea'              => $tra,
                'Darea'              => $tda,
                'Carea'              => $tca,
                'Zarea'              => $tza,
                'Earea'              => $tea,
                'Karea'              => $tka,
                'Farea'              => $tfa,
                'Warea'              => $twa,
                'UpdateBy'           => $this->session->userdata('username'),
                'UpdateDate'         => date('Y-m-d H:i:s')
            );
            $result = $this->M_PapiKostickReport->perbaharui($id,$data);
        }
    	
    	if(!$result){
    		redirect('PapiKostickReport/?msg=success');
    	}else{
    		redirect('PapiKostickReport/?msg=failed');
    	}
    }
}