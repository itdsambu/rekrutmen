<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//てり　らま
class PotonganBon extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }
        $this->load->model(array('M_PotonganBon', 'm_monitor', 'M_Order'));
    }

    // BEGIN :: MASTER SATUAN
    function MstSatuan()
    {
        $data['_getDataSatuan'] = $this->M_PotonganBon->GetMstSatuan();
        $this->template->display('potongan_bon/master/satuan/index', $data);
    }

    function tambah_mst_satuan()
    {
        $this->template->display('potongan_bon/master/satuan/tambah');
    }

    function simpan_mst_satuan()
    {
        $nama_satuan    = $this->input->post('txtNamaSatuan');
        $singkatan      = $this->input->post('txtSingkatan');
        $status         = $this->input->post('txtStatus');
        $data = array(
            'NamaSatuan'        => $nama_satuan,
            'SingkatanSatuan'   => $singkatan,
            'Status'            => $status,
            'CreatedBy'         => $this->session->userdata('username'),
            'CreatedDate'       => date('Y-m-d H:i:s')
        );
        $cek_hdr = $this->M_PotonganBon->GetByNamaSatuan($nama_satuan, $singkatan);
        if (!$cek_hdr) {
            $this->M_PotonganBon->simpan_mst_satuan($data);
            redirect('PotonganBon/MstSatuan?msg=success');
        } else {
            redirect('PotonganBon/MstSatuan?msg=failed');
        }
    }

    function edit_mst_satuan()
    {
        $id = $this->input->get('id');
        $data['_getDataSatuan'] = $this->M_PotonganBon->GetMstSatuan_byid($id);
        $this->template->display('potongan_bon/master/satuan/ubah', $data);
    }

    function update_mst_satuan()
    {
        $id             = $this->input->post('txtSatuanID');
        $nama_satuan    = $this->input->post('txtNamaSatuan');
        $singkatan      = $this->input->post('txtSingkatan');
        $status         = $this->input->post('txtStatus');

        $data = array(
            'NamaSatuan'        => $nama_satuan,
            'SingkatanSatuan'   => $singkatan,
            'Status'            => $status,
            'UpdateBy'          => $this->session->userdata('username'),
            'UpdateDate'        => date('Y-m-d H:i:s')
        );
        $this->M_PotonganBon->update_mst_satuan($id, $data);
        redirect('PotonganBon/MstSatuan?msg=success');
    }

    // END :: MASTER SATUAN

    // BEGIN :: MASTER ITEM
    function MstItem()
    {
        //$data['_getDataItem'] = $this->M_PotonganBon->GetMstItemfull();
        $this->template->display('potongan_bon/master/item/index');
    }

    function MstItem_()
    {
        $this->template->display('potongan_bon/master/item/list_item');
    }

    function ajaxMstItemDataTable()
    {
        if ($this->input->is_ajax_request()) {
            // $config['table_name'] = 'vwDetailProduct';
            $config['table_name']   = 'vw_mstItemPag';
            $config['primary_key']  = 'ItemID';

            $this->load->library('datatable', $config);

            $request = $this->input->post();
            $data = $this->datatable->make($request);
            echo json_encode($data);
        } else {
            echo 'invalid request';
        }
        exit();
    }

    function getMstItem()
    {
        $getDataItem = $this->M_PotonganBon->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($getDataItem as $r) {
            $no++;
            $row    = array();
            $row[]  = $r->KodeItem;
            $row[]  = $r->NamaItem;
            $row[]  = $r->SingkatanSatuan;
            $row[]  = $r->NamaKategori;
            $row[]  = $r->KodeBarkode;
            $row[]  = $r->CreatedBy;
            $row[]  = '';
            $row[]  = '';

            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->M_PotonganBon->count_all(),
            "recordsFiltered" => $this->M_PotonganBon->count_filtered(),
            "data"            => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function ajax_modal($id_item, $id_pbr, $id_sub)
    {

        $data['_getData']   = $this->M_PotonganBon->GetMstItem_BypbrNew($id_item, $id_pbr, $id_sub);
        // echo"<pre>";
        // print_r($data['_getData']);
        // echo"</pre>";
        $this->load->view('potongan_bon/master/item/ajax', $data);
    }

    function modalItem($id_item)
    {
        $data['_getDataPemborong']    = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getDataSub']          = $this->M_PotonganBon->getMstSubPemborong();
        $data['id_item'] = $id_item;

        // print_r($data['_getDataSub']);
        // exit;
        $this->load->view('potongan_bon/master/item/list', $data);
    }

    function ajax_subPBR($pbr)
    {
        $data['_getDataSub']    = $this->M_PotonganBon->getMstSub($pbr);
        $this->load->view('potongan_bon/master/item/sub', $data);
    }

    function tambah_mst_item()
    {
        $kode                     = $this->M_PotonganBon->GetKodeItem();
        $data['kodeitem']         = $kode + 1;
        $data['_getMstSatuan']    = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstItem']      = $this->M_PotonganBon->GetMstItem1();
        $data['_getMstKategori']  = $this->M_PotonganBon->GetMstKategori();
        $this->template->display('potongan_bon/master/item/tambah', $data);
    }

    function getBykode()
    {
        $kode = $this->input->post('kode');
        // $kode = $this->input->post('KodeBarkode');
        // echo $kode;

        $data['getBarcode']       = $this->M_PotonganBon->getByNamaKode($kode);
        // echo '<pre>';
        // print_r( $data['getBarcode']);

        $data['_getMstSatuan']    = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori']  = $this->M_PotonganBon->GetMstKategori();
        if ($data['getBarcode'] == null) {
            echo json_encode(0);
        } else {
            $this->load->view('potongan_bon/master/item/Getkode', $data);
        }
    }

    // BEGIN :: Search Item
    function get_search_item()
    {
        $item = $this->input->post("item");
        $result = $this->M_PotonganBon->get_search_item($item);
        // $item = $this->input->post("NamaItem");
        // $result = $this->M_PotonganBon->get_search_item($item);
        echo json_encode($result);
    }
    // END :: Search Item

    function simpan_mst_item()
    {

        $item_id          = $this->input->post("txtItemID");
        $kode_item        = $this->input->post('txtKodeItem');
        $nama_item        = $this->input->post('txtNamaItem');
        $satuan           = $this->input->post('txtSatuan');
        $kategori         = $this->input->post("txtKategori");
        $barcode          = $this->input->post('txtBarcode');
        $tanggal          = $this->input->post('txtTanggal');
        $harga            = $this->input->post('txtHarga');

        $group_id         = $this->session->userdata('groupuser');
        $data_pemborong   = $this->M_PotonganBon->GetIdSubPemborong($group_id);

        $id_sub_pemborong = $data_pemborong->IDSubPemborong;
        $id_pemborong     = $data_pemborong->IDPemborong;


        $data = array(
            'KodeItem'    => $kode_item,
            'NamaItem'    => $nama_item,
            'SatuanID'    => $satuan,
            'KategoriID'  => $kategori,
            'KodeBarkode' => $barcode,
            'CreatedBy'   => $this->session->userdata('username'),
            'CreatedDate' => date('Y-m-d H:i:s')
        );
        // print_r($data);
        // exit;

        $cek_kode = $this->M_PotonganBon->getByNamaItem($nama_item);
        if (!$cek_kode) {
            $this->M_PotonganBon->simpan_mst_item($data);
            $itemID = $this->db->insert_id();

            $dataHdr = array(
                'Tanggal'        => $tanggal,
                'IDPemborong'    => $id_pemborong,
                'IDSubPemborong' => $id_sub_pemborong,
                'CreatedBy'      => $this->session->userdata("username"),
                'CreatedDate'    => date('Y-m-d H:i:s')
            );

            $cek_hdr = $this->M_PotonganBon->CekDataHdrNew($id_pemborong, $id_sub_pemborong);
            if ($cek_hdr != NULL) {
                $this->M_PotonganBon->update_hdr($id_pemborong, $id_sub_pemborong, $dataHdr);
            } else {
                $hdrid = $this->M_PotonganBon->simpan_hdr_harga($dataHdr);
            }

            foreach ($cek_hdr as $hdr) {
                $hdrid = $hdr->HeaderHargaID;
            }

            $item       = $this->input->post("txtItemID");
            $hitung     = count($itemID);

            for ($i = 0; $i < $hitung; $i++) {
                $dataDtl = array(
                    'HeaderHargaID'  => $hdrid,
                    'IDPemborong'    => $id_pemborong,
                    'IDSubPemborong' => $id_sub_pemborong,
                    'ItemID'         => $itemID,
                    'SatuanID'       => $satuan,
                    'KategoriID'     => $kategori,
                    'Harga'          => str_replace(".", "", $harga)
                );

                $cek_dtl = $this->M_PotonganBon->CekDataDtl($itemID, $id_sub_pemborong);
                if ($cek_dtl != NULL) {
                    $dataDtl['UpdateBy'] = $this->session->userdata("username");
                    $dataDtl['UpdateDate'] = date('Y-m-d H:i:s');
                    foreach ($cek_dtl as $dtl) {
                        $dtlid = $dtl->DetailHargaID;
                        $this->M_PotonganBon->update_dtl_harga($dtlid, $dataDtl);
                    }
                } else {
                    $dataDtl['CreatedBy'] = $this->session->userdata("username");
                    $dataDtl['CreatedDate'] = date('Y-m-d H:i:s');
                    $this->M_PotonganBon->simpan_dtl_harga($dataDtl);
                }
            }

            redirect('PotonganBon/MstItem');
            // redirect('PotonganBon/tambah_mst_item?msg=success1');

        } else {

            $dataHdr = array(
                'Tanggal'        => $tanggal,
                'IDPemborong'    => $id_pemborong,
                'IDSubPemborong' => $id_sub_pemborong,
                'CreatedBy'      => $this->session->userdata("username"),
                'CreatedDate'    => date('Y-m-d H:i:s')
            );

            $cek_hdr = $this->M_PotonganBon->CekDataHdrNew($id_pemborong, $id_sub_pemborong);
            if ($cek_hdr != NULL) {
                $this->M_PotonganBon->update_hdr($id_pemborong, $id_sub_pemborong, $dataHdr);
            } else {
                $hdrid = $this->M_PotonganBon->simpan_hdr_harga($dataHdr);
            }

            foreach ($cek_hdr as $hdr) {
                $hdrid = $hdr->HeaderHargaID;
            }

            $hitung     = count($item_id);

            for ($i = 0; $i < $hitung; $i++) {
                $dataDtl = array(
                    'HeaderHargaID'  => $hdrid,
                    'IDPemborong'    => $id_pemborong,
                    'IDSubPemborong' => $id_sub_pemborong,
                    'ItemID'         => $item_id,
                    'SatuanID'       => $satuan,
                    'KategoriID'     => $kategori,
                    'Harga'          => str_replace(".", "", $harga)
                );

                $cek_dtl = $this->M_PotonganBon->CekDataDtl($item_id, $id_sub_pemborong);
                if ($cek_dtl != NULL) {
                    $dataDtl['UpdateBy']    = $this->session->userdata("username");
                    $dataDtl['UpdateDate']  = date('Y-m-d H:i:s');
                    foreach ($cek_dtl as $dtl) {
                        $dtlid = $dtl->DetailHargaID;
                        $this->M_PotonganBon->update_dtl_harga($dtlid, $dataDtl);
                    }
                } else {
                    $dataDtl['CreatedBy']   = $this->session->userdata("username");
                    $dataDtl['CreatedDate'] = date('Y-m-d H:i:s');
                    $this->M_PotonganBon->simpan_dtl_harga($dataDtl);
                }
            }

            redirect('PotonganBon/tambah_mst_item?msg=success2');
        }
    }

    function edit_mst_item()
    {
        $id = $this->input->get('id');

        $data['_getMstSatuan']    = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori']  = $this->M_PotonganBon->GetMstKategori();
        $data['_getDataItem']     = $this->M_PotonganBon->GetMstItem_ById($id);
        $this->template->display('potongan_bon/master/item/ubah', $data);
    }

    function get_search_barcode()
    {
        $kode   = $this->input->post("kode");
        $result = $this->M_PotonganBon->get_search_barcode($kode);
        echo json_encode($result);
    }

    function update_mst_item()
    {
        $id           = $this->input->post('txtItemID');
        $kode_item    = $this->input->post('txtKodeItem');
        $nama_item    = $this->input->post('txtNamaItem');
        $satuan       = $this->input->post('txtSatuan');
        $kategori     = $this->input->post("txtKategori");
        $barcode      = $this->input->post("txtBarcode");

        $data = array(
            'KodeBarkode' => $barcode,
            'UpdateBy' => $this->session->userdata('username'),
            'UpdateDate' => date('Y-m-d H:i:s')
        );

        $this->M_PotonganBon->update_mst_item($id, $data);
        redirect('PotonganBon/MstItem?msg=success');
    }

    // END :: MASTER ITEM

    // BEGIN :: MASTER KATEGORI

    function MstKategori()
    {
        $data['_getDataKategori'] = $this->M_PotonganBon->GetMstKategori();
        $this->template->display('potongan_bon/master/kategori/index', $data);
    }

    function tambah_mst_kategori()
    {

        $this->template->display('potongan_bon/master/kategori/tambah');
    }

    function simpan_mst_kategori()
    {
        $kategori = $this->input->post("txtNamaKategori");
        $status = $this->input->post('txtStatus');

        $data = array(
            'NamaKategori' => $kategori,
            'Status'       => $status,
            'CreatedBy'    => $this->session->userdata("username"),
            'CreatedDate'  => date('Y-m-d H:i:s'),
        );

        $cek_kategori = $this->M_PotonganBon->GetByKategori($kategori);
        if (!$cek_kategori) {
            $this->M_PotonganBon->simpan_mst_kategori($data);
            redirect('PotonganBon/MstKategori?msg=success');
        } else {
            redirect('PotonganBon/MstKategori?msg=failed');
        }
    }

    function edit_mst_kategori()
    {
        $id = $this->input->get('id');

        $data['_getDataKategori'] = $this->M_PotonganBon->GetMstKategori_ById($id);

        $this->template->display("potongan_bon/master/kategori/ubah", $data);
    }

    function update_mst_kategori()
    {
        $id         = $this->input->post("txtKategoriID");
        $kategori   = $this->input->post("txtNamaKategori");
        $status     = $this->input->post('txtStatus');

        $data = array(
            'NamaKategori' => $kategori,
            'Status'       => $status,
            'UpdateBy'     => $this->session->userdata("username"),
            'UpdateDate'   => date('Y-m-d H:i:s'),
        );

        $this->M_PotonganBon->update_mst_kategori($id, $data);
        redirect('PotonganBon/MstKategori?msg=success');
    }

    // END :: MASTER KATEGORI

    // MASTER CICILAN

    function MstCicilan()
    {
        $data['dataCicilan'] = $this->M_PotonganBon->GetMstCicilan();
        $this->template->display('potongan_bon/master/item_cicilan/index', $data);
    }

    function tambah_mst_item_cicilan()
    {
        $kode                     = $this->M_PotonganBon->GetKodeItemCicilan();
        $data['kodeitem']         = $kode + 1;
        $data['_getMstSatuan']    = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori']  = $this->M_PotonganBon->GetMstKategoriCicilan();
        $this->template->display('potongan_bon/master/item_cicilan/tambah', $data);
    }

    function simpan_mst_item_cicilan()
    {

        $kode_item    = $this->input->post('txtKodeItem');
        $nama_item    = $this->input->post('txtNamaItem');
        $satuan       = $this->input->post('txtSatuan');
        $kategori     = $this->input->post("txtKategori");
        $barcode      = $this->input->post('txtBarcode');

        $data = array(
            'KodeCicilanID'       => $kode_item,
            'NamaCicilan'         => $nama_item,
            'SatuanID'            => $satuan,
            'KategoriCicilanID'   => $kategori,
            'Barcode'             => $barcode,
            'CreatedBy'           => $this->session->userdata('username'),
            'CreatedDate'         => date('Y-m-d H:i:s')
        );
        $this->M_PotonganBon->simpan_mst_item_cicilan($data);
        redirect('PotonganBon/MstCicilan?msg=success');
    }

    function edit_mst_item_cicilan()
    {
        $id = $this->input->get('id');

        $data['_getMstSatuan']    = $this->M_PotonganBon->GetMstSatuan();
        $data['_getMstKategori']  = $this->M_PotonganBon->GetMstKategoriCicilan();
        $data['_getDataItem']     = $this->M_PotonganBon->GetCicilan_ById($id);
        $this->template->display('potongan_bon/master/item_cicilan/ubah', $data);
    }

    function update_mst_item_cicilan()
    {
        $id           = $this->input->post('txtItemID');
        $kode_item    = $this->input->post('txtKodeItem');
        $nama_item    = $this->input->post('txtNamaItem');
        $satuan       = $this->input->post('txtSatuan');
        $kategori     = $this->input->post("txtKategori");
        $barcode      = $this->input->post('txtBarcode');

        $data = array(
            'KodeCicilanID'       => $kode_item,
            'NamaCicilan'         => $nama_item,
            'SatuanID'            => $satuan,
            'KategoriCicilanID'   => $kategori,
            'Barcode'             => $barcode,
            'UpdatedBy'           => $this->session->userdata('username'),
            'UpdatedDate'         => date('Y-m-d H:i:s')
        );

        $this->M_PotonganBon->update_mst_item_cicilan($id, $data);
        redirect('PotonganBon/MstCicilan?msg=success');
    }

    // END :: MASTER CICILAN

    // MASTER KATEGORI POTONGAN

    function MstKategoriCicilan()
    {
        $data['_getDataCicilan'] = $this->M_PotonganBon->GetMstKategoriCicilan();

        $this->template->display('potongan_bon/master/kategori_cicilan/index', $data);
    }

    function tambah_mst_cicilan()
    {
        $this->template->display('potongan_bon/master/kategori_cicilan/tambah');
    }

    function simpan_mst_cicilan()
    {
        $kategori = $this->input->post("txtNamaKategori");
        $status = $this->input->post('txtStatus');
        $prioritas = $this->input->post('txtPrioritas');

        $data = array(
            'NamaKategori' => $kategori,
            'Status'       => $status,
            'Prioritas'    => $prioritas,
            'CreatedBy'    => $this->session->userdata("username"),
            'CreatedDate'  => date('Y-m-d H:i:s'),
        );

        $this->M_PotonganBon->simpan_mst_cicilan($data);

        redirect('PotonganBon/MstKategoriCicilan?msg=success');
    }

    function edit_mst_cicilan()
    {
        $id = $this->input->get('id');

        $data['_getDataCicilan'] = $this->M_PotonganBon->GetMstCicilan_ById($id);

        $this->template->display("potongan_bon/master/kategori_cicilan/ubah", $data);
    }

    function update_mst_cicilan()
    {
        $id         = $this->input->post("txtKategoriCicilanID");
        $kategori   = $this->input->post("txtNamaKategori");
        $status     = $this->input->post('txtStatus');
        $prioritas  = $this->input->post('txtPrioritas');

        $data = array(
            'NamaKategori' => $kategori,
            'Status'       => $status,
            'Prioritas'    => $prioritas,
            'UpdatedBy'    => $this->session->userdata("username"),
            'UpdatedDate'  => date('Y-m-d H:i:s'),
        );
        $this->M_PotonganBon->update_mst_cicilan($id, $data);
        redirect('PotonganBon/MstKategoriCicilan?msg=success');
    }

    #END MASTER KATEGORI POTONGAN

    // BEGIN :: MASTER HARGA
    function MstHarga()
    {
        $data['_getDataHdr'] = $this->M_PotonganBon->GetHeaderMstHarga();
        $this->template->display("potongan_bon/master/harga/index", $data);
    }

    function tambah_mst_harga()
    {
        $sub    = $this->input->post('IDSubPemborong');

        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategori();
        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $data['_getDataPemborong']  = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getDataItem']       = $this->M_PotonganBon->GetMstItemBaru($sub);

        $this->template->display("potongan_bon/master/harga/tambah", $data);
    }

    function simpan_mst_harga()
    {
        // Header
        // echo"<pre>";
        // print_r($this->input->post());
        // echo"</pre>";
        $tanggal    = $this->input->post("txtTanggal");
        $pemborong  = $this->input->post("txtPemborong");
        $subpbr     = $this->input->post("txtSubPemborong");

        $dataHdr = array(
            'Tanggal'        => $tanggal,
            'IDPemborong'    => $pemborong,
            'IDSubPemborong' => $subpbr,
            'CreatedBy'      => $this->session->userdata("username"),
            'CreatedDate'    => date('Y-m-d H:i:s')
        );

        $cek_hdr = $this->M_PotonganBon->CekDataHdrNew($pemborong, $subpbr);
        if ($cek_hdr != NULL) {
            $this->M_PotonganBon->update_hdr($pemborong, $subpbr, $dataHdr);
        } else {
            $hdrid = $this->M_PotonganBon->simpan_hdr_harga($dataHdr);
        }

        foreach ($cek_hdr as $hdr) {
            $hdrid = $hdr->HeaderHargaID;
        }

        $item       = $this->input->post("txtItemID");
        $satuan     = $this->input->post("txtSatuanID");
        $kategori   = $this->input->post("txtKategoriID");
        $harga      = $this->input->post('txtHarga');
        $hitung     = count($item);

        for ($i = 0; $i < $hitung; $i++) {
            $dataDtl = array(
                'HeaderHargaID' => $hdrid,
                'IDPemborong'   => $pemborong,
                'IDSubPemborong' => $subpbr,
                'ItemID'        => $item[$i],
                'SatuanID'      => $satuan[$i],
                'KategoriID'    => $kategori[$i],
                'Harga'         => str_replace(".", "", $harga[$i])
            );

            $cek_dtl = $this->M_PotonganBon->CekDataDtl($item[$i], $subpbr);
            if ($cek_dtl != NULL) {
                $dataDtl['UpdateBy']    = $this->session->userdata("username");
                $dataDtl['UpdateDate']  = date('Y-m-d H:i:s');
                foreach ($cek_dtl as $dtl) {
                    $dtlid = $dtl->DetailHargaID;
                    $this->M_PotonganBon->update_dtl_harga($dtlid, $dataDtl);
                }
            } else {
                $dataDtl['CreatedBy']   = $this->session->userdata("username");
                $dataDtl['CreatedDate'] = date('Y-m-d H:i:s');
                $this->M_PotonganBon->simpan_dtl_harga($dataDtl);
            }
        }
        redirect('PotonganBon/MstHarga');
    }

    function send_data()
    {
        $nik    = $this->uri->segment(3);
        $nama   = $this->uri->segment(3);
        $nofix  = $this->uri->segment(3);
        $pbr    = $this->uri->segment(4);
        // $otp = '123ABC';

        $tanggal = date('Y-m-d');

        // print_r($tanggal);
        // exit;

        $tanggal_periode = date('j', strtotime($tanggal));

        $thn = date('Y', strtotime($tanggal));
        if ($tanggal == $thn . '-01-29' || $tanggal == $thn . '-01-30' || $tanggal == $thn . '-01-31') {
            if ($tanggal_periode >= 14 && $tanggal_periode <= 26) {
                $periode = date('Y-m-16', strtotime($tanggal));
            } else {
                if ($tanggal_periode == 26 || $tanggal_periode == 27 || $tanggal_periode == 28 || $tanggal_periode == 29 || $tanggal_periode == 30 || $tanggal_periode == 31) {
                    $bln        = date('m') + 1;
                    $periode    = date('Y-0' . $bln . '-1', strtotime($tanggal));
                } else {
                    $periode = date('Y-m-1', strtotime($tanggal));
                    // echo $periode;
                }
            }
        } else {
            if ($tanggal_periode >= 14 && $tanggal_periode <= 26) {
                $periode = date('Y-m-16', strtotime($tanggal));
            } else {
                if ($tanggal_periode == 26 || $tanggal_periode == 27 || $tanggal_periode == 28 || $tanggal_periode == 29 || $tanggal_periode == 30 || $tanggal_periode == 31) {
                    // penambahan baru 26-12-2022
                    $bulan        = date('Y-m-d', strtotime($tanggal));
                    $bulan1       = date('m', strtotime($bulan));
                    if ($bulan1 == '12') {
                        $bul        = date('Y-m-d', strtotime('+1 month', strtotime($tanggal))); // penambahan baru 26-12-2022
                        $bln        = date('m', strtotime($bul));
                        $bln_fix    = str_pad($bln, 2, '0');
                        $tahun      = date('Y', strtotime($bul));
                        $periode    = date($tahun . '-' . $bln_fix . '-01', strtotime($tanggal));
                        //  echo $periode;
                    } else {
                        $bul        = date('Y-m-d', strtotime($tanggal));
                        $bln        = date('m', strtotime($bul)) + 1;
                        $bln_fix    = str_pad($bln, 2, '0', STR_PAD_LEFT);
                        $tahun      = date('Y', strtotime($bul));
                        $periode    = date($tahun . '-' . $bln_fix . '-01', strtotime($tanggal));
                        // echo $periode;
                    }
                } else {
                    $periode = date('Y-m-1', strtotime($tanggal));
                    // echo $periode;
                }
            }
        }


        $get_tk   = $this->M_PotonganBon->GetTK($nik, $nama, $nofix, $pbr, $periode);
        // $sub    = $get_tk[0]->FixNo;

        foreach ($get_tk as $get) {

            echo '
                
                <div class="form-group">
                    <label class="col-lg-2 control-label">Nik</label>
                    <div class="col-sm-4">
                        <input type="text" name="txtNik" id="nik" class="form-control" value="' . $get->Nik . '" readonly>
                       
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Nama Lengkap</label>
                    <div class="col-sm-4">
                        <input type="text" name="txtdept" id="dept" class="form-control" value="' . $get->Nama . '" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Dept/Bagian</label>
                    <div class="col-sm-4">
                        <input type="text" name="txtdept" id="dept" class="form-control" value="' . $get->BagianAbbr . '" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Sisa Periode Sebelumnya (Rp.)</label>
                    <div class="col-sm-4">
                        <input type="text" name="txtSisa" id="Sisa" class="form-control" value="' . number_format($get->SisaPeriodeSebelumnya, 0, ",", ".") . '" readonly>
                    </div>
                </div>
            ';
        }
    }


    function getDetailItemHarga()
    {
        $hdrid = $this->input->get('id');

        $data['_getDataHdr']    = $this->M_PotonganBon->GetHeaderMstHarga_ById($hdrid);
        $data['_getDtlHarga']   = $this->M_PotonganBon->GetDtlHarga($hdrid);
        $this->template->display('potongan_bon/master/harga/detail_harga', $data);
    }

    function subpbr($pbr)
    {
        $data['_getDataSub']    = $this->M_PotonganBon->getMstSub($pbr);
        $this->load->view('potongan_bon/master/harga/sub', $data);
    }

    function ajax_pemborong()
    {
        $pbr        = $this->uri->segment(3);
        $sub        = $this->uri->segment(4);
        $kategori   = $this->uri->segment(5);
        $item       = $this->uri->segment(6);

        $data['_getHarga'] = $this->M_PotonganBon->_getData1($pbr, $sub, $kategori, $item);
        $cek_hdr = $this->M_PotonganBon->CekDataHdrNew($pbr, $sub);
        $data['cek_data'] = $cek_hdr;
        $this->load->view('potongan_bon/master/harga/ajax_harga', $data);
    }

    function getMstItemPerSub()
    {
        $pbr = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $data['_getDataItem'] = $this->M_PotonganBon->GetMstItemBysub($pbr, $sub);
        $this->load->view('potongan_bon/master/harga/ajax_item', $data);
    }

    function getMstItemPerKategori()
    {
        $kategori = $this->uri->segment(3);
        $pbr = $this->uri->segment(4);
        $sub = $this->uri->segment(5);

        $data['_getDataItem'] = $this->M_PotonganBon->GetMstItemPerKategori($kategori, $pbr, $sub);
        $this->load->view('potongan_bon/master/harga/ajax_item', $data);
    }

    // END :: MASTER HARGA

    // BEGIN : TRANSAKSI POTONGAN BON
    function ordermanual()
    {
        $data['_getDataPemborong']  = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategori();
        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $data['_getCount']          = $this->M_PotonganBon->_getTotalProses();
        // print_r($data);
        // exit;
        $this->template->display('potongan_bon/transaksi/ordermanual', $data);
    }

    function ajax_subPemborong($pbr)
    {
        $data['_getDataSub']    = $this->M_PotonganBon->getMstSub($pbr);
        $this->load->view('potongan_bon/transaksi/sub', $data);
    }

    function ajax_item($pbr)
    {
        $data['_getDataItem1']    = $this->M_PotonganBon->getMstItemId($pbr);
        $this->load->view('potongan_bon/master/item/item', $data);
    }

    function ajax_list_item()
    {
        $pbrsub                 = $this->uri->segment(3);
        $data['subpemborong']   = $pbrsub;
        $this->load->view("potongan_bon/transaksi/mstListItem", $data);
    }

    // BEGIN : TRANSAKSI POTONGAN BON

    function TransaksiPotonganBon()
    {

        $data['_getListOrder'] = $this->M_PotonganBon->_getListOrder();
        $this->template->display('potongan_bon/transaksi/list_order', $data);
    }

    function ExportExcelTrnBelumProses()
    {
        $this->load->library("Excel/PHPExcel");

        $data['_getDataExcel'] = $this->M_PotonganBon->getDataExcelTrnBelumProses();
        // echo"<pre>";
        // print_r($data['_getDataExcel']);
        // echo"</pre>";
        $this->load->view('potongan_bon/transaksi/ExportExcel', $data);
    }
    function lihat_pesanan()
    {
        $tanggal    = $this->uri->segment(3);
        $nofix      = $this->uri->segment(4);
        $sub        = $this->uri->segment(5);
        $id         = $this->uri->segment(6);

        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategori();
        $data['_getTrnHeader']      = $this->M_PotonganBon->_getTrnHeader($tanggal, $nofix, $sub, $id);
        // $data['_getTrnDetail']      = $this->M_PotonganBon->_getTrnDetail($data['_getTrnHeader']->HeaderID);
        // $data['_getGrandTotal']     = $this->M_PotonganBon->_getGrandTotal($data['_getTrnHeader']->HeaderID);
        $this->template->display('potongan_bon/transaksi/index', $data);
    }

    function ajax_get_data_pesanan()
    {
        $headerID = $this->input->post("headerID");
        $result = $this->M_PotonganBon->_getTrnDetail($headerID);
        echo json_encode($result);
    }

    function ajax_harga()
    {
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);


        $get_harga = $this->M_PotonganBon->get_harga($sub, $item);
        foreach ($get_harga as $key) {
            echo number_format($key->Harga, 0, ",", ".");
        }
    }

    function ajax_hargaid()
    {
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_harga = $this->M_PotonganBon->get_harga($sub, $item);
        foreach ($get_harga as $key) {
            echo $key->DetailHargaID;
        }
    }

    function ajax_satuan()
    {
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($sub, $item);
        foreach ($get_satuan as $key) {
            echo $key->SingkatanSatuan;
        }
    }

    function ajax_satuanid()
    {
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($sub, $item);
        foreach ($get_satuan as $key) {
            echo $key->SatuanID;
        }
    }

    function ajax_kategori()
    {
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($sub, $item);
        foreach ($get_satuan as $key) {
            echo $key->NamaKategori;
        }
    }
    function ajax_kategoriid()
    {
        $item = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $get_satuan = $this->M_PotonganBon->get_harga($sub, $item);
        foreach ($get_satuan as $key) {
            echo $key->KategoriID;
        }
    }

    function hapus_item()
    {
        $dtlid = $this->uri->segment(3);

        $this->M_Order->hapus_item($dtlid);
    }

    function delete($header_id)
    {

        $data = array(
            'DeletedBy'          => $this->session->userdata('username'),
            'DeletedDate'        => date('Y-m-d H:i:s')
        );

        if ($this->M_PotonganBon->delete_trn($header_id, $data)) {
            // if ($this->M_PotonganBon->delete_trn($header_id)) {
            $this->session->set_flashdata('success', 'Berhasil menghapus data ...');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data ...');
        }
        redirect('PotonganBon/TransaksiPotonganBon');
    }
    //============================================================================================//
    // function deleter($header_id)
    // {

    //     // if($this->M_PotonganBon->delete_trn($header_id,$data)){
    //     if ($this->M_PotonganBon->delete_trn_cicilan()($header_id)) {
    //         $this->session->set_flashdata('success', 'Berhasil menghapus data ...');
    //     } else {
    //         $this->session->set_flashdata('error', 'Gagal menghapus data ...');
    //     }
    //     redirect('PotonganBon/TransaksiPotonganBon');
    // }
    //============================================================================================//
    function cari_tenagakerja()
    {
        $nik    = $this->input->post('Nik');
        $nama   = $this->input->post('Nik');
        $nofix  = $this->input->post('Nik');
        if (!is_numeric($nofix)) {
            $nofix = 0;
        }
        // $sub            = $this->input->post('subpemborong');
        $pbr            = $this->input->post('pemborong');


        $data['_getTK'] = $this->M_PotonganBon->GetTK($nik, $nama, $nofix, $pbr);
        // $data['_getTK'] = $this->M_PotonganBon->GetTK($nik, $nama,  $sub);
        //  echo"<pre>";
        //         print_r($data['_getTK']);
        //         exit;
        $this->load->view('potongan_bon/transaksi/list_search', $data);
    }

    function ajaxDataTK()
    {
        $nik    = $this->input->post('nik');
        $nama   = $this->input->post('nama');
        $nofix  = $this->input->post('nofix');
        $pbr    = $this->input->post('pbr');
        $sub    = $this->input->post('subpemborong');

        $data['_getData'] = $this->M_PotonganBon->GetTK($nik, $nama, $nofix, $pbr, $sub);

        $this->load->view('potongan_bon/transaksi/list_dataTK', $data);
    }

    function ajax_search_item()
    {
        $pbrSub   = $this->input->post("pbrSub");
        $search   = $this->input->post("search");
        $kode     = $this->input->post("kode");
        $result   = $this->M_PotonganBon->getSearchItem($pbrSub, $search, $kode);
        echo json_encode($result);
    }


    // BEGIN :: PRINT SLIP BELANJA

    function printSlipBelanja()
    {
        $hdrid = $this->input->post('txthdrid');
        ob_start();
        $hdr                            = $this->M_PotonganBon->printSlipBelanjaSembakoHdr($hdrid);
        $data['_getDataPrintSlipHdr']   = $hdr;
        $data['_getDataPrintSlipDtl']   = $this->M_PotonganBon->printSlipBelanjaSembakoDtl($hdrid);
        $data['_getTotalBelanja']       = $this->M_PotonganBon->getDataGrandTotalSembako($hdr[0]->FixNo, $hdrid);
        $ttl_periode_ini                = $this->M_PotonganBon->getTotalPeriodeIni($hdr[0]->FixNo, $hdr[0]->PeriodeGajian);
        $data['_totalPeriodeIni']       = $ttl_periode_ini;
        $tglMulai                       = $this->M_PotonganBon->getTanggalMulai($hdr[0]->FixNo);

        if (empty($tglMulai)) {
            $tgl_mulai                          = '';
            $ttl_cicilan                        = $this->M_PotonganBon->getPotCicilanPeriodeIni($hdr[0]->FixNo, $tgl_mulai, $hdr[0]->PeriodeGajian);
            $data['_totalCicilanPeriodeIni']    = $ttl_cicilan;
        } else {
            foreach ($tglMulai as $tgl) {
                if ($tgl->TanggalMulai != NULL) {
                    $tgl_mulai                          = $tgl->TanggalMulai;
                    $ttl_cicilan                        = $this->M_PotonganBon->getPotCicilanPeriodeIni($hdr[0]->FixNo, $tgl_mulai, $hdr[0]->PeriodeGajian);
                    $data['_totalCicilanPeriodeIni']    = $ttl_cicilan;
                } else {
                    $tgl_mulai                          = '';
                    $ttl_cicilan                        = $this->M_PotonganBon->getPotCicilanPeriodeIni($hdr[0]->FixNo, $tgl_mulai, $hdr[0]->PeriodeGajian);
                    $data['_totalCicilanPeriodeIni']    = $ttl_cicilan;
                }
            }
        }

        $data['_totalCicilanPeriodeIni']  = $ttl_cicilan;
        $sisa = $this->M_PotonganBon->GetTK($hdr[0]->Nik, $hdr[0]->Nama, $hdr[0]->FixNo, $hdr[0]->IDToko);
        $data['_sisa'] = $sisa;

        $data['_grandTotal'] = $ttl_periode_ini + $ttl_cicilan + $sisa;

        $this->load->view('potongan_bon/transaksi/print_slip', $data);
        $html   = ob_get_contents();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('Print Slip Belanja.pdf');
    }
    // END :: PRINT SLIP BELANJA

    function simpan_trn_manual_potongan_pemborong()
    {
        // Header
        $this->load->library(array('user_agent', 'Mobile_Detect', 'Misc'));

        $detect = new Mobile_Detect();

        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? '' : '') : 'PC');

        foreach ($detect->getRules() as $name => $regex) :
            $check = $detect->{'is' . $name}();
            if ($check == 'true') {
                $deviceType .= $name . ' ';
            }
        endforeach;

        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }


        $tanggal   = $this->input->post("txtTanggal");
        $pemborong = $this->input->post("txtPemborong");
        $sub       = $this->input->post("txtSubPemborong");
        $nofix     = $this->input->post("nik");
        $sisa      = $this->input->post("txtSisaReal");

        if ($nofix == 0 || $nofix == '0') {
            redirect('PotonganBon/ordermanual?msg=gagal');
        } else {

            if ($this->session->userdata('username') === 'riyan') {
                $tanggal_periode = 18;
            } else {
                # code...
            }
            $tanggal_periode = date('j', strtotime($tanggal));


            // if ($tanggal_periode >= 14 && $tanggal_periode <= 26) {
            //     $periode = date('Y-m-16', strtotime($tanggal));
            // } else {
            //     if ($tanggal_periode == 26 || $tanggal_periode == 27 || $tanggal_periode == 28 || $tanggal_periode == 29 || $tanggal_periode == 30 || $tanggal_periode == 31) {
            //         // $bul     = date('Y-m-d',strtotime('+ 1 months'));  // penambahan baru 26-12-2022
            //         // $bln     = date('m',strtotime($bul));
            //         // $bul     = date('Y-m-d');
            //         $bln     = date('m') + 1;
            //         $periode = date('Y-0' . $bln . '-1', strtotime($tanggal));  // pergantian pada bulan 1 untuk tanggal 28 - 31 januari. dan kembalikan lagi di tanggal 1 februari.
            //         // $bln_fix = str_pad($bln, 2, '0');
            //         // $tahun   = date('Y',strtotime($bul));
            //         // $periode    = date($tahun.'-'.$bln_fix.'-1',strtotime($tanggal));
            //     } else {
            //         $periode = date('Y-m-1', strtotime($tanggal));
            //         // echo "lanjut";
            //     }
            // }

            $thn = date('Y', strtotime($tanggal));
            if ($tanggal == $thn . '-01-29' || $tanggal == $thn . '-01-30' || $tanggal == $thn . '-01-31') {
                if ($tanggal_periode >= 14 && $tanggal_periode <= 26) {
                    $periode = date('Y-m-16', strtotime($tanggal));
                } else {
                    if ($tanggal_periode == 26 || $tanggal_periode == 27 || $tanggal_periode == 28 || $tanggal_periode == 29 || $tanggal_periode == 30 || $tanggal_periode == 31) {
                        $bln        = date('m') + 1;
                        $periode    = date('Y-0' . $bln . '-1', strtotime($tanggal));
                    } else {
                        $periode = date('Y-m-1', strtotime($tanggal));
                        // echo $periode;
                    }
                }
            } else {
                if ($tanggal_periode >= 14 && $tanggal_periode <= 26) {
                    $periode = date('Y-m-16', strtotime($tanggal));
                } else {
                    if ($tanggal_periode == 26 || $tanggal_periode == 27 || $tanggal_periode == 28 || $tanggal_periode == 29 || $tanggal_periode == 30 || $tanggal_periode == 31) {
                        // penambahan baru 26-12-2022
                        $bulan        = date('Y-m-d', strtotime($tanggal));
                        $bulan1       = date('m', strtotime($bulan));
                        if ($bulan1 == '12') {
                            $bul        = date('Y-m-d', strtotime('+1 month', strtotime($tanggal))); // penambahan baru 26-12-2022
                            $bln        = date('m', strtotime($bul));
                            $bln_fix    = str_pad($bln, 2, '0');
                            $tahun      = date('Y', strtotime($bul));
                            $periode    = date($tahun . '-' . $bln_fix . '-01', strtotime($tanggal));
                            //  echo $periode;
                        } else {
                            $bul        = date('Y-m-d', strtotime($tanggal));
                            $bln        = date('m', strtotime($bul)) + 1;
                            $bln_fix    = str_pad($bln, 2, '0', STR_PAD_LEFT);
                            $tahun      = date('Y', strtotime($bul));
                            $periode    = date($tahun . '-' . $bln_fix . '-01', strtotime($tanggal));
                            // echo $periode;
                        }
                    } else {
                        $periode = date('Y-m-1', strtotime($tanggal));
                        // echo $periode;
                    }
                }
            }
            /**
             * Jika pemborong lupa input bon di periode sebelumya
             * maka gunakan kondisi ini
             */
            // if ($pemborong == 1) {
            //      $periode = '2023-03-01';
            // }
            // else {
            //     $periode;
            // }
            // exit;
            $dataHdr = array(
                'Tanggal'        => date('Y-m-d H:i:s', strtotime($tanggal)),
                'PeriodeGajian'  => $periode,
                'IDSubPemborong' => $sub,
                'IDPemborong'    => $pemborong,
                'Nofix'          => $nofix,
                'StatusProses'   => 1,
                'CreatedBy'      => $this->session->userdata('username'),
                'CreatedDate'    => date('Y-m-d H:i:s'),
                'Hostname'       => $this->session->userdata('hostname'),
                'IPAddress'      => $this->session->userdata('ipaddress'),
                'Device'         => $deviceType,
                'Browser'        => $agent,
                'Platform'       => $this->misc->platform(),
                'User_Agent'     => $this->agent->agent_string()
            );
            // print_r("tanggala periode".$tanggal_periode);
            // print_r('bulan lengkap'.$bul);
            // echo"<pre>";
            // // // print_r($dataHdr);
            // print_r('bulan'.$bln);
            // echo "<pre>";
            // print_r("periodea" . $periode);
            // exit;
            $hdrid = $this->M_PotonganBon->simpan_trn_hdr($dataHdr);
            echo json_decode($hdrid);
            // echo $hdrid;


            // echo $hdr;


            // BEGIN :: KIRIM KE TELEGRAM

            //=============================================================================//

            $user_tel = $this->M_PotonganBon->GetUserTelegram($nofix);


            // JIKA TIDAK PUNYA TELEGRAM MAKA CUKUP MENGIRIM HEADER ID NYA SAJA
            if ($user_tel == NULL) {
                // echo "tidak punya telegram";
                $hdr = $hdrid;
                // redirect('PotonganBon/ordermanual?msg=success');
            } else {
                $hdr = $hdrid;
                $tglMulai   = $this->M_PotonganBon->getTanggalMulai($nofix);
                $_getTrnHdr = $this->M_PotonganBon->getDataTrnHdrTel($nofix, $hdr);
                $pesan      = "INFO POTONGAN BON : " . date('d-m-Y', strtotime($_getTrnHdr[0]->Tanggal)) . "\r\n";

                $_getTrnDtl             = $this->M_PotonganBon->getDataTrnDtlTel($nofix, $hdrid, $pemborong, $sub);
                $_getGrndTotalSembako   = $this->M_PotonganBon->getDataGrandTotalSembako($nofix, $hdr);
                $_totalPeriodeIni       = $this->M_PotonganBon->getTotalPeriodeIni($nofix, $periode);


                foreach ($_getTrnHdr as $hdr) {
                    $pesan .= "Nama :" . $hdr->Nama . "\r\n" .
                        $pesan .= "Pemborong :" . $hdr->Pemborong . "\r\n" .
                        // "Nofix : ".$hdr->Nofix."\r\n".
                        "Bagian : " . $hdr->BagianAbbr . "\r\n" . "\r\n";
                }

                foreach ($_getTrnDtl as $dtl) {
                    $pesan .= "Nama Item : " . $dtl->NamaItem . "\r\n" .
                        "Quantity : " . $dtl->Quantity . " " . $dtl->SingkatanSatuan . "\r\n" .
                        "Total Harga : Rp." . number_format($dtl->Total, 0, ",", ".") . "\r\n";
                }

                foreach ($_getGrndTotalSembako as $ttl) {
                    $grand = $ttl->GrandTotal;
                    $pesan .= "Grand : Rp." . number_format($grand, 0, ",", ".") . "\r\n";
                }

                $sisa_periode = '0';
                $pesan .= "Sisa Periode Lalu : Rp." . number_format($sisa_periode, 0, ",", ".") . "\r\n";

                foreach ($_totalPeriodeIni as $key) {
                    $pot_sembako = $key->Pot_Sembako;
                    $pesan .= "Total Periode Ini : Rp." . number_format($pot_sembako, 0, ",", ".") . "\r\n";
                }

                foreach ($tglMulai as $tgl) {
                    if ($tgl->TanggalMulai != NULL) {
                        $tgl_mulai = $tgl->TanggalMulai;
                        $_totalCicilanPeriodeIni  = $this->M_PotonganBon->getPotCicilanPeriodeIni($nofix, $tgl_mulai, $periode);
                        $pot_cicilan = 0;
                        $pesan .= "Total Cicilan Periode Ini : Rp." . number_format($pot_cicilan, 0, ",", ".") . "\r\n";
                        $grand_total = $sisa + $pot_sembako + $pot_cicilan;
                        $pesan .= "Grand Total: Rp." . number_format($grand_total, 0, ",", ".") . "\r\n";
                    } else {
                        $tgl_mulai = '';
                        $_totalCicilanPeriodeIni  = $this->M_PotonganBon->getPotCicilanPeriodeIni($nofix, $tgl_mulai, $periode);
                        $pot_cicilan = $tgl->Pot_Cicilan;
                        $pesan .= "Total Cicilan Periode Ini : Rp." . number_format($pot_cicilan, 0, ",", ".") . "\r\n";
                        $grand_total = $sisa + $pot_sembako + $pot_cicilan;
                        $pesan .= "Grand Total: Rp." . number_format($grand_total, 0, ",", ".") . "\r\n";
                    }
                }

                // $grand_total = $sisa + $pot_sembako + $pot_cicilan;
                // $pesan .= "Grand Total: Rp.".number_format($grand_total,0,",",".")."\r\n";

                if ($this->session->userdata("dept") == "ITD") {
                    $pesan .= "TEST PROGRAMMER" . "\r\n\n";
                }

                $pesan = trim($pesan, "\r\n");
                $dataTel = array(
                    'UserGroupID'   => 0,
                    'DataFrom'      => 'RO_BON',
                    // 'ToTelegramID'  => '615320904',
                    // 'ToTelegramID'  => '1234237008',
                    'ToTelegramID'  => $user_tel[0]->TelegramID,
                    // 'FirstName'     => 'LARNADIMI WAGIA',
                    // 'FirstName'     => 'TENGKU RIYAN RAMADHAN',
                    'FirstName'     => $user_tel[0]->nama,
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


            //=============================================================================//

            // END :: KIRIM KE TELEGRAM

        } // redirect('PotonganBon/ordermanual?msg=success');
    }

    function simpan_trn_potongan_pemborong()
    {

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
        $this->M_PotonganBon->update_trn_hdr($hdrid, $dataHdr);

        for ($i = 0; $i < $hitung; $i++) {
            // echo $total[$i];
            $dataDtl = array(
                'HeaderID'       => $hdrid,
                'IDPemborong'    => $pbrid,
                'IDSubPemborong' => $subpbr,
                'Nofix'          => $nofix,
                'ItemID'         => $item[$i],
                'Harga'          => str_replace(".", "", $harga[$i]),
                'HargaID'        => $hargaid[$i],
                'Quantity'       => $qty[$i],
                'SatuanID'       => $satuan[$i],
                'KategoriID'     => $kategori[$i],
                'Total'          => str_replace(".", "", $total[$i]),
                'CreatedBy'      => $this->session->userdata("username"),
                'CreatedDate'    => date('Y-m-d H:i:s')
            );

            // echo "<pre>";
            // print_r($dataDtl);
            $cek_harga = $this->M_PotonganBon->CekHarga($item[$i], $subpbr);
            if ($cek_harga[0]->Harga == str_replace(".", "", $harga[$i])) {
                // jika harga sama 
                $cek_dtl = $this->M_PotonganBon->cek_dtl($dtlid[$i]);
                if ($cek_dtl == NULL) {
                    $this->M_PotonganBon->simpan_trn_dtl($dataDtl);
                } else {
                    $this->M_PotonganBon->update_trn_dtl($dtlid[$i], $dataDtl);
                }
            } else {
                // jika Harga tidak sama :
                $cek_dtl = $this->M_PotonganBon->cek_dtl($dtlid[$i]);
                if ($cek_dtl == NULL) {
                    $this->M_PotonganBon->simpan_trn_dtl($dataDtl);
                } else {
                    $this->M_PotonganBon->update_trn_dtl($dtlid[$i], $dataDtl);
                }

                $dataHarga = array(
                    'Harga' => str_replace(".", "", $harga[$i]),
                );

                $this->M_PotonganBon->update_harga($hargaid[$i], $dataHarga);

                $dataHistoryHarga = array(
                    'DetailHargaID'  => $hargaid[$i],
                    'HeaderHargaID'  => $cek_harga[0]->HeaderHargaID,
                    'IDPemborong'    => $pbrid,
                    'IDSubPemborong' => $subpbr,
                    'ItemID'         => $item[$i],
                    'SatuanID'       => $satuan[$i],
                    'KategoriID'     => $kategori[$i],
                    'Harga'          => str_replace(".", "", $cek_harga[0]->Harga),
                    'CreatedBy'      => $this->session->userdata('username'),
                    'CreatedDate'    => date('Y-m-d H:i:s')
                );

                $this->M_PotonganBon->simpan_history($dataHistoryHarga);
            }
        }
        redirect("PotonganBon/TransaksiPotonganBon?msg=success");
    }


    #TRANSAKSI CICILAN
    function Cicilan()
    {
        $tanggal = date('Y-m-d');
        $tanggal_cicil = date('j', strtotime($tanggal));
        // echo 'hahahah';


        if ($tanggal_cicil >= 14 && $tanggal_cicil <= 26) {
            $periode = date('Y-m-16', strtotime($tanggal));
        } else {
            if ($tanggal_cicil == 26 || $tanggal_cicil == 27 || $tanggal_cicil == 28 || $tanggal_cicil == 29 || $tanggal_cicil == 30 || $tanggal_cicil == 31) {
                $bul        = date('Y-m-d', strtotime('+ 1 months'));
                $bln        = date('m', strtotime($bul));
                $bln_fix = str_pad($bln, 2, '0');
                $tahun = date('Y', strtotime($bul));
                $periode    = date($tahun . '-' . $bln_fix . '-1', strtotime($tanggal));
            } else {
                $periode = date('Y-m-1', strtotime($tanggal));
            }
        }
        // // exit;
        $data['tanggal'] = $periode;
        $data['_getListOrder']      = $this->M_PotonganBon->_getListCicilan($periode);
        $data['_getDataPemborong']  = $this->M_PotonganBon->SelectMstPemborong();
        $this->template->display('potongan_bon/cicilan/index', $data);
    }

    function set_status()
    {
        $dtlid = $this->uri->segment(3);

        $data = array(
            'InActive'     => 1,
            'InActiveBy'   => $this->session->userdata('username'),
            'InActiveDate' => date('Y-m-d H:i:s')
        );

        $result = $this->M_PotonganBon->update_cicilan_dtl($dtlid, $data);
        echo json_encode($result);
    }

    function ajaxListCicilan()
    {
        $pbr       = $this->uri->segment(3);
        $sub       = $this->uri->segment(4);
        $periode   = $this->uri->segment(5);
        $bulan     = $this->uri->segment(6);
        $tahun     = $this->uri->segment(7);

        $periode1 = date($tahun . '-' . $bulan . '-' . $periode);
        $periode2 = date($tahun . '-' . $bulan . '-' . $periode);
        if ($periode == 1) {
            $data['_getListOrder']      = $this->M_PotonganBon->_ajaxgetListCicilan($pbr, $sub, $periode1);
        } else {
            $data['_getListOrder']      = $this->M_PotonganBon->_ajaxgetListCicilan($pbr, $sub, $periode1);
        }

        $this->load->view('potongan_bon/cicilan/ajaxListCicilan', $data);
    }

    function tambahCicilan()
    {
        $data['_getDataPemborong']  = $this->M_PotonganBon->SelectMstPemborong();
        $data['_getMstKategori']    = $this->M_PotonganBon->GetMstKategoriCicilan();
        $data['_getMstSatuan']      = $this->M_PotonganBon->GetMstSatuan();
        $data['_getListItem']       = $this->M_PotonganBon->GetMstCicilan();
        $this->template->display('potongan_bon/cicilan/tambah', $data);
        // if ($this->session->userdata('username') == 'KIKI IRVANSYAH ') {
        //     $this->template->display('potongan_bon/cicilan/tambah', $data);
        // } else {
        //     echo 'perbaikan by programmer';
        // }
    }

    function ajaxCariTenagaKerja()
    {
        if ($this->input->is_ajax_request()) {
            $search            = $this->input->post('ajax_kata_kunci');
            $idSubPbr          = $this->input->post('ajax_sub_pemborong');
            $data['_getTK']    = $this->M_PotonganBon->CariTKSubPemborong($idSubPbr, $search);
            $this->load->view('potongan_bon/transaksi/list_search', $data);
        }
    }

    function ajaxGetSubPemborong($idPbr = 0)
    {
        if ($this->input->is_ajax_request()) {
            $list_sub = $this->M_PotonganBon->selectMstSubPemborong($idPbr);
            $option = "";

            if (count($list_sub) > 0) {
                $option .= "<option value=''>-- Pilih Sub Pemborong --</option>";
                if (count($list_sub) == 1) {
                    $sel = 'selected';
                } else {
                    $sel = "";
                }
                foreach ($list_sub as $key => $sub) {
                    $option .= "<option value='{$sub->IDSubPemborong}' {$sel}>{$sub->Perusahaan}</option>";
                }
                // $option .= "<input type='hidden' name='txtSubPemborong' id='select-sub-pemborong' class='form-control' value=' {$list_sub[0]->IDSubPemborong} ' readonly required>";
                // $option .= "<input type='text' class='form-control' value='{$list_sub[0]->Perusahaan}' readonly required>";
            } else {
                $option .= "<option value=''>-- Sub Pemborong Tidak Ditemukan --</option>";
            }

            echo $option;
        }
    }
    function ajax_satuanNew()
    {
        $item = $this->uri->segment(3);

        $get_satuan = $this->M_PotonganBon->get_ItemNew($item);
        foreach ($get_satuan as $key) {
            echo $key->SingkatanSatuan;
        }
    }

    function ajax_satuanidNew()
    {
        $item = $this->uri->segment(3);

        $get_satuan = $this->M_PotonganBon->get_ItemNew($item);
        foreach ($get_satuan as $key) {
            echo $key->SatuanID;
        }
    }

    function ajax_kategoriNew()
    {
        $item = $this->uri->segment(3);

        $get_satuan = $this->M_PotonganBon->get_ItemNew($item);
        foreach ($get_satuan as $key) {
            echo $key->NamaKategori;
        }
    }
    function ajax_kategoriidNew()
    {
        $item = $this->uri->segment(3);

        $get_satuan = $this->M_PotonganBon->get_ItemNew($item);
        foreach ($get_satuan as $key) {
            echo $key->KategoriCicilanID;
        }
    }

    function ajax_list_item_cicilan()
    {
        $pbr   = $this->uri->segment(3);
        $sub   = $this->uri->segment(4);

        $data['_getListItem'] = $this->M_PotonganBon->GetTrnListItem($pbr);
        $data['pemborong'] = $pbr;
        $this->load->view("potongan_bon/transaksi/mstListItem", $data);
    }

    function simpan_trn_cicilan()
    {
        // Header
        // echo"<pre>";
        // print_r($this->input->post());
        // echo"</pre>";

        $tanggal   = $this->input->post("txtTanggal");
        $pemborong = $this->input->post("txtPemborong");
        $sub_pbr   = $this->input->post('txtSubPemborong');
        $nofix     = $this->input->post("txtNofix");


        $tanggal_periode = date('j', strtotime($tanggal));

        if ($tanggal_periode >= 14 && $tanggal_periode <= 26) {
            $periode = date('Y-m-16', strtotime($tanggal));
        } else {
            if ($tanggal_periode == 26 || $tanggal_periode == 27 || $tanggal_periode == 28 || $tanggal_periode == 29 || $tanggal_periode == 30 || $tanggal_periode == 31) {
                $bul        = date('Y-m-d', strtotime('+ 1 months'));
                $bln        = date('m', strtotime($bul));
                $bln_fix = str_pad($bln, 2, '0');
                $tahun = date('Y', strtotime($bul));
                $periode    = date($tahun . '-' . $bln_fix . '-1', strtotime($tanggal));
                //  echo "OK";
            } else {
                $periode = date('Y-m-1', strtotime($tanggal));
                // echo "lanjut";
            }
        }

        $dataHdr = array(
            'Tanggal'        => date('Y-m-d H:i:s', strtotime($tanggal)),
            'IDPemborong'    => $pemborong,
            'IDSubPemborong' => $sub_pbr,
            'PeriodeGajian'  => $periode,
            'Nofix'          => $nofix,
            'StatusProses'   => 1,
            'CreatedBy'      => $this->session->userdata('username'),
            'CreatedDate'    => date('Y-m-d H:i:s')
        );
        //          echo "<pre>";
        //                  print_r($dataHdr);
        //                  exit;
        //         echo "<pre>";
        //         print_r($dataHdr);
        // exit;
        if ($nofix == NULL) {
            // echo $nofix;
            redirect('PotonganBon/tambahCicilan?msg=failed2');
        } else {
            $hdrid = $this->M_PotonganBon->simpan_cicilan_hdr($dataHdr); // Simpan Header Cicilan

            $item            = $this->input->post('txtItem');


            $harga           = $this->input->post('txtHarga');
            $dp              = $this->input->post('txtDp');
            $quantity        = $this->input->post('txtQuantity');
            $satuan          = $this->input->post('txtSatuanid');
            $kategori        = $this->input->post('txtKategoriid');
            $periode         = $this->input->post('txtPeriode');
            $mulai           = $this->input->post('txtMulai');
            $periodepotong   = $this->input->post('txtperiodepotong');
            $total           = $this->input->post('txtTotal');
            $hitung          = count($item);
            //  print_r($item); exit;


            //  echo "<pre>";
            //           print_r($mulai);
            //           exit;
            for ($i = 0; $i < $hitung; $i++) {
                // Cek apakah item id Numeric atau bukan => Jika bukan insert data master cicilan
                $item_id   = $item[$i];
                //  $item_new  = explode(",",$item[$i]);
                //  $namaItem[$i]  = $item_new[1];
                if (!is_numeric($item_id)) {
                    $kode = $this->M_PotonganBon->GetKodeItemCicilan();
                    $kode_item = sprintf("%05s", ($kode + 1));
                    $data_item_cicilan = [
                        'KodeCicilanID'     => $kode_item[$i],
                        'NamaCicilan'       => $item[$i],
                        'SatuanID'          => $satuan[$i],
                        'KategoriCicilanID' => $kategori[$i],
                        'CreatedBy'         => $this->session->userdata('username'),
                        'CreatedDate'       => date('Y-m-d H:i:s')
                    ];

                    //  $item_id = $this->M_PotonganBon->simpan_mst_item_cicilan($data_item_cicilan);
                }
                $tanggal_cicil = date('j', strtotime($mulai[$i]));
                $thn = date('Y', strtotime($mulai[$i]));
                if ($mulai[$i] == $thn . '-01-29' || $mulai[$i] == $thn . '-01-30' || $mulai[$i] == $thn . '-01-31') {
                    if ($tanggal_cicil >= 14 && $tanggal_cicil <= 26) {
                        $tanggalMulai[$i] = date('Y-m-16', strtotime($mulai[$i]));
                    } else {
                        if ($tanggal_cicil == 26 || $tanggal_cicil == 27 || $tanggal_cicil == 28 || $tanggal_cicil == 29 || $tanggal_cicil == 30 || $tanggal_cicil == 31) {
                            $bln        = date('m', strtotime($mulai[$i])) + 1;
                            $tanggalMulai[$i]    = date('Y-0' . $bln . '-1', strtotime($mulai[$i]));
                        } else {
                            $tanggalMulai[$i] = date('Y-m-1', strtotime($mulai[$i]));
                            echo $tanggalMulai[$i];
                        }
                    }
                } else {
                    if ($tanggal_cicil >= 14 && $tanggal_cicil <= 26) {
                        $tanggalMulai[$i] = date('Y-m-16', strtotime($mulai[$i]));
                    } else {
                        if ($tanggal_cicil == 26 || $tanggal_cicil == 27 || $tanggal_cicil == 28 || $tanggal_cicil == 29 || $tanggal_cicil == 30 || $tanggal_cicil == 31) {
                            $bul        = date('Y-m-d', strtotime('+ 1 months')); // penambahan baru 26-12-2022
                            $bln        = date('m', strtotime($bul));
                            $bln_fix = str_pad($bln, 2, '0');
                            $tahun = date('Y', strtotime($bul));
                            $tanggalMulai[$i]    = date($tahun . '-' . $bln_fix . '-1', strtotime($mulai[$i]));
                        } else {
                            $tanggalMulai[$i] = date('Y-m-1', strtotime($mulai[$i]));
                            echo $tanggalMulai[$i];
                        }
                    }
                }

                // if ($tanggal_cicil >= 14 && $tanggal_cicil <= 26) {
                //     $tanggalMulai[$i] = date('Y-m-16', strtotime($mulai[$i]));
                // } else {
                //     if ($tanggal_cicil == 26 || $tanggal_cicil == 27 || $tanggal_cicil == 28 || $tanggal_cicil == 29 || $tanggal_cicil == 30 || $tanggal_cicil == 31) {
                //         $bul        = date('Y-m-d', strtotime('+ 1 months'));
                //         $bln        = date('m', strtotime($bul));
                //         $bln_fix    = str_pad($bln, 2, '0');
                //         $tahun      = date('Y', strtotime($bul));
                //         $tanggalMulai[$i]    = date($tahun . '-' . $bln_fix . '-1', strtotime($mulai[$i]));
                //         // echo "OK";

                //     } else {
                //         $tanggalMulai[$i] = date('Y-m-1', strtotime($mulai[$i]));
                //         // echo "lanjut";
                //     }
                // }

                // echo "<pre>";
                // print_r($tanggalMulai);
                // exit;
                //ini dia
                $dataDtl = array(
                    'HeaderID'          => $hdrid,
                    'IDPemborong'       => $pemborong,
                    'IDSubPemborong'    => $sub_pbr,
                    'Nofix'             => $nofix,
                    'DP'                => $dp[$i],
                    'CicilanID'         => $item_id,
                    //  'NamaItem'       => $namaItem[$i],
                    'Harga'             => str_replace(".", "", $harga[$i]),
                    'Quantity'          => $quantity[$i],
                    'SatuanID'          => $satuan[$i],
                    'KategoriCicilanID' => $kategori[$i],
                    'Cicilan'           => $periode[$i],
                    'TanggalMulai'      => date('Y-m-d', strtotime($tanggalMulai[$i])),
                    'PeriodeDipotong'   => $periodepotong[$i],
                    'HargaCicilan'      => $total[$i],
                    'CreatedBy'         => $this->session->userdata('username'),
                    'CreatedDate'       => date('Y-m-d H:i:s')
                );

                // jika Harga tidak sama :
                //  echo "<pre>";
                //  print_r($dataDtl);
                //  exit;
                $cek_transaksiDtl = $this->M_PotonganBon->cek_transaksiDtl($nofix, $kategori[$i], $satuan[$i], $item_id);
                //  print_r($cek_transaksiDtl);
                //  exit;

                // if(date('Y-m-d', strtotime($tanggalMulai[$i])) < $periode){
                //     echo "oh yeah";
                //     die;
                // }else{
                //     echo "NNOOOO";
                //     die;
                // }
                // die;
                if ($cek_transaksiDtl != NULL) {
                    redirect('PotonganBon/tambahCicilan?msg=failed3');
                } else {
                    $this->M_PotonganBon->simpan_cicilan_dtl($dataDtl);
                }

                //  if ($kategori[$i] == NULL || $kategori[$i] == 0) {
                //      redirect('PotonganBon/tambahCicilan?msg=failed4');
                //  } else {
                //      $dtlid = $this->M_PotonganBon->simpan_cicilan_dtl($dataDtl);
                //  }

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

            //=============================================================================//

            $user_tel = $this->M_PotonganBon->GetUserTelegram($nofix);
            // echo $hdrid;
            if ($user_tel == NULL) {
                //                  // echo "Tenaga Kerja Tidak Memiliki Telegram";
                redirect('PotonganBon/Cicilan?msg=success');
            } else {
                $pesan = "INFO POTONGAN CICILAN : \r\n";
                $_getDtlCicilan = $this->M_PotonganBon->get_detail_cicilan($nofix, $hdrid);

                // echo "<pre>";
                // print_r($_getDtlCicilan);

                $jml = count($_getDtlCicilan);
                for ($i = 0; $i < $jml; $i++) {
                    // echo $jml;
                    foreach ($_getDtlCicilan as $get) {
                        if ($get->PeriodeDipotong == 1) {
                            $dipotong = 1;
                        } elseif ($get->PeriodeDipotong == 2) {
                            $dipotong = 2;
                        } else {
                            $dipotong = "1 dan 2";
                        }
                        $pesan .= "Nama Item : " . $get->NamaCicilan . "\r\n" .
                            "Harga Full : Rp." . number_format($get->Harga, 0, ",", ".") . "\r\n" .
                            "DP : Rp. " . number_format($get->DP, 0, ",", ".") . "\r\n" .
                            "(x) Dipotong : " . $get->Cicilan . "x" . "\r\n" .
                            "Dipotong Periode : " . $dipotong . "\r\n" .
                            "Nominal Pemotongan : Rp." . number_format($get->HargaCicilan, 0, ",", ".") . "\r\n";
                    }
                }

                $pesan = trim($pesan, "\r\n");
                $dataTel = array(
                    'UserGroupID'   => 0,
                    'DataFrom'      => 'RO_BON',
                    'ToTelegramID'  => $user_tel[0]->TelegramID,
                    //  'ToTelegramID'  => '1234237008',
                    'FirstName'     => $user_tel[0]->FirstName,
                    //  'FirstName'     => 'TENGKU RIYAN RAMADHAN',
                    'Messages'      => $pesan,
                    'ImageReport'   => NULL,
                    'SendingTime'   => date('Y-m-d H:i:s'),
                    'PendingStatus' => 1,
                    'SuccessStatus' => 0,
                );
                //  echo"<pre>";
                //  print_r( $dataTel);
                //  exit;
                $this->m_monitor->send_info($dataTel);
            }
            //=============================================================================//
            //  redirect('PotonganBon/Cicilan?msg=success');
        }
    }
    function lihat_pesanan_cicilan()
    {
        $tanggal = $this->uri->segment(3);
        $nofix = $this->uri->segment(4);
        $sub_pbr = $this->uri->segment(5);
        $id = $this->uri->segment(6);

        $data['_getMstKategori']   = $this->M_PotonganBon->GetMstKategoriCicilan();
        $data['_getMstSatuan']     = $this->M_PotonganBon->GetMstSatuan();
        $data['_getListItem']      = $this->M_PotonganBon->GetMstCicilan();

        // Data yang sudah ada
        $data['_getTrnHeader']     = $this->M_PotonganBon->_getTrnHDR($tanggal, $nofix, $sub_pbr, $id);
        $_trnHeader                = $data['_getTrnHeader'];
        $data['_getTrnDetail']     = $this->M_PotonganBon->_getTrnDTL($_trnHeader[0]->HeaderID);
        $data['_getGrandTotal']    = $this->M_PotonganBon->_getGrandTotalCicilan($_trnHeader[0]->HeaderID);

        $this->template->display('potongan_bon/cicilan/proses', $data);
    }

    function HapusCicilan($header_id)
    {

        $data = array(
            'DeletedBy'          => $this->session->userdata('username'),
            'DeletedDate'        => date('Y-m-d H:i:s')
        );

        if ($this->M_PotonganBon->delete_trn_cicilan($header_id, $data)) {
            //  if ($this->M_PotonganBon->delete_trn_cicilan($header_id)) {
            $this->session->set_flashdata('success', 'Berhasil menghapus data ...');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data ...');
        }
        redirect('PotonganBon/Cicilan');
    }

    function simpan_trn_potongan_cicilan()
    {
        $hdrid           = $this->input->post("txtHeaderID");
        $tgl             = $this->input->post("txtTanggal");
        $nofix           = $this->input->post("txtNofix");
        $pbrid           = $this->input->post("txtPemborong");
        $subpbrid        = $this->input->post('txtSubPemborong');

        // Detail
        $dtlid         = $this->input->post("txtDetailID");
        $item          = $this->input->post("txtItem");
        $harga         = $this->input->post("txtHarga");
        $dp            = $this->input->post("txtDp");
        $qty           = $this->input->post("txtQuantity");
        $satuan        = $this->input->post("txtSatuanid");
        $kategori      = $this->input->post("txtKategoriid");
        $periode       = $this->input->post("txtPeriode");
        $periodeke     = $this->input->post("txtPeriodeke");
        $durasi        = $this->input->post("txtDurasi");
        $keterangan    = $this->input->post("txtKeterangan");
        $mulai         = $this->input->post("txtMulai");
        $periodepotong = $this->input->post('txtperiodepotong');
        $total         = $this->input->post("txtTotal");
        $hitung        = count($harga);



        // print_r("asd".$durasi[0]);
        // echo'<pre>';
        if ($durasi[0] === "") {
            $durasi[0] = null;
        } else {
            $durasi[0] = $durasi[0];
        }
        // print_r("Tampil".$durasi[0]);
        // exit;
        $cek_durasi = $this->M_PotonganBon->cekDurasi($nofix);

        $dataHdr = array(
            // 'StatusProses' => 1, 
            'UpdatedBy'     => $this->session->userdata("username"),
            'UpdatedDate'   => date('Y-m-d H:i:s')
        );

        $this->M_PotonganBon->update_cicilan_hdr($hdrid, $dataHdr);

        for ($i = 0; $i < $hitung; $i++) {
            // echo $periodepotong[$i];
            if (!empty($dtlid[$i])) {
                // Cek apakah item id Numeric atau bukan => Jika bukan insert data master cicilan
                // echo $item[$i];
                $item_id = $item[$i];
                if (!is_numeric($item_id)) {
                    $kode = $this->M_PotonganBon->GetKodeItemCicilan();
                    $kode_item = sprintf("%05s", ($kode + 1));
                    $data_item_cicilan = [
                        'KodeCicilanID'      => $kode_item,
                        'NamaCicilan'        => $item[$i],
                        'SatuanID'           => $satuan[$i],
                        'KategoriCicilanID'  => $kategori[$i],
                        'CreatedBy'          => $this->session->userdata('username'),
                        'CreatedDate'        => date('Y-m-d H:i:s')
                    ];

                    //  $item[$i] = $this->M_PotonganBon->simpan_mst_item_cicilan($data_item_cicilan);
                }
                // $tanggal_cicil = date('j', strtotime($mulai[$i]));
                // if ($tanggal_cicil >= 14 && $tanggal_cicil <= 26) {
                //     $tanggalMulai[$i] = date('Y-m-16', strtotime($mulai[$i]));
                // } else {
                //     if ($tanggal_cicil == 26 || $tanggal_cicil == 27 || $tanggal_cicil == 28 || $tanggal_cicil == 29 || $tanggal_cicil == 30 || $tanggal_cicil == 31) {
                //         $bul        = date('Y-m-d', strtotime('+ 1 months'));
                //         $bln        = date('m', strtotime($bul));
                //         $bln_fix    = str_pad($bln, 2, '0');
                //         $tahun      = date('Y', strtotime($bul));
                //         $tanggalMulai[$i]    = date($tahun . '-' . $bln_fix . '-1', strtotime($mulai[$i]));
                //     } else {
                //         $tanggalMulai[$i] = date('Y-m-1', strtotime($mulai[$i]));
                //     }
                // }

                $tanggal_cicil = date('j', strtotime($mulai[$i]));
                $thn = date('Y', strtotime($mulai[$i]));
                if ($mulai[$i] == $thn . '-01-29' || $mulai[$i] == $thn . '-01-30' || $mulai[$i] == $thn . '-01-31') {
                    if ($tanggal_cicil >= 14 && $tanggal_cicil <= 26) {
                        $tanggalMulai[$i] = date('Y-m-16', strtotime($mulai[$i]));
                    } else {
                        if ($tanggal_cicil == 26 || $tanggal_cicil == 27 || $tanggal_cicil == 28 || $tanggal_cicil == 29 || $tanggal_cicil == 30 || $tanggal_cicil == 31) {
                            $bln        = date('m', strtotime($mulai[$i])) + 1;
                            $tanggalMulai[$i]    = date('Y-0' . $bln . '-1', strtotime($mulai[$i]));
                        } else {
                            $tanggalMulai[$i] = date('Y-m-1', strtotime($mulai[$i]));
                            echo $tanggalMulai[$i];
                        }
                    }
                } else {
                    if ($tanggal_cicil >= 14 && $tanggal_cicil <= 26) {
                        $tanggalMulai[$i] = date('Y-m-16', strtotime($mulai[$i]));
                    } else {
                        if ($tanggal_cicil == 26 || $tanggal_cicil == 27 || $tanggal_cicil == 28 || $tanggal_cicil == 29 || $tanggal_cicil == 30 || $tanggal_cicil == 31) {
                            $bul        = date('Y-m-d', strtotime('+ 1 months')); // penambahan baru 26-12-2022
                            $bln        = date('m', strtotime($bul));
                            $bln_fix = str_pad($bln, 2, '0');
                            $tahun = date('Y', strtotime($bul));
                            $tanggalMulai[$i]    = date($tahun . '-' . $bln_fix . '-1', strtotime($mulai[$i]));
                        } else {
                            $tanggalMulai[$i] = date('Y-m-1', strtotime($mulai[$i]));
                            echo $tanggalMulai[$i];
                        }
                    }
                }

                $dataDtl = array(
                    'harga'           => $harga[$i],
                    'TanggalMulai'    => $tanggalMulai[$i],
                    'PeriodeDipotong' => $periodepotong[$i],
                    'Cicilan'         => $periode[$i],
                    'SisaDurasi'      => $durasi[$i],
                    'Keterangan'      => $keterangan[$i],
                    'UpdatedBy'       => $this->session->userdata("username"),
                    'UpdatedDate'     => date('Y-m-d H:i:s')
                );
                // echo $periodepotong[$i];
                //     print_r($dataDtl);
                // exit;
                $this->M_PotonganBon->update_cicilan_dtl($dtlid[$i], $dataDtl);

                $cek_durasi = $this->M_PotonganBon->cekDurasi($nofix);
                // foreach ($cek_durasi as $get) {
                //     $dataDtl2 = array(
                //         // 'SisaDurasi'   => $get->Durasi,
                //         'SisaDurasi'   => $durasi[$i],
                //     );

                //     $this->M_PotonganBon->update_cicilan_dtl($dtlid[$i], $dataDtl2);
                // }
            } else {
                $dataDtl = array(
                    'Harga'        => $harga[$i],
                    'DP'           => $dp[$i],
                    'Quantity'     => $qty[$i],
                    'Cicilan'      => $periode[$i],
                    'TanggalMulai' => $mulai[$i],
                    'HargaCicilan' => $total[$i],
                    'CicilanKe'    => $periodeke[$i],
                    'SisaDurasi'   => $cek_durasi[0]->Durasi,
                    'Keterangan'   => $keterangan[0]->Keterangan,
                    'UpdatedBy'    => $this->session->userdata("username"),
                    'UpdatedDate'  => date('Y-m-d H:i:s')
                );

                $this->M_PotonganBon->update_cicilan_dtl($dtlid[$i], $dataDtl);
            }
            // echo "<pre>";
            // print_r($dataDtl);
            // exit;

            $dataHistoryHarga = array(
                'IDPemborong'    => $pbrid,
                'IDSubPemborong' => $subpbrid,
                'ItemID'         => $item[$i],
                'SatuanID'       => $satuan[$i],
                'KategoriID'     => $kategori[$i],
                'Harga'          => str_replace(".", "", $harga[$i]),
                'CreatedBy'      => $this->session->userdata('username'),
                'CreatedDate'    => date('Y-m-d H:i:s')
            );
        }

        redirect("PotonganBon/Cicilan?msg=success");
    }

    function getPeriodeDipotong()
    {
        $tgl = $this->uri->segment(3);

        if ($tgl >= 14 && $tgl <= 26) {
            echo '<select class="form-control" name="txtperiodepotong" id="periodepotong" required>
                     <option value="2" selected>2</option>
                     <option value="3">1 dan 2</option>
                 </select>';
        } else {
            echo '<select class="form-control" name="txtperiodepotong" id="periodepotong" required>
                     <option value="">- Pilih -</option>
                     <option value="1" selected>1</option>
                     <option value="3">1 dan 2</option>
                 </select>';
        }
    }
    #end transaksi cicilan

    // BEGIN :: MONITORING CICILAN

    function Mnt_Cicilan()
    {

        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getDataSub']        = $this->M_PotonganBon->getMstSubPemborong();
        $this->template->display('potongan_bon/monitoring/cicilan/index', $data);
    }

    function ajaxMntCicilan()
    {
        $pbr = $this->uri->segment(3);
        $sub = $this->uri->segment(4);
        $periode = $this->uri->segment(5);
        $bulan = $this->uri->segment(6);
        $tahun = $this->uri->segment(7);

        if ($periode == 1) {
            $periodeGajian = $tahun . '-' . $bulan . '-01';
            $data['pbr'] = $pbr;
            $data['sub'] = $sub;
            $data['_getDataTrnCicilanhdr'] = $this->M_PotonganBon->getMonitoringCicilanhdr($pbr, $sub);
            $data['getSub']                = $this->M_PotonganBon->getMonitoringCicilanRow($pbr, $sub);
            $data['_getDataTrnCicilan'] = $this->M_PotonganBon->getMonitoringCicilan($pbr, $sub);
        } else {
            $data['pbr'] = $pbr;
            $data['sub'] = $sub;
            $periodeGajian = $tahun . '-' . $bulan . '-16';
            $data['_getDataTrnCicilanhdr'] = $this->M_PotonganBon->getMonitoringCicilanhdr($pbr, $sub);
            $data['getSub']                = $this->M_PotonganBon->getMonitoringCicilanRow($pbr, $sub);
            $data['_getDataTrnCicilan'] = $this->M_PotonganBon->getMonitoringCicilan($pbr, $sub);
        }

        $this->load->view('potongan_bon/monitoring/cicilan/list', $data);
    }

    function getViewCicilanLunas()
    {
        $dtl = $this->uri->segment(3);
        // echo $dtl."/".$nofix."/".$pbr."/".$sub;

        $data['_getDataList'] = $this->M_PotonganBon->getListDetailCicilanLunas($dtl);
        $this->load->view("potongan_bon/monitoring/cicilan/detail", $data);
    }

    function CicilanBySub()
    {
        ob_start();
        $sub = $this->uri->segment(3);
        $periode = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        if ($periode == 1) {
            $periodeGajian = $tahun . '-' . $bulan . '-01';
            $data['_getDataTrnCicilanhdr'] = $this->M_PotonganBon->getMonitoringCicilanhdrNew($sub);
            $data['_getDataTrnCicilan'] = $this->M_PotonganBon->getMonitoringCicilanNew($sub);
        } else {
            $periodeGajian = $tahun . '-' . $bulan . '-16';
            $data['_getDataTrnCicilanhdr'] = $this->M_PotonganBon->getMonitoringCicilanhdrNew($sub);
            $data['_getDataTrnCicilan'] = $this->M_PotonganBon->getMonitoringCicilanNew($sub);
        }

        $this->load->view('potongan_bon/monitoring/cicilan/pdf', $data);
        // echo "<pre>";
        // print_r($data['_getDataTrnCicilan']);

        $html   = ob_get_contents();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('L', 'A4', 'en');
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('Monitoring Cicilan.pdf');
    }


    function print_cicilan()
    {
        ob_start();
        $nofix = $this->uri->segment(3);
        $periode = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        if ($periode == 1) {
            $periodeGajian = $tahun . '-' . $bulan . '-01';
            $data['_getDataTrnCicilanDtl'] = $this->M_PotonganBon->getMonitoringCicilanByNofix($nofix);
            $data['_getDataTrnCicilan'] = $this->M_PotonganBon->getMonitoringCicilanhdrByNofix($nofix);
        } else {
            $periodeGajian = $tahun . '-' . $bulan . '-16';
            $data['_getDataTrnCicilanDtl'] = $this->M_PotonganBon->getMonitoringCicilanByNofix($nofix);
            $data['_getDataTrnCicilan'] = $this->M_PotonganBon->getMonitoringCicilanhdrByNofix($nofix);
        }

        $this->load->view('potongan_bon/monitoring/cicilan/pdfByNofix', $data);
        // echo "<pre>";
        // print_r($data['_getDataTrnCicilan']);

        $html   = ob_get_contents();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('Monitoring Cicilan By Nofix.pdf');
    }
    // END :: MONITORING CICILAN


    // BEGIN :: MONITORING POTONGAN PEMBORONG

    function MonitoringPotongan()
    {
        // if($this->session->userdata('userid') !=='riyan'){
        //     redirect(site_url('maintenanceControl'));
        // }
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborongNew();
        $data['_getDataSub']       = $this->M_PotonganBon->getMstSubPemborong();
        $status = $this->darurat->getStatus();
        // if ($this->session->userdata('userid') !== 'riyan') {
        //     redirect(site_url('maintenanceControl'));
        // } else {
        # code...
        $this->template->display('potongan_bon/monitoring/index', $data);
        // }
    }

    function MntSub($pbr)
    {
        $data['_getDataSub']    = $this->M_PotonganBon->getMstSub($pbr);
        $this->load->view('potongan_bon/monitoring/sub', $data);
    }
    function ajax_data_potongan()
    {
        $pbr        = $this->uri->segment(3);
        $sub        = $this->uri->segment(4);
        $periode    = $this->uri->segment(5);
        $bln        = $this->uri->segment(6);
        $thn        = $this->uri->segment(7);

        $periode = str_pad($periode, 2, '0', STR_PAD_LEFT);
        $bln = str_pad($bln, 2, '0', STR_PAD_LEFT);

        $periode1  = $thn . $bln . $periode;
        $periode2  = $thn . '-' . $bln . '-' . $periode;

        // echo $periode1;
        // echo $periode2;
        // exit;

        if ($periode == 01) {
            $data['_getDataSub'] = $this->M_PotonganBon->getDataCampuranSub($pbr, $sub, $periode1);
            $cicilan = $this->M_PotonganBon->cicilan($pbr, $sub);
            $data['Periode'] = $periode2;

            if (!empty($cicilan)) {
                foreach ($cicilan as $key) {
                    // echo "wkwkw1";
                    $data['tglMulai'] = $key->TanggalMulai;
                    $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan1($pbr, $sub, $periode2, $key->TanggalMulai);
                    $data['Periode'] = $periode2;
                    $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr, $sub, $periode2);
                    // echo "<pre>";
                    // print_r($data['_getDataCicilan']);exit;
                    // echo "</pre>";
                    $this->load->view('potongan_bon/monitoring/list', $data);
                }
            } else {
                // echo "haha1";
                $tglMulai = '';
                $data['tglMulai'] = $tglMulai;
                $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr, $sub, $periode2);
                $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan1($pbr, $sub, $periode2, $tglMulai);

                // echo "<pre>";
                // print_r($data['_getDataCicilan']);exit;
                // echo"</pre>";
                $this->load->view('potongan_bon/monitoring/list', $data);
            }
            //
        } elseif ($periode == 16) {
            $data['_getDataSub'] = $this->M_PotonganBon->getDataCampuranSub($pbr, $sub, $periode2);
            $cicilan = $this->M_PotonganBon->cicilan($pbr, $sub);
            $data['Periode'] = $periode2;

            if (!empty($cicilan)) {
                foreach ($cicilan as $key) {
                    // echo "wkwkw1";
                    $data['tglMulai'] = $key->TanggalMulai;
                    $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan2($pbr, $sub, $periode2, $key->TanggalMulai);
                    $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr, $sub, $periode2);
                    $this->load->view('potongan_bon/monitoring/list', $data);
                }
            } else {
                // echo "haha1";
                $tglMulai = '';
                $data['tglMulai'] = $tglMulai;
                $data['_getDataSisaCicilan'] = $this->M_PotonganBon->getDataSisaCicilan($pbr, $sub, $periode2);
                $data['_getDataCicilan'] = $this->M_PotonganBon->getDataCicilan2($pbr, $sub, $periode2, $tglMulai);

                $this->load->view('potongan_bon/monitoring/list', $data);
            }
        }
    }

    function detailSisaCicilan()
    {
        $nofix = $this->uri->segment(3);
        $periode = $this->uri->segment(4);

        $data['_getDataTrnHdr'] = $this->M_PotonganBon->getDataTrnHdr($nofix, $periode);
        $data['_getDataDetailSisaCicilan'] = $this->M_PotonganBon->getDetailSisaCicilan($nofix, $periode);
        $data['_getTotalDetail'] = $this->M_PotonganBon->getDetailTotal($nofix, $periode);

        $this->template->display('potongan_bon/monitoring/detail_sisa_cicilan', $data);
    }

    function get_detail_potongan()
    {
        $nofix = $this->uri->segment(3);
        $hdrid = $this->uri->segment(4);


        $data['_getDataTrnHdr'] = $this->M_PotonganBon->getDataTrnHdr($nofix, $hdrid);
        $data['_getDataTrnTanggal'] = $this->M_PotonganBon->getDataTrnTanggal($nofix, $hdrid);
        $data['_getDataTrnDtl'] = $this->M_PotonganBon->getDataTrnDtl($nofix, $hdrid);
        $data['_getDataTotalSem'] = $this->M_PotonganBon->getDataTotalSembako($nofix, $hdrid);
        $data['_getDataTotalCic'] = $this->M_PotonganBon->getDataTotalCicilan($nofix, $hdrid);
        $data['_getDataTrnTotal'] = $this->M_PotonganBon->getDataTrnTotal($nofix, $hdrid);
        $data['_getDataKategori'] = $this->M_PotonganBon->GetMstKategoriCicilan();

        // echo"<pre>";
        // print_r($data['_getDataTrnDtl']);
        // echo"</pre>";
        $this->template->display('potongan_bon/monitoring/detail', $data);
    }

    function detail_potongan_sembako()
    {
        $nofix                        = $this->uri->segment(3);
        $periode                      = $this->uri->segment(4);
        $data['_getDataTrnHdr']       = $this->M_PotonganBon->getDataTrnHdr($nofix, $periode);
        $data['_getDataTotalSem']     = $this->M_PotonganBon->totalsembako($nofix, $periode);
        $data['_getDataTotalSem1']    = $this->M_PotonganBon->getDataTotalSembako($nofix, $periode);

        $this->template->display('potongan_bon/monitoring/list_detail_sembako', $data);
    }

    function detail_potongan_cicilan()
    {
        $nofix                        = $this->uri->segment(3);
        $periode                      = $this->uri->segment(4);

        $periode1                     = date('j', strtotime($periode));

        // echo $periode;
        // exit;

        // echo "$periode1";
        if ($periode1 == 01) {
            $data['_getDataTrnHdr']   = $this->M_PotonganBon->getDataTrnHdr($nofix, $periode);
            $data['_getDataCicilan']  = $this->M_PotonganBon->getDataCicilanDetailPer1($nofix, $periode);
            $data['_getDataTotalCic'] = $this->M_PotonganBon->getDataTotalCicilanNew($nofix, $periode);
        } else {
            $data['_getDataTrnHdr']   = $this->M_PotonganBon->getDataTrnHdr($nofix, $periode);
            $data['_getDataCicilan']  = $this->M_PotonganBon->getDataCicilanDetailNew($nofix, $periode);
            $data['_getDataTotalCic'] = $this->M_PotonganBon->getDataTotalCicilan($nofix, $periode);
        }

        $this->template->display('potongan_bon/monitoring/list_detail_cicilan', $data);
    }

    function detail_potongan_sisa()
    {
        $nofix                        = $this->uri->segment(3);
        $hdrid                        = $this->uri->segment(4);


        $data['_getDataTrnHdr']       = $this->M_PotonganBon->getDataTrnHdr($nofix, $hdrid);
        $data['_getDataTrnTanggal']   = $this->M_PotonganBon->getDataTrnTanggal($nofix, $hdrid);
        $data['_getDataTrnDtl']       = $this->M_PotonganBon->getDataTrnDtl($nofix, $hdrid);
        $data['_getDataTotalSisa']    = $this->M_PotonganBon->getDataTotalSisa($nofix, $hdrid);



        $this->template->display('potongan_bon/monitoring/list_detail_sisa', $data);
    }

    // New Detail Sisa Periode Sebelumnya
    function detail_sisa_periode_sebelumnya()
    {
        $nofix                          = $this->uri->segment(3);
        $periode                        = $this->uri->segment(4);

        $data['_getDataTrnHdr']         = $this->M_PotonganBon->getDataTrnHdr($nofix, $periode);
        $data['_getSisaCicilan']        = $this->M_PotonganBon->getSisaCicilan($nofix, $periode);
        $data['_getSisaSembako']        = $this->M_PotonganBon->getSisaSembako($nofix, $periode);
        $data['_getSisaSembakoBaru']    = $this->M_PotonganBon->getSisaSembakoBaruSebelumnya($nofix, $periode);
        $this->template->display('potongan_bon/monitoring/detail_sisa_sebelumnya', $data);
    }

    function detail_sisa_periode_sebelumnya_tkbaru()
    {
        $nofix                    = $this->uri->segment(3);
        $periode                  = $this->uri->segment(4);

        $data['_getDataTrnHdr']   = $this->M_PotonganBon->getDataTrnHdr($nofix, $periode);
        $data['_getSisaCicilan']  = $this->M_PotonganBon->getSisaCicilanBaru($nofix, $periode);
        $data['_getSisaSembako']  = $this->M_PotonganBon->getSisaSembakoBaru($nofix, $periode);
        $this->template->display('potongan_bon/monitoring/detail_sisa_sebelumnya_baru', $data);
    }

    // End

    function EksportExcelByNofix()
    {
        $this->load->library("Excel/PHPExcel");
        $nofix                    = $this->uri->segment(3);
        $periode                  = $this->uri->segment(4);

        $data['getDataPemborong'] = $this->M_PotonganBon->excelByNofix($nofix, $periode);
        $data['getDataKaryawan']  = $this->M_PotonganBon->dataNama($nofix, $periode);
        // echo "<pre>";
        // print_r($data['getDataPemborong']);
        // echo"</pre>";
        $this->load->view('potongan_bon/monitoring/ExcelByNofix', $data);
    }

    function print_data()
    {
        ob_start();
        $nofix    = $this->uri->segment(3);
        $tglMulai = $this->uri->segment(4);
        $periode  = $this->uri->segment(4);

        $cicilan  = $this->M_PotonganBon->cicilanByNofix($nofix);

        if (!empty($cicilan)) {
            $tanggal = date('j', strtotime($periode));

            if ($tanggal == '01') {
                foreach ($cicilan as $key) {
                    $PotSembako                     = $this->M_PotonganBon->PotonganSembakoByNofixAndPeriode($nofix, $periode);
                    if (!empty($PotSembako)) {
                        $data['tglMulai']           = $key->TanggalMulai;
                        $data['_getDataCicilan']    = $this->M_PotonganBon->getDataCicilanByNofix($nofix, $periode, $key->TanggalMulai);
                        $data['getDataPemborong']   = $this->M_PotonganBon->excelByNofix($nofix, $periode);
                        $data['getCicilan']         = $this->M_PotonganBon->KhususCicilan($nofix, $periode, $tglMulai);

                        $this->load->view('potongan_bon/monitoring/print', $data);
                    } else {
                        $data['tglMulai']           = $key->TanggalMulai;
                        $data['_getDataCicilan']    = $this->M_PotonganBon->getDataCicilanByNofix($nofix, $periode, $key->TanggalMulai);
                        $data['getDataPemborong']   = $this->M_PotonganBon->excelByNofix($nofix, $periode);
                        $data['getCicilan']         = $this->M_PotonganBon->KhususCicilan($nofix, $periode, $tglMulai);

                        $this->load->view('potongan_bon/monitoring/printTanpaSembako', $data);
                    }
                }
            } elseif ($tanggal == '16') {
                foreach ($cicilan as $key) {
                    $PotSembako                     = $this->M_PotonganBon->PotonganSembakoByNofixAndPeriode($nofix, $periode);
                    if (!empty($PotSembako)) {
                        $data['tglMulai']           = $key->TanggalMulai;
                        $data['_getDataCicilan']    = $this->M_PotonganBon->getDataCicilanByNofix($nofix, $periode, $key->TanggalMulai);
                        $data['getDataPemborong']   = $this->M_PotonganBon->excelByNofix($nofix, $periode);
                        $data['getCicilan']         = $this->M_PotonganBon->KhususCicilan2($nofix, $periode, $tglMulai);

                        $this->load->view('potongan_bon/monitoring/print', $data);
                    } else {
                        $data['tglMulai']           = $key->TanggalMulai;
                        $data['_getDataCicilan']    = $this->M_PotonganBon->getDataCicilanByNofix($nofix, $periode, $key->TanggalMulai);
                        $data['getDataPemborong']   = $this->M_PotonganBon->excelByNofix($nofix, $periode);
                        $data['getCicilan']         = $this->M_PotonganBon->KhususCicilan2($nofix, $periode, $tglMulai);

                        $this->load->view('potongan_bon/monitoring/printTanpaSembako', $data);
                    }
                }
            }
        } else {

            $tglMulai                           = '';
            $data['tglMulai']                   = $tglMulai;
            $data['_getDataCicilan']            = $this->M_PotonganBon->getDataCicilanByNofix($nofix, $periode, $tglMulai);
            $data['getDataPemborong']           = $this->M_PotonganBon->excelByNofix($nofix, $periode);

            $this->load->view('potongan_bon/monitoring/printTanpaCicilan', $data);
        }

        $html   = ob_get_contents();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('Monitoring Potongan.pdf');
    }

    function ExportPDFBySub()
    {
        ob_start();
        $pbr        = $this->uri->segment(3);
        $sub        = $this->uri->segment(4);
        $periode    = $this->uri->segment(5);


        $periode1 = date('j', strtotime($periode));

        if ($periode1 == 01) {
            $data['_getDataSub']                    = $this->M_PotonganBon->getDataCampuranSub($pbr, $sub, $periode);
            $cicilan                                = $this->M_PotonganBon->cicilan($pbr, $sub);
            $data['Periode']                        = $periode1;
            if (!empty($cicilan)) {
                foreach ($cicilan as $key) {
                    $data['tglMulai']               = $key->TanggalMulai;
                    $data['_getDataCicilan']        = $this->M_PotonganBon->getDataCicilan1($pbr, $sub, $periode, $key->TanggalMulai);
                    $data['_getDataSisaCicilan']    = $this->M_PotonganBon->getDataSisaCicilan($pbr, $sub, $periode);
                    $this->load->view('potongan_bon/monitoring/pdfBySub', $data);
                }
            } else {
                $data['tglMulai']                   = '';
                $data['_getDataSisaCicilan']        = $this->M_PotonganBon->getDataSisaCicilan($pbr, $sub, $periode);
                $data['_getDataCicilan']            = $this->M_PotonganBon->getDataCampuran($pbr, $sub, $periode);
                $this->load->view('potongan_bon/monitoring/pdfBySub', $data);
            }
        } else {
            $data['_getDataSub']                    = $this->M_PotonganBon->getDataCampuranSub($pbr, $sub, $periode);
            $cicilan                                = $this->M_PotonganBon->cicilan($pbr, $sub);
            $data['Periode']                        = $periode1;
            if (!empty($cicilan)) {
                foreach ($cicilan as $key) {
                    $data['tglMulai']               = $key->TanggalMulai;
                    $data['_getDataCicilan']        = $this->M_PotonganBon->getDataCicilan2($pbr, $sub, $periode, $key->TanggalMulai);
                    $data['_getDataSisaCicilan']    = $this->M_PotonganBon->getDataSisaCicilan($pbr, $sub, $periode);
                    $this->load->view('potongan_bon/monitoring/pdfBySub', $data);
                }
            } else {
                $data['tglMulai']                   = '';
                $data['_getDataSisaCicilan']        = $this->M_PotonganBon->getDataSisaCicilan($pbr, $sub, $periode);
                $data['_getDataCicilan']            = $this->M_PotonganBon->getDataCampuran($pbr, $sub, $periode);
                $this->load->view('potongan_bon/monitoring/pdfBySub', $data);
            }
        }


        $html   = ob_get_contents();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('Monitoring Potongan Sub .pdf');
    }


    // START :: PERBANDINGAN HARGA

    function BandingHarga()
    {
        $data['_getDataPemborong']    = $this->M_PotonganBon->GetPemborongNew();
        $data['_getMstKategori']      = $this->M_PotonganBon->GetMstKategori();
        $data['_getItem']             = $this->M_PotonganBon->GetKodeItemResult();

        $this->template->display('potongan_bon/monitoring/BandingHarga/index', $data);
    }

    function ItemByKategori()
    {
        $kategori = $this->uri->segment(3);

        $data['GetItem']    = $this->M_PotonganBon->GetItemPerKategori($kategori);
        $this->load->view('potongan_bon/monitoring/BandingHarga/ajaxItem', $data);
    }

    function ajaxBandingHarga()
    {
        $pbr                = $this->uri->segment(3);
        $kategori           = $this->uri->segment(4);
        $item               = $this->uri->segment(5);

        $data['getData']    = $this->M_PotonganBon->GetPerbandinganHarga($pbr, $kategori, $item);
        $data['getItem']    = $this->M_PotonganBon->getItemBandingHarga($pbr, $kategori, $item);
        $data['getRow']     = $this->M_PotonganBon->GetPerbandinganHargaRow($pbr, $kategori, $item);

        $this->load->view('potongan_bon/monitoring/BandingHarga/ajax', $data);
    }

    //end perbandinganharga


    // MONITORING HARGA PER SUB UNTUK DI TAMPILKAN DI PBR INTI 

    function Mnt_Harga()
    {
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborongNew();
        $this->template->display('potongan_bon/monitoring/harga/index', $data);
    }

    function ajaxSubPemborong()
    {
        $pbr = $this->uri->segment(3);

        $data['_getSubPemborong'] = $this->M_PotonganBon->_getSubPemborong($pbr);

        $this->load->view('potongan_bon/monitoring/harga/ajax/sub', $data);
    }

    function ajaxListDataMntHarga()
    {
        $pbr = $this->uri->segment(3);
        $sub = $this->uri->segment(4);

        $data['_getListMntHarga'] = $this->M_PotonganBon->_getListMntHarga($pbr, $sub);

        $this->load->view('potongan_bon/monitoring/harga/ajax/listHarga', $data);
    }

    // BEGIN :: MODUL CATATAN HARGA BY PEMBORONG INTI

    function InputCatatanHarga()
    {
        $id_harga = $this->input->get('id');

        $data['id_harga'] = $id_harga;
        $data['getCatatan'] = $this->M_PotonganBon->getCatatanHarga($id_harga);
        $this->load->view("potongan_bon/monitoring/harga/ajax/catatan", $data);
    }

    function simpan_catatan_harga()
    {
        $dtlHrga = $this->input->post("txtDtlHarga");
        $catatan = $this->input->post("txtCatatan");

        $data = array(
            'Catatan'       => $catatan,
            'CatatanBy'     => $this->session->userdata('username'),
            'CatatanDate'   => date('Y-m-d H:i:s')
        );

        // echo "<pre>";
        // print_r($data);

        $this->M_PotonganBon->update_catatan($dtlHrga, $data);
        redirect(site_url('PotonganBon/Mnt_Harga'));
    }

    // END :: MODUL CATATAN HARGA BY PEMBORONG INTI


    #TRANSAKSI AKHIR

    function TransaksiAkhir()
    {
        $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();
        $data['_searchHistory'] = $this->session->userdata('_searchTA');

        $this->template->display('potongan_bon/finish/index', $data);
    }

    function ajax_data_transaksi()
    {
        $pbr        = $this->input->post('ajax_pbr');
        $subpbr     = $this->input->post('ajax_sub_pbr');
        $periode    = $this->input->post('ajax_periode');
        $bln        = $this->input->post('ajax_bulan');
        $bln        = str_pad($bln, 2, '0', STR_PAD_LEFT);
        $thn        = $this->input->post('ajax_tahun');

        // Keep History Search
        $this->session->set_userdata('_searchTA', $this->input->post());

        if ($periode == 1) {
            // Periode 1
            $tglAwal  = date($thn . '-' . $bln . '-01');
            $tglAkhir = date($thn . '-' . $bln . '-d', strtotime('+14 days', strtotime($tglAwal)));

            if ($bln == 1) {
                $periodeSebelumnnya = ($thn - 1) . '1202';
            } else {
                $periodeSebelumnnya = $thn . str_pad($bln - 1, 2, '0', STR_PAD_LEFT) . '02';
            }
        } else {
            // Periode 2
            $tglAwal  = date($thn . '-' . $bln . '-16');
            $tglAkhir = date('Y-m-t', strtotime($thn . '-' . $bln . '-16'));
            $periodeSebelumnnya = $thn . $bln . '01';
        }


        // Potongan Periode Ini
        $data['_getData'] = $this->M_PotonganBon->GetListTransaksiAkhir($pbr, $subpbr, $tglAwal, $tglAkhir, $periodeSebelumnnya);

        // Sisa Potongan Periode Lalu

        $data['periode'] = $periode;
        $data['tglAwal'] = $tglAwal;
        $data['tglAkhir'] = $tglAkhir;
        $this->load->view('potongan_bon/finish/list', $data);
    }

    function TransaksiAkhir_seleksi()
    {
        $NoFix = $this->uri->segment(3);
        $TanggalMulai = $this->uri->segment(4);
        $TanggalAkhir = $this->uri->segment(5);
        $periode = $this->uri->segment(6);
        $data['_periode'] = $this->uri->segment(6);

        $thn = date('Y', strtotime($TanggalMulai));
        $bln = date('n', strtotime($TanggalMulai));
        if ($periode == 1) {
            if ($bln == 1) {
                $periodeSebelumnnya = ($thn - 1) . '1202';
            } else {
                $periodeSebelumnnya = $thn . str_pad($bln - 1, 2, '0', STR_PAD_LEFT) . '02';
            }
        } else {
            // Periode 2
            $periodeSebelumnnya = $thn . str_pad($bln, 2, '0', STR_PAD_LEFT) . '01';
        }
        echo $periodeSebelumnnya;
        $data['_getInfo'] = $this->M_PotonganBon->GetInfoTransaksiAkhir($NoFix);
        $data['_getDataDetail'] = $this->M_PotonganBon->GetViewTransaksiAkhir($NoFix, $TanggalMulai, $TanggalAkhir);
        $data['_getSisaDetail'] = $this->M_PotonganBon->GetSisaTransaksiAkhir($NoFix, $periodeSebelumnnya);

        $this->template->display('potongan_bon/finish/seleksi', $data);
    }

    function TransaksiAkhir_simpan()
    {
        $this->db->trans_begin();

        $periode = $this->input->post('txtPeriode');

        // YYYYMMPP ( Y tahun, M bulan, P periode )
        $periode = date('Ym', strtotime($this->input->post('txtTanggal'))) . str_pad($periode, 2, '0', STR_PAD_LEFT);
        $dataHeader = [
            'Tanggal'        => $this->input->post('txtTanggal'),
            'Nofix'          => $this->input->post('txtNofix'),
            'IDPemborong'    => $this->input->post('txtPemborong'),
            'IDSubPemborong' => $this->input->post('txtSubPemborong'),
            'Periode'        => $periode,
            'CreatedBy'      => $this->session->userdata('username'),
            'CreatedDate'    => date('Y-m-d H:i:s')
        ];

        // Fungsi Simpan Header
        $header_id    = $this->M_PotonganBon->simpanHeaderTransaksiAkhir($dataHeader);

        // Fungsi Simpan Detail
        $detailId     = $this->input->post('txtDetailID');
        $type         = $this->input->post('txtType');
        $itemId       = $this->input->post('txtItemID');
        $hargaFull    = $this->input->post('txtHargaFull');
        $dp           = $this->input->post('txtDP');
        $cicilan      = $this->input->post('txtCicilan');
        $cicilan_ke   = $this->input->post('txtCicilanKe');
        $quantity     = $this->input->post('txtQuantity');
        $satuanId     = $this->input->post('txtSatuanID');
        $kategoriId   = $this->input->post('txtKategoriID');
        $total        = $this->input->post('txtTotal');
        $real         = $this->input->post('txtReal');
        $sisa         = $this->input->post('txtSisa');
        // Apakah Detail ini Merupakan Sisa dari Periode Lalu
        $statusSisa = $this->input->post('txtStatusSisa');

        for ($i = 0; $i < count($detailId); $i++) {
            $dtDetail = [
                'HeaderID'    => $header_id,
                'ItemID'      => $itemId[$i],
                'SatuanID'    => $satuanId[$i],
                'KategoriID'  => $kategoriId[$i],
                'HargaFull'   => $hargaFull[$i],
                'Quantity'    => str_replace(".", "", $quantity[$i]),
                'Cicilan'     => ($cicilan[$i]) ? $cicilan[$i] : null,
                'CicilanKe'   => ($cicilan_ke[$i]) ? $cicilan_ke[$i] : null,
                'DP'          => ($dp[$i]) ? $dp[$i] : null,
                'Total'       => $total[$i],
                'Type'        => $type[$i],
                'Realisasi'   => $real[$i],
                'IDDtlProses' => $detailId[$i],
                'Sisa'        => $sisa[$i],
                'StatusSisa'  => $statusSisa[$i]
            ];

            $this->M_PotonganBon->simpanDetailTransaksiAkhir($dtDetail);
        }

        // Status Proses Sisa jadi 1
        $aSisaID = $this->input->post('txtSisaID');
        foreach ($aSisaID as $sisaId) {
            $data = [
                'StatusProsesSisa' => '1'
            ];
            $this->M_PotonganBon->updateDetailTransaksiAkhir($sisaId, $data);
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

    function TransaksiAkhir_komplit()
    {
        $NoFix = $this->uri->segment(3);
        $TanggalMulai = $this->uri->segment(4);
        $TanggalAkhir = $this->uri->segment(5);
        $periode = $this->uri->segment(6);
        $data['_periode'] = $periode;
        $data['_getHeader'] = $this->M_PotonganBon->GetHeaderTransaksiAkhir($NoFix, $periode);
        if (!empty($data['_getHeader'])) {
            $data['_getDataDetail'] = $this->M_PotonganBon->GetDetailTransaksiAkhir($data['_getHeader']->HeaderID);
            $this->template->display('potongan_bon/finish/komplit', $data);
        } else {
            redirect('PotonganBon/TransaksiAkhir');
        }
    }

    function TransaksiAkhir_update()
    {
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
        $this->M_PotonganBon->updateHeaderTransaksiAkhir($header_id, $dataHeader);

        // Fungsi Update Detail
        $detailAkhirId = $this->input->post('txtIDDtlAkhir');
        $real = $this->input->post('txtReal');
        $sisa = $this->input->post('txtSisa');
        $detailProsesId = $this->input->post('txtIDDtlProses');
        $type = $this->input->post('txtType');
        $statusSisa = $this->input->post('txtStatusSisa');

        for ($i = 0; $i < count($detailAkhirId); $i++) {
            $dtDetail = [
                'Realisasi' => $real[$i],
                'Sisa' => $sisa[$i]
            ];

            if ($type[$i] == 'Cicilan' && $statusSisa[$i] != 1) {
                // Buat Cicilan Setelahnya
                $data_cicilan = $this->M_PotonganBon->getDetailCicilanByID($detailProsesId[$i]);
                if ($data_cicilan) {
                    if ($data_cicilan['Cicilan'] > $data_cicilan['CicilanKe']) {
                        unset($data_cicilan['DetailID']);
                        $data_cicilan['CicilanKe'] += 1;
                        $data_cicilan['CreatedBy'] = 'SYSTEM';
                        $data_cicilan['CreatedDate'] = date('Y-m-d H:i:s');
                        $tgl_mulai = date('j', strtotime($data_cicilan['TanggalMulai']));
                        if ($tgl_mulai >= 1 && $tgl_mulai <= 15) {
                            $data_cicilan['TanggalMulai'] = date('Y-m-16', strtotime($data_cicilan['TanggalMulai']));
                        } else {
                            $data_cicilan['TanggalMulai'] = date('Y-m-01', strtotime($data_cicilan['TanggalMulai'] . ' +16 days'));
                        }

                        $this->M_PotonganBon->simpan_cicilan_dtl($data_cicilan);
                    }
                }
            }


            $this->M_PotonganBon->updateDetailTransaksiAkhir($detailAkhirId[$i], $dtDetail);
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


    // BEGIN :: HAPUS DATA BON

    function HapusDataBon()
    {
        $data['_getDataPemborong']  = $this->M_PotonganBon->GetMstPemborongNew();
        // $data['_getDataPemborong'] = $this->M_PotonganBon->GetMstPemborong();
        $data['_searchHistory'] = $this->session->userdata('_searchTA');

        $this->template->display('potongan_bon/hapus_bon/index', $data);
    }

    function ajax_data_bon()
    {
        $pbr        = $this->input->post('ajax_pbr');
        $subpbr     = $this->input->post('ajax_sub_pbr');
        $periode    = $this->input->post('ajax_periode');
        $bln        = $this->input->post('ajax_bulan');
        $bln        = str_pad($bln, 2, '0', STR_PAD_LEFT);
        $thn        = $this->input->post('ajax_tahun');

        // Keep History Search
        $this->session->set_userdata('_searchTA', $this->input->post());

        $tanggal = date('Y-m-d');
        $tanggal_bon = date('j', strtotime($tanggal));
        // echo 'hahahah';

        if ($periode == "1") {
            $periode = $thn . '-' . $bln . '-01';
        } else {
            $periode = $thn . '-' . $bln . '-16';
            # code...
        }

        // if($tanggal_bon >= 14 && $tanggal_bon <= 26) {
        //     $periode = date('Y-m-16',strtotime($tanggal));
        // }else{
        //     if($tanggal_bon == 26 || $tanggal_bon == 27 || $tanggal_bon == 28 || $tanggal_bon == 29 || $tanggal_bon == 30 || $tanggal_bon == 31){
        //         $bul        = date('Y-m-d',strtotime('+ 1 months'));
        //         $bln        = date('m',strtotime($bul));
        //         $bln_fix    = str_pad($bln, 2, '0');
        //         $tahun      = date('Y',strtotime($bul));
        //         $periode    = date($tahun.'-'.$bln_fix.'-1',strtotime($tanggal));

        //     }else{
        //         $periode    = date('Y-m-01',strtotime($tanggal));

        //     }
        // }
        // print_r($periode);
        // exit;

        $data['_getData'] = $this->M_PotonganBon->GetListHapus($pbr, $subpbr, $periode);

        $this->load->view('potongan_bon/hapus_bon/list', $data);
    }
    function detailhdr()
    {
        $NoFix = base64_decode($this->uri->segment(3));
        $TanggalMulai = $this->uri->segment(4);
        $TanggalAkhir = $this->uri->segment(5);
        $periode = $this->uri->segment(6);
        $data['_periode'] = $this->uri->segment(6);

        $thn = date('Y', strtotime($TanggalMulai));
        $bln = date('n', strtotime($TanggalMulai));
        if ($periode == 1) {
            if ($bln == 1) {
                $periodeSebelumnnya = ($thn - 1) . '1202';
            } else {
                $periodeSebelumnnya = $thn . str_pad($bln - 1, 2, '0', STR_PAD_LEFT) . '02';
            }
        } else {
            // Periode 2
            $periodeSebelumnnya = $thn . str_pad($bln, 2, '0', STR_PAD_LEFT) . '01';
        }

        $data['_getInfo'] = $this->M_PotonganBon->GetInfoTransaksiAkhir($NoFix);
        $data['_getDataDetail'] = $this->M_PotonganBon->GetViewbonhdr($NoFix, $TanggalMulai);
        $data['_getSisaDetail'] = $this->M_PotonganBon->GetSisaTransaksiAkhir($NoFix, $periodeSebelumnnya);

        // print_r( $data['_getDataDetail']);
        // exit;
        $this->template->display('potongan_bon/hapus_bon/seleksi', $data);
    }

    function ajaxDataDetail()
    {
        $id = $this->input->post("id");

        $data = $this->M_PotonganBon->GetViewBonDtl($id);
        echo json_encode($data);
    }

    function HapusDataPotBon()
    {
        $hdrid = $this->input->post('id');

        $_getDataHdr = $this->M_PotonganBon->_getDataHdrByID($hdrid);
        // echo json_encode($_getDataHdr);
        // exit;
        foreach ($_getDataHdr as $key) {
            $datahdr = array(
                'HeaderID'        => $key->HeaderID,
                'Tanggal'         => $key->Tanggal,
                'IDPemborong'     => $key->IDPemborong,
                'Nofix'           => $key->Nofix,
                'StatusProses'    => $key->StatusProses,
                'CreatedBy'       => $key->CreatedBy,
                'CreatedDate'     => $key->CreatedDate,
                'IDSubPemborong'  => $key->IDSubPemborong,
                'PeriodeGajian'   => $key->PeriodeGajian,
                'SisaPot'         => $key->SisaPot,
                'Hostname'        => $key->Hostname,
                'IPAddress'       => $key->IPAddress,
                'Device'          => $key->Device,
                'Browser'         => $key->Browser,
                'Platform'        => $key->Platform,
                'User_Agent'      => $key->User_Agent,
                'DeletedBy'        => $this->session->userdata('username'),
                'DeletedDate'      => date('Y-m-d H:i:s')
            );

            $historyhdrid = $this->M_PotonganBon->simpan_history_deletehdr($datahdr);
        }
        // echo json_encode($datahdr);
        // exit;
        $_getDataDtl = $this->M_PotonganBon->_getDataDtlByID($hdrid);

        foreach ($_getDataDtl as $get) {
            $datadtl = array(
                'HistoryHdrID'   => $historyhdrid,
                'DetailID'       => $get->DetailID,
                'HeaderID'       => $get->HeaderID,
                'IDPemborong'    => $get->IDPemborong,
                'Nofix'          => $get->Nofix,
                'ItemID'         => $get->ItemID,
                'HargaID'        => $get->HargaID,
                'Harga'          => $get->Harga,
                'Quantity'       => $get->Quantity,
                'SatuanID'       => $get->SatuanID,
                'KategoriID'     => $get->KategoriID,
                'Total'          => $get->Total,
                'CreatedBy'      => $get->CreatedBy,
                'CreatedDate'    => $get->CreatedDate,
                'IDSubPemborong' => $get->IDSubPemborong,
                'DeletedBy'      => $this->session->userdata('username'),
                'DeletedDate'    => date('Y-m-d H:i:s')
            );

            $this->M_PotonganBon->simpan_history_deletedtl($datadtl);
        }
        // exit;
        $this->M_PotonganBon->Hapus_PotHdr($hdrid);
        $this->M_PotonganBon->Hapus_PotDtl($hdrid);
        echo json_encode($datadtl);
        // redirect('PotonganBon/detailhdr?msg=success');
    }
    //END HAPUS DATA BON

    //BEGIN HAPUS CICILAN

    function HapusDataPotCicilanHdr()
    {
        $hdrid = $this->input->post('id');

        $_getDataHdr = $this->M_PotonganBon->_getDataHdrByIDCicilan($hdrid);
        $GetDataCicilan = $this->M_PotonganBon->CicilanTerkakulasi($hdrid);
        // foreach($GetDataCicilan as $key){

        //     print_r($GetDataCicilan->SisaDurasi);
        //     exit;
        // }
        // if (isset($GetDataCicilan->SisaDurasi)) {
        //     # code...
        // }
        foreach ($_getDataHdr as $key) {
            $datahdr = array(
                'HeaderID'       => $key->HeaderID,
                'Tanggal'        => $key->Tanggal,
                'PeriodeGajian'  => $key->PeriodeGajian,
                'IDPemborong'    => $key->IDPemborong,
                'Nofix'          => $key->Nofix,
                'StatusProses'   => $key->StatusProses,
                'CreatedBy'      => $key->CreatedBy,
                'CreatedDate'    => $key->CreatedDate,
                'UpdatedBy'      => $key->UpdatedBy,
                'UpdatedDate'    => $key->UpdatedDate,
                'IDSubPemborong' => $key->IDSubPemborong,
                'DeletedBy'      => $this->session->userdata('username'),
                'DeletedDate'    => date('Y-m-d H:i:s')
            );

            $this->M_PotonganBon->simpan_history_deletehdr_cicilan($datahdr);
        }

        $_getDataDtl = $this->M_PotonganBon->_getDataDtlByIDCicilan_byHeader($hdrid);
        // echo json_encode($_getDataDtl);
        // exit;
        if (isset($_getDataDtl)) {
            foreach ($_getDataDtl as $get) {
                $datadtl = array(
                    'DetailID'          => $get->DetailID,
                    'HeaderID'          => $get->HeaderID,
                    'IDPemborong'       => $get->IDPemborong,
                    'Nofix'             => $get->Nofix,
                    'CicilanID'         => $get->CicilanID,
                    'SatuanID'          => $get->SatuanID,
                    'KategoriCicilanID' => $get->KategoriCicilanID,
                    'Harga'             => $get->Harga,
                    'Cicilan'           => $get->Cicilan,
                    'HargaCicilan'      => $get->HargaCicilan,
                    'SisaDurasi'        => $get->SisaDurasi,
                    'Keterangan'        => $get->Keterangan,
                    'Total'             => $get->Total,
                    'CreatedBy'         => $get->CreatedBy,
                    'CreatedDate'       => $get->CreatedDate,
                    'CicilanKe'         => $get->CicilanKe,
                    'TanggalMulai'      => $get->TanggalMulai,
                    'TanggalPotong'     => $get->TanggalPotong,
                    'Quantity'          => $get->Quantity,
                    'DP'                => $get->DP,
                    'NamaItem'          => $get->NamaItem,
                    'PeriodeDipotong'   => $get->PeriodeDipotong,
                    'IDSubPemborong'    => $get->IDSubPemborong,
                    'UpdatedBy'         => $get->UpdatedBy,
                    'UpdatedDate'       => $get->UpdatedDate,
                    'DeletedBy'         => $this->session->userdata('username'),
                    'DeletedDate'       => date('Y-m-d H:i:s')
                );
                // echo json_encode($datadtl);
                // exit;
                $this->M_PotonganBon->simpan_history_deletedtl_cicilan($datadtl);
            }

            $this->M_PotonganBon->Hapus_CicilanDtl($hdrid);
        }


        // echo json_encode($datadtl);
        //     exit;
        // exit;
        $this->M_PotonganBon->Hapus_CicilanHdr($hdrid);
        echo json_encode($datadtl);
    }

    function HapusDataPotCicilanDtl()
    {
        $hdrid = $this->input->post('id');

        $_getDataDtl = $this->M_PotonganBon->_getDataDtlByIDCicilan($hdrid);
        // echo json_encode($_getDataHdr);
        // exit;

        foreach ($_getDataDtl as $get) {
            $datadtl = array(
                'DetailID'          => $get->DetailID,
                'HeaderID'          => $get->HeaderID,
                'IDPemborong'       => $get->IDPemborong,
                'Nofix'             => $get->Nofix,
                'CicilanID'         => $get->CicilanID,
                'SatuanID'          => $get->SatuanID,
                'KategoriCicilanID' => $get->KategoriCicilanID,
                'Harga'             => $get->Harga,
                'Cicilan'           => $get->Cicilan,
                'HargaCicilan'      => $get->HargaCicilan,
                'Keterangan'        => $get->Keterangan,
                'Total'             => $get->Total,
                'CreatedBy'         => $get->CreatedBy,
                'CreatedDate'       => $get->CreatedDate,
                'CicilanKe'         => $get->CicilanKe,
                'TanggalMulai'      => $get->TanggalMulai,
                'TanggalPotong'     => $get->TanggalPotong,
                'Quantity'          => $get->Quantity,
                'DP'                => $get->DP,
                'NamaItem'          => $get->NamaItem,
                'PeriodeDipotong'   => $get->PeriodeDipotong,
                'IDSubPemborong'    => $get->IDSubPemborong,
                'UpdatedBy'         => $get->UpdatedBy,
                'UpdatedDate'       => $get->UpdatedDate,
                'DeletedBy'         => $this->session->userdata('username'),
                'DeletedDate'       => date('Y-m-d H:i:s')
            );
            echo json_encode($datadtl);
            // exit;
            $this->M_PotonganBon->simpan_history_deletedtl_cicilan($datadtl);
        }
        // exit;
        // $this->M_PotonganBon->Hapus_PotHdr($hdrid);
        $this->M_PotonganBon->Hapus_CicilanDtl($hdrid);
        // echo json_encode($datadtl);

    }

    //END HAPUS DATA CICILAN

}

//てり　らま

/* End of file PotonganBon.php */
