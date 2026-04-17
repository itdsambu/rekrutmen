<?php 
defined('BASEPATH') or exit('No Direct Script access Allowed');

class MonitoringInterview extends CI_Controller{
    
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
        
        $this->load->model(array('M_monitoringInterview','M_RegPraPelamarKaryawan'));
    }

    function index(){
        $data['interview'] = $this->M_monitoringInterview->get();
        $this->template->display('monitor/interview/monitoringInterview',$data);
    }

    function edit_data(){
        $idInterview = $this->input->get('idinterview');

        $data['_getData'] = $this->M_monitoringInterview->_getListDataById($idInterview);
        $data['_getMstPendidikan'] = $this->M_monitoringInterview->_getMstPendidikan();
        $data['_getMstJurusan'] = $this->M_monitoringInterview->_getMstJurusan();
        $data['_getMstKecamatan'] = $this->M_monitoringInterview->_getMstKecamatan();
        $data['_getMstSuku'] = $this->M_monitoringInterview->_getMstSuku();
        $data['_getMstDept'] = $this->M_monitoringInterview->_getMstDept();
        $this->template->display('monitor/interview/edit',$data);
    }

    function update(){
        $calonid        = $this->input->post('txtCalonID');
        $interviewid    = $this->input->post('txtInterviewID');
        $nohp           = $this->input->post('txtNoHp');
        $univ           = $this->input->post('txtUniversitas');
        $tinggibadan    = $this->input->post('txtTinggiBadan');
        $bertato        = $this->input->post('txtBertato');
        $bertindik      = $this->input->post('txtBertindik');
        $kecamatan      = $this->input->post('txtKecamatan');
        $suku           = $this->input->post('txtSuku');
        $pengalaman     = $this->input->post('txtPengalamanKerja');
        $knowladge      = $this->input->post('txtKnowledge');
        $interview      = $this->input->post('txtInterviewed');
        $r_penyakit     = $this->input->post('txtRiwayatPenyakit');
        $mutasi         = $this->input->post('txtMutasi');
        $komunikasi     = $this->input->post('txtKomunikasi');
        $dept_tujuan    = $this->input->post('txtDeptTujuan');
        $tgl_kedatangan = $this->input->post('txtTanggalKedatangan');
        $kelebihan      = $this->input->post('txtKelebihan');
        $kelemahan      = $this->input->post('txtKelemahan');
        $keterangan     = $this->input->post('txtKet');
        $nomorsurat     = $this->input->post('txtNomorSurat');
        $gaji           = $this->input->post('txtGaji');


        $data = array(
          'NoHp'            => $nohp,
          'Universitas'     => $univ,
          'TinggiBadan'     => $tinggibadan,
          'PunyaTato'       => $bertato,
          'Bertindik'       => $bertindik,
          'KecamatanID'     => $kecamatan,
          'Suku'            => $suku,
          'Knowledge'       => $knowladge,
          'Kelebihan'       => $kelebihan,
          'Kelemahan'       => $kelemahan,
          'RiwayatPenyakit' => $r_penyakit,
          'PengalamanKerja' => $pengalaman,
          'Mutasi'          => $mutasi,
          'Komunikasi'      => $komunikasi,
          'DeptTujuan'      => $dept_tujuan,
          'Interviewed'     => $interview,
          'TanggalKedatangan' => $tgl_kedatangan,
          'Keterangan'        => $keterangan,
          'NomorSurat'        => $nomorsurat,
          'UpdateBy'        => $this->session->userdata('username'),
          'UpdateDate'      => date('Y-m-d H:i:s')
        );

        $this->M_monitoringInterview->update($interviewid,$data);

        $data2 = array(
            'Gaji'          =>  str_replace(".","",$gaji),
            'UpdateBy'      => $this->session->userdata('username'),
            'UpdateDate'    => date('Y-m-d H:i:s')
        );

        $result = $this->M_monitoringInterview->update_calon_pelamar($calonid,$data2);
       
        if(!$result){
            redirect('MonitoringInterview?msg=success');
        }else{
            redirect('MonitoringInterview?msg=failed');
        }
    }

    function viewDocs(){
         if('IS_AJAX') {
            $userID = $this->input->post('kode');
            $berkas = $this->input->post('nama');
            // echo $userID.'/'.$berkas;
            $data['_jenisBerkas'] = $berkas;
            $data['_getViewDocs'] = $this->M_monitoringInterview->getDocs($userID);
            $data['_getCalonPelamar'] = $this->M_monitoringInterview->getPelamar($userID);
            $this->load->view('calon_pelamar/upload_berkas/viewDocs',$data);
        }
    }

    function set_kedatangan(){
        $idinterview = $this->uri->segment(3);
        $kedatangan  = $this->uri->segment(4);

        if($kedatangan == 1){
            $data = array(
                'Status_kedatangan'     => 1,
                'SuratPanggilanKerja'   => 1,
            );

            $this->M_monitoringInterview->update($idinterview,$data);
        }else{
            $data = array(
                'Status_kedatangan'     => 2,
                'SuratPanggilanKerja'   => 2,
            );

            $this->M_monitoringInterview->update($idinterview,$data);
        }
    }

    function cetak_panggilan(){
        ob_start();
        $hdrid = $this->input->get('id');
        $cek = $this->M_monitoringInterview->cek_nomorSurat($hdrid);
        if($cek[0]->NomorSurat == NULL){
            $hitung     = $this->M_monitoringInterview->nomer();
            $data = array(
                'NomorSurat' => $hitung[0]->Nomor,
            );

            $this->M_monitoringInterview->updateHdr($hdrid,$data);
            $data['_getData']   = $this->M_monitoringInterview->getTenagaKerja($hdrid);
            $this->load->view('monitor/interview/cetakNew',$data);
        }else{
            // echo "hhhh";
            $data['_getData']   = $this->M_monitoringInterview->getTenagaKerja($hdrid);
            $this->load->view('monitor/interview/cetakNew',$data);
        }

        $html   = ob_get_contents();
        
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('Panggilan Kerja'.$hdrid.'.pdf');
        
    }

    function cari_berdasarkan(){
        $cari = $this->uri->segment(3);

        if($cari == 1){
            $_jurusan = $this->M_RegPraPelamarKaryawan->_getMstJurusan();
            echo '<div class="form-group">
                    <label class="col-lg-2 control-label">Pilih Jurusan</label>
                        <div class="col-lg-4">
                            <select class="form-control" id="jurusanid">
                                <option value="">- Pilih -</option>';
                                foreach($_jurusan as $jrs){
                                    echo '<option value="'.$jrs->Jurusan.'">'.$jrs->Jurusan.'</option>';
                                }
                            echo '</select>
                        </div>
                </div>';
        }elseif($cari == 2){
            $_gaji = $this->M_RegPraPelamarKaryawan->_getMstGaji();
            echo '<div class="form-group">
                    <label class="col-lg-2 control-label">Gaji</label>
                        <div class="col-lg-4">
                            <select class="form-control" id="gajiid">
                                <option value="">- Pilih -</option>';
                                foreach($_gaji as $key){
                                    echo '<option value="'.$key->GajiID.'">Rp. '.number_format($key->Gaji_1).' - Rp. '.number_format($key->Gaji_2).'</option>';
                                }
                            echo '</select>
                        </div>
                </div>'; 
        }else{
            $_pendidikan = $this->M_monitoringInterview->_getMstPendidikan();
            echo '<div class="form-group">
                <label class="col-lg-2 control-label">Pilih Jurusan</label>
                    <div class="col-lg-4">
                        <select class="form-control" id="pendidikanid">
                            <option value="">- Pilih -</option>';
                            foreach($_pendidikan as $pnd){
                                echo '<option value="'.$pnd->Pendidikan.'">'.$pnd->Pendidikan.'</option>';
                            }
                        echo '</select>
                    </div>
            </div>';
        }
    }

    function list_data_berdasarkan_jurusan(){
        $jurusan = $this->uri->segment(3);

        $data['interview'] = $this->M_monitoringInterview->_getDataListBerdasarkanJurusan($jurusan);
        $this->load->view('monitor/interview/ajax_list',$data);
    }

    function list_data_berdasarkan_gaji(){
        $gaji = $this->uri->segment(3);

        $_getGaji = $this->M_RegPraPelamarKaryawan->_getGajiByID($gaji);
        $data['interview'] = $this->M_monitoringInterview->_getDataListBerdasarkanGaji($_getGaji[0]->Gaji_1,$_getGaji[0]->Gaji_2);
        $this->load->view('monitor/interview/ajax_list',$data);
    }

    function list_data_berdasarkan_pendidikan(){
        $pendidikan = $this->uri->segment(3);

        $data['interview'] = $this->M_monitoringInterview->_getDataListBerdasarkanPendidikan($pendidikan);
        $this->load->view('monitor/interview/ajax_list',$data);
    }

}