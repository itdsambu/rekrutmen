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
        //$data['_getDataItem'] = $this->M_PotonganBon->GetMstItemfull();
        $this->template->display('potongan_bon/master/item/index');
    }

    function MstItem_(){
        $this->template->display('potongan_bon/master/item/list_item');
    }

    function ajaxMstItemDataTable()
    {
        if($this->input->is_ajax_request())
        {
            $config['table_name'] = 'vw_mstItemPag';
            $config['primary_key'] = 'ItemID';

            $this->load->library('datatable',$config);

            $request = $this->input->post();
            $data = $this->datatable->make($request);
            echo json_encode($data);
        }else{
            echo 'invalid request';
        }
        exit();
    }

    function getMstItem(){
        $getDataItem = $this->M_PotonganBon->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach($getDataItem as $r){
            $no++;
            $row = array();
            $row[] = $r->KodeItem;
            $row[] = $r->NamaItem;
            $row[] = $r->SingkatanSatuan;
            $row[] = $r->NamaKategori;
            $row[] = $r->KodeBarkode;
            $row[] = $r->CreatedBy;
            $row[] = '';
            $row[] = '';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_PotonganBon->count_all(),
            "recordsFiltered" => $this->M_PotonganBon->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function ajax_modal($id_item,$id_pbr,$id_sub){

        $data['_getData']   = $this->M_PotonganBon->GetMstItem_BypbrNew($id_item,$id_pbr,$id_sub);
        // echo"<pre>";
        // print_r($data['_getData']);
        // echo"</pre>";
        $this->load->view('potongan_bon/master/item/ajax',$data);
    }

    function modalItem($id_item){
        
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $data['id_item'] = $id_item;

        $this->load->view('potongan_bon/master/item/list',$data);
    }

    function ajax_subPBR($pbr)
    {
        $data['_getDataSub']    = $this->M_PotonganBon->getMstSub($pbr);
      $this->load->view('potongan_bon/master/item/sub',$data);
    }

    function tambah_mst_item(){
        $kode = $this->M_PotonganBon->GetKodeItem();
        $data['kodeitem'] = $kode + 1;
        $data['_getMstSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori'] = $this->M_PotonganBon->GetMstKategori();
        $this->template->display('potongan_bon/master/item/tambah',$data);
    }

    function getBykode(){
        $kode = $this->input->post('KodeBarkode');

        $data['getBarcode'] = $this->M_PotonganBon->getByNamaKode($kode);
        $data['_getMstSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori'] = $this->M_PotonganBon->GetMstKategori();
        if($data['getBarcode'] == null){
            echo json_encode(0);
        }else{
            $this->load->view('potongan_bon/master/item/Getkode',$data);
        }
    }

    //BEGIN :: YAWALIYUL
    function get_search_item(){
        $item = $this->input->post("item");
        $result = $this->M_PotonganBon->get_search_item($item);
        echo json_encode($result);
    }
    //END :: YAWALIYUL

    function simpan_mst_item(){

        $item_id    = $this->input->post("txtItemID");
        $kode_item = $this->input->post('txtKodeItem');
        $nama_item = $this->input->post('txtNamaItem');
        $satuan    = $this->input->post('txtSatuan');
        $kategori  = $this->input->post("txtKategori");
        $barcode    = $this->input->post('txtBarcode');
        $tanggal    = $this->input->post('txtTanggal');
        $harga      = $this->input->post('txtHarga');

        $group_id = $this->session->userdata('groupuser');
        $data_pemborong = $this->M_PotonganBon->GetIdSubPemborong($group_id);
        
        $id_sub_pemborong = $data_pemborong->IDSubPemborong;
        $id_pemborong     = $data_pemborong->IDPemborong;


        $data = array(
            'KodeItem' => $kode_item,
            'NamaItem' => $nama_item,
            'SatuanID' => $satuan,
            'KategoriID' => $kategori,
            'KodeBarkode' => $barcode,
            'CreatedBy' => $this->session->userdata('username'),
            'CreatedDate' => date('Y-m-d H:i:s')
        );

        $cek_kode = $this->M_PotonganBon->getByNamaItem($nama_item);
         if(!$cek_kode){
            $this->M_PotonganBon->simpan_mst_item($data);
            $itemID = $this->db->insert_id();

            $dataHdr = array(
                'Tanggal'       => $tanggal,
                'IDPemborong'   => $id_pemborong,
                'IDSubPemborong'=> $id_sub_pemborong,
                'CreatedBy'     => $this->session->userdata("username"),
                'CreatedDate'   => date('Y-m-d H:i:s')
            );

            $cek_hdr = $this->M_PotonganBon->CekDataHdrNew($id_pemborong,$id_sub_pemborong);
            if($cek_hdr != NULL){
                $this->M_PotonganBon->update_hdr($id_pemborong,$id_sub_pemborong,$dataHdr);
            }else{
                $hdrid = $this->M_PotonganBon->simpan_hdr_harga($dataHdr);
            }

            foreach($cek_hdr as $hdr){
                $hdrid = $hdr->HeaderHargaID;
            }

            $item       = $this->input->post("txtItemID");
            $hitung     = count($itemID);

            for ($i=0; $i < $hitung; $i++) { 
                $dataDtl = array(
                    'HeaderHargaID' => $hdrid,
                    'IDPemborong'   => $id_pemborong,
                    'IDSubPemborong'=> $id_sub_pemborong,
                    'ItemID'        => $itemID,
                    'SatuanID'      => $satuan,
                    'KategoriID'    => $kategori,
                    'Harga'         => str_replace(".", "",$harga)
                );

                $cek_dtl = $this->M_PotonganBon->CekDataDtl($itemID,$id_sub_pemborong);
                if($cek_dtl != NULL){
                    $dataDtl['UpdateBy'] = $this->session->userdata("username");
                    $dataDtl['UpdateDate'] = date('Y-m-d H:i:s');
                    foreach($cek_dtl as $dtl){
                        $dtlid = $dtl->DetailHargaID;
                         $this->M_PotonganBon->update_dtl_harga($dtlid,$dataDtl);
                    }
                }else{
                    $dataDtl['CreatedBy'] = $this->session->userdata("username");
                    $dataDtl['CreatedDate'] = date('Y-m-d H:i:s');
                    $this->M_PotonganBon->simpan_dtl_harga($dataDtl);
                }
            }

            redirect('PotonganBon/tambah_mst_item?msg=success1');
            
        }else{

            $dataHdr = array(
                'Tanggal'       => $tanggal,
                'IDPemborong'   => $id_pemborong,
                'IDSubPemborong'=> $id_sub_pemborong,
                'CreatedBy'     => $this->session->userdata("username"),
                'CreatedDate'   => date('Y-m-d H:i:s')
            );

            $cek_hdr = $this->M_PotonganBon->CekDataHdrNew($id_pemborong,$id_sub_pemborong);
            if($cek_hdr != NULL){
                $this->M_PotonganBon->update_hdr($id_pemborong,$id_sub_pemborong,$dataHdr);
            }else{
                $hdrid = $this->M_PotonganBon->simpan_hdr_harga($dataHdr);
            }

            foreach($cek_hdr as $hdr){
                $hdrid = $hdr->HeaderHargaID;
            }

            $hitung     = count($item_id);

            for ($i=0; $i < $hitung; $i++) { 
                $dataDtl = array(
                    'HeaderHargaID' => $hdrid,
                    'IDPemborong'   => $id_pemborong,
                    'IDSubPemborong'=> $id_sub_pemborong,
                    'ItemID'        => $item_id,
                    'SatuanID'      => $satuan,
                    'KategoriID'    => $kategori,
                    'Harga'         => str_replace(".", "",$harga)
                );

                $cek_dtl = $this->M_PotonganBon->CekDataDtl($item_id,$id_sub_pemborong);
                if($cek_dtl != NULL){
                    $dataDtl['UpdateBy'] = $this->session->userdata("username");
                    $dataDtl['UpdateDate'] = date('Y-m-d H:i:s');
                    foreach($cek_dtl as $dtl){
                        $dtlid = $dtl->DetailHargaID;
                         $this->M_PotonganBon->update_dtl_harga($dtlid,$dataDtl);
                    }
                }else{
                    $dataDtl['CreatedBy'] = $this->session->userdata("username");
                    $dataDtl['CreatedDate'] = date('Y-m-d H:i:s');
                    $this->M_PotonganBon->simpan_dtl_harga($dataDtl);
                }
            }

            redirect('PotonganBon/tambah_mst_item?msg=success2');
        }
    }

    function edit_mst_item(){
        $id = $this->input->get('id');

        $data['_getMstSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori'] = $this->M_PotonganBon->GetMstKategori();
        $data['_getDataItem'] = $this->M_PotonganBon->GetMstItem_ById($id);
        $this->template->display('potongan_bon/master/item/ubah',$data);
    }

    function get_search_barcode(){
        $kode = $this->input->post("kode");
        $result = $this->M_PotonganBon->get_search_barcode($kode);
        echo json_encode($result);
    }

    function update_mst_item(){
        $id = $this->input->post('txtItemID');
        $kode_item = $this->input->post('txtKodeItem');
        $nama_item = $this->input->post('txtNamaItem');
        $satuan    = $this->input->post('txtSatuan');
        $kategori  = $this->input->post("txtKategori");
        $barcode  = $this->input->post("txtBarcode");

        $data = array(
            'KodeBarkode' => $barcode,
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

    #MASTER CICILAN

    function MstCicilan(){

        $data['dataCicilan'] = $this->M_PotonganBon->GetMstCicilan();

        $this->template->display('potongan_bon/master/item_cicilan/index',$data);
    }

    function tambah_mst_item_cicilan()
    {
        $kode = $this->M_PotonganBon->GetKodeItemCicilan();
        $data['kodeitem'] = $kode + 1;
        $data['_getMstSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori'] = $this->M_PotonganBon->GetMstKategoriCicilan();
        $this->template->display('potongan_bon/master/item_cicilan/tambah',$data);
    }

    function simpan_mst_item_cicilan(){

        $kode_item = $this->input->post('txtKodeItem');
        $nama_item = $this->input->post('txtNamaItem');
        $satuan    = $this->input->post('txtSatuan');
        $kategori  = $this->input->post("txtKategori");
        $barcode    = $this->input->post('txtBarcode');

        $data = array(
            'KodeCicilanID' => $kode_item,
            'NamaCicilan' => $nama_item,
            'SatuanID' => $satuan,
            'KategoriCicilanID' => $kategori,
            'Barcode'   => $barcode,
            'CreatedBy' => $this->session->userdata('username'),
            'CreatedDate' => date('Y-m-d H:i:s')
        );

        $this->M_PotonganBon->simpan_mst_item_cicilan($data);
        redirect('PotonganBon/MstCicilan?msg=success');
    }

    function edit_mst_item_cicilan(){
        $id = $this->input->get('id');

        $data['_getMstSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori'] = $this->M_PotonganBon->GetMstKategoriCicilan();
        $data['_getDataItem'] = $this->M_PotonganBon->GetCicilan_ById($id);
        $this->template->display('potongan_bon/master/item_cicilan/ubah',$data);
    }

    function update_mst_item_cicilan(){
        $id = $this->input->post('txtItemID');
        $kode_item = $this->input->post('txtKodeItem');
        $nama_item = $this->input->post('txtNamaItem');
        $satuan    = $this->input->post('txtSatuan');
        $kategori  = $this->input->post("txtKategori");
        $barcode    = $this->input->post('txtBarcode');

        $data = array(
            'KodeCicilanID' => $kode_item,
            'NamaCicilan' => $nama_item,
            'SatuanID' => $satuan,
            'KategoriCicilanID' => $kategori,
            'Barcode'   => $barcode,
            'UpdatedBy' => $this->session->userdata('username'),
            'UpdatedDate' => date('Y-m-d H:i:s')
        );

        $this->M_PotonganBon->update_mst_item_cicilan($id,$data);
        redirect('PotonganBon/MstCicilan?msg=success');

    }
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
        $status = $this->input->post('txtStatus');
        $prioritas = $this->input->post('txtPrioritas');

        $data = array(
            'NamaKategori' => $kategori,
            'Status'       => $status,
            'Prioritas'     => $prioritas,
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
        $prioritas = $this->input->post('txtPrioritas');

        $data = array(
            'NamaKategori' => $kategori,
            'Status'       => $status,
            'Prioritas'     => $prioritas,                              
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
        $sub    = $this->input->post('IDSubPemborong');

        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getDataItem'] = $this->M_PotonganBon->GetMstItemBaru($sub);

        $this->template->display("potongan_bon/master/harga/tambah",$data);
    }

    function simpan_mst_harga(){
        // Header
        // echo"<pre>";
        // print_r($this->input->post());
        // echo"</pre>";
        $tanggal    = $this->input->post("txtTanggal");
        $pemborong  = $this->input->post("txtPemborong");
        $subpbr     = $this->input->post("txtSubPemborong");

        $dataHdr = array(
            'Tanggal'       => $tanggal,
            'IDPemborong'   => $pemborong,
            'IDSubPemborong'=> $subpbr,
            'CreatedBy'     => $this->session->userdata("username"),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        $cek_hdr = $this->M_PotonganBon->CekDataHdrNew($pemborong,$subpbr);
        if($cek_hdr != NULL){
            $this->M_PotonganBon->update_hdr($pemborong,$subpbr,$dataHdr);
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
                'IDSubPemborong'=> $subpbr,
                'ItemID'        => $item[$i],
                'SatuanID'      => $satuan[$i],
                'KategoriID'    => $kategori[$i],
                'Harga'         => str_replace(".", "",$harga[$i])
            );

            $cek_dtl = $this->M_PotonganBon->CekDataDtl($item[$i],$subpbr);
            if($cek_dtl != NULL){
                $dataDtl['UpdateBy'] = $this->session->userdata("username");
                $dataDtl['UpdateDate'] = date('Y-m-d H:i:s');
                foreach($cek_dtl as $dtl){
                    $dtlid = $dtl->DetailHargaID;
                     $this->M_PotonganBon->update_dtl_harga($dtlid,$dataDtl);
                }
            }else{
                $dataDtl['CreatedBy'] = $this->session->userdata("username");
                $dataDtl['CreatedDate'] = date('Y-m-d H:i:s');
                $this->M_PotonganBon->simpan_dtl_harga($dataDtl);
            }
        }
         redirect('PotonganBon/MstHarga');
    }

    function getDetailItemHarga(){
        $hdrid = $this->input->get('id');

        $data['_getDataHdr'] = $this->M_PotonganBon->GetHeaderMstHarga_ById($hdrid);
        $data['_getDtlHarga'] = $this->M_PotonganBon->GetDtlHarga($hdrid);
        $this->template->display('potongan_bon/master/harga/detail_harga',$data);
    }

    function subpbr($pbr)
    {
        $data['_getDataSub']    = $this->M_PotonganBon->getMstSub($pbr);
      $this->load->view('potongan_bon/master/harga/sub',$data);
    }

    function ajax_pemborong(){
        $pemborong     = $this->uri->segment(3);
        $subpbr     = $this->uri->segment(3);

        $cek_hdr = $this->M_PotonganBon->CekDataHdrNew($pemborong,$subpbr);
        $data['cek_data'] = $cek_hdr;
        // $data['_getDataItem'] = $this->M_PotonganBon->GetMstItemBaru($pemborong);
        $data['_getHarga'] = $this->M_PotonganBon->GetMstItem_ByPemborong($pemborong);
        $this->load->view('potongan_bon/master/harga/ajax_harga',$data);
    }
    // END :: MASTER HARGA


    // BEGIN : TRANSAKSI POTONGAN BON

    function TransaksiPotonganBon(){

        $data['_getListOrder'] = $this->M_PotonganBon->_getListOrder();
        $this->template->display('potongan_bon/transaksi/list_order',$data);
    }

    function ExportExcelTrnBelumProses(){
        $this->load->library("Excel/PHPExcel");

        $data['_getDataExcel'] = $this->M_PotonganBon->getDataExcelTrnBelumProses();
        // echo"<pre>";
        // print_r($data['_getDataExcel']);
        // echo"</pre>";
        $this->load->view('potongan_bon/transaksi/ExportExcel',$data);
    }


    function cari_tenagakerja(){
        $nik = $this->input->post('Nik');
        $nama = $this->input->post('Nik');
        $nofix = $this->input->post('Nik');
        if(!is_numeric($nofix)){
            $nofix = 0;
        }
        $sub = $this->input->post('subpemborong');

        $data['_getTK'] = $this->M_PotonganBon->GetTK($nik,$nama,$nofix,$sub);

         $this->load->view('potongan_bon/transaksi/list_search',$data);
        
    }

     function ajaxDataTK(){
         $nik = $this->input->post('nik');
         $nama = $this->input->post('nama');
         $nofix = $this->input->post('nofix');
         $pbr = $this->input->post('pbr');
         $sub = $this->input->post('subpemborong');

         $data['_getData'] = $this->M_PotonganBon->GetTK($nik,$nama,$nofix,$pbr,$sub);

         $this->load->view('potongan_bon/transaksi/list_dataTK',$data);
     }

    function ordermanual()
    {

        $data['_getDataPemborong']  = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategori();
        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $data['_getCount']          = $this->M_PotonganBon->_getTotalProses();
        $this->template->display('potongan_bon/transaksi/ordermanual',$data);
    }
     
    function ordermanual_iyul()
    {

        $data['_getDataPemborong']  = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategori();
        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $data['_getCount']          = $this->M_PotonganBon->_getTotalProses();
        $this->template->display('potongan_bon/transaksi_test/ordermanual_test',$data);
    }

    function ajax_subPemborong($pbr)
    {
        $data['_getDataSub']    = $this->M_PotonganBon->getMstSub($pbr);
      $this->load->view('potongan_bon/transaksi/sub',$data);
    }

   function send_data(){
        $nik = $this->uri->segment(3);
        $nama = $this->uri->segment(3);
        $nofix = $this->uri->segment(3);
        $sub   = $this->uri->segment(4);
        $otp = '123ABC';


        $get_tk = $this->M_PotonganBon->GetTK($nik,$nama,$nofix,$sub);
        foreach($get_tk as $get){

        echo '
            
            
            <div class="form-group">
                <label class="col-lg-2 control-label">Nik</label>
                <div class="col-sm-4">
                    <input type="text" name="txtNik" id="nik" class="form-control" value="'.$get->Nik.'" readonly>
                   
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Nama Lengkap</label>
                <div class="col-sm-4">
                    <input type="text" name="txtdept" id="dept" class="form-control" value="'.$get->Nama.'" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Dept/Bagian</label>
                <div class="col-sm-4">
                    <input type="text" name="txtdept" id="dept" class="form-control" value="'.$get->Bagian.'" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Sisa Periode Sebelumnya (Rp.)</label>
                <div class="col-sm-4">
                    <input type="text" name="txtSisa" id="Sisa" class="form-control" value="'.number_format($get->SisaPeriodeSebelumnya,0,",",".").'" readonly>
                </div>
            </div>
        ';
    }
}

    function ajax_list_item(){
        $pbrsub   = $this->uri->segment(3);
        $data['subpemborong'] = $pbrsub;
        $this->load->view("potongan_bon/transaksi/mstListItem",$data);
    }

    function ajax_list_item_iyul(){
        $pbrsub   = $this->uri->segment(3);
        $data['subpemborong'] = $pbrsub;
        $this->load->view("potongan_bon/transaksi_test/mstListItem_test",$data);
    }

    function ajax_search_item(){
        $pbrSub = $this->input->post("pbrSub");
        $search = $this->input->post("search");
        $kode   = $this->input->post("kode");
        $result = $this->M_PotonganBon->getSearchItem($pbrSub, $search, $kode);
        echo json_encode($result);
    }

    function ajax_search_item_iyul(){
        $pbrSub = $this->input->post("pbrSub");
        $search = $this->input->post("search");
        $kode   = $this->input->post("kode");
        $result = $this->M_PotonganBon->getSearchItem_iyul($pbrSub, $search, $kode);
        echo json_encode($result);
    }

    function lihat_pesanan(){
        $tanggal = $this->uri->segment(3);
        $nofix = $this->uri->segment(4);
        $sub = $this->uri->segment(5);
        $id = $this->uri->segment(6);
        
        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategori();
        $data['_getTrnHeader']      = $this->M_PotonganBon->_getTrnHeader($tanggal,$nofix,$sub,$id);
        // $data['_getTrnDetail']      = $this->M_PotonganBon->_getTrnDetail($data['_getTrnHeader']->HeaderID);
        // $data['_getGrandTotal']     = $this->M_PotonganBon->_getGrandTotal($data['_getTrnHeader']->HeaderID);
        $this->template->display('potongan_bon/transaksi/index',$data);
    }

    function ajax_get_data_pesanan(){
        $headerID = $this->input->post("headerID");
        $result = $this->M_PotonganBon->_getTrnDetail($headerID);
        echo json_encode($result);
    }

     function ajax_harga(){
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);
        

        $get_harga = $this->M_PotonganBon->get_harga($sub,$item);
        foreach($get_harga as $key){
            echo number_format($key->Harga,0,",",".");
        }
    }

    function ajax_hargaid(){
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_harga = $this->M_PotonganBon->get_harga($sub,$item);
        foreach($get_harga as $key){
            echo $key->DetailHargaID;
        }
    }

    function ajax_satuan(){
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($sub,$item);
        foreach($get_satuan as $key){
            echo $key->SingkatanSatuan;
        }
    }

    function ajax_satuanid(){
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($sub,$item);
        foreach($get_satuan as $key){
            echo $key->SatuanID;
        }
    }

    function ajax_kategori(){
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($sub,$item);
        foreach($get_satuan as $key){
            echo $key->NamaKategori;
        }
    }
    function ajax_kategoriid(){
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($sub,$item);
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
        $sub       = $this->input->post("txtSubPemborong");
        $nofix     = $this->input->post("txtNofix");

        $tanggal_periode = date('j',strtotime($tanggal));

        if($tanggal_periode >= 14 && $tanggal_periode <= 26) {
            $periode = date('Y-m-16',strtotime($tanggal));
        }else{
            if($tanggal_periode == 26 || $tanggal_periode == 27 || $tanggal_periode == 28 || $tanggal_periode == 29 || $tanggal_periode == 30 || $tanggal_periode == 31){
                $bln        = date('m') + 1;
                $periode    = date('Y-0'.$bln.'-1',strtotime($tanggal));
                // echo "OK";
            }else{
                $periode = date('Y-m-1',strtotime($tanggal));
                // echo "lanjut";
            }
        }
        
        $dataHdr = array(
            'Tanggal'       => date('Y-m-d H:i:s',strtotime($tanggal)),
            'PeriodeGajian' => $periode,
            'IDSubPemborong' => $sub,
            'IDPemborong'   => $pemborong,
            'Nofix'         => $nofix,
            'StatusProses'  => 1,
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
              'IDSubPemborong' => $sub,
              'Nofix'       => $nofix,
              'ItemID'      => $item[$i],
              'HargaID'     => $hargaid[$i],
              'Harga'       => str_replace(".", "",$harga[$i]),
              'Quantity'    => $quantity[$i],
              'SatuanID'    => $satuan[$i],
              'KategoriID'  => $kategori[$i],
              'Total'       => str_replace(".", "",$total[$i]),
              'CreatedBy'   => $this->session->userdata('username'),
              'CreatedDate' => date('Y-m-d H:i:s')
            );

            $cek_harga = $this->M_PotonganBon->CekHarga($item[$i],$sub);
            
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
        }

        // KIRIM TELEGRAM

        $user_tel = $this->M_PotonganBon->GetUserTelegram($nofix);
        if($user_tel == NULL){
            echo "Tenaga Kerja Tidak Terdaftar Di Telegram";
        }else{
            $tglMulai = $this->M_PotonganBon->getTanggalMulai($nofix);
            $_getTrnHdr =  $this->M_PotonganBon->getDataTrnHdrTel($nofix,$hdrid);
            $pesan = "INFO POTONGAN SEMBAKO : ".date('d-m-Y',strtotime($_getTrnHdr[0]->Tanggal))."\r\n";

            $_getTrnDtl           = $this->M_PotonganBon->getDataTrnDtlTel($nofix,$hdrid);
            $_getGrndTotalSembako = $this->M_PotonganBon->getDataGrandTotalSembako($nofix,$hdrid);
            $_totalPeriodeIni  = $this->M_PotonganBon->getTotalPeriodeIni($nofix,$periode);
            foreach($tglMulai as $tgl){
                if($tgl->TanggalMulai != NULL){
                    $tgl_mulai = $tgl->TanggalMulai;
                    $_totalCicilanPeriodeIni  = $this->M_PotonganBon->getPotCicilanPeriodeIni($nofix,$tgl_mulai,$periode);
                }else{
                    $tgl_mulai = '';
                     $_totalCicilanPeriodeIni  = $this->M_PotonganBon->getPotCicilanPeriodeIni($nofix,$tgl_mulai,$periode);
                }
            }
            

            $jml = count($_getTrnDtl);
            for ($i=1; $i < $jml; $i++) { 
                foreach($_getTrnDtl as $dtl){
                    $pesan .= "Nama Item : ".$dtl->NamaItem."\r\n".
                                "Quantity : ".$dtl->Quantity." ".$dtl->SingkatanSatuan."\r\n".
                                "Total Harga : Rp.".number_format($dtl->Total,0,",",".")."\r\n";
                    
                }

                foreach($_getGrndTotalSembako as $ttl){
                    $grand = $ttl->GrandTotal;
                    $pesan .= "<strong>Grand : Rp.".number_format($grand,0,",",".")."\r\n";
                }

                $pesan .= "Sisa Periode Lalu : Rp.".number_format($sisa,0,",",".")."\r\n";

                foreach($_totalPeriodeIni as $key){
                    $pot_sembako = $key->Pot_Sembako;
                    $pesan .= "Total Periode Ini : Rp.".number_format($pot_sembako,0,",",".")."\r\n";
                }

                foreach($_totalCicilanPeriodeIni as $row){
                    $pot_cicilan = $row->Pot_Cicilan;
                    $pesan .= "Total Cicilan Periode Ini : Rp.".number_format($pot_cicilan,0,",",".")."\r\n";
                }

                $grand_total = $grand + $sisa + $pot_sembako + $pot_cicilan;
                $pesan .= "Grand Total: Rp.".number_format($grand_total,0,",",".")."</strong>"."\r\n";
            }

            $pesan = trim($pesan,"\r\n");
            $dataTel = array(
                'UserGroupID'   => 0,
                'DataFrom'      => 'Rekrutmen',
                'ToTelegramID'  => $user_tel[0]->TelegramID,
                'FirstName'     => $user_tel[0]->FirstName,
                'Messages'      => $pesan,
                'ImageReport'   => NULL,
                'SendingTime'   => date('Y-m-d H:i:s'),
                'PendingStatus' => 1,
                'SuccessStatus' => 0,
            );

            // echo "<pre>";
            // print_r($dataTel);
            $this->m_monitor->send_info($dataTel);
        }
        redirect('PotonganBon/ordermanual?msg=success');
    }

    function simpan_trn_potongan_pemborong(){

        $hdrid      = $this->input->post("txtHeaderID");
        $tgl        = $this->input->post("txtTanggal");
        $nofix      = $this->input->post("txtNofix");
        $dtlid      = $this->input->post("txtDetailID");
        $pbrid      = $this->input->post("txtPemborong");
        $subpbr     = $this->input->post("txtSubPemborong");
        $item       = $this->input->post("txtItem");
        $harga      = $this->input->post("txtHarga");
        $hargaid    = $this->input->post("txtHargaid");
        $qty        = $this->input->post("txtQuantity");
        $satuan     = $this->input->post("txtSatuanid");
        $kategori   = $this->input->post("txtKategoriid");
        $total      = $this->input->post("txtTotal2");
        $hitung = count($item);

        $dataHdr = array(
            'StatusProses' => 1,
            'UpdateBy'     => $this->session->userdata("username"),
            'UpdateDate'   => date('Y-m-d H:i:s')
        );

        // echo"<pre>";
        // print_r($dataHdr);
        // echo"</pre>";
        $this->M_PotonganBon->update_trn_hdr($hdrid,$dataHdr);

        for ($i=0; $i < $hitung; $i++) { 
            // echo $total[$i];
            $dataDtl = array(
                'HeaderID'      => $hdrid,
                'IDPemborong'   => $pbrid,
                'IDSubPemborong' => $subpbr,
                'Nofix'         => $nofix,
                'ItemID'        => $item[$i],
                'Harga'         => str_replace(".", "",$harga[$i]),
                'HargaID'       => $hargaid[$i],
                'Quantity'      => $qty[$i],
                'SatuanID'      => $satuan[$i],
                'KategoriID'    => $kategori[$i],
                'Total'         => str_replace(".", "",$total[$i]),
                'CreatedBy'     => $this->session->userdata("username"),
                'CreatedDate'   => date('Y-m-d H:i:s')
            );

            // echo "<pre>";
            // print_r($dataDtl);
            $cek_harga = $this->M_PotonganBon->CekHarga($item[$i],$subpbr);
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
                $cek_dtl = $this->M_PotonganBon->cek_dtl($dtlid[$i]);
                if($cek_dtl == NULL){
                    $this->M_PotonganBon->simpan_trn_dtl($dataDtl);
                }else{
                    $this->M_PotonganBon->update_trn_dtl($dtlid[$i],$dataDtl);
                }

                $dataHarga = array(
                    'Harga' => str_replace(".", "",$harga[$i]),
                );

                $this->M_PotonganBon->update_harga($hargaid[$i],$dataHarga);

                $dataHistoryHarga = array(
                  'DetailHargaID' => $hargaid[$i],
                  'HeaderHargaID' => $cek_harga[0]->HeaderHargaID,
                  'IDPemborong'   => $pbrid,
                  'IDSubPemborong' => $subpbr,
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

    function delete($header_id)
    {

        $data = array(
            'DeletedBy'          => $this->session->userdata('username'),
            'DeletedDate'        => date('Y-m-d H:i:s')
        );

        if($this->M_PotonganBon->delete_trn($header_id,$data)){
            $this->session->set_flashdata('success', 'Berhasil menghapus data ...');
        }else{
            $this->session->set_flashdata('error', 'Gagal menghapus data ...');
        }
        redirect('PotonganBon/TransaksiPotonganBon');
    }

    #TRANSAKSI CICILAN
    function Cicilan()
    {
        $data['_getListOrder'] = $this->M_PotonganBon->_getListCicilan();

        $this->template->display('potongan_bon/cicilan/index',$data);
    }

    function tambahCicilan()
    {
        $data['_getDataPemborong']  = $this->M_PotonganBon->SelectMstPemborong();
        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategoriCicilan();
        $data['_getMstSatuan']      = $this->M_PotonganBon->GetMstSatuan();
        $data['_getListItem']       = $this->M_PotonganBon->GetMstCicilan();
        $this->template->display('potongan_bon/cicilan/tambah',$data);
    }

    function ajaxCariTenagaKerja(){
        if($this->input->is_ajax_request()){
            $search = $this->input->post('ajax_kata_kunci');
            $idSubPbr = $this->input->post('ajax_sub_pemborong');
            $data['_getTK'] = $this->M_PotonganBon->CariTKSubPemborong($idSubPbr,$search);
            $this->load->view('potongan_bon/transaksi/list_search',$data);
        }
    }

    function ajaxGetSubPemborong($idPbr = 0)
    {
        if($this->input->is_ajax_request()) {
            $list_sub = $this->M_PotonganBon->selectMstSubPemborong($idPbr);
            $option = "";

            if(count($list_sub) > 0) {
                $option .= "<option value=''>-- Pilih Sub Pemborong --</option>";
                if(count($list_sub) == 1){$sel = 'selected';}else{$sel="";}
                foreach($list_sub as $key=>$sub) {
                    $option .= "<option value='{$sub->IDSubPemborong}' {$sel}>{$sub->NamaSub}</option>";
                }
            }else{
                $option .= "<option value=''>-- Sub Pemborong Tidak Ditemukan --</option>";
            }

            echo $option;
        }
    }
    function ajax_satuanNew(){
        $item = $this->uri->segment(3);

        $get_satuan = $this->M_PotonganBon->get_ItemNew($item);
        foreach($get_satuan as $key){
            echo $key->SingkatanSatuan;
        }
    }

    function ajax_satuanidNew(){
        $item = $this->uri->segment(3);

        $get_satuan = $this->M_PotonganBon->get_ItemNew($item);
        foreach($get_satuan as $key){
            echo $key->SatuanID;
        }
    }

    function ajax_kategoriNew(){
        $item = $this->uri->segment(3);

        $get_satuan = $this->M_PotonganBon->get_ItemNew($item);
        foreach($get_satuan as $key){
            echo $key->NamaKategori;
        }
    }
    function ajax_kategoriidNew(){
        $item = $this->uri->segment(3);

        $get_satuan = $this->M_PotonganBon->get_ItemNew($item);
        foreach($get_satuan as $key){
            echo $key->KategoriCicilanID;
        }
    }

    function ajax_list_item_cicilan(){
        $pbr   = $this->uri->segment(3);
        $sub   = $this->uri->segment(4);

        $data['_getListItem'] = $this->M_PotonganBon->GetTrnListItem($pbr);
        $data['pemborong'] = $pbr;
        $this->load->view("potongan_bon/transaksi/mstListItem",$data);

    }

    function simpan_trn_cicilan(){
        // Header
         // echo"<pre>";
         // print_r($this->input->post());
         // echo"</pre>";

        $tanggal   = $this->input->post("txtTanggal");
        $pemborong = $this->input->post("txtPemborong");
        $sub_pbr   = $this->input->post('txtSubPemborong');
        $nofix     = $this->input->post("txtNofix");


        $tanggal_periode = date('j',strtotime($tanggal));

        if($tanggal_periode >= 14 && $tanggal_periode <= 26) {
            $periode = date('Y-m-16',strtotime($tanggal));
        }else{
            if($tanggal_periode == 26 || $tanggal_periode == 27 || $tanggal_periode == 28 || $tanggal_periode == 29 || $tanggal_periode == 30 || $tanggal_periode == 31){
                $bln        = date('m') + 1;
                $periode    = date('Y-0'.$bln.'-1',strtotime($tanggal));
                // echo "OK";
            }else{
                $periode = date('Y-m-1',strtotime($tanggal));
                // echo "lanjut";
            }
        }

        $dataHdr = array(
            'Tanggal' => date('Y-m-d H:i:s', strtotime($tanggal)),
            'IDPemborong' => $pemborong,
            'IDSubPemborong' => $sub_pbr,
            'PeriodeGajian' => $periode,
            'Nofix' => $nofix,
            'StatusProses' => 1,
            'CreatedBy' => $this->session->userdata('username'),
            'CreatedDate' => date('Y-m-d H:i:s')
        );

        if($nofix == NULL){
            redirect('PotonganBon/tambahCicilan?msg=failed2');
        }else{
            $hdrid = $this->M_PotonganBon->simpan_cicilan_hdr($dataHdr); // Simpan Header

            $item = $this->input->post('txtItem');
            $harga = $this->input->post('txtHarga');
            $dp = $this->input->post('txtDp');
            $quantity = $this->input->post('txtQuantity');
            $satuan = $this->input->post('txtSatuanid');
            $kategori = $this->input->post('txtKategoriid');
            $periode = $this->input->post('txtPeriode');
            $mulai = $this->input->post('txtMulai');
            $periodepotong = $this->input->post('txtperiodepotong');
            $total = $this->input->post('txtTotal');
            $hitung = count($item);

            for ($i = 0; $i < $hitung; $i++) {
                // Cek apakah item id Numeric atau bukan => Jika bukan insert data master cicilan
                $item_id = $item[$i];
                if(!is_numeric($item_id)) {
                    $kode = $this->M_PotonganBon->GetKodeItemCicilan();
                    $kode_item = sprintf("%05s",($kode+1));
                    $data_item_cicilan = [
                        'KodeCicilanID'     => $kode_item,
                        'NamaCicilan'       => $item[$i],
                        'SatuanID'          => $satuan[$i],
                        'KategoriCicilanID' => $kategori[$i],
                        'CreatedBy'         => $this->session->userdata('username'),
                        'CreatedDate'       => date('Y-m-d H:i:s')
                    ];

                    $item_id = $this->M_PotonganBon->simpan_mst_item_cicilan($data_item_cicilan);
                }
                $tanggal_ = date('j',strtotime($mulai[$i]));

                if($tanggal_ >= 14 && $tanggal_ <= 26) {
                    $tanggalMulai[$i] = date('Y-m-16',strtotime($mulai[$i]));
                }else{
                    if($tanggal_ == 26 || $tanggal_ == 27 || $tanggal_ == 28 || $tanggal_ == 29 || $tanggal_ == 30 || $tanggal_ == 31){
                        $bln        = date('m') + 1;
                        $tanggalMulai[$i]    = date('Y-0'.$bln.'-1',strtotime($mulai[$i]));
                        // echo "OK";
                    }else{
                        $tanggalMulai[$i] = date('Y-m-1',strtotime($mulai[$i]));
                        // echo "lanjut";
                    }
                }
                $dataDtl = array(
                    'HeaderID'          => $hdrid,
                    'IDPemborong'       => $pemborong,
                    'IDSubPemborong'    => $sub_pbr,
                    'Nofix'             => $nofix,
                    'DP'                => $dp[$i],
                    'CicilanID'         => $item_id,
                    'Harga'             => str_replace(".", "", $harga[$i]),
                    'Quantity'          => $quantity[$i],
                    'SatuanID'          => $satuan[$i],
                    'KategoriCicilanID' => $kategori[$i],
                    'Cicilan'           => $periode[$i],
                    'TanggalMulai'      => date('Y-m-d',strtotime($tanggalMulai[$i])),
                    'PeriodeDipotong'   => $periodepotong[$i],
                    'HargaCicilan'      => $total[$i],
                    'CreatedBy'         => $this->session->userdata('username'),
                    'CreatedDate'       => date('Y-m-d H:i:s')
                );

                // jika Harga tidak sama :
                // echo "<pre>";
                // print_r($dataDtl);
                $cek_transaksiDtl = $this->M_PotonganBon->cek_transaksiDtl($nofix,$kategori[$i],$satuan[$i],$item_id[$i]);
                if($cek_transaksiDtl != NULL){
                    redirect('PotonganBon/tambahCicilan?msg=failed3');
                }else{
                    $this->M_PotonganBon->simpan_cicilan_dtl($dataDtl);
                }

                $user_tel = $this->M_PotonganBon->GetUserTelegram($nofix);
                if($user_tel == NULL){
                    echo "Tenaga Kerja Tidak Memiliki Telegram";
                }else{
                    $pesan = "INFO POTONGAN CICILAN : \r\n";
                    $_getDtlCicilan = $this->M_PotonganBon->get_detail_cicilan($nofix,$hdrid);

                    $jml = count($_getDtlCicilan);
                    for ($i= 1; $i < $jml; $i++) { 
                        foreach ($_getDtlCicilan as $get) {
                            if($get->PeriodeDipotong == 1){
                                $dipotong = 1;
                            }elseif($get->PeriodeDipotong == 2){
                                $dipotong = 2;
                            }else{
                                $dipotong = "1 dan 2";
                            }
                            $pesan .= "Nama Item : ".$get->NamaCicilan."\r\n".
                                    "Harga Full : Rp.".number_format($get->Harga,0,",",".")."\r\n".
                                    "DP : Rp. ".number_format($get->DP,0,",",".")."\r\n".
                                    "(x) Dipotong : ".$get->Cicilan."x"."\r\n".
                                    "Dipotong Periode : ".$dipotong."\r\n".
                                    "Nominal Pemotongan : Rp.".number_format($get->HargaCicilan,0,",",".")."\r\n";
                        }
                    }

                    $pesan = trim($pesan,"\r\n");
                    $dataTel = array(
                        'UserGroupID'   => 0,
                        'DataFrom'      => 'Rekrutmen',
                        'ToTelegramID'  => $user_tel[0]->TelegramID,
                        'FirstName'     => $user_tel[0]->FirstName,
                        'Messages'      => $pesan,
                        'ImageReport'   => NULL,
                        'SendingTime'   => date('Y-m-d H:i:s'),
                        'PendingStatus' => 1,
                        'SuccessStatus' => 0,
                    );

                    // echo "<pre>";
                    // print_r($dataTel);
                    $this->m_monitor->send_info($dataTel);
                }


                // $dataHistoryHarga = array(
                //     'IDPemborong' => $pemborong,
                //     'ItemID' => $item_id,
                //     'SatuanID' => $satuan[$i],
                //     'KategoriID' => $kategori[$i],
                //     'Harga' => $harga[$i],
                //     'CreatedBy' => $this->session->userdata('username'),
                //     'CreatedDate' => date('Y-m-d H:i:s')
                // );

                #$this->M_PotonganBon->simpan_history_cicilan($dataHistoryHarga);

            }

            redirect('PotonganBon/Cicilan?msg=success');
        }
    }
   function lihat_pesanan_cicilan(){
        $tanggal = $this->uri->segment(3);
        $nofix = $this->uri->segment(4);
        $sub_pbr = $this->uri->segment(5);
       $id = $this->uri->segment(6);

        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategoriCicilan();
        $data['_getMstSatuan']      = $this->M_PotonganBon->GetMstSatuan();
        $data['_getListItem']       = $this->M_PotonganBon->GetMstCicilan();

        // Data yang sudah ada
        $data['_getTrnHeader']      = $this->M_PotonganBon->_getTrnHDR($tanggal,$nofix,$sub_pbr,$id);
        $_trnHeader = $data['_getTrnHeader'];
        $data['_getTrnDetail']      = $this->M_PotonganBon->_getTrnDTL($_trnHeader[0]->HeaderID);
        $data['_getGrandTotal'] = $this->M_PotonganBon->_getGrandTotalCicilan($_trnHeader[0]->HeaderID);

        $this->template->display('potongan_bon/cicilan/proses',$data);
    }

    function HapusCicilan($header_id)
    {

        $data = array(
            'DeletedBy'          => $this->session->userdata('username'),
            'DeletedDate'        => date('Y-m-d H:i:s')
        );

        if($this->M_PotonganBon->delete_trn_cicilan($header_id,$data)){
            $this->session->set_flashdata('success', 'Berhasil menghapus data ...');
        }else{
            $this->session->set_flashdata('error', 'Gagal menghapus data ...');
        }
        redirect('PotonganBon/Cicilan');
    }

    function simpan_trn_potongan_cicilan(){
       $hdrid      = $this->input->post("txtHeaderID");
       $tgl        = $this->input->post("txtTanggal");
       $nofix      = $this->input->post("txtNofix");
       $pbrid      = $this->input->post("txtPemborong");
       $subpbrid   = $this->input->post('txtSubPemborong');

       // Detail
       $dtlid      = $this->input->post("txtDetailID");
       $item       = $this->input->post("txtItem");
       $harga      = $this->input->post("txtHarga");
       $dp         = $this->input->post("txtDp");
       $qty        = $this->input->post("txtQuantity");
       $satuan     = $this->input->post("txtSatuanid");
       $kategori   = $this->input->post("txtKategoriid");
       $periode    = $this->input->post("txtPeriode");
       $mulai      = $this->input->post("txtMulai");
       $periodepotong = $this->input->post('txtperiodepotong');
       $total      = $this->input->post("txtTotal");
       $hitung = count($harga);

       $dataHdr = array(
           'StatusProses' => 1,
           'UpdatedBy'     => $this->session->userdata("username"),
           'UpdatedDate'   => date('Y-m-d H:i:s')
       );

       $this->M_PotonganBon->update_cicilan_hdr($hdrid,$dataHdr);

        for ($i= 0; $i < $hitung; $i++) {
           // echo $periodepotong[$i];
            if(!empty($dtlid[$i])){
                $tanggal_ = date('j',strtotime($Mulai[$i]));

                if($tanggal_ >= 14 && $tanggal_ <= 26) {
                    $tanggalMulai[$i] = date('Y-m-16',strtotime($Mulai[$i]));
                }else{
                    if($tanggal_ == 26 || $tanggal_ == 27 || $tanggal_ == 28 || $tanggal_ == 29 || $tanggal_ == 30 || $tanggal_ == 31){
                        $bln        = date('m') + 1;
                        $tanggalMulai[$i]    = date('Y-0'.$bln.'-1',strtotime($Mulai[$i]));
                        // echo "OK";
                    }else{
                        $tanggalMulai[$i] = date('Y-m-1',strtotime($Mulai[$i]));
                        // echo "lanjut";
                    }
                }
                   $dataDtl = array(
                       'Harga' => $harga[$i],
                       'DP' => $dp[$i],
                       'Quantity' => $qty[$i],
                       'Cicilan' => $periode[$i],
                       'TanggalMulai' => $tanggalMulai[$i],
                       'HargaCicilan' => $total[$i],
                       'PeriodeDipotong' => $periodepotong[$i],
                       // 'CreatedBy' => $this->session->userdata('username'),
                       // 'CreatedDate' => date('Y-m-d H:i:s')
                   );
                   $this->M_PotonganBon->update_cicilan_dtl($dtlid[$i],$dataDtl);
            }else{
                // Cek apakah item id Numeric atau bukan => Jika bukan insert data master cicilan
                // echo $item[$i];
               $item_id = $item[$i];
               if(!is_numeric($item_id)) {
                   $kode = $this->M_PotonganBon->GetKodeItemCicilan();
                   $kode_item = sprintf("%05s",($kode+1));
                   $data_item_cicilan = [
                       'KodeCicilanID' => $kode_item,
                       'NamaCicilan' => $item[$i],
                       'SatuanID' => $satuan[$i],
                       'KategoriCicilanID' => $kategori[$i],
                       'CreatedBy' => $this->session->userdata('username'),
                       'CreatedDate' => date('Y-m-d H:i:s')
                   ];

                   $item[$i] = $this->M_PotonganBon->simpan_mst_item_cicilan($data_item_cicilan);
               }
                $tanggal_ = date('j',strtotime($Mulai[$i]));

                if($tanggal_ >= 14 && $tanggal_ <= 26) {
                    $tanggalMulai[$i] = date('Y-m-16',strtotime($Mulai[$i]));
                }else{
                    if($tanggal_ == 26 || $tanggal_ == 27 || $tanggal_ == 28 || $tanggal_ == 29 || $tanggal_ == 30 || $tanggal_ == 31){
                        $bln        = date('m') + 1;
                        $tanggalMulai[$i]    = date('Y-0'.$bln.'-1',strtotime($Mulai[$i]));
                        // echo "OK";
                    }else{
                        $tanggalMulai[$i] = date('Y-m-1',strtotime($Mulai[$i]));
                        // echo "lanjut";
                    }
                }
               $dataDtl = array(
                   'HeaderID' => $hdrid,
                   'IDPemborong' => $pbrid,
                   'IDSubPemborong' => $subpbrid,
                   'Nofix' => $nofix,
                   'CicilanID' => $item[$i],
                   'Harga' => str_replace(".", "", $harga[$i]),
                   'DP' => $dp[$i],
                   'Quantity' => $qty[$i],
                   'SatuanID' => $satuan[$i],
                   'KategoriCicilanID' => $kategori[$i],
                   'Cicilan' => $periode[$i],
                   'TanggalMulai' => $tanggalMulai[$i],
                   'HargaCicilan' => $total[$i],
                   'PeriodeDipotong' => $periodepotong[$i],
                   'CreatedBy' => $this->session->userdata('username'),
                   'CreatedDate' => date('Y-m-d H:i:s')
               );
               // echo $periodepotong[$i];
               $this->M_PotonganBon->simpan_cicilan_dtl($dataDtl);
            }

           
        }
       redirect("PotonganBon/Cicilan?msg=success");
    }
    #end transaksi cicilan

    #TRANSAKSI AKHIR

    function TransaksiAkhir()
    {
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();
        $data['_searchHistory'] = $this->session->userdata('_searchTA');

        $this->template->display('potongan_bon/finish/index',$data);
    }

    function ajax_data_transaksi(){
        $pbr        = $this->input->post('ajax_pbr');
        $subpbr     = $this->input->post('ajax_sub_pbr');
        $periode    = $this->input->post('ajax_periode');
        $bln        = $this->input->post('ajax_bulan');
        $bln        = str_pad($bln,2,'0',STR_PAD_LEFT);
        $thn        = $this->input->post('ajax_tahun');

        // Keep History Search
        $this->session->set_userdata('_searchTA',$this->input->post());

        if($periode == 1){
            // Periode 1
            $tglAwal  = date($thn.'-'.$bln.'-01');
            $tglAkhir = date($thn.'-'.$bln.'-d', strtotime('+14 days', strtotime($tglAwal)));

            if($bln == 1) {
                $periodeSebelumnnya = ($thn-1).'1202';
            }else{
                $periodeSebelumnnya = $thn.str_pad($bln - 1,2,'0',STR_PAD_LEFT).'02';
            }

        }else{
            // Periode 2
            $tglAwal  = date($thn.'-'.$bln.'-16');
            $tglAkhir = date('Y-m-t',strtotime($thn.'-'.$bln.'-16'));
            $periodeSebelumnnya = $thn.$bln.'01';
        }

        // Potongan Periode Ini
        $data['_getData'] = $this->M_PotonganBon->GetListTransaksiAkhir($pbr,$subpbr,$tglAwal,$tglAkhir,$periodeSebelumnnya);

        // Sisa Potongan Periode Lalu

        $data['periode'] = $periode;
        $data['tglAwal'] = $tglAwal;
        $data['tglAkhir'] = $tglAkhir;
        $this->load->view('potongan_bon/finish/list',$data);
    }

    function TransaksiAkhir_seleksi()
    {
        $NoFix = $this->uri->segment(3);
        $TanggalMulai = $this->uri->segment(4);
        $TanggalAkhir = $this->uri->segment(5);
        $periode = $this->uri->segment(6);
        $data['_periode'] = $this->uri->segment(6);

        $thn = date('Y',strtotime($TanggalMulai));
        $bln = date('n',strtotime($TanggalMulai));
        if($periode == 1){
            if($bln == 1) {
                $periodeSebelumnnya = ($thn-1).'1202';
            }else{
                $periodeSebelumnnya = $thn.str_pad($bln - 1,2,'0',STR_PAD_LEFT).'02';
            }

        }else{
            // Periode 2
            $periodeSebelumnnya = $thn.str_pad($bln,2,'0',STR_PAD_LEFT).'01';
        }
        echo $periodeSebelumnnya;
        $data['_getInfo'] = $this->M_PotonganBon->GetInfoTransaksiAkhir($NoFix);
        $data['_getDataDetail'] = $this->M_PotonganBon->GetViewTransaksiAkhir($NoFix,$TanggalMulai,$TanggalAkhir);
        $data['_getSisaDetail'] = $this->M_PotonganBon->GetSisaTransaksiAkhir($NoFix,$periodeSebelumnnya);

        $this->template->display('potongan_bon/finish/seleksi',$data);
    }

    function TransaksiAkhir_simpan()
    {
        $this->db->trans_begin();

        $periode = $this->input->post('txtPeriode');

        // YYYYMMPP ( Y tahun, M bulan, P periode )
        $periode = date('Ym',strtotime($this->input->post('txtTanggal'))) . str_pad($periode,2,'0',STR_PAD_LEFT);
        $dataHeader = [
            'Tanggal' => $this->input->post('txtTanggal'),
            'Nofix' => $this->input->post('txtNofix'),
            'IDPemborong' => $this->input->post('txtPemborong'),
            'IDSubPemborong' => $this->input->post('txtSubPemborong'),
            'Periode' => $periode,
            'CreatedBy' => $this->session->userdata('username'),
            'CreatedDate' => date('Y-m-d H:i:s')
        ];

        // Fungsi Simpan Header
        $header_id = $this->M_PotonganBon->simpanHeaderTransaksiAkhir($dataHeader);

        // Fungsi Simpan Detail
        $detailId = $this->input->post('txtDetailID');
        $type = $this->input->post('txtType');
        $itemId = $this->input->post('txtItemID');
        $hargaFull = $this->input->post('txtHargaFull');
        $dp = $this->input->post('txtDP');
        $cicilan = $this->input->post('txtCicilan');
        $cicilan_ke = $this->input->post('txtCicilanKe');
        $quantity = $this->input->post('txtQuantity');
        $satuanId = $this->input->post('txtSatuanID');
        $kategoriId = $this->input->post('txtKategoriID');
        $total = $this->input->post('txtTotal');
        $real = $this->input->post('txtReal');
        $sisa = $this->input->post('txtSisa');
        // Apakah Detail ini Merupakan Sisa dari Periode Lalu
        $statusSisa = $this->input->post('txtStatusSisa');

        for($i=0;$i<count($detailId);$i++){
            $dtDetail = [
                'HeaderID' => $header_id,
                'ItemID' => $itemId[$i],
                'SatuanID' => $satuanId[$i],
                'KategoriID' => $kategoriId[$i],
                'HargaFull' => $hargaFull[$i],
                'Quantity' => $quantity[$i],
                'Cicilan' => ($cicilan[$i]) ? $cicilan[$i] : null,
                'CicilanKe' => ($cicilan_ke[$i]) ? $cicilan_ke[$i] : null,
                'DP' => ($dp[$i]) ? $dp[$i] : null,
                'Total' => $total[$i],
                'Type' => $type[$i],
                'Realisasi' => $real[$i],
                'IDDtlProses' => $detailId[$i] ,
                'Sisa' => $sisa[$i],
                'StatusSisa' => $statusSisa[$i]
            ];

            $this->M_PotonganBon->simpanDetailTransaksiAkhir($dtDetail);
        }

        // Status Proses Sisa jadi 1
        $aSisaID = $this->input->post('txtSisaID');
        foreach($aSisaID as $sisaId) {
            $data = [
                'StatusProsesSisa' => '1'
            ];
            $this->M_PotonganBon->updateDetailTransaksiAkhir($sisaId,$data);
        }
        //make transaction complete

        //check if transaction status TRUE or FALSE
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        redirect('PotonganBon/TransaksiAkhir');
    }

    function TransaksiAkhir_komplit(){
        $NoFix = $this->uri->segment(3);
        $TanggalMulai = $this->uri->segment(4);
        $TanggalAkhir = $this->uri->segment(5);
        $periode = $this->uri->segment(6);
        $data['_periode'] = $periode;
        $data['_getHeader'] = $this->M_PotonganBon->GetHeaderTransaksiAkhir($NoFix,$periode);
        if(!empty($data['_getHeader'])) {
            $data['_getDataDetail'] = $this->M_PotonganBon->GetDetailTransaksiAkhir($data['_getHeader']->HeaderID);
            $this->template->display('potongan_bon/finish/komplit',$data);
        }else{
            redirect('PotonganBon/TransaksiAkhir');
        }

    }

    function TransaksiAkhir_update(){
        $this->db->trans_begin();

        $header_id = $this->input->post('txtHeaderID');
        $dataHeader = [
            'StatusKomplit' => '1',
            'UpdatedBy' => $this->session->userdata('username'),
            'UpdatedDate' => date('Y-m-d H:i:s'),
            'CompletedBy' => $this->session->userdata('username'),
            'CompletedDate' => date('Y-m-d H:i:s')
        ];

        // Fungsi Update Header
        $this->M_PotonganBon->updateHeaderTransaksiAkhir($header_id,$dataHeader);

        // Fungsi Update Detail
        $detailAkhirId = $this->input->post('txtIDDtlAkhir');
        $real = $this->input->post('txtReal');
        $sisa = $this->input->post('txtSisa');
        $detailProsesId = $this->input->post('txtIDDtlProses');
        $type = $this->input->post('txtType');
        $statusSisa = $this->input->post('txtStatusSisa');

        for($i=0;$i<count($detailAkhirId);$i++){
            $dtDetail = [
                'Realisasi' => $real[$i],
                'Sisa' => $sisa[$i]
            ];

            if($type[$i] == 'Cicilan' && $statusSisa[$i] != 1) {
                // Buat Cicilan Setelahnya
                $data_cicilan = $this->M_PotonganBon->getDetailCicilanByID($detailProsesId[$i]);
                if($data_cicilan){
                    if($data_cicilan['Cicilan'] > $data_cicilan['CicilanKe'])
                    {
                        unset($data_cicilan['DetailID']);
                        $data_cicilan['CicilanKe'] += 1;
                        $data_cicilan['CreatedBy'] = 'SYSTEM';
                        $data_cicilan['CreatedDate'] = date('Y-m-d H:i:s');
                        $tgl_mulai = date('j',strtotime($data_cicilan['TanggalMulai']));
                        if($tgl_mulai >= 1 && $tgl_mulai <= 15) {
                            $data_cicilan['TanggalMulai'] = date('Y-m-16',strtotime($data_cicilan['TanggalMulai']));
                        }else{
                            $data_cicilan['TanggalMulai'] = date('Y-m-01',strtotime($data_cicilan['TanggalMulai'].' +16 days'));
                        }

                        $this->M_PotonganBon->simpan_cicilan_dtl($data_cicilan);
                    }
                }
            }


            $this->M_PotonganBon->updateDetailTransaksiAkhir($detailAkhirId[$i],$dtDetail);


        }

        //check if transaction status TRUE or FALSE
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

         redirect('PotonganBon/TransaksiAkhir');
    }
    
    // END TRANSAKSI AKHIR

    function TransaksisemuaKategori()
    {
        $nofix        = $this->uri->segment(3);
        
        $data['_getData'] = $this->M_PotonganBon->GetTransaksiFull($nofix);

        $this->template->display('potongan_bon/finish/action',$data);
    }
    // BEGIN :: MONITORING POTONGAN PEMBORONG

    function MonitoringPotongan(){

         $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborongNew();
         $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
         
        $this->template->display('potongan_bon/monitoring/index',$data);
    }

    function MntSub($pbr)
    {
        $data['_getDataSub']    = $this->M_PotonganBon->getMstSub($pbr);
        $this->load->view('potongan_bon/monitoring/sub',$data);
    }

    function ajax_data_potongan(){
        $pbr        = $this->uri->segment(3);
        $sub        = $this->uri->segment(4);
        $periode    = $this->uri->segment(5);
        $bln        = $this->uri->segment(6);
        $thn        = $this->uri->segment(7);

        $periode = str_pad($periode,2,'0',STR_PAD_LEFT);
        $bln = str_pad($bln,2,'0',STR_PAD_LEFT);

        $periode1  = $thn.$bln.$periode;
        $periode2  = $thn.'-'.$bln.'-'.$periode;

        // echo $periode1;

        if($periode == 01){
            $data['_getDataSub'] = $this->M_PotonganBon->getDataCampuranSub($pbr,$sub,$periode1);
            $cicilan = $this->M_PotonganBon->cicilan($pbr,$sub);
            $data['Periode'] = $periode2;

            if(!empty($cicilan)){
                foreach($cicilan as $key){
                    // echo "wkwkw1";
                    $data['tglMulai'] = $key->TanggalMulai;
                    $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan($pbr,$sub,$periode2,$key->TanggalMulai);
                    $data['Periode'] = $periode2;
                    $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr,$sub,$periode2);
                    $this->load->view('potongan_bon/monitoring/list',$data);
//                    echo "<pre>";
//                    print_r($data['_getDataCicilan']);
//                    echo "</pre>";
                }
            }else{
                // echo "haha1";
                $tglMulai = '';
                $data['tglMulai'] = $tglMulai;
                $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr,$sub,$periode2);
                $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan($pbr,$sub,$periode2,$tglMulai);

                $this->load->view('potongan_bon/monitoring/list',$data);
            }
            //
        }elseif($periode == 16){
            $data['_getDataSub'] = $this->M_PotonganBon->getDataCampuranSub($pbr,$sub,$periode2);
            $cicilan = $this->M_PotonganBon->cicilan($pbr,$sub);
            $data['Periode'] = $periode2;

            if(!empty($cicilan)){
                foreach($cicilan as $key){
                    // echo "wkwkw1";
                    $data['tglMulai'] = $key->TanggalMulai;
                    $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan($pbr,$sub,$periode2,$key->TanggalMulai);
                    $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr,$sub,$periode2);
                    $this->load->view('potongan_bon/monitoring/list',$data);

                }
            }else{
                // echo "haha1";
                $tglMulai = '';
                $data['tglMulai'] = $tglMulai;
                $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr,$sub,$periode2);
                $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan($pbr,$sub,$periode2,$tglMulai);

                $this->load->view('potongan_bon/monitoring/list',$data);
            }
        }

    }

    function detailSisaCicilan(){
     $nofix = $this->uri->segment(3);
     $periode = $this->uri->segment(4);

     $data['_getDataTrnHdr'] = $this->M_PotonganBon->getDataTrnHdr($nofix,$periode);
     $data['_getDataDetailSisaCicilan'] = $this->M_PotonganBon->getDetailSisaCicilan($nofix,$periode);
     $data['_getTotalDetail'] = $this->M_PotonganBon->getDetailTotal($nofix,$periode);

     $this->template->display('potongan_bon/monitoring/detail_sisa_cicilan',$data);
   }

    function get_detail_potongan(){
        $nofix = $this->uri->segment(3);
        $hdrid = $this->uri->segment(4);
        

        $data['_getDataTrnHdr'] = $this->M_PotonganBon->getDataTrnHdr($nofix,$hdrid);
        $data['_getDataTrnTanggal'] = $this->M_PotonganBon->getDataTrnTanggal($nofix,$hdrid);
        $data['_getDataTrnDtl'] = $this->M_PotonganBon->getDataTrnDtl($nofix,$hdrid);
        $data['_getDataTotalSem'] = $this->M_PotonganBon->getDataTotalSembako($nofix,$hdrid);
        $data['_getDataTotalCic'] = $this->M_PotonganBon->getDataTotalCicilan($nofix,$hdrid);
        $data['_getDataTrnTotal'] = $this->M_PotonganBon->getDataTrnTotal($nofix,$hdrid);
        $data['_getDataKategori'] = $this->M_PotonganBon->GetMstKategoriCicilan();

        // echo"<pre>";
        // print_r($data['_getDataTrnDtl']);
        // echo"</pre>";
        $this->template->display('potongan_bon/monitoring/detail',$data);
    }

    function detail_potongan_sembako()
    {
        $nofix = $this->uri->segment(3);
        $periode = $this->uri->segment(4);

        

        $data['_getDataTrnHdr'] = $this->M_PotonganBon->getDataTrnHdr($nofix,$periode);
        $data['_getDataTotalSem'] = $this->M_PotonganBon->totalsembako($nofix,$periode);
        $data['_getDataTotalSem1'] = $this->M_PotonganBon->getDataTotalSembako($nofix,$periode);
        

        $this->template->display('potongan_bon/monitoring/list_detail_sembako',$data);
    }

    function detail_potongan_cicilan()
    {
        $nofix = $this->uri->segment(3);
        $periode = $this->uri->segment(4);
        $tglmulai = $this->uri->segment(5);


        $data['_getDataTrnHdr'] = $this->M_PotonganBon->getDataTrnHdr($nofix,$periode);
        $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilanDetail($nofix,$periode,$tglmulai);
        $data['_getDataTotalCic'] = $this->M_PotonganBon->getDataTotalCicilan($nofix,$periode,$tglmulai);


        $this->template->display('potongan_bon/monitoring/list_detail_cicilan',$data);
    }

    function detail_potongan_sisa()
    {
        $nofix = $this->uri->segment(3);
        $hdrid = $this->uri->segment(4);
        

        $data['_getDataTrnHdr'] = $this->M_PotonganBon->getDataTrnHdr($nofix,$hdrid);
        $data['_getDataTrnTanggal'] = $this->M_PotonganBon->getDataTrnTanggal($nofix,$hdrid);
        $data['_getDataTrnDtl'] = $this->M_PotonganBon->getDataTrnDtl($nofix,$hdrid);
        $data['_getDataTotalSisa'] = $this->M_PotonganBon->getDataTotalSisa($nofix,$hdrid);
        
        

        $this->template->display('potongan_bon/monitoring/list_detail_sisa',$data);
    }

    function EksportExcelByNofix()
    {
        $this->load->library("Excel/PHPExcel");
        $nofix = $this->uri->segment(3);
        $periode = $this->uri->segment(4);

        $data['getDataPemborong']    = $this->M_PotonganBon->excelByNofix($nofix,$periode);
        $data['getDataKaryawan'] = $this->M_PotonganBon->dataNama($nofix,$periode);
        // echo "<pre>";
        // print_r($data['getDataPemborong']);
        // echo"</pre>";
        $this->load->view('potongan_bon/monitoring/ExcelByNofix',$data);
    }

    function EksportExcelBySub()
    {
        $this->load->library("Excel/PHPExcel");
        $pbr        = $this->uri->segment(3);
        $sub        = $this->uri->segment(4);
        $periode    = $this->uri->segment(5);

        $data['getDataMonitor']    = $this->M_PotonganBon->getDataMonitoringBySub($pbr,$sub,$periode);
        // echo "<pre>";
        // print_r($data['getDataMonitor']);
        // echo"</pre>";
        $this->load->view('potongan_bon/monitoring/ExcelBySub',$data);
    }
    // END :: MONITORING POTONG PEMBORONG

    #History harga 
    function history()
    {
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();
        $this->template->display('potongan_bon/history/index',$data);
    }

    function getDataPerPemborong()
    {
        $pbr = $this->uri->segment(3);

        $data['getdatahistory'] = $this->M_PotonganBon->getDataPerPemborong($pbr);
        #echo"<pre>";
        #print_r($data['getdatahistory']);
        #echo"</pre>";
        $this->load->view('potongan_bon/history/list',$data);
    }

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

    function update_subpemborong(){
        
        $idfix = $this->input->post('txtNofix');
        $subpbr = $this->input->post('txtSubPemborong');

        $data = array(
            'IDSubPemborong'        => $subpbr
        );

        $id = implode("','",$idfix);


        $this->M_PotonganBon->save_tenagaKerja($id,$data);
         redirect('PotonganBon/MstTK?msg=success');
    }

    function ajax_sub($pbr)
    {
        $data['_getTK']    = $this->M_PotonganBon->getMstSubdaripemborong($pbr);
      $this->load->view('potongan_bon/master/tenaga_kerja/sub',$data);
    }

    #monitoring tenaga kerja

    function monitorTK(){

        $pbr =$this->input->post('IDPemborong');
        $sub = $this->input->post('IDSubPemborong');

        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();
        $data['_getTK']    = $this->M_PotonganBon->getTK_bySubPemborong($pbr,$sub);
      $this->template->display('potongan_bon/master/tenaga_kerja/monitoring',$data);
    }

    function ajax_subpbr2($pbr)
    {
        $data['_getDataSub']    = $this->M_PotonganBon->getMstSub($pbr);
      $this->load->view('potongan_bon/master/tenaga_kerja/sub2',$data);
    }

     function ajax_TenagaKerja($pbr,$sub){

        $data['_getTK']    = $this->M_PotonganBon->getTK_bySubPemborong($pbr,$sub);
        $this->load->view('potongan_bon/master/tenaga_kerja/listTenagaKerja',$data);
    }

     function MonitorHarga()
    {
        
        $data['_getData'] = $this->M_PotonganBon->monitorHarga();
        
        $this->template->display('potongan_bon/master/harga/monitoring',$data);
    }

    function ajaxMonitorHarga()
    {
        $tanggal = $this->uri->segment(3);

        $data['tanggal'] = $tanggal;

        $data['getDataPemborong']    = $this->M_PotonganBon->monitorHargaPemborong($tanggal);

        // echo"<pre>";
        // print_r($data['getDataPemborong']);
        // echo"</pre>";

        $this->load->view('potongan_bon/master/harga/list',$data);
    }

    function EksportExcel()
    {
        $this->load->library("Excel/PHPExcel");
        $data['_getData'] = $this->M_PotonganBon->monitorHarga();

        $this->load->view('potongan_bon/master/harga/ExcelIndex',$data);
    }

    function EksportExcelList()
    {
        $this->load->library("Excel/PHPExcel");
        $tanggal = $this->uri->segment(3);

        $data['getDataPemborong']    = $this->M_PotonganBon->monitorHargaPemborong($tanggal);

        $this->load->view('potongan_bon/master/harga/ExcelList',$data);
    }

    // MONITORING HARGA PER SUB UNTUK DI TAMPILKAN DI PBR INTI 

    function Mnt_Harga(){
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborongNew();
        $this->template->display('potongan_bon/monitoring/harga/index',$data);
    }

    function ajaxSubPemborong(){
        $pbr = $this->uri->segment(3);

        $data['_getSubPemborong'] = $this->M_PotonganBon->_getSubPemborong($pbr);

        $this->load->view('potongan_bon/monitoring/harga/ajax/sub',$data);
    }

    function ajaxListDataMntHarga(){
        $pbr = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $data['_getListMntHarga'] = $this->M_PotonganBon->_getListMntHarga($pbr,$sub);

        $this->load->view('potongan_bon/monitoring/harga/ajax/listHarga',$data);
    }

    // MONITORING POTONGAN BON PER SUB

    function Mnt_Pot_Bon(){
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $this->template->display('potongan_bon/monitoring/pot_bon/index',$data);
    }

    function ajax_mnt_data_potongan(){
        $pbr        = $this->uri->segment(3);
        $sub        = $this->uri->segment(4);
        $periode    = $this->uri->segment(5);
        $bln        = $this->uri->segment(6);
        $thn        = $this->uri->segment(7);

        $periode = str_pad($periode,2,'0',STR_PAD_LEFT);
        $bln = str_pad($bln,2,'0',STR_PAD_LEFT);

        $periode1  = $thn.$bln.$periode;
        $periode2  = $thn.'-'.$bln.'-'.$periode;

        // echo $periode1;

        if($periode == 01){
            $data['_getDataSub'] = $this->M_PotonganBon->getDataCampuranSub($pbr,$sub,$periode1);
            $cicilan = $this->M_PotonganBon->cicilan($pbr,$sub);
            $data['Periode'] = $periode2;

            if(!empty($cicilan)){
                foreach($cicilan as $key){
                    // echo "wkwkw1";
                    $data['tglMulai'] = $key->TanggalMulai;
                    $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan($pbr,$sub,$periode2,$key->TanggalMulai);
                    $data['Periode'] = $periode2;
                    // $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr,$sub,$periode1);
                    $this->load->view('potongan_bon/monitoring/list',$data);
//                    echo "<pre>";
//                    print_r($data['_getDataCicilan']);
//                    echo "</pre>";
                }
            }else{
                // echo "haha1";
                $tglMulai = '';
                $data['tglMulai'] = $tglMulai;
                $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr,$sub,$periode2);
                $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan($pbr,$sub,$periode2,$tglMulai);

                $this->load->view('potongan_bon/monitoring/list',$data);
            }
            //
        }elseif($periode == 16){
            $data['_getDataSub'] = $this->M_PotonganBon->getDataCampuranSub($pbr,$sub,$periode2);
            $cicilan = $this->M_PotonganBon->cicilan($pbr,$sub);
            $data['Periode'] = $periode2;

            if(!empty($cicilan)){
                foreach($cicilan as $key){
                    // echo "wkwkw1";
                    $data['tglMulai'] = $key->TanggalMulai;
                    $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan($pbr,$sub,$periode2,$key->TanggalMulai);
                    $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr,$sub,$periode2);
                    $this->load->view('potongan_bon/monitoring/list',$data);

                }
            }else{
                // echo "haha1";
                $tglMulai = '';
                $data['tglMulai'] = $tglMulai;
                $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr,$sub,$periode2);
                $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan($pbr,$sub,$periode2,$tglMulai);

                $this->load->view('potongan_bon/monitoring/list',$data);
            }
        }
    }

    function getPeriodeDipotong(){
        $tgl = $this->uri->segment(3);

        if($tgl >= 14 && $tgl <= 26){
            echo '<select class="form-control" name="txtperiodepotong" id="periodepotong" required>
                    <option value="2" selected>2</option>
                    <option value="3">1 dan 2</option>
                </select>';
        }else{
            echo '<select class="form-control" name="txtperiodepotong" id="periodepotong" required>
                    <option value="">- Pilih -</option>
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">1 dan 2</option>
                </select>';
        }
    }
}?>