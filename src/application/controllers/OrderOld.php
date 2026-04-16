<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */

class Order extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('darurat');
        
        date_default_timezone_set("Asia/Jakarta");        
        $this->load->model(array('M_Order','M_PotonganBon','m_monitor'));
    }
    
    
    function index(){
        
        $this->template->display('potongan_bon/order/index');
    }

    function send_otp(){
        $nik = $this->uri->segment(3);
        $otp = '123ABC';

        $get_tk = $this->M_Order->GetTK($nik);
        $nofix = $get_tk[0]->Nofix;

        $user_tel = $this->M_PotonganBon->GetUserTelegram($nofix);
        if($user_tel == NULL){
            echo "Tenaga Kerja Tidak Ada Telegram";
        }else{
            $pesan = "KODE OTP ANDA : ".str_shuffle($otp)."\r\n";

            $pesan = trim($pesan, "\r\n");
            $data = array(
                'UserGroupID'   => 0,
                'DataFrom'      => 'OTP BON PEMBORONG',
                'ToTelegramID'  => $user_tel[0]->TelegramID,
                'FirstName'     => $user_tel[0]->FirstName,
                'Messages'      => $pesan,
                'ImageReport'   => NULL,
                'SendingTime'   => date('Y-m-d H:i:s'),
                'PendingStatus' => 1,
                'SuccessStatus' => 0,
            );

            // $this->m_monitor->send_info($data);
        }

        echo '
            <div class="form-group">
                <label class="col-lg-1 control-label">Pemborong</label>
                <div class="col-lg-3">
                    <input type="text" name="txtPemborong" id="pemborong" class="form-control" value="'.$get_tk[0]->Pemborong.'" readonly>
                    <input type="hidden" name="txtPemborongID" id="pemborongid" class="form-control" value="'.$get_tk[0]->IDPemborong.'">
                    <input type="hidden" name="txtNofix" id="nofix" class="form-control" value="'.$nofix.'">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-1 control-label">OTP</label>
                <div class="col-sm-3">
                    <input type="text" name="txtOtp" id="otp" class="form-control" placeholder="Silahkan Masukkan OTP Anda !!">
                    <input type="hidden" name="txtTelegramID" id="telid" value="'.$user_tel[0]->TelegramID.'">
                </div>
                <div class="col-sm-3">
                    <a class="btn btn-sm btn-primary" onclick="load_halaman_order()">Submit</a>
                </div>
            </div>

        ';

    }

    function load_halaman_order(){
        $otp   = $this->uri->segment(3);
        $telID = $this->uri->segment(4);
        $pbrid = str_replace('%20','',$this->uri->segment(5));
        $nofix = $this->uri->segment(6);
        $tanggal = date('Y-m-d');

        $data = array(
            'Tanggal'       => $tanggal,
            'IDPemborong'   => $pbrid,
            'Nofix'         => $nofix,
            // 'CreatedBy'     => $this->session->userdata('username'),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );

        // print_r($data);
        $cek_hdr = $this->M_Order->cek_header($tanggal,$nofix,$pbrid);
        if($cek_hdr == NULL){
            $hdrid = $this->M_Order->simpan_hdr($data);
            $cek_otp = $this->M_Order->CekOtp($telID);
            $kode_otp = substr($cek_otp[0]->Messages, 16);

            if($otp != $kode_otp){
                echo "OTP Salah ..!!";
            }else{
                $data['pbrid'] = $pbrid;
                $data['nofix'] = $nofix;
                $data['hdrid'] = $hdrid;
                $data['hitung'] = $this->M_Order->HitungPesanan($nofix);
                $data['_getItem'] = $this->M_Order->GetItem();
                $this->load->view('potongan_bon/order/get_list_barang',$data);
            }
        }else{
            $this->M_Order->update_hdr($cek_hdr[0]->HeaderID,$data);
            $cek_otp = $this->M_Order->CekOtp($telID);
            $kode_otp = substr($cek_otp[0]->Messages, 16);

            if($otp != $kode_otp){
                echo "OTP Salah ..!!";
            }else{
                $data['pbrid'] = $pbrid;
                $data['nofix'] = $nofix;
                $data['hdrid'] = $cek_hdr[0]->HeaderID;
                $data['hitung'] = $this->M_Order->HitungPesanan($nofix);
                $data['_getItem'] = $this->M_Order->GetItem();
                $this->load->view('potongan_bon/order/get_list_barang',$data);
            }
        }

    }

    function cari_item(){
        $item  = $this->uri->segment(3);
        $pbrid = str_replace('%20','',$this->uri->segment(4));
        $nofix = $this->uri->segment(5);
        $hdrid = $this->uri->segment(6);

        $data['GetItem'] = $this->M_Order->GetListItem($item);
        $data['pbrid'] = $pbrid;
        $data['nofix'] = $nofix;
        $data['hdrid'] = $hdrid;
        $this->load->view('potongan_bon/order/list_item',$data);
    }

    function input_quantity(){
        $item  = $this->uri->segment(3);
        $pbrid = str_replace('%20','',$this->uri->segment(4));
        $hdrid = $this->uri->segment(5);
        $nofix = $this->uri->segment(6);

        $cek_trn = $this->M_Order->cek_transaksi($hdrid,$item);
        if($cek_trn != NULL){
            $qty = $cek_trn[0]->Quantity + 1;

            $data = array(
                'Quantity'  => $qty,
                'Total'     => $cek_trn[0]->Harga * $qty,
            );
            $this->M_Order->update_pesanan($cek_trn[0]->DetailID,$data);
        }else{
            $GetHarga = $this->M_Order->GetHarga($item,$pbrid);
            $qty = 1;
            if($GetHarga != NULL){
                $data = array(
                    'HeaderID'      => $hdrid,
                    'IDPemborong'   => $pbrid,
                    'Nofix'         => $nofix,
                    'ItemID'        => $item,
                    'HargaID'       => $GetHarga[0]->DetailHargaID,
                    'Harga'         => $GetHarga[0]->Harga,
                    'Quantity'      => $qty,
                    'SatuanID'      => $GetHarga[0]->SatuanID,
                    'KategoriID'    => $GetHarga[0]->KategoriID,
                    'Total'         => $qty * $GetHarga[0]->Harga,
                    'CreatedDate'   => date('Y-m-d H:i:s')
                );
                $this->M_Order->simpan_pesanan($data);
            }else{
                $qty = 1;
                $data = array(
                    'HeaderID'      => $hdrid,
                    'IDPemborong'   => $pbrid,
                    'Nofix'         => $nofix,
                    'ItemID'        => $item,
                    'HargaID'       => $GetHarga[0]->DetailHargaID,
                    'Harga'         => 0,
                    'Quantity'      => $qty,
                    'SatuanID'      => $GetHarga[0]->SatuanID,
                    'KategoriID'    => $GetHarga[0]->KategoriID,
                    'Total'         => $qty * $GetHarga[0]->Harga,
                    'CreatedDate'   => date('Y-m-d H:i:s')
                );

                $this->M_Order->simpan_pesanan($data);
            }
        }

    }

    function lihat_keranjang(){
        $nofix = $this->input->get('nofix');

        $data['_getOrderHdr'] = $this->M_Order->GetOrderHdr($nofix);
        $data['_getOrder'] = $this->M_Order->GetOrder($nofix);
        $data['_hitung'] = $this->M_Order->HitungKuantitas($nofix);
        $this->template->display("potongan_bon/order/lihat_keranjang",$data);
    }

    function hapus_quantity(){
        $detailid = $this->uri->segment(3);
        $qty = $this->uri->segment(4);

        $cek_dtl = $this->M_Order->cek_detail($detailid);
        if($cek_dtl != NULL){
            $kuantitas = $qty - 1;
            $data = array(
                'Quantity'  => $kuantitas,
                'Total'     => $kuantitas * $cek_dtl[0]->Harga,
            );
        }

        $this->M_Order->update_pesanan($detailid,$data);
    }

    function tambah_quantity(){
        $detailid = $this->uri->segment(3);
        $qty = $this->uri->segment(4);

        $cek_dtl = $this->M_Order->cek_detail($detailid);
        if($cek_dtl != NULL){
            $kuantitas = $qty + 1;
            $data = array(
                'Quantity'  => $kuantitas,
                'Total'     => $kuantitas * $cek_dtl[0]->Harga,
            );
        }

        $this->M_Order->update_pesanan($detailid,$data);
    }

    function hapus_item(){
        $detailid = $this->uri->segment(3);
        $nofix = $this->uri->segment(4);

        // echo $detailid.'/'.$nofix;

        $this->M_Order->hapus_item($detailid);
        redirect('Order/lihat_keranjang?nofix='.$nofix);
    }
}