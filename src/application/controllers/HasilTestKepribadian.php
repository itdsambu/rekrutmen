<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  ITD 31
 */
class HasilTestKepribadian extends CI_Controller
{
	
	function __construct()
	{
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
        $this->load->model('m_HasiltestKepribadian');
	}
	function index(){
		$this->template->display('hasilTestKepribadian/index');
	}
    function getKaryawan(){
        $nama = $this->uri->segment(3);
        $data['getData']  = $this->m_HasiltestKepribadian->getKaryawan($nama);
        $this->load->view('hasilTestKepribadian/ajaxCari',$data);
    }

    function getNama(){
        $id = $this->uri->segment(3);
        // echo $id;
        $data['getData']  = $this->m_HasiltestKepribadian->getData($id);
        $this->load->view('hasilTestKepribadian/getNama',$data);
    }

    function simpanData(){
        $id             = $this->input->post('txtHeaderid');
        $nama           = $this->input->post('txtnama');
        $tgl_lahir      = $this->input->post('txttgllahir');
        $tempat_lahir   = $this->input->post('txttempatlahir');
        $jeniskelamin   = $this->input->post('txtjeniskelamin');
        $perusahaan     = $this->input->post('txtperusahaan');
        $pendidikan     = $this->input->post('txtpendidikan');
        $gambaranumum   = $this->input->post('txtgambaranumum');
        $relasisosial   = $this->input->post('txtrelasisosial');
        $kerjasama      = $this->input->post('txtkerjasama');
        $situasistress  = $this->input->post('txtsituasistress');
        $responsituasi  = $this->input->post('txtresponsituasional');
        $responperubahan= $this->input->post('txtresponperubahan');
        $orientasihasil = $this->input->post('txtorientasihasil');
        $kepemimpinan   = $this->input->post('txtkepemimpinan');
        $ikekuatan      = $this->input->post('txtidentifikasikekuatan');
        $ikelemahan     = $this->input->post('txtidentifikasikelemahan');
        $rekomendasi    = $this->input->post('txtrekomendasi');
        $CEK = $this->m_HasiltestKepribadian->cekHasil($id);
        if (empty($CEK)) {
            $data = array(
                'HeaderID'        => $id,
                'Nama'            => $nama,
                'Tgl_Lahir'       => date('Y-m-d',strtotime($tgl_lahir)),
                'Tempat_Lahir'    => $tempat_lahir,
                'Jenis_Kelamin'   => $jeniskelamin,
                'Perusahaan'      => $perusahaan,
                'Pendidikan'      => $pendidikan,
                'Gambaran_umum'   => $gambaranumum,
                'Relasi_sosial'   => $relasisosial,
                'Kerjasama'       => $kerjasama,
                'Situasi_stress'  => $situasistress,
                'Respon_situasi'  => $responsituasi,
                'Respon_perubahan'=> $responperubahan,
                'Orientasi_hasil' => $orientasihasil,
                'Kepemimpinan'    => $kepemimpinan,
                'Ikekuatan'       => $ikekuatan,
                'Ikelemahan'      => $ikelemahan,
                'Rekomendasi'     => $rekomendasi,
                'CreatedBy'       => $this->session->userdata('username'),
                'CreatedDate'     => date('Y-m-d H:i:s')
            );
            $result = $this->m_HasiltestKepribadian->simpan($data);
        }elseif (!empty($CEK)) {
            $data = array(
                'Gambaran_umum'   => $gambaranumum,
                'Relasi_sosial'   => $relasisosial,
                'Kerjasama'       => $kerjasama,
                'Situasi_stress'  => $situasistress,
                'Respon_situasi'  => $responsituasi,
                'Respon_perubahan'=> $responperubahan,
                'Orientasi_hasil' => $orientasihasil,
                'Kepemimpinan'    => $kepemimpinan,
                'Ikekuatan'       => $ikekuatan,
                'Ikelemahan'      => $ikelemahan,
                'Rekomendasi'     => $rekomendasi,
                'UpdateBy'        => $this->session->userdata('username'),
                'UpdateDate'      => date('Y-m-d H:i:s')
            );
            $result = $this->m_HasiltestKepribadian->perbaharui($id,$data);
        }
        if(!$result){
            redirect('PsychologicalAssisment/?msg=success');
        }else{
            redirect('PsychologicalAssisment/?msg=failed');
        }
    }
}