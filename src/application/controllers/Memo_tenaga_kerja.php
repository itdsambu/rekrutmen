<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class memo_tenaga_kerja extends CI_Controller{
    
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
        
        $this->load->model(array('M_memo_tenaga_kerja'));
    }

    function wawancara(){

        $data['_getFormID']         = $this->input->get('id');
    	$data['getAppWawancara'] = $this->M_memo_tenaga_kerja->get_approvalWawancara();
    	$this->template->display('transaksi/memo_tenaga_kerja/wawancara/index',$data);
    }

    function simpanApprovalWawancara(){
    	$cek = $this->input->post('cek');
    	$jumlah  = count($cek);

    	for ($i=0; $i < $jumlah; $i++) { 
    		$data = array(
    			'AppMemoWawancara' => 1,
    			'AppMemoWawancaraBy' => $this->session->userdata('username'),
    			'AppMemoWawancaraDate' => date('Y-m-d H:i:s'),
    		);
            // print_r($data);
    		$this->M_memo_tenaga_kerja->simpan($cek[$i],$data);
    	}

        redirect('memo_tenaga_kerja/wawancara');
    }

    function wawancara_dept(){
        $data['_getFormID']         = $this->input->get('id');
        $data['getAppWawancara'] = $this->M_memo_tenaga_kerja->get_approvalWawancara_dept();
        $this->template->display('transaksi/memo_tenaga_kerja/wawancara/index_dept',$data);
    }

    function simpanApprovalWawancaraDept(){
        $cek = $this->input->post('cek');
        $jumlah  = count($cek);

        for ($i=0; $i < $jumlah; $i++) { 
            $data = array(
                'AppMemoWawancara_dept' => 1,
                'AppMemoWawancaraBy_dept' => $this->session->userdata('username'),
                'AppMemoWawancaraDate_dept' => date('Y-m-d H:i:s'),
            );

            $this->M_memo_tenaga_kerja->simpan($cek[$i],$data);
        }
        redirect('memo_tenaga_kerja/wawancara_dept');
    }

    function wawancara_div(){

        $data['_getFormID']      = $this->input->get('id');
        $data['getAppWawancara'] = $this->M_memo_tenaga_kerja->get_approvalWawancara_div();
        $this->template->display('transaksi/memo_tenaga_kerja/wawancara/index_div',$data);
    }

    function simpanApprovalWawancaraDiv(){
        $cek = $this->input->post('cek');
        $jumlah  = count($cek);

        for ($i=0; $i < $jumlah; $i++) { 
            $data = array(
                'AppMemoWawancara_div' => 1,
                'AppMemoWawancaraBy_div' => $this->session->userdata('username'),
                'AppMemoWawancaraDate_div' => date('Y-m-d H:i:s'),
                'GeneralApproved' => 1
            );

            $this->M_memo_tenaga_kerja->simpan($cek[$i],$data);
        }
        redirect('memo_tenaga_kerja/wawancara_div');
    }

    function updatehasilwawancara(){
        $hdrid = $this->input->get('id');

        $data['hdrid'] = $hdrid;
        $data['getHasil'] = $this->M_memo_tenaga_kerja->get_hasil($hdrid);
        $this->load->view('transaksi/memo_tenaga_kerja/wawancara/updatehasil',$data);
    }

    function updateHasil(){
        $hasil = $this->input->post('selHasilWawancara');
        $ket = $this->input->post('txtKeterangan');
        $hdrid = $this->input->post('txthdrid');

        if($hasil == 'LULUS'){
            $data =array(
                'Grade'      => $hasil,
                'Keterangan' => $ket,
                'WawancaraUpdateBy' => $this->session->userdata('username'),
                'WawancaraUpdateDate' => date('Y-m-d H:i:s'),
            );

            $this->M_memo_tenaga_kerja->update_wawancara($hdrid,$data);
            $datatk = array(
                'WawancaraHasil' => 1,
            );
            $this->M_memo_tenaga_kerja->update_tk($hdrid,$datatk);
            redirect('memo_tenaga_kerja/wawancara_div');
        }else{
            $data =array(
                'Grade'                 => $hasil,
                'Keterangan'            => $ket,
                'WawancaraUpdateBy'     => $this->session->userdata('username'),
                'WawancaraUpdateDate'   => date('Y-m-d H:i:s'),
            );

            $this->M_memo_tenaga_kerja->update_wawancara($hdrid,$data);
            $datatk = array(
                'WawancaraHasil' => 0,
            );

            $this->M_memo_tenaga_kerja->update_tk($hdrid,$datatk);
            redirect('memo_tenaga_kerja/wawancara_div');
        }
        
       
    }

    function cek_fisik(){

        $data['_getFormID']         = $this->input->get('id');
    	$data['getAppCekFisik'] = $this->M_memo_tenaga_kerja->get_approvalCekFisik();
    	$this->template->display('transaksi/memo_tenaga_kerja/cek_fisik/index',$data);
    }

    function simpanApprovalCekFisik(){
    	$cek       = $this->input->post('cek');
    	$jumlah    = count($cek);

    	for ($i=0; $i < $jumlah; $i++) { 
    		$data = array(
    			'AppMemoCekFisik' => 1,
    			'AppMemoCekFisikBy' => $this->session->userdata('username'),
    			'AppMemoCekFisikDate' => date('Y-m-d H:i:s'),
    		);

    		$this->M_memo_tenaga_kerja->simpan($cek[$i],$data);
    	}

        redirect('memo_tenaga_kerja/cek_fisik');
    }

    function mod_input_hasil(){
        $hdrid = $this->input->get('id');

        $data['hdrid'] = $hdrid;
        $this->load->view('transaksi/memo_tenaga_kerja/cek_fisik/modal_input_hasil',$data);
    }

    function ajax_hasil(){
        $pilih = $this->uri->segment(3);

        if($pilih == 1){
            $this->load->view('transaksi/memo_tenaga_kerja/cek_fisik/ajax/upload');
        }else{
             $this->load->view('transaksi/memo_tenaga_kerja/cek_fisik/ajax/keterangan');
        }
       
    }

    function simpan_hasil_cek_fisik(){
        $hdrid      = $this->input->post('txthdrid');
        $jamawal    = $this->input->post('txtjamawal');
        $jamakhir   = $this->input->post('txtjamakhir');
        $pilihhasil = $this->input->post('selhasil');
        $keterangan = $this->input->post('txtketerangan');
        $upload     = $this->input->post('fileupload');

        if($pilihhasil == 1){
            $data = array(
                'RequestID'        => $hdrid,
                'JamCekFisilAwal'  => $jamawal,
                'JamCekFisikAkhir' => $jamakhir,
                'HasilCekFisik'    => $pilihhasil,
                'keterangan'       => $keterangan,
                'Link_file'        => './cek_fisik/'.$hdrid,
                'StatusCek'        => 1,
                'CreatedBy'        => $this->session->userdata('username'),
                'CreatedDate'      => date('Y-m-d H:i:s'),
            );
            $id = $this->M_memo_tenaga_kerja->simpan_hasil($data);

            $config['upload_path']      = './dataupload/cek_fisik/';
            $config['allowed_types']    = 'jpg|jpeg|png|pdf|xlsx|xls|Bmp';
            $config['max_size']         = '3000';
            $config['max_height']       = '0';
            $config['overwrite']        = TRUE;
            $config['file_name']        = $hdrid.'.jpg';

            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('fileupload')) {
                $errors = $this->upload->display_errors();
                $data   = array('UploadFile' => 0,);
                    $this->M_memo_tenaga_kerja->updateForm($id,$data);
            }else{
                $upload_berkas = $this->upload->data();
                $data   = array('UploadFile' => 1,);
                $this->M_memo_tenaga_kerja->updateForm($id,$data);
            }

            redirect('memo_tenaga_kerja/cek_fisik');
        }else{
            $data = array(
                'RequestID'        => $hdrid,
                'JamCekFisilAwal'  => $jamawal,
                'JamCekFisikAkhir' => $jamakhir,
                'HasilCekFisik'    => $pilihhasil,
                'keterangan'       => $keterangan,
                'StatusCek'        => 1,
                'CreatedBy'        => $this->session->userdata('username'),
                'CreatedDate'      => date('Y-m-d H:i:s'),
            );

            $this->M_memo_tenaga_kerja->simpan_hasil($data);
            redirect('memo_tenaga_kerja/cek_fisik');
        }

    }


    // monitoring memo tenaga kerja

    function monCek_fisik(){

        $data['_getFormID']      = $this->input->get('id');
        $data['getTKCekFisik'] = $this->M_memo_tenaga_kerja->get_TkCekFisik();
        $data['getCekHasilCekFisik'] = $this->M_memo_tenaga_kerja->get_hasilcekfisik();
        $this->template->display('monitor/memo_tenaga_kerja/cek_fisik/index',$data);
    }

    function view_gambar(){
        $hdrid = $this->input->get('id');

        $data['hdrid'] = $hdrid;
        $this->load->view('monitor/memo_tenaga_kerja/cek_fisik/gambar',$data);
    }

    function ajax_datacekfisik(){
        $tanggal = $this->uri->segment(3);
        $jamAwal = date('H:i:s',strtotime($this->uri->segment(4)));
        $jamAkhir = date('H:i:s',strtotime($this->uri->segment(5)));

        $data['tanggal'] = $tanggal;
        $data['jamAwal'] = $jamAwal;
        $data['jamAkhir'] = $jamAkhir;
        $data['getTKCekFisik'] = $this->M_memo_tenaga_kerja->get_TkCekFisikPerTanggal($tanggal,$jamAwal,$jamAkhir);
        $data['getCekHasilCekFisik'] = $this->M_memo_tenaga_kerja->get_hasilcekfisikPerTanggal($tanggal,$jamAwal,$jamAkhir);
        $this->load->view('monitor/memo_tenaga_kerja/cek_fisik/ajax/data',$data);
    }

    function print_memo_cek_fisik(){
        ob_start();
        $tanggal = $this->uri->segment(3);
        $jamAwal = date('H:i:s',strtotime($this->uri->segment(4)));
        $jamAkhir = date('H:i:s',strtotime($this->uri->segment(5)));
        $userID = $this->session->userdata('userid');

        $data['tanggal'] = $tanggal;
        $data['jamAwal'] = $jamAwal;
        $data['JamAkhir'] = $jamAkhir;
        $data['getTenagaKerja'] = $this->M_memo_tenaga_kerja->get_tenagakerja($tanggal,$jamAwal,$jamAkhir);
        $data['getApproval'] = $this->M_memo_tenaga_kerja->get_appmemocekfisik($tanggal,$jamAwal,$jamAkhir);
        $data['getUser'] = $this->M_memo_tenaga_kerja->getUser($userID);
        $this->load->view('monitor/memo_tenaga_kerja/cek_fisik/print/wawancara',$data);


        $html   = ob_get_contents();
        
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('cek_fisik'.$tanggal.'.pdf');
    }


    function monWawancara(){

        $data['_getFormID']      = $this->input->get('id');
        $data['getTkWawancara'] = $this->M_memo_tenaga_kerja->get_TkWawancara();
        $data['departemen']     = $this->M_memo_tenaga_kerja->get_departemen();
        $this->template->display('monitor/memo_tenaga_kerja/wawancara/index',$data);
    }

    function ajax_datawawancara(){
        $tanggal = $this->uri->segment(3);
        $dept = $this->uri->segment(4);

        $data['tanggal'] = $tanggal;
        $data['dept']   = $dept;
        $data['getTkWawancara'] = $this->M_memo_tenaga_kerja->get_tkwawancarapertanggal($tanggal,$dept);
        $data['getApp'] = $this->M_memo_tenaga_kerja->get_appmemowawancara($tanggal);
        $this->load->view('monitor/memo_tenaga_kerja/wawancara/ajax/data',$data);
    }

     function export_memo_wawancara(){
        ob_start();
        $tanggal = $this->uri->segment(3);
        $dept = $this->uri->segment(4);

        $data['tanggal'] = $tanggal;
        $data['dept']   = $dept;
        $data['getTkWawancara'] = $this->M_memo_tenaga_kerja->get_tkwawancarapertanggal($tanggal,$dept);
        $data['getDept']    = $this->M_memo_tenaga_kerja->get_dept($dept);
        $data['getApproval'] = $this->M_memo_tenaga_kerja->get_appmemowawancara($tanggal);
        $this->load->view('monitor/memo_tenaga_kerja/wawancara/print/memo_wawancara',$data);


        $html   = ob_get_contents();
        ob_end_clean();
        
        require_once ('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P','A4','en');
        $pdf->writeHTML($html);
        $pdf->Output('wawancara'.$tanggal.'.pdf');
    }

    function open_lock(){
        $id = $this->input->get('id');

        $cek_tgl_lock = $this->m_register->cek_tgl_lock($id);
        foreach ($cek_tgl_lock as $key) {
            echo '<div class="row">
                    <div class="col-lg-12">
                        <form class="form-horizontal" role="form" name="myForm" method="POST" action="Verifikasi/simpan_open_lock">
                           <div class="form-group">
                               <label class="col-lg-3 control-label">Tanggal Lock</label>
                               <div class="col-lg-5">
                                   <input type="date" class="form-control" name="tgl_lock" value="'.$key->TanggalLock.'">
                                   <input type="hidden" class="form-control" name="pra_pelamar" value="'.$key->Pra_PelamarID.'">
                                   <input type="hidden" class="form-control" name="headerid" value="'.$key->HeaderID.'">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="col-lg-3 control-label">Open Lock</label>
                               <div class="col-lg-5">
                                   <input type="text" class="form-control" name="open_lock">
                               </div>
                           </div> 
                           <div class="form-group">
                               <label class="col-lg-3 control-label"></label>
                               <div class="col-lg-4">
                                   <input type="submit" value="Simpan" class="btn btn-sm btn-primary">
                               </div>
                           </div>  
                        </form>
                    </div>
                </div>';
        }
    }

    function simpan_open_lock(){
        $id         = $this->input->post('pra_pelamar');
        $hdrid         = $this->input->post('headerid');
        $tgl_lock   = $this->input->post('tgl_lock');
        $open_lock  = $this->input->post('open_lock');

        $lock =  date('d-m-Y', strtotime('+'.$open_lock.' days', strtotime($tgl_lock)));
        $data = array(
            'TanggalLock' => date('Y-m-d',strtotime($lock)),
        );

        $this->m_register->update_tgl_lock($id,$data);
        redirect(site_url('Verifikasi/index?msg=success2'));
    }
 }