<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */

class PotonganBon extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        
        $this->load->model(array('M_PotonganBon','m_monitor','M_Order'));
    }

    // BEGIN :: MASTER SATUAN

    function MstSatuan(){
        $data['_getDataSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $this->template->display('potongan_bon/master/satuan/index',$data);
    }

    function tambah_mst_satuan(){

        $this->template->display('potongan_bon/master/satuan/tambah');

    }
#050122
    function simpan_mst_satuan(){
        $nama_satuan = $this->input->post('txtNamaSatuan');
        $singkatan   = $this->input->post('txtSingkatan');
        $status = $this->input->post('txtStatus');

        $data = array(
            'NamaSatuan'        => $nama_satuan,
            'SingkatanSatuan'   => $singkatan,
            'Status'            => $status,
            'CreatedBy'         => $this->session->userdata('username'),
            'CreatedDate'       => date('Y-m-d H:i:s')
        );
        $cek_hdr = $this->M_PotonganBon->GetByNamaSatuan($nama_satuan,$singkatan);
        
        if(!$cek_hdr){
            $this->M_PotonganBon->simpan_mst_satuan($data);
            redirect('PotonganBon/MstSatuan?msg=success');
        }else {
            redirect('PotonganBon/MstSatuan?msg=failed');
        }
    }


    function edit_mst_satuan(){
        $id = $this->input->get('id');

        $data['_getDataSatuan'] = $this->M_PotonganBon->GetMstSatuan_byid($id);
        $this->template->display('potongan_bon/master/satuan/ubah',$data);
    }

    function update_mst_satuan(){
        $id = $this->input->post('txtSatuanID');
        $nama_satuan = $this->input->post('txtNamaSatuan');
        $singkatan   = $this->input->post('txtSingkatan');
        $status = $this->input->post('txtStatus');

        $data = array(
            'NamaSatuan'        => $nama_satuan,
            'SingkatanSatuan'   => $singkatan,
            'Status'            => $status,
            'UpdateBy'          => $this->session->userdata('username'),
            'UpdateDate'        => date('Y-m-d H:i:s')
        );

        $this->M_PotonganBon->update_mst_satuan($id,$data);
        redirect('PotonganBon/MstSatuan?msg=success');
    }

    // END :: MASTER SATUAN

    // BEGIN :: MASTER ITEM 

    function MstItem(){

        $data['_getDataItem'] = $this->M_PotonganBon->GetMstItemfull();
        $this->template->display('potongan_bon/master/item/index',$data);
    }

    function tambah_mst_item(){
        $kode = $this->M_PotonganBon->GetKodeItem();
        $data['kodeitem'] = $kode + 1;
        $data['_getMstSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori'] = $this->M_PotonganBon->GetMstKategori();
        $this->template->display('potongan_bon/master/item/tambah',$data);
    }

    function ajax_modal($id_item,$id_pbr){

        $data['_getDataItem'] = $this->M_PotonganBon->GetMstItem_Bypbr($id_item,$id_pbr);
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();

        $this->load->view('potongan_bon/master/item/ajax',$data);
    }

    function modalItem($id_item){

        $data['_getMstSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori'] = $this->M_PotonganBon->GetMstKategori();
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();
        $data['id_item'] = $id_item;

        $this->load->view('potongan_bon/master/item/list',$data);
    }
    //BEGIN :: YAWALIYUL
    function get_search_item(){
        $item = $this->input->post("item");
        $result = $this->M_PotonganBon->get_search_item($item);
        echo json_encode($result);
    }
    //END :: YAWALIYUL

    function simpan_mst_item(){


        $kode_item = $this->input->post('txtKodeItem');
        $nama_item = $this->input->post('txtNamaItem');
        $satuan    = $this->input->post('txtSatuan');
        $kategori  = $this->input->post("txtKategori");

        $data = array(
            'KodeItem' => $kode_item,
            'NamaItem' => $nama_item,
            'SatuanID' => $satuan,
            'KategoriID' => $kategori,
            'CreatedBy' => $this->session->userdata('username'),
            'CreatedDate' => date('Y-m-d H:i:s')
        );

        $cek_item = $this->M_PotonganBon->getByNamaItem($nama_item);
        if(!$cek_item){
            $this->M_PotonganBon->simpan_mst_item($data);
        redirect('PotonganBon/MstItem?msg=success');
        }else{
        redirect('PotonganBon/MstItem?msg=failed');
        } 
    }

    function edit_mst_item(){
        $id = $this->input->get('id');

        $data['_getMstSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori'] = $this->M_PotonganBon->GetMstKategori();
        $data['_getDataItem'] = $this->M_PotonganBon->GetMstItem_ById($id);
        $this->template->display('potongan_bon/master/item/ubah',$data);
    }

    function update_mst_item(){
        $id = $this->input->post('txtItemID');
        $kode_item = $this->input->post('txtKodeItem');
        $nama_item = $this->input->post('txtNamaItem');
        $satuan    = $this->input->post('txtSatuan');
        $kategori  = $this->input->post("txtKategori");

        $data = array(
            'KodeItem' => $kode_item,
            'NamaItem' => $nama_item,
            'SatuanID' => $satuan,
            'KategoriID' => $kategori,
            'UpdateBy' => $this->session->userdata('username'),
            'UpdateDate' => date('Y-m-d H:i:s')
        );

        $this->M_PotonganBon->update_mst_item($id,$data);
        redirect('PotonganBon/MstItem?msg=success');

    }

    // END :: MASTER ITEM

    // BEGIN :: MASTER KATEGORI

    function MstKategori(){
        $data['_getDataKategori'] = $this->M_PotonganBon->GetMstKategori();
        $this->template->display('potongan_bon/master/kategori/index',$data);
    }

    function tambah_mst_kategori(){

        $this->template->display('potongan_bon/master/kategori/tambah');
    }

    function simpan_mst_kategori(){
        $kategori = $this->input->post("txtNamaKategori");
        $status = $this->input->post('txtStatus');

        $data = array(
            'NamaKategori' => $kategori,
            'Status'       => $status,
            'CreatedBy'    => $this->session->userdata("username"),
            'CreatedDate'  => date('Y-m-d H:i:s'),
        );

        $cek_kategori = $this->M_PotonganBon->GetByKategori($kategori);
        if(!$cek_kategori){
            $this->M_PotonganBon->simpan_mst_kategori($data);
            redirect('PotonganBon/MstKategori?msg=success');
        }else{
            redirect('PotonganBon/MstKategori?msg=failed');
        }
    }

    function edit_mst_kategori(){
        $id = $this->input->get('id');

        $data['_getDataKategori'] = $this->M_PotonganBon->GetMstKategori_ById($id);

        $this->template->display("potongan_bon/master/kategori/ubah",$data);
    }

    function update_mst_kategori(){
        $id = $this->input->post("txtKategoriID");
        $kategori = $this->input->post("txtNamaKategori");
        $status = $this->input->post('txtStatus');

        $data = array(
            'NamaKategori' => $kategori,
            'Status'       => $status,
            'UpdateBy'    => $this->session->userdata("username"),
            'UpdateDate'  => date('Y-m-d H:i:s'),
        );

        $this->M_PotonganBon->update_mst_kategori($id,$data);
        redirect('PotonganBon/MstKategori?msg=success');
    }

    // END :: MASTER KATEGORI

    #MASTER KATEGORI POTONGAN

    function MstKategoriCicilan(){
        $data['_getDataCicilan'] = $this->M_PotonganBon->GetMstKategoriCicilan();

        $this->template->display('potongan_bon/master/kategori_cicilan/index',$data);
    }

    function tambah_mst_cicilan(){

        $this->template->display('potongan_bon/master/kategori_cicilan/tambah');
    }

    function simpan_mst_cicilan(){
        $kategori = $this->input->post("txtNamaKategori");
        $prioritas = $this->input->post("txtPrioritas");
        $status = $this->input->post('txtStatus');

        $data = array(
            'NamaKategori' => $kategori,
            'Prioritas'    => $prioritas, 
            'Status'       => $status,
            'CreatedBy'    => $this->session->userdata("username"),
            'CreatedDate'  => date('Y-m-d H:i:s'),
        );

        $this->M_PotonganBon->simpan_mst_cicilan($data);

        redirect('PotonganBon/MstKategoriCicilan?msg=success');
    }

    function edit_mst_cicilan(){
        $id = $this->input->get('id');

        $data['_getDataCicilan'] = $this->M_PotonganBon->GetMstCicilan_ById($id);

        $this->template->display("potongan_bon/master/kategori_cicilan/ubah",$data);
    }

    function update_mst_cicilan(){
        $id = $this->input->post("txtKategoriCicilanID");
        $kategori = $this->input->post("txtNamaKategori");
        $status = $this->input->post('txtStatus');

        $data = array(
            'NamaKategori' => $kategori,
            'Status'       => $status,
            'UpdatedBy'    => $this->session->userdata("username"),
            'UpdatedDate'  => date('Y-m-d H:i:s'),
        );
        $this->M_PotonganBon->update_mst_cicilan($id,$data);
        redirect('PotonganBon/MstKategoriCicilan?msg=success');
    }

    #END MASTER KATEGORI POTONGAN


    // BEGIN :: MASTER HARGA

    function MstHarga(){
        $data['_getDataHdr'] = $this->M_PotonganBon->GetHeaderMstHarga();
        $this->template->display("potongan_bon/master/harga/index",$data);
    }

    function tambah_mst_harga(){
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();
        $data['_getDataItem'] = $this->M_PotonganBon->GetMstItemBaru();
        $this->template->display("potongan_bon/master/harga/tambah",$data);
    }

    function simpan_mst_harga(){
        // Header
        $tanggal    = $this->input->post("txtTanggal");
        $pemborong  = $this->input->post("txtPemborong");

        $dataHdr = array(
            'Tanggal'       => $tanggal,
            'IDPemborong'   => $pemborong,
            'CreatedBy'     => $this->session->userdata("username"),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        $cek_hdr = $this->M_PotonganBon->CekDataHdr($pemborong);
        if($cek_hdr != NULL){
            $this->M_PotonganBon->update_hdr($pemborong,$dataHdr);
        }else{
            $hdrid = $this->M_PotonganBon->simpan_hdr_harga($dataHdr);
        }

        foreach($cek_hdr as $hdr){
            $hdrid = $hdr->HeaderHargaID;
        }

        $item       = $this->input->post("txtItemID");
        $satuan     = $this->input->post("txtSatuanID");
        $kategori   = $this->input->post("txtKategoriID");
        $harga      = $this->input->post('txtHarga');
        $hitung     = count($item);

        for ($i=0; $i < $hitung; $i++) { 
            $dataDtl = array(
                'HeaderHargaID' => $hdrid,
                'IDPemborong'   => $pemborong,
                'ItemID'        => $item[$i],
                'SatuanID'      => $satuan[$i],
                'KategoriID'    => $kategori[$i],
                'Harga'         => str_replace(".", "",$harga[$i]),
                'CreatedBy'     => $this->session->userdata("username"),
                'CreatedDate'   => date('Y-m-d H:i:s')
            );

            $cek_dtl = $this->M_PotonganBon->CekDataDtl($item[$i],$pemborong);
            if($cek_dtl != NULL){
                foreach($cek_dtl as $dtl){
                    $dtlid = $dtl->DetailHargaID;
                     $this->M_PotonganBon->update_dtl_harga($dtlid,$dataDtl);
                }
            }else{
                $this->M_PotonganBon->simpan_dtl_harga($dataDtl);
            }
        }

        redirect('PotonganBon/tambah_mst_harga');

    }

    

    function getDetailItemHarga(){
        $hdrid = $this->input->get('id');

        $data['_getDataHdr'] = $this->M_PotonganBon->GetHeaderMstHarga_ById($hdrid);
        $data['_getDtlHarga'] = $this->M_PotonganBon->GetDtlHarga($hdrid);
        $this->template->display('potongan_bon/master/harga/detail_harga',$data);
    }

    function ajax_pemborong(){
        $pemborong = $this->uri->segment(3);

        $cek_hdr = $this->M_PotonganBon->CekDataHdr($pemborong);
        $data['cek_data'] = $cek_hdr;
        $data['_getDataItem'] = $this->M_PotonganBon->GetMstItemBaru();
        $data['_getHarga'] = $this->M_PotonganBon->GetMstItem_ByPemborong($pemborong);
        $this->load->view('potongan_bon/master/harga/ajax_harga',$data);
    }
    // END :: MASTER HARGA


    // BEGIN : TRANSAKSI POTONGAN BON

    function TransaksiPotonganBon(){

        $data['_getListOrder'] = $this->M_PotonganBon->_getListOrder();
        $this->template->display('potongan_bon/transaksi/list_order',$data);
    }
    function cari_tenagakerja(){
        $nik = $this->input->post('Nik');
        $nama = $this->input->post('Nik');
        $nofix = $this->input->post('Nik');
        if(!is_numeric($nofix)){
            $nofix = 0;
        }
        $pbr = $this->input->post('pemborong');

        $data['_getTK'] = $this->M_PotonganBon->GetTK($nik,$nama,$nofix,$pbr);

         $this->load->view('potongan_bon/transaksi/list_search',$data);
        
    }
    function ajaxDataTK(){
         $nik = $this->input->post('nik');
         $nama = $this->input->post('nama');
         $nofix = $this->input->post('nofix');
         $pbr = $this->input->post('pbr');


         $data['_getData'] = $this->M_PotonganBon->GetTK($nik,$nama,$pbr,$nofix);
         // echo"<pre>";
         // print_r($data['_getData']);
         // echo"</pre>";
         $this->load->view('potongan_bon/transaksi/list_dataTK',$data);
     }

    function ordermanual()
    {
        $nik    = $this->input->post('nik');
        $nama   = $this->input->post('nama');
        $data['_getDataPemborong']  = $this->M_PotonganBon->GetMstPemborong();
        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategori();
        $data['_getListItem']       = $this->M_PotonganBon->GetMstItem();
        // $data['_getTK']             = $this->M_PotonganBon->GetTK($nik,$nama);

        $this->template->display('potongan_bon/transaksi/ordermanual',$data);
    }

    function send_data(){
        $nik = $this->uri->segment(3);
        $nama = $this->uri->segment(3);
        $nofix = $this->uri->segment(3);
        $pemborong = $this->uri->segment(4);
        $otp = '123ABC';


        $get_tk = $this->M_PotonganBon->GetTK($nik,$nama,$nofix,$pemborong);
        $nofix = $get_tk[0]->Nofix;

        echo '
            
            <div class="form-group">
                <label class="col-lg-2 control-label">Nofix</label>
                <div class="col-sm-4">
                    <input type="text" name="txtNofix" id="nofix" class="form-control" value="'.$nofix.'" readonly>
                    <input type="hidden" name="txtPemborong" id="pemborong" class="form-control" value="'.$get_tk[0]->Pemborong.'" readonly>
                    <input type="hidden" name="txtPemborong" id="pemborong" class="form-control" value="'.$get_tk[0]->IDPemborong.'" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Nama Lengkap</label>
                <div class="col-sm-4">
                    <input type="text" name="txtdept" id="dept" class="form-control" value="'.$get_tk[0]->Nama.'" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Dept/Bagian</label>
                <div class="col-sm-4">
                    <input type="text" name="txtdept" id="dept" class="form-control" value="'.$get_tk[0]->Bagian.'" readonly>
                </div>
            </div>
        ';
    }
    function ajax_list_item(){
        $pbr   = $this->uri->segment(3);

        $data['_getListItem'] = $this->M_PotonganBon->GetTrnListItem($pbr);
        $data['pemborong'] = $pbr;
        $this->load->view("potongan_bon/transaksi/mstListItem",$data);

    }

    function lihat_pesanan(){
        $tanggal = $this->uri->segment(3);
        $nofix = $this->uri->segment(4);
        $pbr = $this->uri->segment(5);

        $data['_getDataPemborong']  = $this->M_PotonganBon->GetMstPemborong();
        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategori();
        $data['_getTrnHeader']      = $this->M_PotonganBon->_getTrnHeader($tanggal,$nofix,$pbr);
        $_trnHeader = $data['_getTrnHeader'];
        $data['_getTrnDetail']      = $this->M_PotonganBon->_getTrnDetail($_trnHeader[0]->HeaderID);
        $data['_getListItem'] = $this->M_PotonganBon->GetMstItem();
        $data['_getGrandTotal'] = $this->M_PotonganBon->_getGrandTotal($_trnHeader[0]->HeaderID);
        $this->template->display('potongan_bon/transaksi/index',$data);
    }

     function ajax_harga(){
        $item = $this->uri->segment(3);
        $pbr = $this->uri->segment(4);

        $get_harga = $this->M_PotonganBon->get_harga($pbr,$item);
        foreach($get_harga as $key){
            echo number_format($key->Harga,0,",",".");
        }
    }

    function ajax_hargaid(){
        $item = $this->uri->segment(3);
        $pbr = $this->uri->segment(4);

        $get_harga = $this->M_PotonganBon->get_harga($pbr,$item);
        foreach($get_harga as $key){
            echo $key->DetailHargaID;
        }
    }

    function ajax_satuan(){
        $item = $this->uri->segment(3);
        $pbr = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($pbr,$item);
        foreach($get_satuan as $key){
            echo $key->SingkatanSatuan;
        }
    }

    function ajax_satuanid(){
        $item = $this->uri->segment(3);
        $pbr = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($pbr,$item);
        foreach($get_satuan as $key){
            echo $key->SatuanID;
        }
    }

    function ajax_kategori(){
        $item = $this->uri->segment(3);
        $pbr = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($pbr,$item);
        foreach($get_satuan as $key){
            echo $key->NamaKategori;
        }
    }
    function ajax_kategoriid(){
        $item = $this->uri->segment(3);
        $pbr = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($pbr,$item);
        foreach($get_satuan as $key){
            echo $key->KategoriID;
        }
    }

    function hapus_item(){
        $dtlid = $this->uri->segment(3);

        $this->M_Order->hapus_item($dtlid);
    }

       function simpan_trn_manual_potongan_pemborong(){
        // Header
        $tanggal   = $this->input->post("txtTanggal");
        $pemborong = $this->input->post("txtPemborong");
        $nofix     = $this->input->post("txtNofix");
        
            $dataHdr = array(
            'Tanggal'       => date('Y-m-d H:i:s',strtotime($tanggal)),
            'IDPemborong'   => $pemborong,
            'Nofix'         => $nofix,
            'CreatedBy'     => $this->session->userdata('username'),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        $hdrid = $this->M_PotonganBon->simpan_trn_hdr($dataHdr);

        // Detail

        $item       = $this->input->post('txtItem');
        $harga      = $this->input->post('txtHarga');
        $hargaid    = $this->input->post('txtHargaid');
        $quantity   = $this->input->post('txtQuantity');
        $satuan     = $this->input->post('txtSatuanid');
        $kategori   = $this->input->post('txtKategoriid');
        $total      = $this->input->post('txtTotal');
        $hitung = count($item);

        for ($i=0; $i < $hitung; $i++) { 
            $dataDtl = array(
              'HeaderID'    => $hdrid,
              'IDPemborong' => $pemborong,
              'Nofix'       => $nofix,
              'ItemID'      => $item[$i],
              'HargaID'     => $hargaid[$i],
              'Harga'       => str_replace(".", "",$harga[$i]),
              'Quantity'    => $quantity[$i],
              'SatuanID'    => $satuan[$i],
              'KategoriID'  => $kategori[$i],
              'Total'       => $total[$i],
              'CreatedBy'   => $this->session->userdata('username'),
              'CreatedDate' => date('Y-m-d H:i:s')
            );

            $cek_harga = $this->M_PotonganBon->CekHarga($hargaid[$i],$pemborong);
            if($cek_harga[0]->Harga != $harga[$i]){
                $this->M_PotonganBon->simpan_trn_dtl($dataDtl);

                $dataHarga = array(
                    'Harga' => str_replace(".", "",$harga[$i]),
                );

                $this->M_PotonganBon->update_harga($hargaid[$i],$dataHarga);

                $dataHistoryHarga = array(
                  'DetailHargaID' => $hargaid[$i],
                  'HeaderHargaID' => $cek_harga[0]->HeaderHargaID,
                  'IDPemborong'   => $pemborong,
                  'ItemID'        => $item[$i],
                  'SatuanID'      => $satuan[$i],
                  'KategoriID'    => $kategori[$i],
                  'Harga'         => str_replace(".", "",$cek_harga[0]->Harga),
                  'CreatedBy'     => $this->session->userdata('username'),
                  'CreatedDate'   => date('Y-m-d H:i:s')
                );

                $this->M_PotonganBon->simpan_history($dataHistoryHarga);
            }else{
                $this->M_PotonganBon->simpan_trn_dtl($dataDtl);
            }

         redirect('PotonganBon/TransaksiPotonganBon?msg=success');
        }
    }

    function simpan_trn_potongan_pemborong(){

        $hdrid      = $this->input->post("txtHeaderID");
        $tgl        = $this->input->post("txtTanggal");
        $nofix      = $this->input->post("txtNofix");
        $dtlid      = $this->input->post("txtDetailID");
        $pbrid      = $this->input->post("txtPemborong");
        $item       = $this->input->post("txtItem");
        $harga      = $this->input->post("txtHarga");
        $hargaid    = $this->input->post("txtHargaid");
        $qty        = $this->input->post("txtQuantity");
        $satuan     = $this->input->post("txtSatuanid");
        $kategori   = $this->input->post("txtKategoriid");
        $total      = $this->input->post("txtTotal");
        $hitung = count($item);



        $dataHdr = array(
            'StatusProses' => 1,
            'CreatedBy'     => $this->session->userdata("username"),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        // echo"<pre>";
        // print_r($dataHdr);
        // echo"</pre>";
        $this->M_PotonganBon->update_trn_hdr($hdrid,$dataHdr);

        for ($i=0; $i < $hitung; $i++) { 
            // echo $hitung;
            $dataDtl = array(
                'HeaderID'      => $hdrid,
                'IDPemborong'   => $pbrid,
                'Nofix'         => $nofix,
                'ItemID'        => $item[$i],
                'Harga'         => str_replace(".", "",$harga[$i]),
                'HargaID'       => $hargaid[$i],
                'Quantity'      => $qty[$i],
                'SatuanID'      => $satuan[$i],
                'KategoriID'    => $kategori[$i],
                'Total'         => $total[$i],
                'CreatedBy'     => $this->session->userdata("username"),
                'CreatedDate'   => date('Y-m-d H:i:s')
            );
            $cek_harga = $this->M_PotonganBon->CekHarga($item[$i],$pbrid);
            if($cek_harga[0]->Harga == str_replace(".", "",$harga[$i])){
                // jika harga sama 
                $cek_dtl = $this->M_PotonganBon->cek_dtl($dtlid[$i]);
                if($cek_dtl == NULL){
                    $this->M_PotonganBon->simpan_trn_dtl($dataDtl);
                }else{
                    $this->M_PotonganBon->update_trn_dtl($dtlid[$i],$dataDtl);
                }
            }else{
                // jika Harga tidak sama :
                $this->M_PotonganBon->simpan_trn_dtl($dataDtl);

                $dataHarga = array(
                    'Harga' => str_replace(".", "",$harga[$i]),
                );

                $this->M_PotonganBon->update_harga($hargaid[$i],$dataHarga);

                $dataHistoryHarga = array(
                  'DetailHargaID' => $hargaid[$i],
                  'HeaderHargaID' => $cek_harga[0]->HeaderHargaID,
                  'IDPemborong'   => $pbrid,
                  'ItemID'        => $item[$i],
                  'SatuanID'      => $satuan[$i],
                  'KategoriID'    => $kategori[$i],
                  'Harga'         => str_replace(".", "",$cek_harga[0]->Harga),
                  'CreatedBy'     => $this->session->userdata('username'),
                  'CreatedDate'   => date('Y-m-d H:i:s')
                );

                $this->M_PotonganBon->simpan_history($dataHistoryHarga);
            }

        }
        redirect("PotonganBon/TransaksiPotonganBon?msg=success");
    }

    
    // BEGIN :: MONITORING POTONGAN PEMBORONG

    function MonitoringPotongan(){

         $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();
        $this->template->display('potongan_bon/monitoring/index',$data);
    }

    function ajax_data_potongan(){
        $pbr        = $this->uri->segment(3);
        $periode    = $this->uri->segment(4);
        $bln        = $this->uri->segment(5);
        $thn        = $this->uri->segment(6);

        if($periode == 1){
            // Periode 1
            $tglAwal  = date($thn.'-'.$bln.'-1');
            $tglAkhir = date($thn.'-'.$bln.'-d', strtotime('+14 days', strtotime($tglAwal)));
            $data['_getData'] = $this->M_PotonganBon->GetDataPotongan($pbr,$tglAwal,$tglAkhir);
            $data['_getTotal'] = $this->M_PotonganBon->GetDataTotal($tglAwal,$tglAkhir);

            $data['tglAwal'] = $tglAwal;
            $data['tglAkhir'] = $tglAkhir;
            $this->load->view('potongan_bon/monitoring/list',$data);
        }else{
            // Periode 2
            $tglAwal  = date($thn.'-'.$bln.'-16');
            $tglAkhir = date($thn.'-'.$bln.'-'.date(cal_days_in_month(CAL_GREGORIAN, $bln, $thn)));
            $data['_getData'] = $this->M_PotonganBon->GetDataPotongan($pbr,$tglAwal,$tglAkhir);
            $data['_getTotal'] = $this->M_PotonganBon->GetDataTotal($tglAwal,$tglAkhir);

            $data['tglAwal'] = $tglAwal;
            $data['tglAkhir'] = $tglAkhir;
            $this->load->view('potongan_bon/monitoring/list',$data);
        }
    }

    function get_detail_potongan(){
        $nofix = $this->uri->segment(3);
        $tglAwal = $this->uri->segment(4);
        $tglAkhir = $this->uri->segment(5);

        $data['_getDataTrnHdr'] = $this->M_PotonganBon->getDataTrnHdr($nofix,$tglAwal,$tglAkhir);
        $data['_getDataTrnTanggal'] = $this->M_PotonganBon->getDataTrnTanggal($nofix,$tglAwal,$tglAkhir);
        $data['_getDataTrnDtl'] = $this->M_PotonganBon->getDataTrnDtl($nofix,$tglAwal,$tglAkhir);
        $data['_getDataTrnTotal'] = $this->M_PotonganBon->getDataTrnTotal($nofix,$tglAwal,$tglAkhir);
        $this->load->view('potongan_bon/transaksi/detail',$data);
    }
    // END :: MONITORING POTONG PEMBORONG

    function mstTK()
    {
        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();
      $this->template->display('potongan_bon/master/tenaga_kerja/index',$data);
    }

    function ajaxTenagaKerja($pbr)
    {
        $data['_getTK']    = $this->M_PotonganBon->getTK_byPemborong($pbr);
      $this->load->view('potongan_bon/master/tenaga_kerja/ajax',$data);
    }

    function save_tenagaKerja($id,$data){
        $this->db->where("Nofix IN ('".$id."')");
        $this->db->update('RSUPBorongan2010.dbo.tblMstTenagaKerja',$data);
    }

    function ajax_sub($pbr)
    {
        $data['_getTK']    = $this->M_PotonganBon->getMstSub($pbr);
      $this->load->view('potongan_bon/master/tenaga_kerja/sub',$data);
    }

}?>