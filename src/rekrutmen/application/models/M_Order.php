<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */

class M_Order extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }

    function GetTK($nik){
        $query = $this->db->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja where Nik = '".$nik."'");
        return $query->result();
    }

    function GetItem($sub){
        $query = $this->db->query("SELECT a.ItemID,A.Harga,B.NamaItem,C.SingkatanSatuan from tblMstDetailHarga as a left join tblMstItem as b on A.ItemID = B.ItemID left join tblMstSatuan as c on A.SatuanID =  C.SatuanID where IDSubPemborong = '$sub' and Harga ! = 0");
        return $query->result();
    }

    function CekOtp($telID){
        $query = $this->db->query("SELECT TOP (1) * FROM SMSGateway..TelegramOutbox where ToTelegramID = '".$telID."' and DataFrom = 'OTP BON PEMBORONG' ORDER BY OutboxID DESC");
        return $query->result();
    }

    function GetListItem($item){
        $query = $this->db->query("SELECT * FROM vwMstItem where NamaItem like '%$item%'");
        return $query->result();
    }

    function GetHarga($item,$pbrid){
        $query = $this->db->query("SELECT * FROM vwMstHarga where ItemID = '$item' and IDPemborong = '$pbrid'");
        return $query->result();
    }

    function simpan_hdr($data){
        $this->db->insert('RSUPBorongan2010.dbo.tblTrnPotonganPemborongHdr',$data);
        $primay_key = $this->db->insert_id();
        return $primay_key;
    }

    function cek_header($tanggal,$nofix,$pbr,$sub){
        $query = $this->db->query("SELECT * FROM RSUPBorongan2010..tblTrnPotonganPemborongHdr where Tanggal = '$tanggal' and Nofix = '$nofix' and IDPemborong = '$pbr' and IDSubPemborong = '$sub'");
        return $query->result();
    }

    function update_hdr($hdrid,$data){
        $this->db->where('HeaderID',$hdrid);
        $this->db->update('tblTrnPotonganPemborongHdr',$data);
    }

    function HitungPesanan($nofix){
        $query = $this->db->query("SELECT Nofix,ItemID,SUM(Quantity) as Kuantitas,SUM(Total) as TotalHarga FROM RSUPBorongan2010..tblTrnPotonganPemborongDtl WHERE Nofix = '".$nofix."' GROUP BY Nofix,ItemID");
        return $query->num_rows();
    }

    function simpan_pesanan($data){
        $this->db->insert('tblTrnPotonganPemborongDtl',$data);
        $primay_key = $this->db->insert_id();
        return $primay_key;
    }

    function update_pesanan($detailid,$data){
        $this->db->where('DetailID',$detailid);
        $this->db->update('tblTrnPotonganPemborongDtl',$data);
    }

    function cek_detail($detailid){
        $query = $this->db->query("SELECT * FROM RSUPBorongan2010..tblTrnPotonganPemborongDtl where DetailID = '".$detailid."'");
        return $query->result();
    }

    function GetOrderHdr($nofix){
        $query = $this->db->query("SELECT * FROM RSUPBorongan2010..tblTrnPotonganPemborongHdr where Nofix = '".$nofix."'");
        return $query->result();
    }

    function GetOrder($nofix){
        $query = $this->db->query("SELECT distinct A.HeaderID,B.DetailID,A.Nofix,A.IDPemborong,B.ItemID,C.NamaItem,B.HargaID,B.SatuanID,C.SingkatanSatuan,B.KategoriID,C.NamaKategori,B.Quantity,B.Harga FROM tblTrnPotonganPemborongHdr as A left join tblTrnPotonganPemborongDtl as B ON A.HeaderID = B.HeaderID
            left join vwMstItem as C ON B.ItemID = C.ItemID
            where A.Nofix = '".$nofix."' and B.ItemID IS NOT NULL");
        return $query->result();
    }

    function HitungKuantitas($nofix){
        $query = $this->db->query("SELECT distinct  A.Nofix,B.ItemID,C.NamaItem,SUM(B.Quantity) as Kuantitas,SUM(B.Total) as TotalHarga FROM tblTrnPotonganPemborongHdr as A left join tblTrnPotonganPemborongDtl as B ON A.HeaderID = B.HeaderID
            left join vwMstItem as C ON B.ItemID = C.ItemID
            where A.Nofix = '".$nofix."' AND B.ItemID IS NOT NULL GROUP BY A.Nofix,B.ItemID,C.NamaItem");
        return $query->result();
    }

    function cek_transaksi($hdrid,$item){
        $query = $this->db->query("SELECT * FROM tblTrnPotonganPemborongDtl where HeaderID = '$hdrid' and ItemID='$item'");
        return $query->result();
    }

    function hapus_item($detailid){
        $this->db->delete('RSUPBorongan2010.dbo.tblTrnPotonganPemborongDtl',array('DetailID' => $detailid));
    }
}