<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD24
 */

class M_PotonganBon extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }

    function simpan_mst_satuan($data){
        $this->db->insert('tblMstSatuan',$data);
    }

    function GetMstSatuan(){
        $query = $this->db->query("SELECT * FROM tblMstSatuan");
        return $query->result();
    }

    function GetMstSatuan_byid($id){
        $query = $this->db->query("SELECT * FROM tblMstSatuan where SatuanID = '$id'");
        return $query->result();
    }

    function update_mst_satuan($id,$data){
        $this->db->where('SatuanID',$id);
        $this->db->update('tblMstSatuan',$data);
    }
#050122
    function GetByNamaSatuan($nama,$singkatan){
        $query = $this->db->query("SELECT * FROM tblMstSatuan where NamaSatuan = '$nama' or SingkatanSatuan = '$singkatan'");
        return $query->result();
    }

    // Master Item

    function GetKodeItem(){
        $query = $this->db->query("SELECT * FROM tblMstItem");
        return $query->num_rows();
    }

    function getByNamaItem($nama)
    {
        $query = $this->db->query("SELECT * from tblMstItem where NamaItem = '$nama'");
        return $query->row();
    }
   
    function simpan_mst_item($data){
        $this->db->insert('tblMstItem',$data);
    }
    function GetMstItemfull(){
         $query = $this->db->query("SELECT A.*,B.*,C.*, tbD.itemidharga FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID
            left join tblMstKategori as C ON A.KategoriID = C.KategoriID left join 
            (select DISTINCT(a.ItemID), (b.ItemID) itemidharga from tblMstItem a left join tblMstDetailHarga b on a.ItemID=b.ItemID ) as tbD on A.ItemID=tbD.ItemID");
        return $query->result();
    }

    function GetMstItem(){
         $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan,C.NamaKategori FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID
            left join tblMstKategori as C ON A.KategoriID = C.KategoriID");
        return $query->result();
    }

    function GetMstItem_Bypbr($id,$pbr){
         $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan,C.* FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID  left join tblMstDetailHarga as c on A.ItemID = C.ItemID WHERE A.ItemID = '$id' and C.IDPemborong = '$pbr'");
        return $query->result();
    }
    function GetMstItemBaru(){
        $create = $this->session->userdata('username');
        if($create == "SITI MUTHOHAROH"){
            $where = "";
        }else{
            $where = " where A.CreatedBy = '$create'";            
        }
        $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan,C.NamaKategori FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID
            left join tblMstKategori as C ON A.KategoriID = C.KategoriID ".$where);
        return $query->result();
    }
    function GetMstItem_ById($id){
         $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID WHERE A.ItemID = '$id' ");
        return $query->result();
    }
    function update_mst_item($id,$data){
        $this->db->where('ItemID',$id);
        $this->db->update('tblMstItem',$data);
    }

    //BEGIN :: YAWALIYUL
    function get_search_item($item){
        $query = $this->db->query("SELECT A.*,B.*,C.*, tbD.itemidharga 
            FROM tblMstItem as A 
            left join tblMstSatuan as B ON A.SatuanID = B.SatuanID
            left join tblMstKategori as C ON A.KategoriID = C.KategoriID 
            left join (select DISTINCT(a.ItemID), (b.ItemID) itemidharga from tblMstItem a left join tblMstDetailHarga b on a.ItemID=b.ItemID ) as tbD on A.ItemID=tbD.ItemID
            WHERE A.NamaItem LIKE '%$item%'");
        return $query->result();
    }
    //END :: YAWALIYUL
    // BEGIN :: MASTER KATEGORI

    function simpan_mst_kategori($data){
        $this->db->insert('tblMstKategori',$data);
    }

    function GetMstKategori(){
        $query = $this->db->query("SELECT * FROM tblMstKategori");
        return $query->result();
    }

    function GetByKategori($nama){
        $query = $this->db->query("SELECT * FROM tblMstKategori WHERE NamaKategori = '$nama'");
        return $query->result();
    }

    function GetMstKategori_ById($id){
        $query = $this->db->query("SELECT * FROM tblMstKategori WHERE KategoriID = '$id'");
        return $query->result();
    }

    function update_mst_kategori($id,$data){
        $this->db->where("KategoriID",$id);
        $this->db->update("tblMstKategori",$data);
    }

    // END :: MASTER KATEGORI

     #MASTER KATEGORI CICILAN
    function GetMstKategoriCicilan(){
        $query = $this->db->query("SELECT * FROM tblMstKategoriCicilan");
        return $query->result();
    }

    function simpan_mst_cicilan($data){
        $this->db->insert('tblMstKategoriCicilan',$data);
    }

    function GetMstCicilan_ById($id){
        $query = $this->db->query("SELECT * FROM tblMstKategoriCicilan WHERE KategoriCicilanID = '$id'");
        return $query->result();
    }

    function update_mst_cicilan($id,$data){
        $this->db->where("KategoriCicilanID",$id);
        $this->db->update("tblMstKategoriCicilan",$data);
    }

    // BEGIN :: MASTER HARGA

    function GetMstPemborong(){
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM tblUtlGroupPemborong as A left join vwMstPemborong as B ON A.PemborongID = B.IDPemborong where A.GroupID = '$groupid' and B.IDPemborong not in (15,16) ");
        return $query->result();
    }

    function simpan_hdr_harga($dataHdr){
        $this->db->insert('tblMstHeaderHarga',$dataHdr);
        $primay_key = $this->db->insert_id();
        return $primay_key;
    }

    function update_hdr($pemborong,$dataHdr){
        $this->db->where("IDPemborong",$pemborong);
        $this->db->update('tblMstHeaderHarga',$dataHdr);
    }

    function CekDataHdr($pemborong){
        $query = $this->db->query("SELECT * FROM tblMstHeaderHarga where IDPemborong = '$pemborong'");
        return $query->result();
    }

    function CekDataDtl($item,$pemborong){
        $query = $this->db->query("SELECT * FROM tblMstDetailHarga Where IDPemborong = '$pemborong' and ItemID = '$item'");
        return $query->result();
    }

    function simpan_dtl_harga($dataDtl){
        $this->db->insert('tblMstDetailHarga',$dataDtl);
    }

    function update_dtl_harga($dtlid,$dataDtl){
        $this->db->where("DetailHargaID",$dtlid);
        $this->db->update('tblMstDetailHarga',$dataDtl);
    }

    function GetHeaderMstHarga(){
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.*,B.Pemborong,B.Perusahaan FROM tblMstHeaderHarga as A left join vwMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblUtlGroupPemborong as C on B.IDPemborong = C.PemborongID where C.GroupID = '$groupid' and B.IDPemborong not in (15,16)");
        return $query->result();
    }

    function GetHeaderMstHarga_ById($hdrid){
        $query = $this->db->query("SELECT A.*,B.Pemborong,B.Perusahaan FROM tblMstHeaderHarga as A left join vwMstPemborong as B ON A.IDPemborong = B.IDPemborong where A.HeaderHargaID = '$hdrid'");
        return $query->result();
    }

    function GetDtlHarga($id){
        $query = $this->db->query("SELECT A.*,B.NamaItem,C.SingkatanSatuan,D.NamaKategori FROM tblMstDetailHarga as A left join tblMstItem as B ON A.ItemID = B.ItemID left join tblMstSatuan as C ON A.SatuanID = C.SatuanID left join tblMstKategori as D ON A.KategoriID = D.KategoriID where HeaderHargaID = '$id' and Harga !='0'");
        return $query->result();
    }

    function GetMstItem_ByPemborong($pemborong){
        $query = $this->db->query("SELECT * FROM vwMstHarga where IDPemborong = '$pemborong'");
        return $query->result();
    }

    // END :: MASTER HARGA


    // BEGIN :: TRANSAKSI POTONGAN PEMBORONG
    function _getListOrder(){
        $grupID = $this->session->userdata('groupuser');
       $tanggal_hari_ini = DATE('Y-m-d');
        $query = $this->db->query("SELECT A.HeaderID,A.Tanggal,A.IDPemborong,A.Nofix,B.Nik,B.Nama,B.Pemborong,B.Perusahaan,B.Bagian FROM tblTrnPotonganPemborongHdr as A LEFT JOIN RSUPBorongan2010..vwMasterTenagaKerja as B ON A.Nofix = B.Nofix
            where A.IDPemborong IN (SELECT PemborongID FROM tblUtlGroupPemborong where GroupID = '".$grupID."') and A.StatusProses is NULL and CONVERT(DATE,A.CreatedDate) = '$tanggal_hari_ini' ");
        return $query->result();
    }

    function GetTK($nik,$nama,$nofix,$pemborong){
        $query = $this->db->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja where (Nik = '".$nik."' or Nama LIKE '%$nama%' or NoFix = '".$nofix."') and Nik IS NOT NULL and IDPemborong = '".$pemborong."' AND TanggalKeluar is null");
        return $query->result();
    }

    function get_idcalontenagakerja($id){
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja where HeaderID like '%$id%'");
        return $query->result();
    }

    function cari_tenaga_kerja($nik,$pbr){
        $query = $this->db->query("SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja where Nik = '$nik' and IDPemborong = '$pbr'");
        return $query->result();
    }
    function GetTrnListItem($pbr){
        $query = $this->db->query("SELECT A.DetailHargaID,A.ItemID,B.NamaItem FROM tblMstDetailHarga as A left join tblMstItem as B ON A.ItemID = B.ItemID where A.IDPemborong = '$pbr' and A.Harga != '0'");
        return $query->result();
    }

    function cek_transaksi($tanggal,$nofix){
        $query = $this->db->query("SELECT * FROM tblTrnPotonganPemborongHdr where Nofix = '$nofix' and Tanggal = '$tanggal'");
        return $query->result();
    }

    function simpan_trn_hdr($dataHdr){
        $this->db->insert('tblTrnPotonganPemborongHdr',$dataHdr);
        $primay_key = $this->db->insert_id();
        return $primay_key;
    }

    function _getTrnHeader($tanggal,$nofix,$pbr){
         $query = $this->db->query("SELECT A.HeaderID,A.Tanggal,A.IDPemborong,A.Nofix,B.Nik,B.Nama,B.Pemborong,B.Perusahaan,B.Bagian FROM tblTrnPotonganPemborongHdr as A LEFT JOIN RSUPBorongan2010..vwMasterTenagaKerja as B ON A.Nofix = B.Nofix where A.Tanggal = '".$tanggal."' and A.Nofix='".$nofix."' and A.IDPemborong='".$pbr."'");
        return $query->result();
    }

    function _getTrnDetail($hdrid){
        $query = $this->db->query("SELECT *,B.NamaItem,B.NamaSatuan,B.SingkatanSatuan,B.NamaKategori FROM tblTrnPotonganPemborongDtl as A left join vwMstItem as B ON A.ItemID = B.ItemID where A.HeaderID = '".$hdrid."'");
        return $query->result();
    }

    function _getManual()
    {
        $query = $this->db->query("SELECT *,B.NamaItem,B.NamaSatuan,B.SingkatanSatuan,B.NamaKategori FROM tblTrnPotonganPemborongDtl as A left join vwMstItem as B ON A.ItemID = B.ItemID");
        return $query->result();
    }
    function GetUserTelegram($nofix){
        $query = $this->db->query("SELECT * FROM SMSGateway..TelegramUserRegistered where KaryawanID = '$nofix' and Status = '0'");
        return $query->result();
    }

    function get_harga($pbr,$item){
        $query = $this->db->query("SELECT * FROM vwMstHarga WHERE IDPemborong = '$pbr' and ItemID = '$item'");
        return $query->result();
    }

    function _getGrandTotal($hdrid){
        $query = $this->db->query("SELECT SUM(Total) as GrandTotal FROM tblTrnPotonganPemborongDtl where HeaderID = '".$hdrid."'");
        return $query->result();
    }

    function cek_dtl($dtlid){
        $query = $this->db->query("SELECT * FROM tblTrnPotonganPemborongDtl where DetailID = '".$dtlid."'");
        return $query->result();
    }

    function CekHarga($item,$pemborong){
        $query = $this->db->query("SELECT * FROM tblMstDetailHarga where IDPemborong = '$pemborong' and ItemID ='$item'");
        return $query->result();
    }

    function simpan_trn_dtl($dataDtl){
        $this->db->insert('tblTrnPotonganPemborongDtl',$dataDtl);
        $primay_key = $this->db->insert_id();
        return $primay_key;
    }

    function update_trn_dtl($dtlid,$dataDtl){
        $this->db->where("DetailID",$dtlid);
        $this->db->update("tblTrnPotonganPemborongDtl",$dataDtl);
    }

    function update_trn_hdr($hdrid,$dataHdr){
        $this->db->where("HeaderID",$hdrid);
        $this->db->update("tblTrnPotonganPemborongHdr",$dataHdr);
    }

    function update_harga($hargaid,$dataHarga){
        $this->db->where("DetailHargaID",$hargaid);
        $this->db->update("tblMstDetailHarga",$dataHarga);
    }

    function simpan_history($dataHistoryHarga){
        $this->db->insert('tblHistoryMstHarga',$dataHistoryHarga);
        $primay_key = $this->db->insert_id();
        return $primay_key;
    }
    // END :: TRANSAKSI POTONGAN PEMBORONG

    // BEGIN :: MONITORING POTONGAN PEMBORONG

    function GetDataPotongan($pbr,$tglAwal,$tglAkhir){
        $query = $this->db->query("SELECT distinct a.IDPemborong,A.Nofix,C.Nik,C.Nama,c.Bagian,D.Total FROM tblTrnPotonganPemborongHdr as A left join tblTrnPotonganPemborongDtl as B ON A.HeaderID = B.HeaderID
            LEFT JOIN RSUPBorongan2010..vwMasterTenagaKerja as C ON A.Nofix = C.Nofix left join (SELECT Nofix,SUM(Total) as Total FROM tblTrnPotonganPemborongDtl GROUP BY Nofix) as D ON A.Nofix = D.Nofix
            WHERE A.IDPemborong = '".$pbr."' and A.Tanggal BETWEEN '".$tglAwal."' AND '".$tglAkhir."' AND A.StatusProses is not NULL
            GROUP BY A.IDPemborong,A.Tanggal,A.Nofix,C.Nik,C.Nama,C.Bagian,D.Total");
        return $query->result();
    }

    function GetDataTotal($tglAwal,$tglAkhir){
        $query = $this->db->query("SELECT distinct A.Nofix,SUM(B.Total) AS GrandTotal FROM tblTrnPotonganPemborongHdr as A left join tblTrnPotonganPemborongDtl as B ON A.HeaderID = B.HeaderID 
            where  A.Tanggal BETWEEN '".$tglAwal."' AND '".$tglAkhir."' and A.StatusProses = '1'
            GROUP BY A.Nofix");
        return $query->result();
    }

    function getDataTrnHdr($nofix,$tglAwal,$tglAkhir){
        $query = $this->db->query("SELECT TOP(1) A.Nofix,B.Nama,B.Nik,C.Pemborong,C.Perusahaan,B.Bagian,A.Tanggal FROM tblTrnPotonganPemborongHdr as A left join RSUPBorongan2010..vwMasterTenagaKerja as B ON A.Nofix = B.Nofix
            left join vwMstPemborong as C ON A.IDPemborong = C.IDPemborong
             where A.Nofix = '$nofix' and A.Tanggal BETWEEN '$tglAwal' AND '$tglAkhir' ORDER BY A.CreatedDate DESC ");
        return $query->result();
    }

    function getDataTrnHdrTel($nofix,$tanggal){
        $query = $this->db->query("SELECT TOP(1) A.Nofix,B.Nama,B.Nik,C.Pemborong,C.Perusahaan,B.Bagian,A.Tanggal FROM tblTrnPotonganPemborongHdr as A left join RSUPBorongan2010..vwMasterTenagaKerja as B ON A.Nofix = B.Nofix
            left join vwMstPemborong as C ON A.IDPemborong = C.IDPemborong
             where A.Nofix = '$nofix' and A.Tanggal = '$tanggal' and A.StatusProses = '1' ORDER BY A.CreatedDate DESC ");
        return $query->result();
    }

    function getDataTrnDtl($nofix,$tglAwal,$tglAkhir){
        $query = $this->db->query("SELECT distinct A.Nofix,A.Tanggal,C.NamaItem,B.Quantity,B.Harga,C.SingkatanSatuan,C.NamaKategori,B.Total FROM tblTrnPotonganPemborongHdr as A left join tblTrnPotonganPemborongDtl as B ON A.HeaderID = B.HeaderID 
            left join vwMstHarga as C ON B.ItemID = C.ItemID
            where A.Nofix = '$nofix' and A.Tanggal BETWEEN '$tglAwal' AND '$tglAkhir'");
        return $query->result();
    }

    function getDataTrnDtlTel($nofix,$tanggal){
        $query = $this->db->query("SELECT distinct A.Nofix,A.Tanggal,C.NamaItem,B.Quantity,B.Harga,C.SingkatanSatuan,C.NamaKategori,B.Total FROM tblTrnPotonganPemborongHdr as A left join tblTrnPotonganPemborongDtl as B ON A.HeaderID = B.HeaderID 
            left join vwMstHarga as C ON B.ItemID = C.ItemID
            where A.Nofix = '$nofix' and A.Tanggal = '$tanggal'");
        return $query->result();
    }

    function getDataTrnTanggal($nofix,$tglAwal,$tglAkhir){
        $query = $this->db->query("SELECT distinct A.Nofix,A.Tanggal,SUM(B.Total) AS Total FROM tblTrnPotonganPemborongHdr as A left join tblTrnPotonganPemborongDtl as B ON A.HeaderID = B.HeaderID where A.Nofix = '$nofix' and A.Tanggal BETWEEN '$tglAwal' AND '$tglAkhir' and A.StatusProses = '1'
            GROUP BY A.Nofix,A.Tanggal");
        return $query->result();
    }

    function getDataTrnTotal($nofix,$tglAwal,$tglAkhir){
        $query = $this->db->query("SELECT distinct A.Nofix,SUM(B.Total) AS GrandTotal FROM tblTrnPotonganPemborongHdr as A left join tblTrnPotonganPemborongDtl as B ON A.HeaderID = B.HeaderID 
            where A.Nofix = '$nofix' and A.Tanggal BETWEEN '$tglAwal' AND '$tglAkhir' and A.StatusProses = '1'
            GROUP BY A.Nofix");
        return $query->result();
    }

    function getDataTrnGTotalTel($nofix,$tanggal){
        $query = $this->db->query("SELECT distinct A.Nofix,SUM(B.Total) AS GrandTotal FROM tblTrnPotonganPemborongHdr as A left join tblTrnPotonganPemborongDtl as B ON A.HeaderID = B.HeaderID 
            where A.Nofix = '$nofix' and A.Tanggal = '$tanggal' and A.StatusProses = '1'
            GROUP BY A.Nofix");
        return $query->result();
    }

    // END :: MONITORING POTONGAN PEMBORONG

    function getMstSubPemborong()
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT * FROM tblUtlGroupPemborong as A join tblMstsubPemborong as B on A.PemborongID = B.IDPemborong where A.GroupID = '$groupid'");
        return $query->result();
    }

    function getTK_byPemborong($pbr)
    {
        $query = $this->db->query("SELECT * from  RSUPBorongan2010..vwMasterTenagaKerja where TanggalKeluar is null and TanggalKeluarTemporary is null and IDPemborong = '$pbr' and IDSubPemborong ='0'");
        return $query->result();
    }

    function getMstSub($id)
    {
        $query = $this->db->query("SELECT * FROM tblMstsubPemborong where IDPemborong = '$id'");
        return $query->result();
    }
}?>