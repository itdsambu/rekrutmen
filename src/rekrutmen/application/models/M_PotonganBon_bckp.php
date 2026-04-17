<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD26
 */

class M_PotonganBon extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->PSGBOR = $this->load->database('PSGBOR', TRUE);
    }

    function simpan_mst_satuan($data)
    {
        $this->db->insert('tblMstSatuan', $data);
    }

    function GetMstSatuan()
    {
        $query = $this->db->query("SELECT * FROM tblMstSatuan");
        return $query->result();
    }

    function GetMstItem1()
    {
        $query = $this->db->query("SELECT * FROM tblMstItem");
        return $query->result();
    }

    function GetByNamaSatuan($nama, $singkatan)
    {
        $query = $this->db->query("SELECT * FROM tblMstSatuan where NamaSatuan = '$nama' or SingkatanSatuan = '$singkatan'");
        return $query->result();
    }

    function GetMstSatuan_byid($id)
    {
        $query = $this->db->query("SELECT * FROM tblMstSatuan where SatuanID = '$id'");
        return $query->result();
    }

    function update_mst_satuan($id, $data)
    {
        $this->db->where('SatuanID', $id);
        $this->db->update('tblMstSatuan', $data);
    }

    // Master Item

    function GetKodeItem()
    {
        $query = $this->db->query("SELECT * FROM tblMstItem");
        return $query->num_rows();
    }

    function getByNamaKode($kode)
    {
        // $sessIDSubPemborong = $this->session->userdata('idpemborong');
        $sessIDPemborong = $this->session->userdata('groupuser');
        // echo  $sessIDPemborong;
        // $result   = $this->db->query("SELECT * FROM tblUtlAksesSubPemborong where GroupID = '$sessIDPemborong'")->row();
        // echo '<pre>';  print_r($result);
        // // // $query    = $this->db->query("SELECT TOP 1 (CASE WHEN IDSubPemborong = '$result->IDSubPemborong' THEN 1 ELSE 2 END) AS row, a.ItemID,a.KodeItem,a.NamaItem,a.KodeBarkode,a.SatuanID,a.KategoriID,b.Harga,b.IDSubPemborong,c.SatuanID, c.NamaSatuan,c.SingkatanSatuan,d.NamaKategori,d.KategoriID  FROM tblMstItem as a left join tblMstDetailHarga as b on a.ItemID = b.ItemID left join tblMstSatuan as c on c.SatuanID = a.SatuanID left join tblMstKategori as d on d.KategoriID = a.KategoriID  where KodeBarkode = '$kode' ORDER BY row");
        // $query    = $this->db->query(
        //     "SELECT TOP
        //                 1 ( CASE WHEN IDPemborong = '$result->$sessIDPemborong' THEN 1 ELSE 2 END ) AS row,
        //                 a.ItemID,
        //                 a.SatuanID,
        //                 a.KategoriID,
        //                 c.IDSubPemborong,
        //                 c.SatuanID,
        //                 a.KategoriID,
        //                 a.KodeItem,
        //                 a.NamaItem,
        //                 a.KodeBarkode,
        //                 d.NamaSatuan,
        //                 d.SingkatanSatuan,
        //                 e.NamaKategori,
        //                 c.Harga  
        //     FROM tblMstItem as A left join tblMstItemDetail as B ON A.ItemID = B.ItemID
        //     left join tblMstDetailHarga as C ON A.ItemID = C.ItemID 
        //     left join tblMstSatuan as D ON A.SatuanID = D.SatuanID
        //     left join tblMstKategori as E ON A.KategoriID = E.KategoriID
        //     where A.KodeBarkode = '8993188111113'
        //     ORDER BY
        //     row"
        // );
        // return $query->result();
        // echo '<pre>';  print_r($query);

        $query = $this->db->query("SELECT TOP
                1 ( CASE WHEN IDPemborong in (SELECT IDPemborong FROM tblUtlAksesSubPemborong where GroupID = '$sessIDPemborong') THEN 1 ELSE 2 END ) AS row,
                a.ItemID,
                a.SatuanID,
                a.KategoriID,
                c.IDSubPemborong,
                c.SatuanID,
                a.KategoriID,
                a.KodeItem,
                a.NamaItem,
                a.KodeBarkode,
                d.NamaSatuan,
                d.SingkatanSatuan,
                e.NamaKategori,
                c.Harga  
        FROM tblMstItem as A left join tblMstItemDetail as B ON A.ItemID = B.ItemID
        left join tblMstDetailHarga as C ON A.ItemID = C.ItemID 
        left join tblMstSatuan as D ON A.SatuanID = D.SatuanID
        left join tblMstKategori as E ON A.KategoriID = E.KategoriID
        where A.KodeBarkode = '$kode' 
        and c.IDPemborong in (SELECT IDPemborong FROM tblUtlAksesSubPemborong where GroupID = '$sessIDPemborong')
        ORDER BY
                row");
        return $query->result();
    }

    function get_search_barcode($kode)
    {
        $query = $this->db->query(
            "SELECT
                A.*,
                B.*,
                C.*,
                tbD.itemidharga 
            FROM
                tblMstItem AS A
                LEFT JOIN tblMstSatuan AS B ON A.SatuanID = B.SatuanID
                LEFT JOIN tblMstKategori AS C ON A.KategoriID = C.KategoriID
                LEFT JOIN (
                SELECT DISTINCT
                    ( a.ItemID ),
                    ( b.ItemID ) itemidharga 
                FROM
                    tblMstItem a
                    LEFT JOIN tblMstDetailHarga b ON a.ItemID= b.ItemID 
                ) AS tbD ON A.ItemID= tbD.ItemID 
            WHERE
                A.KodeBarkode LIKE '%$kode%'"
        );
        return $query->result();
    }

    function GetIdSubPemborong($group_id)
    {
        $query = $this->db->query("SELECT * FROM tblUtlAksesSubPemborong WHERE GroupID =$group_id");
        return $query->row();
    }

    function getByNamaItem($item)
    {
        $itemfix = str_replace("'", "' + CHAR(39) + '", $item);
        $query = $this->db->query("SELECT * from tblMstItem where NamaItem = '$itemfix'");
        return $query->row();
    }
    function simpan_mst_item($data)
    {
        $this->db->insert('tblMstItem', $data);
    }

    function GetMstItemfull()
    {
        $query = $this->db->query("SELECT A.*,B.SatuanID,B.NamaSatuan,B.SingkatanSatuan,C.KategoriID,C.NamaKategori, tbD.itemidharga FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID
            left join tblMstKategori as C ON A.KategoriID = C.KategoriID left join 
            (select DISTINCT(a.ItemID), (b.ItemID) itemidharga from tblMstItem a left join tblMstDetailHarga b on a.ItemID=b.ItemID ) as tbD on A.ItemID=tbD.ItemID");
        return $query->result();
    }

    // Tambahan untuk paging manual
    var $table = 'vwMstItem';
    var $column_order = array(null, 'ItemID', 'KodeItem', 'NamaItem', 'SatuanID', 'NamaSatuan', 'SingkatanSatuan', 'KategoriID', 'NamaKategori', 'itemidharga', 'CreatedBy', 'CreatedDate', 'UpdateBy', 'UpdatedDate', 'KodeBarkode');
    var $column_search = array('ItemID', 'KodeItem', 'NamaItem', 'SatuanID', 'NamaSatuan', 'SingkatanSatuan', 'KategoriID', 'NamaKategori', 'itemidharga', 'CreatedBy', 'CreatedDate', 'UpdateBy', 'UpdatedDate', 'KodeBarkode');
    var $order = array('ItemID' => 'asc'); // default order 

    // public function get_mstitem_count(){
    //     $query = $this->db->query("SELECT A.*,B.SatuanID,B.NamaSatuan,B.SingkatanSatuan,C.KategoriID,C.NamaKategori, tbD.itemidharga FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID
    //         left join tblMstKategori as C ON A.KategoriID = C.KategoriID left join 
    //         (select DISTINCT(a.ItemID), (b.ItemID) itemidharga from tblMstItem a left join tblMstDetailHarga b on a.ItemID=b.ItemID ) as tbD on A.ItemID=tbD.ItemID");
    //     return $query->num_rows();
    // }

    function _get_datatables_query()
    {

        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Ending paging manual

    function GetMstItemBaru($sub)
    {
        $create = $this->session->userdata('username');

        $where = " where  IDSubPemborong = '$sub' and CreatedBy = '$create'";

        $query = $this->db->query("SELECT * from vwMstHarga" . $where);
        return $query->result();
    }

    function GetMstItem()
    {
        $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan,C.NamaKategori FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID
            left join tblMstKategori as C ON A.KategoriID = C.KategoriID");
        return $query->result();
    }
    function GetMstItem_ById($id)
    {
        $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan,c.NamaKategori FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID left join tblMstKategori as c on a.KategoriID = c.KategoriID  WHERE A.ItemID = '$id' ");
        return $query->result();
    }

    function GetMstItem_Bypbr($id, $pbr, $sub)
    {
        $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan,C.* FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID  left join tblMstDetailHarga as c on A.ItemID = C.ItemID WHERE A.ItemID = '$id' and C.IDPemborong = '$pbr'and C.IDSubPemborong = '$sub'");
        return $query->result();
    }
    function GetMstItem_BypbrNew($id, $pbr, $sub)
    {
        $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan,C.* FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID  left join tblMstDetailHarga as c on A.ItemID = C.ItemID WHERE A.ItemID = '$id' and C.IDPemborong = '$pbr' and C.IDSubPemborong = '$sub'");
        $ar = $query->result();
        if (count($ar) > 0) {
            $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan,C.*,D.* FROM tblMstItem as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID left join tblMstDetailHarga as c on A.ItemID = C.ItemID left join tblMstKategori as D on A.KategoriID=D.KategoriID  WHERE A.ItemID = '$id' and C.IDPemborong = '$pbr' and C.IDSubPemborong = '$sub'");
        } else {
            $query = $this->db->query("SELECT * , '0' as Harga from tblMstItem as a left join tblMstSatuan as b on a.SatuanID=b.SatuanID left join tblMstKategori as c on a.KategoriID=c.KategoriID where ItemID = '$id'");
        }
        return $query->result();
    }

    function item($id)
    {
        $query = $this->db->query("SELECT * from tblMstItem as a left join tblMstSatuan as b on a.SatuanID=b.SatuanID where ItemID = '$id'");
        return $query->result();
    }
    function update_mst_item($id, $data)
    {
        $this->db->where('ItemID', $id);
        $this->db->update('tblMstItem', $data);
    }

    // BEGIN :: MASTER KATEGORI

    function simpan_mst_kategori($data)
    {
        $this->db->insert('tblMstKategori', $data);
    }

    function GetMstKategori()
    {
        $query = $this->db->query("SELECT * FROM tblMstKategori");
        return $query->result();
    }

    function GetByKategori($nama)
    {
        $query = $this->db->query("SELECT * FROM tblMstKategori WHERE NamaKategori = '$nama'");
        return $query->result();
    }

    function GetMstKategori_ById($id)
    {
        $query = $this->db->query("SELECT * FROM tblMstKategori WHERE KategoriID = '$id'");
        return $query->result();
    }

    function update_mst_kategori($id, $data)
    {
        $this->db->where("KategoriID", $id);
        $this->db->update("tblMstKategori", $data);
    }
    // END :: MASTER KATEGORI

    #MASTER KATEGORI CICILAN
    function GetMstKategoriCicilan()
    {
        $query = $this->db->query("SELECT * FROM tblMstKategoriCicilan");
        return $query->result();
    }

    function simpan_mst_cicilan($data)
    {
        $this->db->insert('tblMstKategoriCicilan', $data);
    }

    function GetMstCicilan_ById($id)
    {
        $query = $this->db->query("SELECT * FROM tblMstKategoriCicilan WHERE KategoriCicilanID = '$id'");
        return $query->result();
    }

    function update_mst_cicilan($id, $data)
    {
        $this->db->where("KategoriCicilanID", $id);
        $this->db->update("tblMstKategoriCicilan", $data);
    }

    #MASTER CICILAN

    function GetMstCicilan()
    {
        $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan,C.NamaKategori FROM tblMstItemCicilan as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID
            left join tblMstKategoriCicilan as C ON A.KategoriCicilanID = C.KategoriCicilanID");
        return $query->result();
    }

    function GetKodeItemCicilan()
    {
        $query = $this->db->query("SELECT * FROM tblMstItemCicilan");
        return $query->num_rows();
    }
    function simpan_mst_item_cicilan($data)
    {
        $this->db->insert('tblMstItemCicilan', $data);
        return $this->db->insert_id();
    }
    function GetCicilan_ById($id)
    {
        $query = $this->db->query("SELECT A.*,B.NamaSatuan,B.SingkatanSatuan FROM tblMstItemCicilan as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID  WHERE A.CicilanID = '$id' ");
        return $query->result();
    }

    function update_mst_item_cicilan($id, $data)
    {
        $this->db->where("CicilanID", $id);
        $this->db->update("tblMstItemCicilan", $data);
    }

    // BEGIN :: MASTER HARGA
    function GetMstPemborong()
    {
        $groupid = $this->session->userdata('groupuser');

        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        tblUtlAksesSubPemborong AS A
                                        LEFT JOIN vwMstPemborong AS B ON A.IDPemborong = B.IDPemborong 
                                    WHERE
                                        A.GroupID = '$groupid'
                                        AND B.IDPemborong NOT IN ( 15, 16 )
                                         ");
        return $query->result();
    }

    function GetAllPemborong()
    {
        $query = $this->db->query("SELECT * FROM vwMstPemborong");
        return $query->result();
    }

    function GetMstPemborongNew()
    {
        $groupid = $this->session->userdata('groupuser');

        $query = $this->db->query("SELECT
                                    A.IDPemborong,
                                    B.IDPerusahaan,
                                    B.Pemborong,
                                    B.IDPemborong
                                FROM
                                    tblUtlAksesSubPemborong AS A
                                    LEFT JOIN VW_subpemborong AS B ON A.IDPemborong = B.IDPemborong
                                WHERE
                                    A.GroupID = '$groupid'
                                    AND B.IDPemborong NOT IN ( 15, 16 )
                                GROUP BY
                                    A.IDPemborong,
                                    B.IDPerusahaan,
                                    B.Pemborong,
                                    B.IDPemborong
                             ");
        return $query->result();

        // $query = $this->db->query("SELECT A.IDPemborong,B.Perusahaan,B.IDPerusahaan,B.Pemborong,B.IDPemborong FROM tblUtlAksesSubPemborong as A left join VW_subpemborong as B ON A.IDSubPemborong = B.IDSubPemborong where A.GroupID = '$groupid' and B.IDPemborong not in (15,16) GROUP BY A.IDPemborong,B.Perusahaan,B.IDPerusahaan,B.Pemborong,B.IDPemborong");
        // return $query->result();
    }

    function GetMstItemBysub($pbr, $sub)
    {
        $query = $this->db->query("SELECT ItemID,NamaItem FROM vwMstHarga where IDPemborong = '" . $pbr . "' and IDSubPemborong = '" . $sub . "'");
        return $query->result();
    }

    // begin :: Penambahan Baru di transaksi Harga
    function GetMstItemPerKategori($kategori, $pbr, $sub)
    {
        $query = $this->db->query("SELECT * FROM vwMstHarga where IDPemborong = '$pbr' and IDSubPemborong = '$sub' and KategoriID = '$kategori'");
        return $query->result();
    }

    // end :: Penambahan Baru di transaksi Harga

    // BEGIN :: AJAX FILTER HARGA
    function _getData1($pbr, $sub, $kategori, $item)
    {
        if ($kategori != 0 && $item != 0) {
            $query = $this->db->query("SELECT * FROM vwMstHarga where IDPemborong = '$pbr' and IDSubPemborong = '$sub' and KategoriID= '$kategori' and ItemID = '$item'");
            return $query->result();
        } elseif ($kategori != 0 && $item == 0) {
            $query = $this->db->query("SELECT * FROM vwMstHarga where IDPemborong = '$pbr' and IDSubPemborong = '$sub' and KategoriID= '$kategori'");
            return $query->result();
        } elseif ($item != 0 && $kategori == 0) {
            $query = $this->db->query("SELECT * FROM vwMstHarga where IDPemborong = '$pbr' and IDSubPemborong = '$sub' and ItemID = '$item'");
            return $query->result();
        } elseif ($kategori == 0 && $item == 0) {
            $query = $this->db->query("SELECT * FROM vwMstHarga where IDPemborong = '$pbr' and IDSubPemborong = '$sub'");
            return $query->result();
        }
    }

    // END :: AJAX FILTER HARGA


    function simpan_hdr_harga($dataHdr)
    {
        $this->db->insert('tblMstHeaderHarga', $dataHdr);
        $primay_key = $this->db->insert_id();
        return $primay_key;
    }

    function update_hdr($pemborong, $subpemborong, $dataHdr)
    {
        $this->db->where("IDPemborong", $pemborong);
        $this->db->where("IDSubPemborong", $subpemborong);
        $this->db->update('tblMstHeaderHarga', $dataHdr);
    }

    #cekdurasicicilanlunas
    function cekDurasi($nofix)
    {
        $query = $this->db->query("SELECT DISTINCT
                                        DetailIDCicilan,
                                        a.jml_cicilan_lunas,
                                        B.Cicilan,
                                        b.Cicilan - a.jml_cicilan_lunas AS Durasi 
                                    FROM
                                        (
                                        SELECT
                                            FixNo,
                                            DetailIDCicilan,
                                            COUNT ( DetailIDCicilan ) AS jml_cicilan_lunas 
                                        FROM
                                            [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi 
                                        WHERE
                                            FixNo = '$nofix' 
                                        GROUP BY
                                            FixNo,
                                            DetailIDCicilan 
                                        ) AS A
                                        LEFT JOIN ( SELECT * FROM [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganCicilanDtl WHERE Nofix = '$nofix' ) AS B ON A.DetailIDCicilan = B.DetailID");
        return $query->result();
    }

    function CekDataHdrNew($pemborong, $sub)
    {
        $query = $this->db->query("SELECT * FROM tblMstHeaderHarga where IDPemborong = '$pemborong' and IDSubPemborong = '$sub'");
        return $query->result();
    }
    function CekDataHdr($pemborong)
    {
        $query = $this->db->query("SELECT * FROM tblMstHeaderHarga where IDPemborong = '$pemborong'");
        return $query->result();
    }

    function CekDataDtl($item, $pemborong)
    {
        $query = $this->db->query("SELECT * FROM tblMstDetailHarga Where IDSubPemborong = '$pemborong' and ItemID = '$item'");
        return $query->result();
    }

    function simpan_dtl_harga($dataDtl)
    {
        $this->db->insert('tblMstDetailHarga', $dataDtl);
    }

    function update_dtl_harga($dtlid, $dataDtl)
    {
        $this->db->where("DetailHargaID", $dtlid);
        $this->db->update('tblMstDetailHarga', $dataDtl);
    }

    function GetHeaderMstHarga()
    {
        $groupid = $this->session->userdata('groupuser');

        $query = $this->db->query("SELECT A.*,B.Pemborong,B.IDPerusahaan,B.Perusahaan,D.NamaSub FROM tblMstHeaderHarga as A left join VW_subpemborong as B ON A.IDSubPemborong = B.IDSubPemborong left join tblUtlAksesSubPemborong as C on B.IDSubPemborong = C.IDSubPemborong left join tblMstsubPemborong as D on A.IDSubPemborong=D.IDSubPemborong where  C.GroupID = '$groupid' and A.IDPemborong not in(15,16)");
        return $query->result();
    }

    function GetHeaderMstHarga_ById($hdrid)
    {
        $query = $this->db->query("SELECT A.*,B.Pemborong,B.Perusahaan,C.* FROM tblMstHeaderHarga as A left join vwMstPemborong as B ON A.IDPemborong = B.IDPemborong left join VW_subpemborong as C on A.IDSubPemborong = C.IDSubPemborong where A.HeaderHargaID = '$hdrid'");
        return $query->result();
    }

    function GetDtlHarga($id)
    {
        $query = $this->db->query("SELECT A.*,B.KodeItem,B.NamaItem,C.SingkatanSatuan,D.NamaKategori FROM tblMstDetailHarga as A left join tblMstItem as B ON A.ItemID = B.ItemID left join tblMstSatuan as C ON A.SatuanID = C.SatuanID left join tblMstKategori as D ON A.KategoriID = D.KategoriID where HeaderHargaID = '$id'  and Harga !='0' AND DeletedBy is null");
        return $query->result();
    }

    function GetHarga($id, $item, $idpbr)
    {
        $query = $this->db->query("SELECT A.*,B.NamaItem,C.SingkatanSatuan,D.NamaKategori FROM tblMstDetailHarga as A left join tblMstItem as B ON A.ItemID = B.ItemID left join tblMstSatuan as C ON A.SatuanID = C.SatuanID left join tblMstKategori as D ON A.KategoriID = D.KategoriID where HeaderHargaID = '$id'  and ItemID = '$item' and IDPemborong ='$idpbr'");
        return $query->result();
    }

    function GetMstItem_ByPemborong($sub)
    {
        $query = $this->db->query("SELECT * FROM vwMstHarga where IDSubPemborong = '$sub'");
        return $query->result();
    }

    // END :: MASTER HARGA


    // BEGIN :: TRANSAKSI POTONGAN PEMBORONG
    function _getListOrder()
    {
        $grupID = $this->session->userdata('groupuser');

        $query = $this->db->query("
                                    SELECT
                                        A.HeaderID,
                                        A.Tanggal,
                                        A.IDPemborong,
                                        A.IDSubPemborong,
                                        A.Nofix,
                                        A.DeletedBy,
                                        A.DeletedDate,
                                        B.Nik,
                                        B.Nama,
                                        B.Pemborong,
                                        B.Perusahaan,
                                        B.BagianAbbr,
                                        C.NamaSubPemborong 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.tblMstSubPemborong AS C ON A.IDSubPemborong = C.SubPemborongID 
                                    WHERE
                                        A.IDSubPemborong IN ( SELECT IDSubPemborong FROM dbo.tblUtlAksesSubPemborong WHERE GroupID = '$grupID' ) 
                                        AND A.StatusProses IS NULL
                                        AND deletedBy IS NULL 
                                        AND DeletedDate IS NULL 
                                        AND A.Nofix != '0' 
                                    ORDER BY
                                        A.Tanggal
                                            ");
        return $query->result();
    }

    // function _getListOrder(){
    //     $grupID = $this->session->userdata('groupuser');

    //     $query = $this->db->query("
    //                                 SELECT
    //                                     A.HeaderID,
    //                                     A.Tanggal,
    //                                     A.IDPemborong,
    //                                     A.IDSubPemborong,
    //                                     A.Nofix,
    //                                     A.DeletedBy,
    //                                     A.DeletedDate,
    //                                     B.Nik,
    //                                     B.Nama,
    //                                     B.Pemborong,
    //                                     B.Perusahaan,
    //                                     B.BagianAbbr,
    //                                     C.NamaSubPemborong 
    //                                 FROM
    //                                     [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
    //                                     LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
    //                                     LEFT JOIN [192.168.3.32].psgborongan.dbo.tblMstSubPemborong AS C ON A.IDSubPemborong = C.SubPemborongID 
    //                                 WHERE
    //                                     A.IDSubPemborong IN ( SELECT IDSubPemborong FROM dbo.tblUtlAksesSubPemborong WHERE GroupID = '$grupID' )
    //                                 ORDER BY
    //                                     A.Tanggal
    //                                         ");
    //     return $query->result();
    // }


    function getDataExcelTrnBelumProses()
    {
        $grupID = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT
                                        A.HeaderID,
                                        A.Tanggal,
                                        A.IDPemborong,
                                        A.IDSubPemborong,
                                        A.Nofix,
                                        A.DeletedBy,
                                        A.DeletedDate,
                                        B.Nik,
                                        B.Nama,
                                        B.Pemborong,
                                        B.Perusahaan,
                                        B.BagianAbbr,
                                        C.NamaSub,
                                        D.GrandTotal 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
                                        LEFT JOIN tblMstSubPemborong AS C ON A.IDSubPemborong = C.IDSubPemborong
                                        LEFT JOIN ( SELECT HeaderID, SUM ( Total ) AS GrandTotal FROM [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl GROUP BY HeaderID ) AS D ON A.HeaderID = D.HeaderID 
                                    WHERE
                                        A.IDSubPemborong IN ( SELECT IDSubPemborong FROM tblUtlAksesSubPemborong WHERE GroupID = '$grupID' ) 
                                        AND A.StatusProses IS NULL 
                                        AND deletedBy IS NULL 
                                        AND DeletedDate IS NULL 
                                    GROUP BY
                                        A.HeaderID,
                                        A.Tanggal,
                                        A.IDPemborong,
                                        A.IDSubPemborong,
                                        A.Nofix,
                                        A.DeletedBy,
                                        A.DeletedDate,
                                        B.Nik,
                                        B.Nama,
                                        B.Pemborong,
                                        B.Perusahaan,
                                        B.BagianAbbr,
                                        C.NamaSub,
                                        D.GrandTotal 
                                    ORDER BY
                                        A.Tanggal");
        return $query->result();
    }

    function _getTotalProses()
    {
        $grupID   = $this->session->userdata('groupuser');
        $query    = $this->db->query("SELECT count(A.HeaderID) as total FROM [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr as A left join [192.168.3.32].psgborongan.dbo.tblMstSubPemborong as C on A.IDSubPemborong = C.SubPemborongID where A.IDSubPemborong IN (SELECT IDSubPemborong FROM tblUtlAksesSubPemborong where GroupID = '$grupID') and A.StatusProses IS NULL and deletedBy is NULL and A.Nofix != 0");
        return $query->row();
    }

    function GetTK($nik, $nama, $nofix, $pbr)
    {
        $query = $this->db->query(
            "WITH tk AS (
                	SELECT
                        -- idpemborong idpemborong2,
                        -- idsubpemborong idsubpemborong2,
                    CASE
                    WHEN IDSubPemborong = '6' THEN
                            '2' 
                    WHEN IDSubPemborong = '7' THEN
                            '13' ELSE IDPemborong 
                    END AS IDPemborongNew,* 
                FROM
            		[192.168.3.32].psgborongan.dbo.vwmsttenagakerja
                WHERE
                    ( Nik = '$nik' OR Nama LIKE '%$nama%' OR FixNo = '$nofix' )
                    AND Nik IS NOT NULL 
                    -- AND TanggalKeluarTemp IS NULL // sementara
                    AND TanggalKeluar IS NULL 
                ),
                sembako AS ( SELECT FixNo, SUM ( SisaPotonganPeriodeIni ) AS SisaSembako FROM [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongSisa WHERE FixNo = '$nofix' GROUP BY FixNo ),
                cicilan AS ( SELECT FixNo, SUM ( SisaUpahSembako ) AS SisaCicilan FROM [192.168.3.32].psgborongan.dbo.vwTrnPotonganBONPemborongSisaCicilan WHERE FixNo = '$nofix' GROUP BY FixNo ) 
                
                SELECT
                A.FixNo,
                A.Nama,
                A.Nik,
                A.BagianAbbr,
                A.Pemborong,
                A.IDToko,
                -- A.IDPemborong,
                A.IDPemborongNew,
                ( b.SisaSembako + c.SisaCicilan ) AS SisaPeriodeSebelumnya 
            FROM
                tk AS a
                LEFT JOIN sembako AS b ON a.FixNo = b.FixNo
                LEFT JOIN cicilan AS c ON a.FixNo = c.FixNo 
            WHERE
                IDPemborongNew = '$pbr' 
            ORDER BY
                a.Nama ASC"
        );
        return $query->result();
    }

    function GetTKLama($nik, $nama, $nofix, $sub)
    {
        $query = $this->db->query(
            "WITH tk AS (
                SELECT
                    * 
                FROM
                    [192.168.3.32].psgborongan.dbo.vwmsttenagakerja
                WHERE
                    ( Nik = '$nik' OR Nama LIKE '%$nama%' OR FixNo = '$nofix' ) 
                    AND Nik IS NOT NULL 
                    AND IDSubPemborong = '$sub' 
                    AND TanggalKeluarTemp IS NULL 
                ),
                sembako AS ( SELECT FixNo, SUM ( SisaPotonganPeriodeIni ) AS SisaSembako FROM [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongSisa WHERE FixNo = '$nofix' GROUP BY FixNo ),
                cicilan AS ( SELECT FixNo, SUM ( SisaUpahSembako ) AS SisaCicilan FROM [192.168.3.32].psgborongan.dbo.vwTrnPotonganBONPemborongSisaCicilan WHERE FixNo = '$nofix' GROUP BY FixNo ) SELECT
                A.FixNo,
                A.Nama,
                A.Nik,
                A.BagianAbbr,
                A.Pemborong,
                A.IDSubPemborong,
                A.IDPemborong,
                ( b.SisaSembako + c.SisaCicilan ) AS SisaPeriodeSebelumnya 
            FROM
                tk AS a
                LEFT JOIN sembako AS b ON a.FixNo = b.FixNo
                LEFT JOIN cicilan AS c ON a.FixNo = c.FixNo 
            ORDER BY
                a.Nama ASC"
        );
        return $query->result();
    }

    function get_idcalontenagakerja($id)
    {
        $query = $this->db->query("SELECT * FROM tblTrnCalonTenagaKerja where HeaderID like '%$id%'");
        return $query->result();
    }

    function cari_tenaga_kerja($nik, $pbr)
    {
        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.vwMasterTenagaKerja where Nik = '$nik' and IDPemborong = '$pbr'");
        return $query->result();
    }
    function GetTrnListItem($sub)
    {
        $query = $this->db->query("SELECT A.DetailHargaID,A.ItemID,B.NamaItem,B.KodeBarkode FROM tblMstDetailHarga as A left join tblMstItem as B ON A.ItemID = B.ItemID where   A.IDSubPemborong ='$sub' and A.Harga != '0' and NamaItem is not null");
        return $query->result();
    }

    function cek_transaksi($tanggal, $nofix)
    {
        $query = $this->db->query("SELECT * FROM [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongHdr where Nofix = '$nofix' and Tanggal = '$tanggal'");
        return $query->result();
    }

    function simpan_trn_hdr($dataHdr)
    {
        // $this->PSGBOR->insert("PSGBorongan.dbo.tbltrnpotonganpemboronghdr", $dataHdr);
        // $primay_key = $this->PSGBOR->insert_id();
        // return $primay_key;

        $this->db->trans_begin();

        $this->PSGBOR->insert('PSGBorongan.dbo.tbltrnpotonganpemboronghdr', $dataHdr);
        $primay_key = $this->PSGBOR->insert_id();

        // Detail
        $hdr = $primay_key;
        $sub       = $this->input->post("txtSubPemborong");
        $item       = $this->input->post('txtItem');
        $harga      = $this->input->post('txtHarga');
        $hargaid    = $this->input->post('txtHargaid');
        $quantity   = $this->input->post('txtQuantity');
        $satuan     = $this->input->post('txtSatuanid');
        $kategori   = $this->input->post('txtKategoriid');
        // $total      = $this->input->post('txtTotal');
        $hitung = count($item);

        for ($i = 0; $i < $hitung; $i++) {
            $dataDtl = array(
                'HeaderID'    => $hdr,
                'IDPemborong' => $dataHdr['IDPemborong'],
                'IDSubPemborong' => $dataHdr['IDSubPemborong'],
                'Nofix'       => $dataHdr['Nofix'],
                'ItemID'      => $item[$i],
                'HargaID'     => $hargaid[$i],
                'Harga'       => str_replace(".", "", $harga[$i]),
                'Quantity'    => $quantity[$i],
                'SatuanID'    => $satuan[$i],
                'KategoriID'  => $kategori[$i],
                'Total'       => $quantity[$i] * str_replace(".", "", $harga[$i]),
                'CreatedBy'   => $this->session->userdata('username'),
                'CreatedDate' => date('Y-m-d H:i:s')
            );

            $cek_harga = $this->CekHarga($item[$i], $sub);

            if ($cek_harga[0]->Harga != $harga[$i]) {
                $this->simpan_trn_dtl($dataDtl);

                $dataHarga = array(
                    'Harga' => str_replace(".", "", $harga[$i]),
                );

                $this->update_harga($hargaid[$i], $dataHarga);

                $dataHistoryHarga = array(
                    'DetailHargaID' => $hargaid[$i],
                    'HeaderHargaID' => $cek_harga[0]->HeaderHargaID,
                    'IDPemborong'   => $dataHdr['IDPemborong'],
                    'ItemID'        => $item[$i],
                    'SatuanID'      => $satuan[$i],
                    'KategoriID'    => $kategori[$i],
                    'Harga'         => str_replace(".", "", $cek_harga[0]->Harga),
                    'CreatedBy'     => $this->session->userdata('username'),
                    'CreatedDate'   => date('Y-m-d H:i:s')
                );

                $this->simpan_history($dataHistoryHarga);
            } else {
                $this->simpan_trn_dtl($dataDtl);
            }

            // $this->simpan_trn_dtl($dataDtl);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $primay_key;
        }
    }

    function _getTrnHeader($tanggal, $nofix, $sub, $id)
    {
        $query = $this->db->query("SELECT TOP
         ( 1 ) A.HeaderID,
         A.Tanggal,
         A.IDPemborong,
         A.Nofix,
         B.Nik,
         B.Nama,
         B.Pemborong,
         B.Perusahaan,
         B.BagianAbbr,
         B.IDSubPemborong,
         E.NamaSub,
         SUM ( c.SisaPotonganPeriodeIni ) AS sisaSembako,
         SUM ( d.SisaUpahSembako ) AS sisacicilan 
     FROM
         [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
         LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
         LEFT JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongSisa AS C ON A.Nofix = C.FixNo
         LEFT JOIN [192.168.3.32].psgborongan.dbo.vwTrnPotonganBONPemborongSisaCicilan AS D ON a.Nofix = D.FixNo
         LEFT JOIN tblMstSubPemborong AS E ON a.IDSubPemborong = E.IDSubPemborong 
     WHERE A.Tanggal = '" . $tanggal . "' and A.Nofix='" . $nofix . "' and A.IDSubPemborong='" . $sub . "' and A.HeaderID = '" . $id . "'
            group by  A.HeaderID,A.Tanggal,A.IDPemborong,A.Nofix,B.Nik,B.Nama,B.Pemborong,B.Perusahaan,B.BagianAbbr,B.IDSubPemborong,E.NamaSub");
        return $query->row();
    }

    function _getTrnDetail($hdrid)
    {
        $query = $this->db->query("SELECT *,B.NamaItem,B.NamaSatuan,B.SingkatanSatuan,B.NamaKategori FROM [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongDtl as A left join vwMstItem as B ON A.ItemID = B.ItemID where A.HeaderID = '" . $hdrid . "'");
        return $query->result();
    }

    function _getManual()
    {
        $query = $this->db->query("SELECT *,B.NamaItem,B.NamaSatuan,B.SingkatanSatuan,B.NamaKategori FROM [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongDtl as A left join vwMstItem as B ON A.ItemID = B.ItemID");
        return $query->result();
    }
    // send to tk
    function GetUserTelegram($nofix)
    {
        $query = $this->db->query("SELECT TelegramID, * FROM PSGKlinik.dbo.vw_sambupedia_all_pekerja_aktif where personalid = '$nofix' and personalstatus = '2' AND TelegramID IS NOT NULL");
        return $query->result();
    }

    // user telegram to pemborong

    function GetUserTelPemborong($sub)
    {
        $query = $this->db->query(
            "SELECT DISTINCT
                A.IDSubPemborong,
                A.IDPemborong,
                A.NamaSub,
                B.FromTelegramID,
                B.FirstName 
            FROM
                RSUPTKRequest..tblMstSubPemborong AS A
                LEFT JOIN SMSGateway..TelegramInboxPemborong AS B ON A.FromTelegramID = B.FromTelegramID 
            WHERE
                A.IDSubPemborong = '$sub'"
        );
        return $query->result();
    }

    // end user telegram to pemborong

    function get_harga($sub, $item)
    {
        $query = $this->db->query("SELECT * FROM vwMstHarga WHERE IDSubPemborong = '$sub' and ItemID = '$item'");
        return $query->result();
    }

    function _getGrandTotal($hdrid)
    {
        $query = $this->PSGBOR->query("SELECT SUM(Total) as GrandTotal FROM PSGBorongan.dbo.tblTrnPotonganPemborongDtl where HeaderID = '" . $hdrid . "'");
        return $query->result();
    }


    function cek_dtl($dtlid)
    {
        $query = $this->PSGBOR->query("SELECT * FROM PSGBorongan.dbo.tblTrnPotonganPemborongDtl where DetailID = '" . $dtlid . "'");
        return $query->result();
    }

    function CekHarga($item, $pemborong)
    {
        $query = $this->db->query("SELECT * FROM tblMstDetailHarga where IDSubPemborong = '$pemborong' and ItemID ='$item'");
        return $query->result();
    }

    function simpan_trn_dtl($dataDtl)
    {
        $this->PSGBOR->insert("PSGBorongan.dbo.tblTrnPotonganPemborongDtl", $dataDtl);
        $primay_key = $this->PSGBOR->insert_id();
        return $primay_key;
    }

    function update_trn_dtl($dtlid, $dataDtl)
    {
        $this->PSGBOR->where("DetailID", $dtlid);
        $this->PSGBOR->update("PSGBorongan.dbo.tblTrnPotonganPemborongDtl", $dataDtl);
    }

    function update_trn_hdr($hdrid, $dataHdr)
    {
        $this->PSGBOR->where("HeaderID", $hdrid);
        $this->PSGBOR->update("PSGBorongan.dbo.tblTrnPotonganPemborongDtl", $dataHdr);
    }

    function update_harga($hargaid, $dataHarga)
    {
        $this->db->where("DetailHargaID", $hargaid);
        $this->db->update("tblMstDetailHarga", $dataHarga);
    }

    function simpan_history($dataHistoryHarga)
    {
        $this->db->insert('tblHistoryMstHarga', $dataHistoryHarga);
        $primay_key = $this->db->insert_id();
        return $primay_key;
    }

    function getSearchItem($sub, $search, $kode)
    {
        if ($kode == 1) {
            $query = $this->db->query("SELECT A.DetailHargaID,A.ItemID,B.NamaItem,B.KodeBarkode, A.Harga, B.SatuanID, C.SingkatanSatuan, B.KategoriID, D.NamaKategori
                FROM tblMstDetailHarga as A
                LEFT JOIN tblMstItem as B ON A.ItemID = B.ItemID
                LEFT JOIN tblMstSatuan AS C ON A.SatuanID = C.SatuanID
                LEFT JOIN tblMstKategori AS D ON A.KategoriID = D.KategoriID
                WHERE A.IDSubPemborong ='$sub' and A.Harga != '0' AND B.KodeBarkode='$search' and NamaItem is not null");
            return $query->result();
        } else {
            $query = $this->db->query("SELECT A.DetailHargaID,A.ItemID,B.NamaItem,B.KodeBarkode, A.Harga, B.SatuanID, C.SingkatanSatuan, B.KategoriID, D.NamaKategori
                FROM tblMstDetailHarga as A
                LEFT JOIN tblMstItem as B ON A.ItemID = B.ItemID
                LEFT JOIN tblMstSatuan AS C ON A.SatuanID = C.SatuanID
                LEFT JOIN tblMstKategori AS D ON A.KategoriID = D.KategoriID
                WHERE A.IDSubPemborong ='$sub' and A.Harga != '0' AND B.NamaItem LIKE '%$search%' and NamaItem is not null");
            return $query->result();
        }
    }

    function getSearchItem_iyul($sub, $search, $kode)
    {
        if ($kode == 1) {
            $query = $this->db->query("SELECT A.DetailHargaID,A.ItemID,B.NamaItem,B.KodeBarkode, A.Harga, B.SatuanID, C.SingkatanSatuan, B.KategoriID, D.NamaKategori
                FROM tblMstDetailHarga as A
                LEFT JOIN tblMstItem as B ON A.ItemID = B.ItemID
                LEFT JOIN tblMstSatuan AS C ON A.SatuanID = C.SatuanID
                LEFT JOIN tblMstKategori AS D ON A.KategoriID = D.KategoriID
                WHERE A.IDSubPemborong ='$sub' and A.Harga != '0' AND B.KodeBarkode='$search' and NamaItem is not null");
            return $query->result();
        } else {
            $query = $this->db->query("SELECT A.DetailHargaID,A.ItemID,B.NamaItem,B.KodeBarkode, A.Harga, B.SatuanID, C.SingkatanSatuan, B.KategoriID, D.NamaKategori
                FROM tblMstDetailHarga as A
                LEFT JOIN tblMstItem as B ON A.ItemID = B.ItemID
                LEFT JOIN tblMstSatuan AS C ON A.SatuanID = C.SatuanID
                LEFT JOIN tblMstKategori AS D ON A.KategoriID = D.KategoriID
                WHERE A.IDSubPemborong ='$sub' and A.Harga != '0' AND B.NamaItem LIKE '%$search%' and NamaItem is not null");
            return $query->result();
        }
    }

    // END :: TRANSAKSI POTONGAN PEMBORONG

    #Transaksi cicilan
    function _getListCicilan($periode)
    {
        $grupID = $this->session->userdata('groupuser');
        //        $tanggal_hari_ini = DATE('Y-m-d');
        $query = $this->db->query("SELECT
                                        A.HeaderID,
                                        A.Tanggal,
                                        A.IDPemborong,
                                        A.IDSubPemborong,
                                        C.NamaSub,
                                        A.Nofix,
                                        B.Nik,
                                        B.Nama,
                                        B.Pemborong,
                                        B.Perusahaan,
                                        B.BagianAbbr 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
                                        LEFT JOIN tblMstSubPemborong AS C ON C.IDSubPemborong = A.IDSubPemborong 
                                    WHERE
                                        A.IDSubPemborong IN ( SELECT IDSubPemborong FROM tblUtlAksesSubPemborong WHERE GroupID ='$grupID' ) 
                                        AND A.Nofix IS NOT NULL 
                                        AND PeriodeGajian = '$periode'
                                          ");
        return $query->result();
    }

    function _ajaxgetListCicilan($pbr, $sub, $periode)
    {
        $grupID = $this->session->userdata('groupuser');
        //        $tanggal_hari_ini = DATE('Y-m-d');
        $query = $this->db->query("SELECT
                                        A.HeaderID,
                                        A.Tanggal,
                                        A.IDPemborong,
                                        A.IDSubPemborong,
                                        C.NamaSub,
                                        A.Nofix,
                                        B.Nik,
                                        B.Nama,
                                        B.Pemborong,
                                        B.Perusahaan,
                                        B.BagianAbbr 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
                                        LEFT JOIN tblMstSubPemborong AS C ON C.IDSubPemborong = A.IDSubPemborong 
                                    WHERE
                                        A.IDSubPemborong IN ( SELECT IDSubPemborong FROM tblUtlAksesSubPemborong WHERE GroupID = '$grupID' ) 
                                        AND A.Nofix IS NOT NULL 
                                        AND PeriodeGajian = '$periode'
                                        AND A.IDPemborong = '$pbr' 
                                        AND A.IDSubPemborong = '$sub'
                                            ");
        return $query->result();
    }

    function GetTrnList()
    {
        $query = $this->db->query("SELECT NamaCicilan FROM tblMstItemCicilan");
        return $query->result();
    }

    function get_ItemNew($item)
    {
        $query = $this->db->query("SELECT * FROM vw_itemNew WHERE CicilanID = '$item'");
        return $query->result();
    }

    function GetTrnListItemcicilan($pbr)
    {
        $query = $this->db->query("SELECT A.DetailHargaID,A.ItemID,B.NamaItem FROM tblMstDetailHarga as A left join tblMstItem as B ON A.ItemID = B.ItemID where A.IDPemborong = '$pbr'");
        return $query->result();
    }

    function simpan_cicilan_hdr($dataHdr)
    {
        $this->PSGBOR->insert('PSGBorongan.dbo.tblTrnPotonganCicilanHdr', $dataHdr);
        // $this->db->insert('tblTrnPotonganCicilanHdr',$dataHdr);
        $primay_key = $this->PSGBOR->insert_id();
        return $primay_key;
    }

    function simpan_cicilan_dtl($dataDtl)
    {
        $this->PSGBOR->insert('PSGBorongan.dbo.tblTrnPotonganCicilanDtl', $dataDtl);
        // $this->db->insert('tblTrnPotonganCicilanDtl',$dataDtl);
        $primay_key = $this->PSGBOR->insert_id();
        return $primay_key;
    }

    function getDataCicilan1($pbr, $sub, $periode, $tglMulai)
    {
        $query = $this->PSGBOR->query("WITH Tenaga_kerja AS (
                                                        SELECT
                                                            * 
                                                        FROM
                                                            (
                                                            SELECT
                                                                a.FixNo AS FixNoTenaga_kerja,
                                                                a.Nama,
                                                                a.Nik,
                                                                b.BagianAbbr,
                                                            CASE
                                                                    
                                                                    WHEN IDSubPemborong = '6' THEN
                                                                    '2' 
                                                                    WHEN IDSubPemborong = '7' THEN
                                                                    '13' ELSE IDPemborong 
                                                                END AS IDPemborongNew,
                                                                a.IDPemborong,
                                                                a.IDSubPemborong,
                                                                a.IDToko,
                                                                DATEADD( MONTH,+ 3, a.PeriodeMasuk ) AS AkhirPeriode,
                                                                a.TanggalKeluar,
                                                                a.TanggalKeluarTemp,
                                                                a.TanggalMasuk 
                                                            FROM
                                                                vwMstTenagaKerja AS a
                                                                LEFT JOIN tblMstBagian AS b ON a.IDBagian= b.IDBagian 
                                                            ) AS a 
                                                        WHERE
                                                            a.TanggalKeluar IS NULL 
                                                            AND a.IDPemborongNew = '$pbr' 
                                                        ),
                                                        Pot_sembako AS (
                                                            SELECT
                                                                A.Nofix,
                                                                A.IDPemborong,
                                                                A.IDSubPemborong,
                                                                B.PeriodeGajian,
                                                        SUM ( A.Total ) AS Pot_Sembako,
                                                                B.StatusProses 
                                                            FROM
                                                                [192.168.2.3].PSGRekrutmen.dbo.vwTrnPotonganBonDtl AS A
                                                                INNER JOIN [192.168.2.3].PSGRekrutmen.dbo.vwTrnPotonganBonHdr AS B ON A.HeaderID = B.HeaderID
                                                            WHERE
                                                                A.IDPemborong = '$pbr' 
                                                                AND A.IDSubPemborong = '$sub' 
                                                                AND B.PeriodeGajian = '$periode' 
                                                            GROUP BY
                                                                A.Nofix,
                                                                A.IDPemborong,
                                                                A.IDSubPemborong,
                                                                B.PeriodeGajian,
                                                                B.StatusProses
                                                            ),
                                                    SisaCicilanKemaren AS(	
                                                            SELECT 
                                                                ISNULL( sisa, 0 ) AS SisaCicilanKemaren,
                                                                PeriodeAkanDipotong ,
                                                                FixNo
                                                                FROM
                                                                vwTrnPotonganBONPemborongSisaCicilanSum 
                                                                WHERE
                                                                PeriodeAkanDipotong = '$periode' 
                                                                AND (PeriodeAkanDipotong is null or PeriodeAkanDipotong is not null)),
                                                        Sisa_Sembako AS (
                                                        SELECT
                                                            FixNo,
                                                            SUM ( SisaPotonganPeriodeIni ) AS SisaSembakoPeriodeini_tklama,
                                                            SUM ( SisaPotonganTKBaru ) AS sisa_TKBaru,
                                                            PeriodeGajian,
                                                            PeriodePotongan 
                                                        FROM
                                                            tblTrnPotonganBONPemborongSisa 
                                                        WHERE
                                                        PeriodePotongan = '$periode' 
                                                            AND IDPemborong = '$pbr' 
                                                        GROUP BY
                                                            FixNo,
                                                            PeriodeGajian,
                                                            PeriodePotongan UNION ALL
                                                        SELECT
                                                            FixNo,
                                                            SUM ( SisaPotonganPeriodeIni ) AS SisaSembakoPeriodeini,
                                                            SUM ( SisaPotonganTKBaru ) AS sisa_TKBaru,
                                                            PeriodeGajian,
                                                            PeriodePotongan 
                                                        FROM
                                                            tblTrnPotonganBONPemborongSisaArsip 
                                                        WHERE
                                                        PeriodePotongan = '$periode' 
                                                            AND IDPemborong = '$pbr' 
                                                        GROUP BY
                                                            FixNo,
                                                            PeriodeGajian,
                                                            PeriodePotongan 
                                                        ),
                                                        Di_Potongan_Periodeini_Sembako AS (
                                                        SELECT
                                                            A.FixNo,
                                                            SUM ( A.DiPotongPeriodeIni_Sembako ) AS DiPotongPeriodeIni_Sembako,
                                                            A.PeriodeGajian,
                                                            SUM ( A.PotonganCicilan ) AS PotonganCicilan 
                                                        FROM
                                                            (
                                                            SELECT SUM
                                                                ( DiPotongPeriodeIni ) AS DiPotongPeriodeIni_Sembako,
                                                                FixNo,
                                                                PeriodeGajian,
                                                                PotonganCicilan 
                                                            FROM
                                                                tblTrnPotonganBONPemborongFinal 
                                                            WHERE
                                                                PeriodeGajian = '$periode' 
                                                            GROUP BY
                                                                FixNo,
                                                                PeriodeGajian,
                                                                PotonganCicilan UNION ALL
                                                            SELECT SUM
                                                                ( DiPotongPeriodeIni ) AS DiPotongPeriodeIni_Sembako,
                                                                FixNo,
                                                                PeriodeGajian,
                                                                PotonganCicilan 
                                                            FROM
                                                                tblTrnPotonganBONPemborongFinalArsip 
                                                            WHERE
                                                                PeriodeGajian = '$periode' 
                                                            GROUP BY
                                                                FixNo,
                                                                PeriodeGajian,
                                                                PotonganCicilan 
                                                            ) AS A 
                                                        GROUP BY
                                                            A.FixNo,
                                                            A.PeriodeGajian 
                                                        ),
                                                        Pot_Cicilan AS (
                                                        SELECT
                                                            Nofix,
                                                            SUM ( HargaCicilan ) AS Pot_Cicilan 
                                                        FROM
                                                            [192.168.2.3].PSGRekrutmen.dbo.vwPotonganCicilanNew 
                                                        WHERE
                                                            terakhir >= '$periode' 
                                                            AND TanggalMulai <= '$periode' 
                                                            AND PeriodeDipotong IN ( 1, 3 ) 
                                                            AND ISNULL( PeriodeDipotong, 0 ) > 0 
                                                            AND KategoriCicilanID != 0 
                                                            AND IDPemborong = '$pbr' 
                                                        GROUP BY
                                                            Nofix 
                                                        ),
                                                        Sisa_cicilan_PeriodeIni AS ( SELECT FixNo, Periode, SUM ( SisaCicilanAkanDipotong ) AS SisaCicilan FROM vwTrnPotonganBONPemborongSisaCicilan WHERE Periode = '$periode' AND IDPemborong = '$pbr' GROUP BY FixNo, Periode ),
                                                        DiPotong_PeriodeIni_cicilan AS ( SELECT FixNo, SUM ( PotonganCicilan ) AS DiPotong_Periode_iniCicilan FROM tblTrnPotonganBONPemborongFinal WHERE PeriodeGajian = '$periode' GROUP BY FixNo ),
                                                        sisa_tkBaru AS (
                                                        SELECT
                                                            IDPemborong,
                                                            FixNo,
                                                            SUM ( sisa_sebelumnya ) AS Sisa 
                                                        FROM
                                                            [192.168.2.3].PSGRekrutmen.dbo.vwTrnSisaPeriodeSebelumnya 
                                                        WHERE
                                                            IDPemborong = '$pbr' 
                                                            AND PeriodeAkanDatang BETWEEN PeriodeAwal 
                                                            AND '$periode' 
                                                            AND PeriodeGajian >= '2023-01-16' 
                                                        GROUP BY
                                                            FixNo,
                                                            IDPemborong 
                                                        ),
                                                        Sisa_Periode_sebelumnya_tkLama AS (
                                                        SELECT
                                                            A.PeriodeGajian,
                                                            a.FixNo,
                                                            ( ISNULL( B.SisaCicilan, 0 ) + ISNULL( A.SisaPotBon, 0 ) ) AS SisaPeriodeSebelumnya_tklama 
                                                        FROM
                                                            ( SELECT PeriodePotongan AS PeriodeGajian, FixNo, SisaBon AS SisaPotBon FROM vwTrnPotonganBONPemborongSisaBonSum WHERE PeriodePotongan = '$periode' ) AS A
                                                            LEFT JOIN ( SELECT PeriodeAkanDipotong AS PeriodeGajian, FixNo, Sisa AS SisaCicilan FROM vwTrnPotonganBONPemborongSisaCicilanSum WHERE PeriodeAkanDipotong = '$periode' ) AS B ON A.FixNo = B.FixNo 
                                                        WHERE
                                                            a.PeriodeGajian >= '2023-01-16' 
                                                        ),
                                                        Sisa_TkBaru_Sembako AS ( SELECT * FROM [192.168.2.3].PSGRekrutmen.dbo.vwSisaPeriodeSebelumnyaSembako WHERE PeriodeAkanDatang BETWEEN PeriodeBerakhir AND '$periode' ) SELECT
                                                        A.*,
                                                        B.*,
                                                        C.sisa_TKBaru,
                                                        c.sisa_TKBaru AS SisaSembakoPeriodeIni_tkbaru,
                                                        C.SisaSembakoPeriodeini_tklama,
                                                        D.DiPotongPeriodeIni_Sembako,
                                                        E.*,
                                                        F.SisaCicilan,
                                                        G.DiPotong_Periode_iniCicilan,
                                                        I.NamaSub,
                                                        I.Perusahaan,
                                                        H.Sisa AS Sisa_PeriodeSebelumnya_tkbaru,
                                                        J.SisaPeriodeSebelumnya_tklama,
                                                        -- K.sisa_TKBaru AS sisaTk,
                                                        L.*,
                                                        DATEDIFF( MONTH, B.PeriodeGajian, A.AkhirPeriode ) AS PasTigaBulan,
                                                        DATEDIFF( day, B.PeriodeGajian, A.AkhirPeriode ) AS SelisihHari  
                                                    FROM
                                                        Tenaga_kerja AS a
                                                        LEFT JOIN Pot_sembako AS B ON a.FixNoTenaga_kerja = B.Nofix
                                                        LEFT JOIN Sisa_Sembako AS C ON A.FixNoTenaga_kerja = C.FixNo
                                                        LEFT JOIN Di_Potongan_Periodeini_Sembako AS D ON A.FixNoTenaga_kerja = D.FixNo
                                                        LEFT JOIN Pot_Cicilan AS E ON A.FixNoTenaga_kerja = E.Nofix
                                                        LEFT JOIN Sisa_cicilan_PeriodeIni AS F ON A.FixNoTenaga_kerja = F.FixNo
                                                        LEFT JOIN DiPotong_PeriodeIni_cicilan AS G ON A.FixNoTenaga_kerja = G.FixNo
                                                        LEFT JOIN sisa_tkBaru AS H ON A.FixNoTenaga_kerja = H.FixNo
                                                        LEFT JOIN [192.168.2.3].PSGRekrutmen.dbo.tblMstSubPemborong AS I ON A.IDToko = I.IDSubPemborong
                                                        LEFT JOIN Sisa_Periode_sebelumnya_tkLama AS J ON A.FixNoTenaga_kerja = J.FixNo
                                                        -- LEFT JOIN Sisa_TkBaru_Sembako AS K ON A.FixNoTenaga_kerja = K.FixNo 
                                                        LEFT JOIN sisacicilankemaren AS L ON A.FixNoTenaga_kerja = L.FixNo 
                                                    ORDER BY
                                                        A.Nama ASC
                                    ");
        return $query->result();
    }

    function getDataCicilan2($pbr, $sub, $periode, $tglMulai)
    {
        $query = $this->PSGBOR->query("WITH Tenaga_kerja AS (
                                                    SELECT
                                                        * 
                                                    FROM
                                                        (
                                                            SELECT a.FixNo AS FixNoTenaga_kerja,
                                                            a.Nama,
                                                            a.Nik,
                                                            b.BagianAbbr,
                                                        CASE
                                                                
                                                                WHEN IDSubPemborong = '6' THEN
                                                                '2' 
                                                                WHEN IDSubPemborong = '7' THEN
                                                                '13' ELSE IDPemborong 
                                                            END AS IDPemborongNew,
                                                            a.IDPemborong,
                                                            a.IDSubPemborong,
                                                            a.IDToko,
                                                            DATEADD( MONTH,+ 3, a.PeriodeMasuk ) AS AkhirPeriode,
                                                            a.TanggalKeluar,
                                                            a.TanggalKeluarTemp,
                                                            a.TanggalMasuk 
                                                        FROM
                                                            vwMstTenagaKerja AS a
                                                            LEFT JOIN tblMstBagian AS b ON a.IDBagian= b.IDBagian 
                                                        ) AS a 
                                                    WHERE
                                                        a.TanggalKeluar IS NULL 
                                                        AND a.IDPemborongNew = '$pbr' 
                                                    ),
                                                    Pot_sembako AS (
                                                            SELECT
                                                                A.Nofix,
                                                                A.IDPemborong,
                                                                A.IDSubPemborong,
                                                                B.PeriodeGajian,
                                                        SUM ( A.Total ) AS Pot_Sembako,
                                                                B.StatusProses 
                                                            FROM
                                                                [192.168.2.3].PSGRekrutmen.dbo.vwTrnPotonganBonDtl AS A
                                                                INNER JOIN [192.168.2.3].PSGRekrutmen.dbo.vwTrnPotonganBonHdr AS B ON A.HeaderID = B.HeaderID
                                                            WHERE
                                                                A.IDPemborong = '$pbr' 
                                                                AND A.IDSubPemborong = '$sub' 
                                                                AND B.PeriodeGajian = '$periode' 
                                                            GROUP BY
                                                                A.Nofix,
                                                                A.IDPemborong,
                                                                A.IDSubPemborong,
                                                                B.PeriodeGajian,
                                                                B.StatusProses
                                                            ),
                                                    SisaCicilanKemaren AS(	
                                                            SELECT 
                                                                ISNULL( sisa, 0 ) AS SisaCicilanKemaren,
                                                                PeriodeAkanDipotong ,
                                                                FixNo
                                                                FROM
                                                                vwTrnPotonganBONPemborongSisaCicilanSum 
                                                                WHERE
                                                                PeriodeAkanDipotong = '$periode' 
                                                                AND (PeriodeAkanDipotong is null or PeriodeAkanDipotong is not null)),
                                                    Sisa_Sembako AS (
                                                    SELECT
                                                        FixNo,
                                                        SUM ( SisaPotonganPeriodeIni ) AS SisaSembakoPeriodeini_tklama,
                                                        SUM ( SisaPotonganTKBaru ) AS sisa_TKBaru,
                                                        PeriodeGajian,
                                                        PeriodePotongan 
                                                    FROM
                                                        tblTrnPotonganBONPemborongSisa 
                                                    WHERE
                                                    PeriodePotongan = '$periode' 
                                                        AND IDPemborong = '$pbr' 
                                                    GROUP BY
                                                        FixNo,
                                                        PeriodeGajian,
                                                        PeriodePotongan UNION ALL
                                                    SELECT
                                                        FixNo,
                                                        SUM ( SisaPotonganPeriodeIni ) AS SisaSembakoPeriodeini,
                                                        SUM ( SisaPotonganTKBaru ) AS sisa_TKBaru,
                                                        PeriodeGajian,
                                                        PeriodePotongan 
                                                    FROM
                                                        dbo.tblTrnPotonganBONPemborongSisaArsip 
                                                    WHERE
                                                    PeriodePotongan = '$periode' 
                                                        AND IDPemborong = '$pbr' 
                                                    GROUP BY
                                                        FixNo,
                                                        PeriodeGajian,
                                                        PeriodePotongan 
                                                    ),
                                                    Di_Potongan_Periodeini_Sembako AS (
                                                    SELECT
                                                        A.FixNo,
                                                        SUM ( A.DiPotongPeriodeIni_Sembako ) AS DiPotongPeriodeIni_Sembako,
                                                        A.PeriodeGajian,
                                                        SUM ( A.PotonganCicilan ) AS PotonganCicilan 
                                                    FROM
                                                        (
                                                        SELECT SUM
                                                            ( DiPotongPeriodeIni ) AS DiPotongPeriodeIni_Sembako,
                                                            FixNo,
                                                            PeriodeGajian,
                                                            PotonganCicilan 
                                                        FROM
                                                            dbo.tblTrnPotonganBONPemborongFinal 
                                                        WHERE
                                                            PeriodeGajian = '$periode' 
                                                        GROUP BY
                                                            FixNo,
                                                            PeriodeGajian,
                                                            PotonganCicilan UNION ALL
                                                        SELECT SUM
                                                            ( DiPotongPeriodeIni ) AS DiPotongPeriodeIni_Sembako,
                                                            FixNo,
                                                            PeriodeGajian,
                                                            PotonganCicilan 
                                                        FROM
                                                            tblTrnPotonganBONPemborongFinalArsip 
                                                        WHERE
                                                            PeriodeGajian = '$periode' 
                                                        GROUP BY
                                                            FixNo,
                                                            PeriodeGajian,
                                                            PotonganCicilan 
                                                        ) AS A 
                                                    GROUP BY
                                                        A.FixNo,
                                                        A.PeriodeGajian 
                                                    ),
                                                    Pot_Cicilan AS (
                                                    SELECT
                                                        Nofix,
                                                        SUM ( HargaCicilan ) AS Pot_Cicilan 
                                                    FROM
                                                        [192.168.2.3].PSGRekrutmen.dbo.vwPotonganCicilanNew 
                                                    WHERE
                                                        terakhir >= '$periode' 
                                                        AND TanggalMulai <= '$periode' 
                                                        AND PeriodeDipotong IN ( 2, 3 ) 
                                                        AND ISNULL( PeriodeDipotong, 0 ) > 0 
                                                        AND KategoriCicilanID != 0 
                                                        AND IDPemborong = '$pbr' 
                                                    GROUP BY
                                                        Nofix 
                                                    ),
                                                    Sisa_cicilan_PeriodeIni AS (
                                                    SELECT
                                                        FixNo,
                                                        Periode,
                                                        SUM ( SisaCicilanAkanDipotong ) AS SisaCicilan 
                                                    FROM
                                                        vwTrnPotonganBONPemborongSisaCicilan 
                                                    WHERE
                                                        Periode = '$periode' 
                                                        AND IDPemborong = '$pbr' 
                                                    GROUP BY
                                                        FixNo,
                                                        Periode 
                                                    ),
                                                    DiPotong_PeriodeIni_cicilan AS ( SELECT FixNo, SUM ( PotonganCicilan ) AS DiPotong_Periode_iniCicilan FROM tblTrnPotonganBONPemborongFinal WHERE PeriodeGajian = '$periode' GROUP BY FixNo ),
                                                    sisa_tkBaru AS (
                                                    SELECT
                                                        IDPemborong,
                                                        FixNo,
                                                        SUM ( sisa_sebelumnya ) AS Sisa 
                                                    FROM
                                                        [192.168.2.3].PSGRekrutmen.dbo.vwTrnSisaPeriodeSebelumnya 
                                                    WHERE
                                                        IDPemborong = '$pbr' 
                                                        AND PeriodeAkanDatang BETWEEN PeriodeAwal 
                                                        AND '$periode' 
                                                        AND PeriodeGajian > '2023-01-16' 
                                                    GROUP BY
                                                        FixNo,
                                                        IDPemborong 
                                                    ),
                                                    Sisa_Periode_sebelumnya_tkLama AS (
                                                    SELECT
                                                        A.PeriodeGajian,
                                                        a.FixNo,
                                                        ( ISNULL( B.SisaCicilan, 0 ) + ISNULL( A.SisaPotBon, 0 ) ) AS SisaPeriodeSebelumnya_tklama 
                                                    FROM
                                                        ( SELECT PeriodePotongan AS PeriodeGajian, FixNo, SisaBon AS SisaPotBon FROM vwTrnPotonganBONPemborongSisaBonSum WHERE PeriodePotongan = '$periode' ) AS A
                                                        LEFT JOIN ( SELECT PeriodeAkanDipotong AS PeriodeGajian, FixNo, Sisa AS SisaCicilan FROM vwTrnPotonganBONPemborongSisaCicilanSum WHERE PeriodeAkanDipotong = '$periode' ) AS B ON A.FixNo = B.FixNo 
                                                    WHERE
                                                        a.PeriodeGajian > '2023-01-16' 
                                                    ),
                                                    Sisa_TkBaru_Sembako AS ( SELECT * FROM [192.168.2.3].PSGRekrutmen.dbo.vwSisaPeriodeSebelumnyaSembako WHERE PeriodeAkanDatang BETWEEN PeriodeBerakhir AND '$periode' ) 
                                                    SELECT
                                                    A.*,
                                                    B.*,
                                                    C.sisa_TKBaru,
                                                    c.sisa_TKBaru AS SisaSembakoPeriodeIni_tkbaru,
                                                    C.SisaSembakoPeriodeini_tklama,
                                                    D.DiPotongPeriodeIni_Sembako,
                                                    E.*,
                                                    F.SisaCicilan,
                                                    G.DiPotong_Periode_iniCicilan,
                                                    I.NamaSub,
                                                    I.Perusahaan,
                                                    H.Sisa AS Sisa_PeriodeSebelumnya_tkbaru,
                                                    J.SisaPeriodeSebelumnya_tklama,
                                                    -- K.sisa_TKBaru AS sisaTk,
                                                    L.*,
                                                    DATEDIFF( MONTH, B.PeriodeGajian, A.AkhirPeriode ) AS PasTigaBulan,
                                                    DATEDIFF( day, B.PeriodeGajian, A.AkhirPeriode ) AS SelisihHari   
                                                FROM
                                                    Tenaga_kerja AS a
                                                    LEFT JOIN Pot_sembako AS B ON a.FixNoTenaga_kerja = B.Nofix
                                                    LEFT JOIN Sisa_Sembako AS C ON A.FixNoTenaga_kerja = C.FixNo
                                                    LEFT JOIN Di_Potongan_Periodeini_Sembako AS D ON A.FixNoTenaga_kerja = D.FixNo
                                                    LEFT JOIN Pot_Cicilan AS E ON A.FixNoTenaga_kerja = E.Nofix
                                                    LEFT JOIN Sisa_cicilan_PeriodeIni AS F ON A.FixNoTenaga_kerja = F.FixNo
                                                    LEFT JOIN DiPotong_PeriodeIni_cicilan AS G ON A.FixNoTenaga_kerja = G.FixNo
                                                    LEFT JOIN sisa_tkBaru AS H ON A.FixNoTenaga_kerja = H.FixNo
                                                    LEFT JOIN [192.168.2.3].PSGRekrutmen.dbo.tblMstSubPemborong AS I ON A.IDToko = I.IDSubPemborong
                                                    LEFT JOIN Sisa_Periode_sebelumnya_tkLama AS J ON A.FixNoTenaga_kerja = J.FixNo
                                                    -- LEFT JOIN Sisa_TkBaru_Sembako AS K ON A.FixNoTenaga_kerja = K.FixNo
                                                    LEFT JOIN sisacicilankemaren AS L ON A.FixNoTenaga_kerja = L.FixNo 
                                                ORDER BY
                                                    A.Nama ASC
                                                ");
        return $query->result();
    }

    // function cek_transaksi_cicilan($tanggal, $nofix)
    // {
    //     $query = $this->db->query("SELECT * FROM RSUPBorongan2010..tblTrnPotonganCicilanHdr where Nofix = '$nofix' and Tanggal = '$tanggal'");
    //     return $query->result();
    // }

    function simpan_history_cicilan($dataHistoryHarga)
    {
        $this->db->insert('tblHistoryHargaCicilan', $dataHistoryHarga);
        $primay_key = $this->db->insert_id();
        return $primay_key;
    }
    function _getTrnHDR($tanggal, $nofix, $subpbr, $id)
    {
        $query = $this->db->query("SELECT
                                        A.HeaderID,
                                        A.Tanggal,
                                        A.IDPemborong,
                                        A.IDSubPemborong,
                                        A.Nofix,
                                        B.Nik,
                                        B.Nama,
                                        B.Pemborong,
                                        B.Perusahaan,
                                        B.BagianAbbr,
                                        C.NamaSub 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
                                        LEFT JOIN tblMstSubPemborong C ON A.IDSubPemborong = C.IDSubPemborong 
                                    WHERE
                                        A.Tanggal = '" . $tanggal . "' 
                                        AND A.Nofix= '" . $nofix . "' 
                                        AND A.IDSubPemborong= '" . $subpbr . "' 
                                        AND A.HeaderID = '" . $id . "'
                                        ");
        return $query->result();
    }

    // function _getTrnDTL($hdrid)
    // {
    //     $query = $this->db->query("SELECT
    //                                     A.*,
    //                                     B.NamaCicilan,
    //                                     B.NamaSatuan,
    //                                     B.SingkatanSatuan,
    //                                     B.NamaKategori 
    //                                 FROM
    //                                     [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanDtl AS A
    //                                     LEFT JOIN Vw_itemNew AS B ON A.CicilanID = B.CicilanID 
    //                                 WHERE
    //                                     A.HeaderID = '" . $hdrid . "'
    //                                             ");
    //     return $query->result();
    // }

    function _getTrnDTL($hdrid)
    {
        $query = $this->db->query("SELECT
                                        A.*,
                                        C.NamaCicilan,
                                        B.NamaKategori,
                                        C.SingkatanSatuan,
                                        D.JmlCicilanLunas 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanDtl AS A
                                        LEFT JOIN tblMstKategoriCicilan AS B ON A.KategoriCicilanID = B.KategoriCicilanID
                                        LEFT JOIN Vw_itemNew AS C ON A.CicilanID = C.CicilanID
                                        LEFT JOIN ( SELECT FixNo, DetailIDCicilan, COUNT ( DetailIDCicilan ) AS JmlCicilanLunas FROM [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi GROUP BY FixNo, DetailIDCicilan ) AS D ON A.DetailID = D.DetailIDCicilan
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS E ON a.HeaderID = E.HeaderID 
                                    WHERE
                                        a.HeaderID = '$hdrid' 
                                        AND E.StatusProses = 1 
                                        AND A.KategoriCicilanID != '0'
                                        ");
        return $query->result();
    }

    function _getGrandTotalCicilan($hdrid)
    {
        $query = $this->PSGBOR->query("SELECT SUM(HargaCicilan) as GrandTotal FROM tblTrnPotonganCicilanDtl where HeaderID = '" . $hdrid . "'");
        return $query->result();
    }

    function update_cicilan_hdr($hdrid, $dataHdr)
    {
        $this->PSGBOR->where("HeaderID", $hdrid);
        $this->PSGBOR->update("dbo.tblTrnPotonganCicilanHdr", $dataHdr);
    }

    function update_cicilan_dtl($hdrid, $dataHdr)
    {
        $this->PSGBOR->where("DetailID", $hdrid);
        $this->PSGBOR->update("dbo.tblTrnPotonganCicilanDtl", $dataHdr);
    }

    // function cek_dtlCicilan($dtlid)
    // {
    //     $query = $this->db->query("SELECT * FROM RSUPBorongan2010..tblTrnPotonganCicilanDtl where DetailID = '" . $dtlid . "'");
    //     return $query->result();
    // }

    // Add By Farih
    function SelectMstPemborong()
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("
            SELECT DISTINCT A.Perusahaan, A.IDPerusahaan, A.Pemborong, A.IDPemborong
            FROM vwMstPemborong A
            JOIN tblUtlAksesSubPemborong B on A.IDPemborong = B.IDPemborong
            WHERE A.IDPemborong NOT IN (15,16)
            AND B.GroupID = '$groupid'
       ");
        return $query->result();
    }

    function SelectMstSubPemborong($idPbr)
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("
            SELECT DISTINCT A.IDSubPemborong,A.IDPemborong,A.NamaSub,A.Perusahaan
            FROM tblMstSubPemborong A
            JOIN tblUtlAksesSubPemborong B on A.IDSubPemborong = B.IDSubPemborong
            WHERE B.GroupID = '$groupid' AND A.IDPemborong = '$idPbr'
        ");

        return $query->result();
    }

    // Search = Kata Kunci Pencarian
    function CariTKSubPemborong($idSub, $search = "")
    {
        $query = $this->db->query("SELECT * FROM (SELECT
                                                    CASE
                                                    WHEN IDSubPemborong = '6' THEN
                                                            '2' 
                                                    WHEN IDSubPemborong = '7' THEN
                                                            '13' ELSE IDPemborong 
                                                    END AS IDPemborongNew, * 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja ) AS A
                                    WHERE
                                        ( A.Nik = '" . $search . "' OR A.Nama LIKE '%$search%' or CAST(A.FixNo AS varchar) = '" . $search . "'  ) 
                                        AND A.IDPemborongNew = '" . $idSub . "'  
                                        AND A.TanggalKeluar IS NULL 
                                        AND A.IDToko != '0'
                                        ");
        return $query->result();
    }
    // END
    #transaksigabungan
    function GetTransaksi($pbr, $tglAwal, $tglAkhir)
    {
        $query = $this->db->query("SELECT DISTINCT Nofix,Nik,Nama,Perusahaan,Pemborong,Bagian,IDPemborong FROM Vw_transaksi
        where IDPemborong = '" . $pbr . "'");
        return $query->result();
    }

    function GetTransaksiFull($nofix)
    {
        $query = $this->db->query("SELECT * FROM Vw_transaksi where Nofix = '" . $nofix . "'");
        return $query->result();
    }

    function GetTotal($tglAwal, $tglAkhir)
    {
        $query = $this->db->query("SELECT distinct Nofix,SUM(Total) AS GrandTotal FROM Vw_transaksi where  Tanggal BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "' GROUP BY Nofix");
        return $query->result();
    }

    // TRANSAKSI AKHIR
    function GetListTransaksiAkhir($pbr, $sub_pbr, $tglAwal, $tglAkhir, $prd_sblm)
    {
        $sql = "SELECT
                    A.Nofix,
                    A.IDPemborong,
                    A.IDSubPemborong,
                    B.Nama,
                    B.Nik,
                    B.BagianAbbr,
                    SUM ( CASE WHEN ( A.Periode = '$prd_sblm' ) THEN A.Sisa ELSE A.Total END ) AS GrandTotal,
                    SUM ( CASE WHEN ( A.Periode = '$prd_sblm' ) THEN 0 ELSE A.Realisasi END ) AS GrandTotalRealisasi 
                FROM
                    Vw_PotonganBonTransaksiAkhir AS A
                    LEFT JOIN [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja AS B ON A.Nofix = B.FixNo 
                WHERE
                    A.IDPemborong = '$pbr' 
                    AND A.IDSubPemborong = '$sub_pbr' 
                    AND StatusProses = '1' 
                    AND (
                        ( A.Tanggal BETWEEN '$tglAwal' AND '$tglAkhir' AND A.StatusKomplit IS NULL ) 
                        OR ( A.TglTrAkhir >= '$tglAwal' AND A.TglTrAkhir <= '$tglAkhir' AND A.StatusKomplit IS NULL ) 
                        OR ( A.Periode = '$prd_sblm' AND A.Sisa != 0 AND A.StatusProsesSisa = '0' ) 
                    ) 
                GROUP BY
                    A.Nofix,
                    A.IDPemborong,
                    A.IDSubPemborong,
                    B.Nama,
                    B.Nik,
                    B.BagianAbbr";

        //echo $sql;
        $query = $this->db->query($sql);

        return $query->result();
    }
    function GetListHapus($pbr, $sub_pbr, $periode)
    {
        $sql = "SELECT
                    c.NAMA,
                    c.Nik,
                    c.BagianAbbr,
                    a.Nofix,
                    a.IDPemborong,
                    a.IDSubPemborong,
                    a.periodegajian,
                    SUM(b.total) as total
                FROM
                    [192.168.3.32].PSGBorongan.dbo.tbltrnpotonganpemboronghdr a
                    LEFT JOIN [192.168.3.32].PSGBorongan.dbo.tbltrnpotonganpemborongdtl b ON a.HeaderID = b.HeaderID
                    LEFT JOIN [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja c ON a.NoFix = c.FixNO  
                WHERE
                    A.IDPemborong = '$pbr'
                    and a.periodegajian ='$periode'
                    GROUP BY
                    a.Nofix,
                    a.IDPemborong,
                    a.IDSubPemborong,
                    a.periodegajian,
                    c.Nama,
                    c.Nik,
                    c.BagianAbbr
                    ORDER BY
                    c.NAMA";

        // echo $sql;
        // exit;
        $query = $this->db->query($sql);

        return $query->result();
    }

    function GetInfoTransaksiAkhir($noFix)
    {
        $query = $this->db->query("SELECT
                                        A.FixNo,
                                        A.Nama,
                                        A.Nik,
                                        A.BagianAbbr,
                                        A.IDPemborong,
                                        A.Pemborong,
                                        A.IDSubPemborong,
                                        B.Perusahaan 
                                    FROM
                                        [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja A
                                        LEFT JOIN tblMstSubPemborong B ON A.IDToko = B.IDSubPemborong 
                                    WHERE
                                        Fixno = '$noFix'
                                                ");

        return $query->row();
    }

    function GetSisaTransaksiAkhir($Nofix, $periode)
    {
        $query = $this->db->query("SELECT * FROM
                    Vw_PotonganBonTransaksiAkhir A
                        WHERE A.Periode = '$periode'
                        AND A.Nofix = '$Nofix'
                        AND A.Sisa != 0");

        return $query->result();
    }

    function GetViewTransaksiAkhir($noFix, $tglAwal, $tglAkhir)
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        Vw_PotonganBonTransaksiAkhir AS A 
                                    WHERE
                                        A.NoFix = '$noFix' 
                                        AND StatusProses = '1' 
                                        AND StatusKomplit IS NULL 
                                        AND A.Tanggal >= '" . $tglAwal . "' 
                                        AND A.Tanggal <= '" . $tglAkhir . "' 
                                    ORDER BY
                                        Prioritas ASC,
                                        Tanggal ASC
                                                ");

        return $query->result();
    }

    function GetViewbonhdr($noFix, $TanggalMulai)
    {
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                    [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongHdr
                                    WHERE
                                        NoFix = '$noFix'
                                        and periodegajian = '$TanggalMulai'
                                                ");

        return $query->result();
    }
    function GetViewBonDtl($id)
    {
        $query = $this->db->query("SELECT
                                        c.NamaItem,
                                        d.SingkatanSatuan,
                                        e.NamaKategori,
                                        a.*,
                                        b.* 
                                    FROM
                                        [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongHdr AS A
                                        LEFT JOIN [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongdtl AS b ON a.HeaderID= b.HeaderID
                                        LEFT JOIN tblMstItem AS c ON b.ItemID = c.ItemID
                                        LEFT JOIN tblMstSatuan AS d ON b.SatuanID = d.SatuanID
                                        LEFT JOIN tblMstKategori AS e ON b.KategoriID = e.KategoriID 
                                    WHERE
                                        b.HeaderID = '$id'
                                                ");

        return $query->result();
    }

    function _getDataHdrByID($id)
    {
        $query = $this->db->query("SELECT
                                            * 
                                        FROM
                                        [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongHdr
                                        WHERE
                                        HeaderID = '$id'
                                                    ");

        return $query->result();
    }

    function simpan_history_deletehdr($datahdr)
    {
        return $this->db->insert('tblHistoryHapusBonHdr', $datahdr);
    }

    function _getDataDtlByID($id)
    {
        $query = $this->db->query("SELECT
                                            * 
                                        FROM
                                        [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongDtl
                                        WHERE
                                        HeaderID = '$id'
                                                    ");

        return $query->result();
    }

    function simpan_history_deletedtl($datadtl)
    {
        return $this->db->insert('tblHistoryHapusBonDtl', $datadtl);
    }

    function Hapus_PotHdr($id)
    {
        $this->PSGBOR->where('HeaderID', $id);
        $this->PSGBOR->delete('psgborongan.dbo.tblTrnPotonganPemborongHdr');
    }

    function Hapus_PotDtl($id)
    {
        $this->PSGBOR->where('HeaderID', $id);
        $this->PSGBOR->delete('psgborongan.dbo.tblTrnPotonganPemborongDtl');
    }

    //Hapus Cicilan
    function _getDataHdrByIDCicilan($id)
    {
        $query = $this->db->query("SELECT
                                            * 
                                        FROM
                                        [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganCicilanhdr
                                        WHERE
                                        HeaderID = '$id'
                                                    ");
        return $query->result();
    }

    function _getDataDtlByIDCicilan($id)
    {
        $query = $this->db->query("SELECT
                                            * 
                                        FROM
                                        [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganCicilandtl
                                        WHERE
                                        DetailID = '$id'
                                                    ");
        return $query->result();
    }

    function _getDataDtlByIDCicilan_byHeader($id)
    {
        $query = $this->db->query("SELECT
                                            * 
                                        FROM
                                        [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganCicilandtl
                                        WHERE
                                        HeaderID = '$id'
                                                    ");
        return $query->result();
    }

    function simpan_history_deletehdr_cicilan($datahdr)
    {
        return $this->db->insert('tblHistoryHapusCicilanHdr', $datahdr);
    }

    function Hapus_CicilanHdr($id)
    {
        $this->PSGBOR->where('HeaderID', $id);
        $this->PSGBOR->delete('psgborongan.dbo.tblTrnPotonganCicilanhdr');
    }

    function Hapus_CicilanDtl($id)
    {
        $this->PSGBOR->where('DetailID', $id);
        $this->PSGBOR->delete('psgborongan.dbo.tblTrnPotonganCicilandtl');
    }

    function simpan_history_deletedtl_cicilan($datadtl)
    {
        return $this->db->insert('tblHistoryHapusCicilanDtl', $datadtl);
    }
    //end Hapus Cicilan


    function getHeaderTransaksiAkhir($noFix, $periode)
    {
        $query = $this->db->query("SELECT
                                        A.FixNo,
                                        A.Nama,
                                        A.Nik,
                                        A.BagianAbbr,
                                        A.IDPemborong,
                                        A.Pemborong,
                                        A.IDSubPemborong,
                                        A.IDToko,
                                        B.Perusahaan,
                                        C.HeaderID,
                                        C.Tanggal 
                                    FROM
                                        [192.168.3.32].PSGBorongan.dbo.vwMstTenagaKerja A
                                        LEFT JOIN tblMstSubPemborong B ON A.IDToko = B.IDSubPemborong
                                        JOIN tblTrnTransaksiAkhirHdr C ON C.Nofix = A.FixNo 
                                    WHERE
                                        C.NoFix = '$noFix' 
                                        AND C.Periode = '$periode'
                                                ");

        return $query->row();
    }

    function getDetailTransaksiAkhir($HeaderID)
    {
        $query = $this->db->query("
                SELECT *
                FROM Vw_PotonganBonTransaksiAkhir
                where HeaderID = '$HeaderID'
                ORDER BY  Prioritas ASC,Tanggal ASC
                ");

        return $query->result();
    }

    function simpanHeaderTransaksiAkhir($data)
    {
        $this->db->insert('tblTrnTransaksiAkhirHdr', $data);
        return $this->db->insert_id();
    }

    function simpanDetailTransaksiAkhir($data)
    {
        return $this->db->insert('tblTrnTransaksiAkhirDtl', $data);
    }

    function updateHeaderTransaksiAkhir($headerID, $data)
    {
        $this->db->where("HeaderID", $headerID);
        return $this->db->update('tblTrnTransaksiAkhirHdr', $data);
    }

    function updateDetailTransaksiAkhir($detailID, $data)
    {
        $this->db->where("DetailID", $detailID);
        return $this->db->update('tblTrnTransaksiAkhirDtl', $data);
    }

    function getDetailCicilanByID($cicilanDetailID)
    {
        $this->PSGBOR->where("DetailID", $cicilanDetailID);
        return $this->PSGBOR->get('tblTrnPotonganCicilanDtl')->row_array();
    }

    // function delete_trn($id)
    // {
    //     $this->PSGBOR->where('HeaderID', $id);
    //     $this->PSGBOR->delete('psgborongan.dbo.tblTrnPotonganPemborongHdr');
    // }
    function delete_trn($id, $data)
    {
        $this->PSGBOR->where('HeaderID', $id);
        $this->PSGBOR->update('dbo.tblTrnPotonganPemborongHdr', $data);
    }

    // function delete_trn_cicilan($id)
    // {
    //     $this->PSGBOR->where('HeaderID', $id);
    //     $this->PSGBOR->delete('psgborongan.dbo.tblTrnPotonganCicilanHdr');
    // }
    function delete_trn_cicilan($id, $data)
    {
        $this->PSGBOR->where('HeaderID', $id);
        $this->PSGBOR->update('dbo.tblTrnPotonganCicilanHdr', $data);
    }

    // END TRANSAKSI AKHIR

    // BEGIN :: MONITORING POTONGAN PEMBORONG

    function GetDataPotongan($pbr, $sub, $periode)
    {
        $query = $this->db->query("SELECT A.HeaderID,A.IDPemborong,A.IDSubPemborong,A.Nofix,B.Nik,B.Nama,B.Bagian,D.Total FROM tblTrnTransaksiAkhirHdr as A left join RSUPBorongan2010..vwMasterTenagaKerja as B on A.Nofix = B.Nofix left join (SELECT A.Nofix,SUM(B.Realisasi) as total FROM tblTrnTransaksiAkhirHdr as A left join tblTrnTransaksiAkhirDtl as b on A.headerID = B.HeaderID WHERE StatusKomplit ='1' GROUP BY Nofix) as D on A.Nofix = D.Nofix WHERE A.IDPemborong = '$pbr' and A.IDSubPemborong ='$sub' and A.Periode ='$periode' and StatusKomplit='1'  GROUP BY  A.HeaderID,A.IDPemborong,A.IDSubPemborong,A.Nofix,B.Nik,B.Nama,B.Bagian,D.Total");
        return $query->result();
    }



    function getDataCampuranSub($pbr, $sub, $periode)
    {
        $query = $this->db->query("SELECT TOP
                                        ( 1 ) PeriodeGajian,
                                        -- A.IDPemborongNew,
                                        A.IDPemborong,
                                        A.IDSubPemborong,
                                        A.Nofix,
                                        B.Nama,
                                        b.Nik,
                                        b.BagianAbbr,
                                        C.NamaSub,
                                        SUM ( CASE WHEN flag = 0 THEN Total END ) AS Pot_Sembako,
                                        SUM ( CASE WHEN flag = 1 THEN Total END ) AS Cicilan 
                                    FROM
                                        (
                                        SELECT
                                            A.HeaderID,
                                            '0' AS flag,
                                            A.Tanggal,
                                            A.PeriodeGajian,
                                        -- CASE
                                                
                                        --         WHEN A.IDSubPemborong = '6' THEN
                                        --         '2' 
                                        --         WHEN A.IDSubPemborong = '7' THEN
                                        --         '13' ELSE A.IDPemborong 
                                        --     END AS IDPemborongNew,
                                                                                A.IDPemborong,
                                            A.IDSubPemborong,
                                            A.Nofix,
                                            A.StatusProses,
                                            A.CreatedBy,
                                            A.CreatedDate,
                                            B.DetailID,
                                            B.ItemID,
                                            B.SatuanID,
                                            B.KategoriID,
                                            B.HargaID,
                                            B.Harga,
                                            B.Quantity,
                                            B.Total,
                                            NULL AS CicilanKe,
                                            NULL AS TanggalMulai,
                                            NULL AS DP,
                                            NULL AS PeriodeDipotong 
                                        FROM
                                            [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                                            INNER JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID UNION
                                        SELECT
                                            A.HeaderID,
                                            '1' AS flag,
                                            A.Tanggal,
                                            A.PeriodeGajian,
                                        -- CASE
                                                
                                        --         WHEN A.IDSubPemborong = '6' THEN
                                        --         '2' 
                                        --         WHEN A.IDSubPemborong = '7' THEN
                                        --         '13' ELSE A.IDPemborong 
                                        --     END AS IDPemborongNew,
                                                                                A.IDPemborong,
                                            A.IDSubPemborong,
                                            A.Nofix,
                                            A.StatusProses,
                                            A.CreatedBy,
                                            A.CreatedDate,
                                            B.DetailID,
                                            B.CicilanID AS ItemID,
                                            B.SatuanID,
                                            B.KategoriCicilanID AS KategoriID,
                                            B.Cicilan AS HargaID,
                                            B.Harga,
                                            B.Quantity,
                                            B.HargaCicilan AS Total,
                                            B.CicilanKe,
                                            B.TanggalMulai,
                                            B.DP,
                                            B.PeriodeDipotong 
                                        FROM
                                            [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS A
                                            INNER JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanDtl AS B ON A.HeaderID = B.HeaderID 
                                        ) AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS b ON a.Nofix = b.FixNo
                                        LEFT JOIN tblMstSubPemborong AS C ON A.IDSubPemborong = C.IDSubPemborong 
                                    WHERE
                                        -- A.IDPemborongNew = '$pbr' 
                                                                                A.IDPemborong = '$pbr'
                                    AND A.IDSubPemborong = '$sub'
                                    AND PeriodeGajian = '$periode'
                                        
                                        AND A.StatusProses = '1' 
                                    GROUP BY
                                        PeriodeGajian,
                                        -- A.IDPemborongNew,
                                                                            A.IDPemborong,
                                        A.IDSubPemborong,
                                        A.Nofix,
                                        B.Nama,
                                        b.Nik,
                                        b.BagianAbbr,
                                        C.NamaSub

                                 ");
        return $query->result();
    }

    // function getDataCicilan($pbr, $sub, $periode, $tglMulai)
    // {
    //     $month = date('m', strtotime($tglMulai));
    //     $month2 = date('m', strtotime($periode));
    //     // echo $periode;
    //     // echo $month.'<br>'.$month2.'<br>'.$pbr.'<br>'.$sub;
    //     $query = $this->db->query("with Tenaga_kerja as (SELECT * FROM RSUPBorongan2010..vwMasterTenagaKerja where TanggalKeluar is null and IDPemborong = '$pbr' and IDSubPemborong = '$sub'),
    //         Pot_sembako as (SELECT * FROM (SELECT A.Nofix,A.IDPemborong,A.IDSubPemborong,A.PeriodeGajian,SUM(B.Total) as Pot_Sembako,A.StatusProses
    //                 FROM RSUPBorongan2010..tblTrnPotonganPemborongHdr AS A INNER JOIN RSUPBorongan2010..tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID
    //                 where a.IDPemborong = '$pbr' and a.IDSubPemborong = '$sub' and a.PeriodeGajian = '$periode' and A.StatusProses = '1'
    //                 GROUP BY A.Nofix,A.IDPemborong,A.IDSubPemborong,A.PeriodeGajian,A.StatusProses) AS A
    //                 UNION ALL (SELECT A.Nofix,A.IDPemborong,A.IDSubPemborong,A.PeriodeGajian,SUM(B.Total) as Pot_Sembako,A.StatusProses
    //                 FROM RSUPBorongan2010..tblTrnPotonganPemborongHdrArsip AS A INNER JOIN RSUPBorongan2010..tblTrnPotonganPemborongDtlArsip AS B ON A.HeaderID = B.HeaderID
    //                 where a.IDPemborong = '$pbr' and a.IDSubPemborong = '$sub' and a.PeriodeGajian = '$periode' and A.StatusProses = '1'
    //                 GROUP BY A.Nofix,A.IDPemborong,A.IDSubPemborong,A.PeriodeGajian,A.StatusProses) ),
    //         Sisa_Sembako as (SELECT FixNo,PeriodeGajian,PeriodePotongan,SUM(SisaPotonganPeriodeIni) as SisaSembako,IDPemborong FROM RSUPBorongan2010..tblTrnPotonganBONPemborongSisa
    //                where PeriodeGajian = '$periode' and IDPemborong = '$pbr'
    //                GROUP BY FixNo,PeriodeGajian,PeriodePotongan,IDPemborong),
    //         Potongan_Sembako as (SELECT * FROM (SELECT SUM(DiPotongPeriodeIni) as DiPotongPeriodeIni_Sembako,FixNo,PeriodeGajian,PotonganCicilan 
    //                     FROM RSUPBorongan2010..tblTrnPotonganBONPemborongFinal WHERE PeriodeGajian = '$periode' GROUP BY FixNo,PeriodeGajian,PotonganCicilan) AS A
    //             UNION ALL
    //             (SELECT SUM(DiPotongPeriodeIni) as DiPotongPeriodeIni_Sembako,FixNo,PeriodeGajian,PotonganCicilan 
    //                     FROM RSUPBorongan2010..tblTrnPotonganBONPemborongFinalArsip WHERE PeriodeGajian = '$periode' GROUP BY FixNo,PeriodeGajian,PotonganCicilan)),
    //         Pot_cicilan as (SELECT Distinct A.Nofix,B.Pot_Cicilan FROM (SELECT DetailID,Cicilan,TanggalMulai,IDPemborong,IDSubPemborong,Nofix,PeriodeDipotong FROM vwPotonganCicilanNew) as A left join 
    //         (SELECT Nofix,SUM(HargaCicilan) as Pot_Cicilan FROM vwPotonganCicilanNew  where Durasi != 0 and ISNULL(PeriodeDipotong,0) > 0
    //        GROUP BY Nofix) as B ON A.Nofix = B.Nofix left join (SELECT DISTINCT FixNo,DetailIDCicilan,COUNT(DetailIDCicilan) as JmlCicilanLunas,Periode FROM RSUPBorongan2010..tblTrnPotonganBONPemborongCicilanKalkulasi  WHERE DiPotong != 0
    //         GROUP BY FixNo,DetailIDCicilan,Periode) as C on A.DetailID = C.DetailIDCicilan
    //         where (A.Cicilan >= C.JmlCicilanLunas OR C.JmlCicilanLunas is null AND TanggalMulai = '$periode') and a.IDPemborong = '$pbr' and a.IDSubPemborong = '$sub' and ISNULL(A.PeriodeDipotong,0) > 0),
    //         Sisa_cicilan as (SELECT FixNo,Periode,SUM(SisaCicilanAkanDipotong) as SisaCicilan FROM RSUPBorongan2010..vwTrnPotonganBONPemborongSisaCicilan 
    //                where Periode = '$periode' and IDPemborong = '$pbr' GROUP BY FixNo,Periode),
    //         Potongan_cicilan as (SELECT Sum(DiPotong) as DiPotongPeriodeIni_Cicilan,FixNo,Periode FROM RSUPBorongan2010..tblTrnPotonganBONPemborongCicilanKalkulasi WHERE Periode = '$periode' GROUP BY FixNo,Periode
    //                 UNION ALL
    //         SELECT Sum(DiPotong) as DiPotongPeriodeIni_Cicilan,FixNo,Periode FROM RSUPBorongan2010..tblTrnPotonganBONPemborongCicilanKalkulasiArsip WHERE Periode = '$periode' GROUP BY FixNo,Periode),
    //         Sisa_periode_sebelumnya_sembako as (SELECT FixNo,PeriodeGajian,PeriodePotongan,SUM(SisaPotonganPeriodeIni) as SisaSembako,IDPemborong FROM RSUPBorongan2010..tblTrnPotonganBONPemborongSisa
    //                        where PeriodePotongan = '$periode' and IDPemborong = '$pbr'
    //                        GROUP BY FixNo,PeriodeGajian,PeriodePotongan,IDPemborong
    //             UNION ALL 
    //             SELECT FixNo,PeriodeGajian,PeriodePotongan,SUM(SisaPotonganPeriodeIni) as SisaSembako,IDPemborong FROM RSUPBorongan2010..tblTrnPotonganBONPemborongSisaArsip
    //                        where PeriodePotongan = '$periode' and IDPemborong = '$pbr'
    //                        GROUP BY FixNo,PeriodeGajian,PeriodePotongan,IDPemborong),
    //         Sisa_periode_sebelumnya_cicilan as (SELECT FixNo,Periode,SUM(SisaCicilanAkanDipotong) as SisaCicilan FROM RSUPBorongan2010..vwTrnPotonganBONPemborongSisaCicilan 
    //                        where PeriodeAkanDipotong = '$periode' and IDPemborong = '$pbr' GROUP BY FixNo,Periode)
    //             SELECT Distinct a.Nofix,a.Nama,a.Nik,a.Bagian,a.IDPemborong,a.IDSubPemborong,b.Pot_Sembako,e.DiPotongPeriodeIni_Sembako,c.SisaSembako,f.Pot_Cicilan,g.DiPotongPeriodeIni_Cicilan,d.SisaCicilan,h.NamaSub,(i.SisaSembako + j.SisaCicilan) as Sisa_periode_sebelumnya,i.SisaSembako as Sisa_sembako_sebelumnya,j.SisaCicilan as Sisa_cicilan_sebelumnya
    //             FROM Tenaga_kerja as a left join Pot_sembako as b on a.Nofix = b.Nofix
    //             left join Sisa_Sembako as c on a.Nofix = c.FixNo
    //             left join Sisa_cicilan as d on a.Nofix = d.FixNo
    //             left join Potongan_Sembako as e on a.Nofix = e.FixNo
    //             left join Pot_cicilan as f on a.Nofix = f.Nofix
    //             left join Potongan_cicilan as g on a.Nofix = g.FixNo
    //             left join tblMstSubPemborong as h on a.IDSubPemborong = h.IDSubPemborong
    //             left join Sisa_periode_sebelumnya_sembako as i ON a.Nofix = i.FixNo
    //             left join Sisa_periode_sebelumnya_cicilan as j on a.Nofix = j.FixNo
    //             ORDER BY a.Nama asc");
    //     return $query->result();
    // }

    function getDataCicilanByNofix($nofix, $periode, $tglMulai)
    {
        $month = date('m', strtotime($tglMulai));
        $month2 = date('m', strtotime($periode));
        // echo $periode;
        // echo $month.'<br>'.$month2.'<br>'.$pbr.'<br>'.$sub;
        $query = $this->db->query("WITH Tenaga_kerja AS ( SELECT * FROM [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja WHERE TanggalKeluar IS NULL AND FixNo = '$nofix' ),
                                        Pot_sembako AS (
                                            SELECT
                                                A.Nofix,
                                                A.IDPemborong,
                                                A.IDSubPemborong,
                                                A.PeriodeGajian,
                                                SUM ( B.Total ) AS Pot_Sembako,
                                                A.StatusProses 
                                            FROM
                                                [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                                                INNER JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID 
                                            WHERE
                                                A.Nofix = '$nofix' 
                                                AND a.PeriodeGajian = '$periode' 
                                                AND A.StatusProses = '1' 
                                            GROUP BY
                                                A.Nofix,
                                                A.IDPemborong,
                                                A.IDSubPemborong,
                                                A.PeriodeGajian,
                                                A.StatusProses 
                                            ),
                                            Sisa_Sembako AS (
                                            SELECT
                                                FixNo,
                                                PeriodeGajian,
                                                PeriodePotongan,
                                                SUM ( SisaPotonganPeriodeIni ) AS SisaSembako,
                                                IDPemborong 
                                            FROM
                                                [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongSisa 
                                            WHERE
                                                PeriodeGajian = '$periode' 
                                                AND FixNo = '$nofix' 
                                            GROUP BY
                                                FixNo,
                                                PeriodeGajian,
                                                PeriodePotongan,
                                                IDPemborong 
                                            ),
                                            Potongan_Sembako AS (
                                            SELECT SUM
                                                ( DiPotongPeriodeIni ) AS DiPotongPeriodeIni_Sembako,
                                                FixNo,
                                                PeriodeGajian,
                                                PotonganCicilan 
                                            FROM
                                                [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongFinal 
                                            WHERE
                                                PeriodeGajian = '$periode' 
                                            GROUP BY
                                                FixNo,
                                                PeriodeGajian,
                                                PotonganCicilan 
                                            ),
                                            Pot_cicilan AS (
                                            SELECT DISTINCT
                                                A.Nofix,
                                                B.Pot_Cicilan 
                                            FROM
                                                ( SELECT DetailID, Cicilan, TanggalMulai, IDPemborong, IDSubPemborong, Nofix, PeriodeDipotong FROM vwPotonganCicilanNew ) AS A
                                                LEFT JOIN ( SELECT Nofix, SUM ( HargaCicilan ) AS Pot_Cicilan FROM vwPotonganCicilanNew WHERE Durasi != 0 GROUP BY Nofix ) AS B ON A.Nofix = B.Nofix
                                                LEFT JOIN (
                                                SELECT DISTINCT
                                                    FixNo,
                                                    DetailIDCicilan,
                                                    COUNT ( DetailIDCicilan ) AS JmlCicilanLunas,
                                                    Periode 
                                                FROM
                                                    [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi 
                                                WHERE
                                                    DiPotong != 0 
                                                GROUP BY
                                                    FixNo,
                                                    DetailIDCicilan,
                                                    Periode 
                                                ) AS C ON A.DetailID = C.DetailIDCicilan 
                                            WHERE
                                                ( A.Cicilan >= C.JmlCicilanLunas OR C.JmlCicilanLunas IS NULL AND TanggalMulai = '$periode' ) 
                                                AND  A.Nofix = '$nofix' 
                                            ),
                                            Sisa_cicilan AS (
                                            SELECT
                                                FixNo,
                                                Periode,
                                                SUM ( SisaCicilanAkanDipotong ) AS SisaCicilan 
                                            FROM
                                                [192.168.3.32].psgborongan.dbo.vwTrnPotonganBONPemborongSisaCicilan 
                                            WHERE
                                                Periode = '$periode' 
                                                AND FixNo = '$nofix' 
                                            GROUP BY
                                                FixNo,
                                                Periode 
                                            ),
                                            Potongan_cicilan AS (
                                            SELECT SUM
                                                ( DiPotong ) AS DiPotongPeriodeIni_Cicilan,
                                                FixNo,
                                                Periode 
                                            FROM
                                                [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi 
                                            WHERE
                                                Periode = '$periode' 
                                            GROUP BY
                                                FixNo,
                                                Periode 
                                            ),
                                            Sisa_periode_sebelumnya_sembako AS (
                                            SELECT
                                                FixNo,
                                                PeriodeGajian,
                                                PeriodePotongan,
                                                SUM ( SisaPotonganPeriodeIni ) AS SisaSembako,
                                                IDPemborong 
                                            FROM
                                                [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongSisa 
                                            WHERE
                                                PeriodePotongan = '$periode' 
                                                AND FixNo = '$nofix' 
                                            GROUP BY
                                                FixNo,
                                                PeriodeGajian,
                                                PeriodePotongan,
                                                IDPemborong 
                                            ),
                                            Sisa_periode_sebelumnya_cicilan AS (
                                            SELECT
                                                FixNo,
                                                Periode,
                                                SUM ( SisaCicilanAkanDipotong ) AS SisaCicilan 
                                            FROM
                                                [192.168.3.32].psgborongan.dbo.vwTrnPotonganBONPemborongSisaCicilan 
                                            WHERE
                                                PeriodeAkanDipotong = '$periode' 
                                                AND FixNo = '$nofix' 
                                            GROUP BY
                                                FixNo,
                                                Periode 
                                            ) SELECT DISTINCT
                                            a.FixNo,
                                            a.Nama,
                                            a.Nik,
                                            a.BagianAbbr,
                                            a.IDPemborong,
                                            a.IDSubPemborong,
                                            a.Pemborong,
                                            b.PeriodeGajian,
                                            b.Pot_Sembako,
                                            e.DiPotongPeriodeIni_Sembako,
                                            c.SisaSembako,
                                            f.Pot_Cicilan,
                                            g.DiPotongPeriodeIni_Cicilan,
                                            d.SisaCicilan,
                                            h.NamaSub,
                                            h.Perusahaan,
                                            ( i.SisaSembako + j.SisaCicilan ) AS Sisa_periode_sebelumnya,
                                            i.SisaSembako AS Sisa_sembako_sebelumnya,
                                            j.SisaCicilan AS Sisa_cicilan_sebelumnya 
                                        FROM
                                            Tenaga_kerja AS a
                                            LEFT JOIN Pot_sembako AS b ON a.FixNo = b.Nofix
                                            LEFT JOIN Sisa_Sembako AS c ON a.FixNo = c.FixNo
                                            LEFT JOIN Sisa_cicilan AS d ON a.FixNo = d.FixNo
                                            LEFT JOIN Potongan_Sembako AS e ON a.FixNo = e.FixNo
                                            LEFT JOIN Pot_cicilan AS f ON a.FixNo = f.Nofix
                                            LEFT JOIN Potongan_cicilan AS g ON a.FixNo = g.FixNo
                                            LEFT JOIN tblMstSubPemborong AS h ON a.IDToko = h.IDSubPemborong
                                            LEFT JOIN Sisa_periode_sebelumnya_sembako AS i ON a.FixNo = i.FixNo
                                            LEFT JOIN Sisa_periode_sebelumnya_cicilan AS j ON a.FixNo = j.FixNo 
                                        ORDER BY
                                            a.Nama ASC
                                        ");
        return $query->row();
    }

    function cicilan($pbr, $sub)
    {
        $query = $this->db->query("SELECT TOP
                                        ( 1 ) B.TanggalMulai 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS A
                                        INNER JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanDtl AS B ON A.HeaderID = B.HeaderID 
                                    WHERE
                                        A.IDPemborong = '$pbr' 
                                        AND A.IDSubPemborong = '$sub' 
                                        AND A.StatusProses = '1' 
                                        AND B.TanggalMulai NOT IN ( '1970-01-01' ) 
                                    ORDER BY
                                        B.TanggalMulai ASC
                                        ");
        return $query->result();
    }

    function cicilanByNofix($nofix)
    {
        $query = $this->db->query("SELECT TOP (1)  A.PeriodeGajian, A.IDPemborong, A.IDSubPemborong, A.Nofix, A.StatusProses,TanggalMulai 
                                    FROM [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS A INNER JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanDtl AS B ON A.HeaderID = B.HeaderID
                                    where A.Nofix='$nofix' AND A.StatusProses = '1'");
        return $query->result();
    }

    function PotonganSembakoByNofixAndPeriode($nofix, $periode)
    {
        $query = $this->db->query("SELECT * FROM [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A INNER JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID WHERE A.Nofix ='$nofix' AND A.StatusProses ='1' AND PeriodeGajian ='$periode'");
        return $query->result();
    }

    function getDataSisaCicilan($pbr, $sub, $periode1)
    {
        $query = $this->db->query("WITH th1 AS (
                                        SELECT
                                            A.Nofix,
                                            B.DetailID,
                                            B.HargaCicilan,
                                            A.IDPemborong,
                                            A.IDSubPemborong,
                                            a.PeriodeGajian 
                                        FROM
                                            [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS A
                                            LEFT JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanDtl AS B ON a.HeaderID = B.HeaderID 
                                        WHERE
                                            A.StatusProses = '1' 
                                        ),
                                        th2 AS ( SELECT FixNo, DetailIDCicilan, DiPotong FROM [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi ) SELECT
                                        a.Nofix,
                                        SUM ( HargaCicilan ) AS SisaCicilan,
                                        a.IDPemborong,
                                        a.IDSubPemborong,
                                        a.PeriodeGajian 
                                    FROM
                                        th1 AS a
                                        LEFT JOIN th2 AS b ON a.Nofix = FixNo 
                                        AND a.DetailID = b.DetailIDCicilan 
                                    WHERE
                                        b.DetailIDCicilan IS NULL 
                                        AND a.PeriodeGajian = '$periode1' 
                                        AND a.IDPemborong = '$pbr' 
                                        AND a.IDSubPemborong = '$sub'
                                        AND a.DetailID IS NOT NULL 
                                    GROUP BY
                                        a.Nofix,
                                        a.IDPemborong,
                                        a.IDSubPemborong,
                                        a.PeriodeGajian 
                                    ORDER BY
                                        a.Nofix ASC
                                            ");
        return $query->result();
    }

    function getDataCampuran($pbr, $sub, $periode1)
    {
        $query = $this->db->query("WITH th1 AS ( SELECT * FROM  [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja WHERE TanggalKeluar IS NULL AND IDPemborong = '$pbr' ),
                                        th2 AS (
                                            SELECT
                                                A.Nofix,
                                                A.IDPemborong,
                                                A.IDSubPemborong,
                                                A.PeriodeGajian,
                                                SUM ( B.Total ) AS Pot_Sembako,
                                                A.StatusProses 
                                            FROM
                                                [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                                                INNER JOIN  [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID 
                                            WHERE
                                                a.IDPemborong = '$pbr' 
                                                AND a.IDSubPemborong = '$sub' 
                                                AND a.PeriodeGajian = '$periode1' 
                                                AND A.StatusProses = '1' 
                                            GROUP BY
                                                A.Nofix,
                                                A.IDPemborong,
                                                A.IDSubPemborong,
                                                A.PeriodeGajian,
                                                A.StatusProses 
                                            ),
                                            th3 AS (
                                            SELECT
                                                Nofix,
                                                SUM ( HargaCicilan ) AS Cicilan,
                                                TanggalMulai 
                                            FROM
                                                vwPotonganCicilanNew 
                                            WHERE
                                                TanggalMulai <= '$periode1' 
                                                AND terakhir >= '$periode1' 
                                                AND IDPemborong = '$pbr' 
                                                AND IDSubPemborong = '$sub' 
                                            GROUP BY
                                                Nofix,
                                                TanggalMulai 
                                            ) SELECT
                                            a.FixNo,
                                            A.Nama,
                                            A.Nik,
                                            A.IDPemborong,
                                            A.IDSubPemborong,
                                            D.NamaSub,
                                            A.BagianAbbr,
                                            b.PeriodeGajian,
                                            b.Pot_Sembako,
                                            C.Cicilan AS Pot_cicilan,
                                            c.TanggalMulai,
                                            e.SisaPotonganPeriodeIni,
                                            f.DiPotongPeriodeIni_Sembako,
                                            g.DiPotong_Cicilan 
                                        FROM
                                            th1 AS a
                                            LEFT JOIN th2 AS b ON a.FixNo= b.Nofix
                                            LEFT JOIN th3 AS c ON a.FixNo= c.Nofix
                                            LEFT JOIN tblMstSubPemborong AS d ON a.IDSubPemborong = d.IDSubPemborong
                                            LEFT JOIN ( SELECT SUM ( SisaPotonganPeriodeIni ) AS SisaPotonganPeriodeIni, FixNo, PeriodePotongan FROM  [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongSisa WHERE PeriodePotongan = '$periode1' GROUP BY FixNo, PeriodePotongan ) AS e ON a.FixNo = e.FixNo
                                            LEFT JOIN ( SELECT SUM ( DiPotongPeriodeIni ) AS DiPotongPeriodeIni_Sembako, FixNo, PeriodeGajian FROM  [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongFinal WHERE PeriodeGajian = '$periode1' GROUP BY FixNo, PeriodeGajian ) AS f ON a.FixNo = f.FixNo
                                            LEFT JOIN ( SELECT SUM ( DiPotong ) AS DiPotong_Cicilan, FixNo, Periode FROM  [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi WHERE Periode = '$periode1' GROUP BY FixNo, Periode ) AS g ON a.FixNo = g.FixNo
                                            ");
        return $query->result();
    }

    function getDetailTotal($nofix, $periode)
    {
        $query = $this->db->query("SELECT
                                        a.Nofix,
                                        SUM ( A.HargaCicilan ) AS Sisa_Cicilan,
                                        B.DiPotong 
                                    FROM
                                        vwPotonganCicilanNew AS a
                                        LEFT JOIN ( SELECT FixNo, DetailIDCicilan, DiPotong FROM  [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi ) AS b ON a.Nofix = b.FixNo 
                                        AND A.DetailID = B.DetailIDCicilan 
                                    WHERE
                                        a.PeriodeGajian = '$periode' 
                                        AND A.Nofix = '$nofix' 
                                        AND b.DiPotong = '0' 
                                    GROUP BY
                                        a.Nofix,
                                        b.DiPotong
                                        ");
        return $query->result();
    }

    function getDetailSisaCicilan($nofix, $periode)
    {
        $query = $this->db->query("WITH th1 AS (
                                        SELECT
                                            A.Nofix,
                                            B.DetailID,
                                            B.HargaCicilan,
                                            A.IDPemborong,
                                            A.IDSubPemborong,
                                            a.PeriodeGajian,
                                            b.KategoriCicilanID,
                                            B.CicilanID,
                                            b.Quantity,
                                            b.SatuanID 
                                        FROM
                                            [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS A
                                            LEFT JOIN  [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanDtl AS B ON a.HeaderID = B.HeaderID 
                                        WHERE
                                            A.StatusProses = '1' 
                                        ),
                                        th2 AS ( SELECT FixNo, DetailIDCicilan, DiPotong FROM  [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi ) SELECT
                                        a.Nofix,
                                        a.HargaCicilan,
                                        a.IDPemborong,
                                        a.IDSubPemborong,
                                        a.PeriodeGajian,
                                        a.KategoriCicilanID,
                                        c.NamaKategori,
                                        d.NamaCicilan,
                                        a.Quantity,
                                        e.NamaSatuan 
                                    FROM
                                        th1 AS a
                                        LEFT JOIN th2 AS b ON a.Nofix = FixNo 
                                        AND a.DetailID = b.DetailIDCicilan
                                        LEFT JOIN tblMstKategoriCicilan AS c ON a.KategoriCicilanID = c.KategoriCicilanID
                                        LEFT JOIN tblMstItemCicilan AS d ON a.CicilanID = d.CicilanID
                                        LEFT JOIN tblMstSatuan AS e ON a.SatuanID = e.SatuanID 
                                    WHERE
                                        a.PeriodeGajian = '$periode' 
                                        AND b.DiPotong = '0' 
                                        AND A.Nofix = '$nofix' 
                                    ORDER BY
                                        a.Nofix ASC
                                        ");
        return $query->result();
    }

    function GetDataTotal($periode)
    {
        $query = $this->db->query("SELECT distinct A.Nofix,D.GrandTotal FROM tblTrnTransaksiAkhirHdr as A left join RSUPBorongan2010..vwMasterTenagaKerja as B on A.Nofix = B.Nofix
left join (SELECT A.Nofix,SUM(B.Realisasi) as GrandTotal FROM tblTrnTransaksiAkhirHdr as A left join tblTrnTransaksiAkhirDtl as b on A.headerID = B.HeaderID WHERE StatusKomplit ='1' and Periode ='$periode'
GROUP BY Nofix) as D on A.Nofix = D.Nofix GROUP BY A.Nofix,D.GrandTotal ");
        return $query->result();
    }

    function getDataTrnHdr($nofix, $Periode)
    {
        $query = $this->PSGBOR->query("SELECT  TOP
                                        ( 1 ) A.Nofix,
                                        B.Nama,
                                        B.Nik,
                                        C.Pemborong,
                                        C.NamaSub,
                                        C.Perusahaan,
                                        B.BagianAbbr,
                                        A.Tanggal,
                                        a.PeriodeGajian as PeriodeGajianBon,
                                        e.PeriodeGajian as PeriodeGajianCicilan
                                    FROM
                                        tblTrnPotonganPemborongHdr AS A
                                        LEFT JOIN tblTrnPotonganCicilanHdr AS E ON A.Nofix = E.NoFix
                                        LEFT JOIN vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
                                        LEFT JOIN [192.168.2.3].PSGRekrutmen.dbo.VW_subpemborong AS C ON A.IDSubPemborong = C.IDSubPemborong 
                                    WHERE
                                        A.Nofix = '$nofix' 
                                        AND (a.PeriodeGajian = '$Periode' OR e.PeriodeGajian = '$Periode') UNION ALL
                                    SELECT TOP
                                        ( 1 ) A.Nofix,
                                        B.Nama,
                                        B.Nik,
                                        C.Pemborong,
                                        C.NamaSub,
                                        C.Perusahaan,
                                        B.BagianAbbr,
                                        A.Tanggal,
                                        a.PeriodeGajian as PeriodeGajianBon,
                                        e.PeriodeGajian as PeriodeGajianCicilan 
                                    FROM
                                        tblTrnPotonganPemborongHdrArsip AS A
                                        LEFT JOIN tblTrnPotonganCicilanHdr AS E ON A.Nofix = E.NoFix
                                        LEFT JOIN  vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
                                        LEFT JOIN [192.168.2.3].PSGRekrutmen.dbo.VW_subpemborong AS C ON A.IDSubPemborong = C.IDSubPemborong 
                                    WHERE
                                        A.Nofix = '$nofix' 
                                        AND (a.PeriodeGajian = '$Periode' OR e.PeriodeGajian = '$Periode') 
                                        ");
        return $query->result();
    }
    function totalsembako($nofix, $periode)

    {
        $query = $this->db->query("SELECT SUM
                                        ( B.Total ) AS grand 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID 
                                    WHERE
                                        A.Nofix = '$nofix' 
                                        AND PeriodeGajian = '$periode' 
                                        AND A.StatusProses = '1' UNION
                                    SELECT SUM
                                        ( B.Total ) AS grand 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdrArsip AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtlArsip AS B ON A.HeaderID = B.HeaderID 
                                    WHERE
                                        A.Nofix = '$nofix' 
                                        AND PeriodeGajian = '$periode' 
                                        AND A.StatusProses = '1'
                                        ");
        return $query->result();
    }
    // $query = $this->PSGBOR->query("SELECT Distinct Nofix,TanggalMulai FROM PSGBorongan.dbo.tblTrnPotonganCicilanDtl where Nofix = '$nofix' ORDER BY TanggalMulai ASC");
    function getDataTrnHdrTel($nofix, $hdrid)
    {
        $query = $this->PSGBOR->query(
            "SELECT  A.HeaderID,
                A.Nofix,
                B.Nama,
                B.Nik,
                C.Pemborong,
                C.Perusahaan,
                B.BagianAbbr,
                A.Tanggal 
            FROM
                PSGBorongan.dbo.tblTrnPotonganPemborongHdr AS A
                LEFT JOIN PSGBorongan.dbo.vwMstTenagaKerja AS B ON A.Nofix = B.FixNo
                LEFT JOIN PSGBorongan.dbo.vwMstPemborongJoinPerusahaan AS C ON A.IDPemborong = C.IDPemborong 
            WHERE
                A.Nofix = '$nofix' 
                AND A.HeaderID = '$hdrid' 
                AND A.StatusProses = '1' 
            ORDER BY
                A.CreatedDate DESC"
        );
        return $query->result();
    }



    function getDataTrnDtl($nofix, $hdrid)
    {
        $query = $this->db->query("SELECT distinct A.Nofix,A.Tanggal,SUM(B.Realisasi) as total_sisa from tblTrnTransaksiAkhirHdr as A left join tblTrnTransaksiAkhirDtl as B on A.HeaderID = B.HeaderID where A.Nofix = '$nofix' and StatusSisa ='1' and A.HeaderID ='$hdrid' GROUP BY A.Nofix,A.Tanggal");
        return $query->result();
    }

    function getDataTotalSisa($nofix, $hdrid)
    {
        $query = $this->db->query("SELECT * FROM Vw_detailTransaksiAkhir where StatusSisa = '1' and Nofix = '$nofix' and HeaderID = '$hdrid'");
        return $query->result();
    }

    function getDataTotalSembako($nofix, $periode)
    {
        $query = $this->db->query("SELECT
                                        A.Nofix,
                                        A.Tanggal,
                                        B.Quantity,
                                        B.Harga,
                                        B.Total,
                                        C.NamaItem,
                                        D.NamaSatuan,
                                        D.SingkatanSatuan,
                                        E.NamaKategori 
                                    FROM
                                        [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID
                                        LEFT JOIN tblMstItem AS C ON B.ItemID = C.ItemID
                                        LEFT JOIN tblMstSatuan AS D ON B.SatuanID = D.SatuanID
                                        LEFT JOIN tblMstKategori AS E ON B.KategoriID = E.KategoriID 
                                    WHERE
                                        A.Nofix = '$nofix' 
                                        AND PeriodeGajian = '$periode' 
                                        AND A.StatusProses = '1' 
                                        ");
        return $query->result();
    }
    // function getDataTotalSembako($nofix, $periode)
    // {
    //     $query = $this->db->query("SELECT
    //                                     A.Nofix,
    //                                     A.Tanggal,
    //                                     B.Quantity,
    //                                     B.Harga,
    //                                     B.Total,
    //                                     C.NamaItem,
    //                                     D.NamaSatuan,
    //                                     D.SingkatanSatuan,
    //                                     E.NamaKategori 
    //                                 FROM
    //                                     [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
    //                                     LEFT JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID
    //                                     LEFT JOIN tblMstItem AS C ON B.ItemID = C.ItemID
    //                                     LEFT JOIN tblMstSatuan AS D ON B.SatuanID = D.SatuanID
    //                                     LEFT JOIN tblMstKategori AS E ON B.KategoriID = E.KategoriID 
    //                                 WHERE
    //                                     A.Nofix = '$nofix' 
    //                                     AND PeriodeGajian = '$periode' 
    //                                     AND A.StatusProses = '1' UNION
    //                                 SELECT
    //                                     A.Nofix,
    //                                     A.Tanggal,
    //                                     B.Quantity,
    //                                     B.Harga,
    //                                     B.Total,
    //                                     C.NamaItem,
    //                                     D.NamaSatuan,
    //                                     D.SingkatanSatuan,
    //                                     E.NamaKategori 
    //                                 FROM
    //                                     [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdrArsip AS A
    //                                     LEFT JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtlArsip AS B ON A.HeaderID = B.HeaderID
    //                                     LEFT JOIN tblMstItem AS C ON B.ItemID = C.ItemID
    //                                     LEFT JOIN tblMstSatuan AS D ON B.SatuanID = D.SatuanID
    //                                     LEFT JOIN tblMstKategori AS E ON B.KategoriID = E.KategoriID 
    //                                 WHERE
    //                                     A.Nofix = '$nofix' 
    //                                     AND PeriodeGajian = '$periode' 
    //                                     AND A.StatusProses = '1'
    //                                     ");
    //     return $query->result();
    // }

    function getDataSembakoDetail($nofix, $hdrid)
    {
        $query = $this->db->query("SELECT  A.Nofix,A.Tanggal,B.HargaFull,B.Quantity,B.Total,B.Realisasi,B.Sisa,C.NamaItem,D.NamaSatuan,D.SingkatanSatuan,E.NamaKategori from tblTrnTransaksiAkhirHdr as A left join tblTrnTransaksiAkhirDtl as B on A.HeaderID = B.HeaderID left join tblMstItem as C on B.ItemID = C.ItemID left join tblMstSatuan as D on B.SatuanID = D.SatuanID left join tblMstKategori as E on B.KategoriID = E.KategoriID where A.Nofix = '$nofix' and Type ='Sembako' and A.HeaderID ='$hdrid' and B.StatusSisa ='0'");
        return $query->result();
    }
    public function getDataCicilanDetailNew($nofix, $periode)
    {
        $query = $this->db->query("SELECT
                                        a.*,
                                        b.NamaCicilan,
                                        c.SingkatanSatuan,
                                        d.NamaKategori 
                                    FROM
                                        vwPotonganCicilanNew AS a
                                        LEFT JOIN tblMstItemCicilan AS b ON a.CicilanID = b.CicilanID
                                        LEFT JOIN tblMstSatuan AS c ON a.SatuanID = c.SatuanID
                                        LEFT JOIN tblMstKategoriCicilan AS d ON a.KategoriCicilanID = d.KategoriCicilanID 
                                    WHERE
                                        Nofix = '$nofix' 
                                        AND terakhir >= '$periode' 
                                        AND TanggalMulai <= '$periode' 
                                        AND PeriodeDipotong IN ( 2, 3 ) 
                                        AND ISNULL( PeriodeDipotong, 0 ) > 0 
                                        AND a.KategoriCicilanID != 0
                                        ");
        return $query->result();
    }

    public function getDataCicilanDetailPer1($nofix, $periode)
    {
        $query = $this->db->query("SELECT
                                        a.*,
                                        b.NamaCicilan,
                                        c.SingkatanSatuan,
                                        d.NamaKategori 
                                    FROM
                                        vwPotonganCicilanNew AS a
                                        LEFT JOIN tblMstItemCicilan AS b ON a.CicilanID = b.CicilanID
                                        LEFT JOIN tblMstSatuan AS c ON a.SatuanID = c.SatuanID
                                        LEFT JOIN tblMstKategoriCicilan AS d ON a.KategoriCicilanID = d.KategoriCicilanID 
                                    WHERE
                                        Nofix = '$nofix' 
                                        AND terakhir >= '$periode' 
                                        AND TanggalMulai <= '$periode' 
                                        AND PeriodeDipotong IN ( 1, 3 ) 
                                        AND ISNULL( PeriodeDipotong, 0 ) > 0 
                                        AND a.KategoriCicilanID != 0
                                        ");
        return $query->result();
    }

    function getDataTotalCicilan($nofix, $periode)
    {

        $query = $this->db->query("SELECT SUM
                                        ( HargaCicilan ) AS grand 
                                    FROM
                                        vwPotonganCicilanNew 
                                    WHERE
                                        Nofix = '$nofix' 
                                        AND terakhir >= '$periode' 
                                        AND TanggalMulai <= '$periode' 
                                        AND PeriodeDipotong IN ( 2, 3 ) 
                                        AND ISNULL( PeriodeDipotong, 0 ) > 0 
                                        AND KategoriCicilanID != 0
                                    ");
        return $query->result();
    }

    function getDataTotalCicilanNew($nofix, $periode)
    {

        $query = $this->db->query(" SELECT SUM
                                        ( HargaCicilan ) AS grand 
                                    FROM
                                        vwPotonganCicilanNew 
                                    WHERE
                                        Nofix = '$nofix' 
                                        AND terakhir >= '$periode' 
                                        AND TanggalMulai <= '$periode' 
                                        AND PeriodeDipotong IN ( 1, 3 ) 
                                        AND ISNULL( PeriodeDipotong, 0 ) > 0 
                                        AND KategoriCicilanID !=0
                                        ");
        return $query->result();
    }

    function getDataCicilanDetail($nofix)
    {

        $query = $this->db->query(
            "SELECT
                A.DetailID,
                A.HeaderID,
                A.IDPemborong,
                A.Nofix,
                C.NamaCicilan,
                D.SingkatanSatuan,
                D.NamaSatuan,
                E.NamaKategori,
                A.Harga,
                A.Cicilan,
                A.HargaCicilan,
                A.Total,
                A.CreatedBy,
                A.CreatedDate,
                A.CicilanKe,
                A.TanggalMulai,
                A.TanggalPotong,
                A.Quantity,
                A.DP,
                A.NamaItem,
                A.IDSubPemborong,
                A.PeriodeDipotong,
                Tanggal,
                PeriodeGajian,
                fnGetPeriodeCicilan ( A.TanggalMulai, ISNULL( A.PeriodeDipotong, 1 ), ISNULL( A.Cicilan, 1 ) ) AS terakhir 
            FROM
                vwPotonganCicilanNew AS A
                LEFT OUTER JOIN tblMstItemCicilan AS C ON A.CicilanID = C.CicilanID
                LEFT JOIN tblMstSatuan AS D ON A.SatuanID = D.SatuanID
                LEFT JOIN tblMstKategoriCicilan AS E ON A.KategoriCicilanID = E.KategoriCicilanID 
            WHERE
                a.Nofix = '$nofix' 
                AND A.KategoriCicilanID > 0 
                AND Harga > 0 
                AND Cicilan > 0 
                AND HargaCicilan > 0 
                AND Durasi > 0 
                AND ISNULL( PeriodeDipotong, 0 ) > 0"
        );
        return $query->result();
    }

    function getDataTrnDtlTel($nofix, $hdrid, $pemborong, $sub)
    {
        $query = $this->PSGBOR->query(
            "SELECT
                A.HeaderID,
                A.Nofix,
                A.Tanggal,
                C.NamaItem,
                B.Quantity,
                B.Harga,
                C.SingkatanSatuan,
                C.NamaKategori,
                B.Total 
            FROM
            PSGBorongan.dbo.tblTrnPotonganPemborongHdr AS A
                LEFT JOIN PSGBorongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID
                LEFT JOIN ( SELECT * FROM [192.168.2.3].PSGRekrutmen.dbo.vwMstHarga WHERE IDPemborong = '$pemborong' AND IDSubPemborong = '$sub' ) AS C ON B.ItemID = C.ItemID 
            WHERE
                A.HeaderID = '$hdrid' 
                AND A.Nofix = '$nofix'"
        );
        return $query->result();
    }

    function excelByNofix($nofix, $periode)
    {
        $query = $this->db->query("SELECT
                                    A.HeaderID,
                                    A.Tanggal,
                                    A.PeriodeGajian,
                                    A.IDPemborong,
                                    A.IDSubPemborong,
                                    A.Nofix,
                                    A.StatusProses,
                                    A.CreatedBy,
                                    A.CreatedDate,
                                    B.DetailID,
                                    B.ItemID,
                                    B.SatuanID,
                                    B.KategoriID,
                                    B.HargaID,
                                    B.Harga,
                                    B.Quantity,
                                    B.Total,
                                    B.Total AS Total_s,
                                    D.FixNo,
                                    D.Nama,
                                    D.Nik,
                                    D.BagianAbbr,
                                    C.NamaSub,
                                    E.NamaItem,
                                    F.SingkatanSatuan,
                                    G.NamaKategori 
                                FROM
                                    [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                                    LEFT JOIN  [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID
                                    LEFT JOIN  [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS d ON a.Nofix = d.FixNo
                                    LEFT JOIN tblMstSubPemborong AS C ON A.IDSubPemborong = C.IDSubPemborong
                                    LEFT JOIN tblMstitem AS E ON B.ItemID = E.ItemID
                                    LEFT JOIN tblMstSatuan AS F ON B.SatuanID = F.SatuanID
                                    LEFT JOIN tblMstKategori AS G ON B.KategoriID = G.KategoriID 
                                WHERE
                                    A.Nofix= '$nofix' 
                                    AND PeriodeGajian = '$periode' 
                                    AND A.StatusProses = '1'
                                    ");
        return $query->result();
    }

    function KhususCicilan($nofix, $tglMulai, $periode)
    {
        // $month = date('m',strtotime($tglMulai));
        // $month2 = date('m',strtotime($periode));
        $query = $this->PSGBOR->query("SELECT
                                            A.DetailID,
                                            A.HeaderID,
                                            A.IDPemborong,
                                            A.Nofix,
                                            C.NamaCicilan,
                                            D.SingkatanSatuan,
                                            D.NamaSatuan,
                                            E.NamaKategori,
                                            A.Harga,
                                            A.Cicilan,
                                            A.HargaCicilan,
                                            A.Total,
                                            A.CreatedBy,
                                            A.CreatedDate,
                                            A.CicilanKe,
                                            A.TanggalMulai,
                                            A.TanggalPotong,
                                            A.Quantity,
                                            A.DP,
                                            A.NamaItem,
                                            A.IDSubPemborong,
                                            A.PeriodeDipotong,
                                            Tanggal,
                                            PeriodeGajian,
                                            psgborongan.dbo.fnGetPeriodeCicilan ( A.TanggalMulai, ISNULL( A.PeriodeDipotong, 1 ), ISNULL( A.Cicilan, 1 ) ) AS terakhir 
                                        FROM
                                            [192.168.2.3].PSGRekrutmen.dbo.vwPotonganCicilanNew AS A
                                            LEFT OUTER JOIN [192.168.2.3].PSGRekrutmen.dbo.tblMstItemCicilan AS C ON A.CicilanID = C.CicilanID
                                            LEFT JOIN [192.168.2.3].PSGRekrutmen.dbo.tblMstSatuan AS D ON A.SatuanID = D.SatuanID
                                            LEFT JOIN [192.168.2.3].PSGRekrutmen.dbo.tblMstKategoriCicilan AS E ON A.KategoriCicilanID = E.KategoriCicilanID 
                                        WHERE
                                            a.Nofix = '$nofix' 
                                            AND A.KategoriCicilanID > 0 
                                            AND Harga > 0 
                                            AND Cicilan > 0 
                                            AND HargaCicilan > 0 
                                            AND Durasi > 0 
                                            AND ISNULL( PeriodeDipotong, 0 ) > 0 
                                            AND TanggalMulai <> '1970-01-01' 
                                            AND ( TanggalMulai <= '$tglMulai' OR TanggalMulai >= '$periode' ) 
                                            AND terakhir <> TanggalMulai
                                                ");
        return $query->result();
    }

    function dataNama($nofix, $periode)
    {
        $query = $this->db->query("SELECT DISTINCT
                A.HeaderID, '0' AS flag, A.Tanggal, A.PeriodeGajian, A.IDPemborong, A.IDSubPemborong, A.Nofix, A.StatusProses, A.CreatedBy, A.CreatedDate,Type ='Sembako',
                D.Nofix,D.Nama,D.Nik,D.Bagian,D.Pemborong,C.NamaSub
                FROM RSUPBorongan2010..tblTrnPotonganPemborongHdr AS A
                left join RSUPBorongan2010..vwMasterTenagaKerja as d on a.Nofix = d.Nofix 
                LEFT JOIN tblMstSubPemborong as C on A.IDSubPemborong = C.IDSubPemborong
                WHERE A.Nofix='$nofix' and A.PeriodeGajian ='$periode' and A.StatusProses ='1' 
            UNION
                SELECT DISTINCT
                A.HeaderID, '1' AS flag, A.Tanggal, A.PeriodeGajian, A.IDPemborong, A.IDSubPemborong, A.Nofix, A.StatusProses, A.CreatedBy, A.CreatedDate, Type ='Cicilan',               
                D.Nofix,D.Nama,D.Nik,D.Bagian,D.Pemborong,C.NamaSub
                FROM RSUPBorongan2010..tblTrnPotonganCicilanHdr AS A
                left join RSUPBorongan2010..vwMasterTenagaKerja as d on a.Nofix = d.Nofix 
                LEFT JOIN tblMstSubPemborong as C on A.IDSubPemborong = C.IDSubPemborong
                WHERE A.Nofix='$nofix' and A.PeriodeGajian ='$periode' and A.StatusProses ='1'");
        return $query->result();
    }

    function getDataMonitoringBySub($pbr, $sub, $periode)
    {
        $query = $this->db->query("SELECT
                                        PeriodeGajian,
                                        A.IDPemborong,
                                        A.IDSubPemborong,
                                        A.Nofix,
                                        B.Nama,
                                        b.Nik,
                                        b.BagianAbbr,
                                        C.NamaSub,
                                        SUM ( CASE WHEN flag = 0 THEN Total END ) AS Pot_Sembako,
                                        SUM ( CASE WHEN flag = 1 THEN Total END ) AS Cicilan 
                                    FROM
                                        (
                                        SELECT
                                            A.HeaderID,
                                            '0' AS flag,
                                            A.Tanggal,
                                            A.PeriodeGajian,
                                            A.IDPemborong,
                                            A.IDSubPemborong,
                                            A.Nofix,
                                            A.StatusProses,
                                            A.CreatedBy,
                                            A.CreatedDate,
                                            B.DetailID,
                                            B.ItemID,
                                            B.SatuanID,
                                            B.KategoriID,
                                            B.HargaID,
                                            B.Harga,
                                            B.Quantity,
                                            B.Total,
                                            NULL AS CicilanKe,
                                            NULL AS TanggalMulai,
                                            NULL AS DP,
                                            NULL AS PeriodeDipotong 
                                        FROM
                                            [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                                            INNER JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID UNION
                                        SELECT
                                            A.HeaderID,
                                            '1' AS flag,
                                            A.Tanggal,
                                            A.PeriodeGajian,
                                            A.IDPemborong,
                                            A.IDSubPemborong,
                                            A.Nofix,
                                            A.StatusProses,
                                            A.CreatedBy,
                                            A.CreatedDate,
                                            B.DetailID,
                                            B.CicilanID AS ItemID,
                                            B.SatuanID,
                                            B.KategoriCicilanID AS KategoriID,
                                            B.Cicilan AS HargaID,
                                            B.Harga,
                                            B.Quantity,
                                            B.HargaCicilan AS Total,
                                            B.CicilanKe,
                                            B.TanggalMulai,
                                            B.DP,
                                            B.PeriodeDipotong 
                                        FROM
                                            [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr AS A
                                            INNER JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanDtl AS B ON A.HeaderID = B.HeaderID 
                                        ) AS A
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS b ON a.Nofix = b.FixNo
                                        LEFT JOIN tblMstSubPemborong AS C ON A.IDSubPemborong = C.IDSubPemborong 
                                    WHERE
                                        A.IDPemborong = '$pbr' 
                                        AND A.IDSubPemborong = '$sub' 
                                        AND PeriodeGajian = '$periode' 
                                        AND A.StatusProses = '1' 
                                    GROUP BY
                                        PeriodeGajian,
                                        A.IDPemborong,
                                        A.IDSubPemborong,
                                        A.Nofix,
                                        B.Nama,
                                        b.Nik,
                                        b.BagianAbbr,
                                        C.NamaSub
                                                ");
        return $query->result();
    }

    function getDataTrnTanggal($nofix, $hdrid)
    {
        $query = $this->db->query("SELECT distinct A.HeaderID,Nofix,Tanggal,SUM(Total) AS Total FROM tblTrnTransaksiAkhirHdr as A left join tblTrnTransaksiAkhirDtl as b on A.HeaderID = b.HeaderID where Nofix = '$nofix' and A.HeaderID = '$hdrid' and StatusKomplit = '1' GROUP BY A.HeaderID,Nofix,Tanggal");
        return $query->result();
    }

    function getDataTrnTotal($nofix, $hdrid)
    {
        $query = $this->db->query("SELECT distinct A.Nofix,SUM(B.Total) AS GrandTotal from tblTrnTransaksiAkhirHdr as A left join tblTrnTransaksiAkhirDtl as B on A.HeaderID = B.HeaderId where Nofix = '$nofix' and A.HeaderID ='$hdrid' and StatusKomplit = '1' group by Nofix ");
        return $query->result();
    }

    function getDataTrnGTotalTel($nofix, $tanggal)
    {
        $query = $this->db->query("SELECT DISTINCT
                                        A.Nofix,
                                        SUM ( B.Total ) AS GrandTotal 
                                    FROM
                                        [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongHdr AS A
                                        LEFT JOIN [192.168.3.32].PSGBorongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID 
                                    WHERE
                                        A.Nofix = '$nofix' 
                                        AND A.Tanggal = '$tanggal' 
                                        AND A.StatusProses = '1' 
                                    GROUP BY
                                        A.Nofix");
        return $query->result();
    }

    // END :: MONITORING POTONGAN PEMBORONG

    #History harga perpemborong

    function getDataPerPemborong($IDPemborong)
    {
        $query = $this->db->query("SELECT distinct D.NamaItem,A.*,B.*,C.*,E.* FROM tblHistoryMstHarga as A left join tblMstHeaderHarga as B on A.HeaderHargaID=B.HeaderHargaID left join tblMstDetailHarga as C on A.DetailHargaID=C.DetailHargaID left join tblMstItem as D on A.ItemID=D.ItemID left join tblMstSatuan as E on A.SatuanID=E.SatuanID left join tblMstKategori as F on A.KategoriID = F.KategoriID where A.IDPemborong = '$IDPemborong' and D.ItemID is not NULL");
        return $query->result();
    }

    //BEGIN :: YAWALIYUL
    function get_search_item($item)
    {
        $query = $this->db->query(
            "SELECT
                A.*,
                B.*,
                C.*,
                tbD.itemidharga 
            FROM
                tblMstItem AS A
                LEFT JOIN tblMstSatuan AS B ON A.SatuanID = B.SatuanID
                LEFT JOIN tblMstKategori AS C ON A.KategoriID = C.KategoriID
                LEFT JOIN (
                SELECT DISTINCT
                    ( a.ItemID ),
                    ( b.ItemID ) itemidharga 
                FROM
                    tblMstItem a
                    LEFT JOIN tblMstDetailHarga b ON a.ItemID= b.ItemID 
                ) AS tbD ON A.ItemID= tbD.ItemID 
            WHERE
                A.NamaItem LIKE '%$item%'"
        );
        return $query->result();
    }
    //END :: YAWALIYUL

    function getTK_byPemborong($pbr)
    {
        $query = $this->db->query("SELECT * from  RSUPBorongan2010..vwMasterTenagaKerja where TanggalKeluar is null and IDPemborong = '$pbr' and IDSubPemborong ='0'");
        return $query->result();
    }

    function getMstSubPemborong()
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT
                                        * 
                                    FROM
                                        tblUtlAksesSubPemborong AS A
                                        JOIN tblMstsubPemborong AS B ON A.IDSubPemborong = B.IDSubPemborong 
                                    WHERE
                                        A.GroupID = '$groupid'
                                    ");
        return $query->result();
    }
    function save_tenagaKerja($id, $data)
    {
        $this->db->where("Nofix IN ('" . $id . "')");
        $this->db->update('RSUPBorongan2010.dbo.tblMstTenagaKerja', $data);
    }

    function getSubPemborong()
    {
        $query = $this->db->query("SELECT * FROM tblMstsubPemborong ");
        return $query->result();
    }

    function getMstSub($id)
    {
        $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT A.IDSubPemborong,B.Perusahaan,B.IDPemborong FROM tblUtlAksesSubPemborong as A LEFT JOIN tblMstsubPemborong as B  on a.IDSubPemborong = B.IDSubPemborong where B.IDPemborong = '$id' AND a.GroupID = '$groupid'");
        return $query->result();
    }
    function getMstItemId($id)
    {
        // $groupid = $this->session->userdata('groupuser');
        $query = $this->db->query("SELECT
                                        ItemID,
                                        KodeItem,
                                        NamaItem 
                                    FROM
                                        tblMstItem 
                                    WHERE
                                        ItemID = '$id'
                                        ");
        return $query->result();
    }

    function getMstSubdaripemborong($id)
    {
        $query = $this->db->query("SELECT distinct A.IDSubPemborong,A.NamaSub,B.IDPemborong FROM tblMstsubPemborong as A JOIN tblUtlAksesSubPemborong as B  on a.IDSubPemborong = B.IDSubPemborong 
            where A.IDPemborong = '$id' order by NamaSub ASC");
        return $query->result();
    }

    function getTK_bySubPemborong($pbr, $sub)
    {
        $query = $this->db->query(
            "SELECT
                        idpemborong idpemborong2,
                        idsubpemborong idsubpemborong2,
                    CASE
                    WHEN IDSubPemborong = '6' THEN
                            '2' 
                    WHEN IDSubPemborong = '7' THEN
                            '13' ELSE IDPemborong 
                    END AS IDPemborongNew,
        	    A.*,
            	B.NamaSub as NamaToko
            FROM
            	[192.168.3.32].psgborongan.dbo.vwmsttenagakerja AS A
            	LEFT JOIN tblMstSubPemborong AS B ON A.IDToko= B.IDSubPemborong 
            WHERE
            	TanggalKeluar IS NULL 
            AND A.IDPemborongNew = '" . $pbr . "' 
            AND A.IDToko = '" . $sub . "'"
        );
        return $query->result();
    }

    function monitorHargaPemborong($tanggal)
    {
        $query = $this->db->query("SELECT  A.IDSubPemborong,B.Pemborong,B.NamaSub,  COUNT(DetailHargaID) as Jumlah from tblmstdetailharga as A left join VW_subpemborong as B on A.IDSubPemborong = B.IDSubPemborong where A.IDSubPemborong is not null and A.IDSubPemborong != '0' and harga>0 and CONVERT(DATE,CreatedDate)>='2021-10-23' and CONVERT(DATE,CreatedDate)<='$tanggal' group by A.IDSubPemborong,B.Pemborong,B.NamaSub ORDER BY B.Pemborong ASC");
        return $query->result();
    }

    function monitorHarga()
    {
        $query = $this->db->query("SELECT count(DetailHargaID)as Jumlah,A.IDSubPemborong,B.Pemborong,B.NamaSub from tblMstDetailHarga as A left join (select distinct B.IDSubPemborong,B.Pemborong,B.NamaSub from tblMstDetailHarga as A join VW_subpemborong as B on A.IDSubPemborong = B.IDSubPemborong where Harga != 0 ) as B on A.IDSubPemborong = B.IDSubPemborong where  Harga > 0 AND A.IDSubPemborong != '0' group by A.IDSubPemborong,B.Pemborong,B.NamaSub ORDER BY B.Pemborong ASC");
        return $query->result();
    }

    // MONITORING HARGA PERSUB UNTUK PBR INTI

    function _getSubPemborong($pbr)
    {
        $query = $this->db->query("SELECT * FROM tblMstSubPemborong WHERE IDPemborong= '" . $pbr . "' ORDER BY NamaSub ASC");
        return $query->result();
    }

    function _getListMntHarga($pbr, $sub)
    {
        $query = $this->db->query("SELECT A.*,D.NamaItem,B.NamaSatuan,C.NamaKategori FROM tblMstDetailHarga as A left join tblMstSatuan as B ON A.SatuanID = B.SatuanID 
                left join tblMstKategori as C ON A.KategoriID = C.KategoriID left join tblMstItem as D ON A.ItemID = D.ItemID
                where A.IDPemborong = '" . $pbr . "' and A.IDSubPemborong = '" . $sub . "'");
        return $query->result();
    }

    function cek_transaksiDtl($nofix, $kategori, $satuan, $item_id)
    {
        $query = $this->db->query("SELECT * FROM [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanDtl as A left join [192.168.3.32].psgborongan.dbo.tblTrnPotonganCicilanHdr as B ON A.HeaderID = B.HeaderID where A.Nofix = '" . $nofix . "' and A.CicilanID = '" . $item_id . "' and A.SatuanID = '" . $satuan . "' and A.KategoriCicilanID = '" . $kategori . "'");
        return $query->result();
    }


    // BEGIN :: KIRIM KE TELEGRAM
    function getTanggalMulai($nofix)
    {
        $query = $this->PSGBOR->query("SELECT Distinct Nofix,TanggalMulai FROM PSGBorongan.dbo.tblTrnPotonganCicilanDtl where Nofix = '$nofix' ORDER BY TanggalMulai ASC");
        return $query->result();
    }

    function getDataGrandTotalSembako($nofix, $hdrid)
    {
        $query = $this->db->query(
            "SELECT DISTINCT
                A.Nofix,
                SUM ( B.Total ) AS GrandTotal 
            FROM
                [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                LEFT JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID 
            WHERE
                A.Nofix = '$nofix' 
                AND A.HeaderID = '$hdrid' 
                AND A.StatusProses = '1' 
            GROUP BY
                A.Nofix"
        );
        return $query->result();
    }

    function getTotalPeriodeIni($nofix, $periode)
    {
        $query = $this->db->query(
            "SELECT
                A.Nofix,
                A.IDPemborong,
                A.IDSubPemborong,
                A.PeriodeGajian,
                SUM ( B.Total ) AS Pot_Sembako,
                A.StatusProses 
            FROM
                [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongHdr AS A
                INNER JOIN [192.168.3.32].psgborongan.dbo.tblTrnPotonganPemborongDtl AS B ON A.HeaderID = B.HeaderID 
            WHERE
                a.Nofix = '$nofix' 
                AND a.PeriodeGajian = '$periode' 
                AND A.StatusProses = '1' 
            GROUP BY
                A.Nofix,
                A.IDPemborong,
                A.IDSubPemborong,
                A.PeriodeGajian,
                A.StatusProses"
        );
        return $query->result();
    }

    function getPotCicilanPeriodeIni($nofix, $tglMulai, $periode)
    {
        $month = date('m', strtotime($tglMulai));
        $month2 = date('m', strtotime($periode));

        $query = $this->db->query(
            "SELECT
                Nofix,
                SUM ( HargaCicilan ) AS Pot_Cicilan 
            FROM
                vwPotonganCicilanNew 
            WHERE
                KategoriCicilanID > 0 
                AND Harga > 0 
                AND Cicilan > 0 
                AND HargaCicilan > 0 
                AND ISNULL( PeriodeDipotong, 0 ) > 0 
                AND ( TanggalMulai <= '$tglMulai' OR terakhir >= '$periode' ) 
                AND ( MONTH ( TanggalMulai ) = '$month' OR MONTH ( TanggalMulai ) = '$month2' ) 
                AND Nofix = '$nofix' 
            GROUP BY
                Nofix"
        );
        return $query->result();
    }

    // END :: KIRIM KE TELEGRAM

    // Send Telegram Transaksi Cicilan

    function get_detail_cicilan($nofix, $hdrid)
    {
        $query = $this->db->query("SELECT * FROM vwTrnCicilan where Nofix = '$nofix' and  HeaderID = '$hdrid'");
        return $query->result();
    }

    // BEGIN :: MODUL CATATAN HARGA BY PEMBORONG INTI

    function update_catatan($dtlHrga, $data)
    {
        $this->db->update("tblMstDetailHarga", $data);
        $this->db->where("DetailHargaID", $dtlHrga);
    }

    function getCatatanHarga($id_harga)
    {
        $query = $this->db->query("SELECT DetailHargaID,Catatan FROM tblMstDetailHarga where DetailHargaID = '$id_harga'");
        return $query->result();
    }

    // BEGIN :: MONITORING CICILAN

    function getMonitoringCicilan($pbr, $sub)
    {
        $query = $this->db->query("SELECT DISTINCT
                                        A.Nofix,
                                        A.Tanggal,
                                        c.NamaCicilan,
                                        b.DetailIDCicilan,
                                        a.Quantity,
                                        a.Harga,
                                        a.DP,
                                        a.HargaCicilan,
                                        a.Cicilan,
                                        ( A.Cicilan - ( SUM ( b.JmlCicilanLunas ) ) ) AS Durasi,
                                        SUM (isnull(b.JmlCicilanLunas,0)) AS JmlCicilanLunas,
                                        a.PeriodeDipotong,
                                        SUM ( b.dipotong ) AS dipotong,
                                        a.CreatedBy,
                                        A.CreatedDate,
                                        A.UpdatedBy,
                                        A.UpdatedDate,
                                        A.InActiveBy,
                                        A.InActiveDate,
                                        A.InActive 
                                    FROM
                                        vw_PotonganCicilanNew2 AS A 
                                            LEFT JOIN (
                                        SELECT
                                            FixNo,
                                            DetailIDCicilan,
                                            COUNT ( DetailIDCicilan ) AS JmlCicilanLunas,
                                            Periode,
                                            SUM ( DiPotong ) AS dipotong
                                        FROM
                                            [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi
                                        GROUP BY
                                            FixNo,
                                            DetailIDCicilan,
                                            Periode
                                        ) AS B ON a.Nofix = b.FixNo
                                        AND a.DetailID = b.DetailIDCicilan
                                        LEFT JOIN tblMstItemCicilan AS c ON a.CicilanID = c.CicilanID
                                        LEFT JOIN tblMstKategoriCicilan AS d ON a.KategoriCicilanID = d.KategoriCicilanID
                                        LEFT JOIN tblMstSatuan AS e ON a.SatuanID = e.SatuanID
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS f ON a.Nofix = f.FixNo 
                                    WHERE
                                        a.IDPemborong = '$pbr' 
                                        AND a.IDSubPemborong = '$sub' 
                                            AND a.Cicilan > isnull(b.JmlCicilanLunas,0)
                                        
                                    GROUP BY
                                        A.Nofix,
                                        A.Tanggal,
                                        c.NamaCicilan,
                                        b.DetailIDCicilan,
                                        a.Quantity,
                                        a.Harga,
                                        a.DP,
                                        a.HargaCicilan,
                                        a.Cicilan,
                                        a.Durasi,
                                        b.JmlCicilanLunas,
                                        a.PeriodeDipotong,
                                        a.CreatedBy,
                                        A.CreatedDate,
                                        A.UpdatedBy,
                                        A.UpdatedDate,
                                        A.InActiveBy,
                                        A.InActiveDate,
                                        A.InActive
                                            ");
        return $query->result();
    }
    // function getMonitoringCicilan($pbr, $sub)
    // {
    //     $query = $this->db->query("SELECT DISTINCT
    //                                     A.Nofix,
    //                                     A.Tanggal,
    //                                     c.NamaCicilan,
    //                                     b.DetailIDCicilan,
    //                                     a.Quantity,
    //                                     a.Harga,
    //                                     a.DP,
    //                                     a.HargaCicilan,
    //                                     a.Cicilan,
    //                                     ( A.Cicilan - ( SUM ( b.JmlCicilanLunas ) ) ) AS Durasi,
    //                                     SUM ( b.JmlCicilanLunas ) AS JmlCicilanLunas,
    //                                     a.PeriodeDipotong,
    //                                     SUM ( b.dipotong ) AS dipotong,
    //                                     a.CreatedBy,
    //                                     A.CreatedDate,
    //                                     A.UpdatedBy,
    //                                     A.UpdatedDate,
    //                                     A.InActiveBy,
    //                                     A.InActiveDate,
    //                                     A.InActive 
    //                                 FROM
    //                                     vw_PotonganCicilanNew2 AS A
    //                                     LEFT JOIN (
    //                                     SELECT
    //                                         FixNo,
    //                                         DetailIDCicilan,
    //                                         COUNT ( DetailIDCicilan ) AS JmlCicilanLunas,
    //                                         Periode,
    //                                         SUM ( DiPotong ) AS dipotong 
    //                                     FROM
    //                                         [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi 
    //                                     GROUP BY
    //                                         FixNo,
    //                                         DetailIDCicilan,
    //                                         Periode 
    //                                     ) AS B ON a.Nofix = b.FixNo 
    //                                     AND a.DetailID = b.DetailIDCicilan
    //                                     LEFT JOIN tblMstItemCicilan AS c ON a.CicilanID = c.CicilanID
    //                                     LEFT JOIN tblMstKategoriCicilan AS d ON a.KategoriCicilanID = d.KategoriCicilanID
    //                                     LEFT JOIN tblMstSatuan AS e ON a.SatuanID = e.SatuanID
    //                                     LEFT JOIN  [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS f ON a.Nofix = f.FixNo 
    //                                 WHERE
    //                                     a.IDPemborong = '$pbr' 
    //                                     AND a.IDSubPemborong = '$sub' 
    //                                     AND a.Cicilan > b.JmlCicilanLunas 
    //                                 GROUP BY
    //                                     A.Nofix,
    //                                     A.Tanggal,
    //                                     c.NamaCicilan,
    //                                     b.DetailIDCicilan,
    //                                     a.Quantity,
    //                                     a.Harga,
    //                                     a.DP,
    //                                     a.HargaCicilan,
    //                                     a.Cicilan,
    //                                     a.Durasi,
    //                                     b.JmlCicilanLunas,
    //                                     a.PeriodeDipotong,
    //                                     a.CreatedBy,
    //                                     A.CreatedDate,
    //                                     A.UpdatedBy,
    //                                     A.UpdatedDate,
    //                                     A.InActiveBy,
    //                                     A.InActiveDate,
    //                                     A.InActive
    //                                         ");
    //     return $query->result();
    // }

    function getMonitoringCicilanNew($sub)
    {
        $query = $this->db->query("SELECT DISTINCT
                                        A.Nofix,
                                        A.Tanggal,
                                        c.NamaCicilan,
                                        b.DetailIDCicilan,
                                        a.Quantity,
                                        a.Harga,
                                        a.DP,
                                        a.HargaCicilan,
                                        a.Cicilan,
                                        a.Durasi,
                                        SUM (isnull (b.JmlCicilanLunas,0) ) AS JmlCicilanLunas,
                                        a.PeriodeDipotong, 
                                            SUM ( b.dipotong ) AS dipotong
                                        
                                    FROM
                                        vwPotonganCicilanNew AS A 
                                            LEFT JOIN (
                                        SELECT
                                            FixNo,
                                            DetailIDCicilan,
                                            COUNT ( DetailIDCicilan ) AS JmlCicilanLunas,
                                            Periode,
                                            SUM ( DiPotong ) AS dipotong
                                        FROM
                                            [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi
                                        WHERE
                                            DiPotong != 0
                                        GROUP BY
                                            FixNo,
                                            DetailIDCicilan,
                                            Periode
                                        ) AS B ON a.Nofix = b.FixNo
                                        AND a.DetailID = b.DetailIDCicilan
                                        LEFT JOIN tblMstItemCicilan AS c ON a.CicilanID = c.CicilanID
                                        LEFT JOIN tblMstKategoriCicilan AS d ON a.KategoriCicilanID = d.KategoriCicilanID
                                        LEFT JOIN tblMstSatuan AS e ON a.SatuanID = e.SatuanID
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS f ON a.Nofix = f.FixNo 
                                    WHERE
                                        a.IDSubPemborong = '$sub' 
                                            AND a.Cicilan > isnull (b.JmlCicilanLunas,0)
                                        
                                    GROUP BY
                                        A.Nofix,
                                        A.Tanggal,
                                        c.NamaCicilan,
                                        b.DetailIDCicilan,
                                        a.Quantity,
                                        a.Harga,
                                        a.DP,
                                        a.HargaCicilan,
                                        a.Cicilan,
                                        a.Durasi,
                                        b.JmlCicilanLunas,
                                        a.PeriodeDipotong
                                             ");
        return $query->result();
    }

    function getMonitoringCicilanByNofix($nofix)
    {
        $query = $this->db->query("SELECT DISTINCT
                                        A.Nofix,
                                        A.Tanggal,
                                        c.NamaCicilan,
                                        b.DetailIDCicilan,
                                        a.Quantity,
                                        a.Harga,
                                        a.DP,
                                        a.HargaCicilan,
                                        a.Cicilan,
                                        a.Durasi,
                                        SUM ( ISNULL(b.JmlCicilanLunas, 0) ) AS JmlCicilanLunas,
                                        a.PeriodeDipotong,
                                            SUM ( b.dipotong ) AS dipotong
                                        
                                    FROM
                                        vwPotonganCicilanNew AS A 
                                            LEFT JOIN (
                                        SELECT
                                            FixNo,
                                            DetailIDCicilan,
                                            COUNT ( DetailIDCicilan ) AS JmlCicilanLunas,
                                            Periode,
                                            SUM ( DiPotong ) AS dipotong
                                        FROM
                                            [192.168.3.32].psgborongan.dbo.tblTrnPotonganBONPemborongCicilanKalkulasi
                                        WHERE
                                            DiPotong != 0
                                        GROUP BY
                                            FixNo,
                                            DetailIDCicilan,
                                            Periode
                                        ) AS B ON a.Nofix = b.FixNo
                                        AND a.DetailID = b.DetailIDCicilan
                                        LEFT JOIN tblMstItemCicilan AS c ON a.CicilanID = c.CicilanID
                                        LEFT JOIN tblMstKategoriCicilan AS d ON a.KategoriCicilanID = d.KategoriCicilanID
                                        LEFT JOIN tblMstSatuan AS e ON a.SatuanID = e.SatuanID
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS f ON a.Nofix = f.FixNo 
                                    WHERE
                                        a.Nofix= '$nofix' 
                                            AND a.Cicilan > ISNULL(b.JmlCicilanLunas, 0)
                                        
                                    GROUP BY
                                        A.Nofix,
                                        A.Tanggal,
                                        c.NamaCicilan,
                                        b.DetailIDCicilan,
                                        a.Quantity,
                                        a.Harga,
                                        a.DP,
                                        a.HargaCicilan,
                                        a.Cicilan,
                                        a.Durasi,
                                        b.JmlCicilanLunas,
                                        a.PeriodeDipotong
                                        ");
        return $query->result();
    }

    function getMonitoringCicilanhdr($pbr, $sub)
    {
        $query = $this->db->query("SELECT DISTINCT
                                        a.Nofix,
                                        b.Nama,
                                        b.Nik,
                                        b.BagianAbbr,
                                        b.IDToko,
                                        b.IDPemborong 
                                    FROM
                                        vwPotonganCicilanNew AS a
                                        LEFT JOIN  [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS b ON a.Nofix = b.FixNo 
                                    WHERE
                                        b.IDPemborong = '$pbr' 
                                        AND b.IDToko = '$sub'
                                        ");
        return $query->result();
    }

    function getMonitoringCicilanhdrNew($sub)
    {
        $query = $this->db->query("SELECT DISTINCT
                                        a.Nofix,
                                        b.Nama,
                                        b.Nik,
                                        b.BagianAbbr,
                                        b.IDToko,
                                        b.IDPemborong 
                                    FROM
                                        vwPotonganCicilanNew AS a
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS b ON a.Nofix = b.FixNo 
                                    WHERE
                                    b.IDToko = '$sub'
            ");
        return $query->result();
    }

    function getMonitoringCicilanhdrByNofix($nofix)
    {
        $query = $this->db->query("SELECT DISTINCT
                                        a.Nofix,
                                        b.Nama,
                                        b.Nik,
                                        b.BagianAbbr,
                                        b.IDToko,
                                        b.IDPemborong,
                                        b.Pemborong,
                                        e.NamaSub,
                                        e.Perusahaan 
                                    FROM
                                        vwPotonganCicilanNew AS a
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS b ON a.Nofix = b.FixNo
                                        LEFT JOIN VW_subpemborong AS e ON b.IDToko = e.IDSubPemborong 
                                    WHERE
                                        a.Nofix = '$nofix'
                                 ");
        return $query->row();
    }

    function getMonitoringCicilanRow($pbr, $sub)
    {
        $query = $this->db->query("SELECT DISTINCT
                                        a.Nofix,
                                        b.Nama,
                                        b.Nik,
                                        b.BagianAbbr,
                                        b.IDToko,
                                        b.IDPemborong 
                                    FROM
                                        vwPotonganCicilanNew AS a
                                        LEFT JOIN [192.168.3.32].psgborongan.dbo.vwMstTenagaKerja AS b ON a.Nofix = b.FixNo 
                                    WHERE
                                        b.IDPemborong = '$pbr' 
                                        AND b.IDToko = '$sub'
            ");
        return $query->row();
    }

    function getListDetailCicilanLunas($dtl)
    {
        $query = $this->PSGBOR->query("SELECT * FROM tblTrnPotonganBONPemborongCicilanKalkulasi  WHERE DetailIDCicilan = '$dtl'");
        return $query->result();
    }
    // END :: MONITORING CICILAN

    // START :: PEBANDINGAN HARGA

    function getItemBandingHarga($pbr, $kategori, $item)
    {
        if ($pbr == 0 && $kategori != 0 && $item == 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.KategoriID = '$kategori' ORDER BY Harga ASC");
            return $query->result();
        } elseif ($pbr != 0 && $kategori != 0 && $item == 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.KategoriID = '$kategori' and a.IDPemborong = '$pbr' ORDER BY Harga ASC");
            return $query->result();
        } elseif ($pbr == 0 && $kategori == 0 && $item != 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.ItemID = '$item' ORDER BY Harga ASC");
            return $query->result();
        } elseif ($pbr == 0 && $kategori != 0 && $item != 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.ItemID = '$item' and KategoriID ='$kategori' ORDER BY Harga ASC");
            return $query->result();
        } elseif ($pbr != 0 && $kategori == 0 && $item == 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.IDPemborong = '$pbr' ORDER BY Harga ASC");
            return $query->result();
        } elseif ($pbr != 0 && $kategori != 0 && $item != 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.IDPemborong = '$pbr' and KategoriID ='$kategori' and ItemID ='$item' ORDER BY Harga ASC");
            return $query->result();
        }
    }

    function GetPemborongNew()
    {
        $groupid = $this->session->userdata('groupuser');

        $query = $this->db->query("SELECT A.IDPemborong,B.Perusahaan,B.IDPerusahaan,B.Pemborong,B.IDPemborong FROM tblUtlAksesSubPemborong as A left join VW_subpemborong as B ON A.IDSubPemborong = B.IDSubPemborong where A.GroupID = '$groupid' and B.IDPemborong not in (15) GROUP BY A.IDPemborong,B.Perusahaan,B.IDPerusahaan,B.Pemborong,B.IDPemborong");
        return $query->result();
    }
    function GetPerbandinganHarga($pbr, $kategori, $item)
    {
        if ($pbr == 0 && $kategori != 0 && $item == 0) {
            $query = $this->db->query("SELECT distinct NamaItem,ItemID,SingkatanSatuan,NamaKategori,KodeBarkode,KodeItem FROM vwMstHarga 
                where KategoriID='$kategori'");
            return $query->result();
        } elseif ($pbr != 0 && $kategori != 0 && $item == 0) {
            $query = $this->db->query("SELECT distinct NamaItem,ItemID,SingkatanSatuan,NamaKategori,KodeBarkode,KodeItem FROM vwMstHarga 
                where KategoriID = '$kategori' and IDPemborong ='$pbr'");
            return $query->result();
        } elseif ($pbr == 0 && $kategori == 0 && $item != 0) {
            $query = $this->db->query("SELECT distinct NamaItem,ItemID,SingkatanSatuan,NamaKategori,KodeBarkode,KodeItem FROM vwMstHarga 
                where ItemID='$item'");
            return $query->result();
        } elseif ($pbr == 0 && $kategori != 0 && $item != 0) {
            $query = $this->db->query("SELECT distinct NamaItem,ItemID,SingkatanSatuan,NamaKategori,KodeBarkode,KodeItem FROM vwMstHarga 
                where ItemID='$item' and KategoriID = '$kategori'");
            return $query->result();
        } elseif ($pbr != 0 && $kategori == 0 && $item == 0) {
            $query = $this->db->query("SELECT distinct NamaItem,ItemID,SingkatanSatuan,NamaKategori,KodeBarkode,KodeItem FROM vwMstHarga 
                where IDPemborong='$pbr'");
            return $query->result();
        } elseif ($pbr != 0 && $kategori != 0 && $item != 0) {
            $query = $this->db->query("SELECT distinct NamaItem,ItemID,SingkatanSatuan,NamaKategori,KodeBarkode,KodeItem FROM vwMstHarga 
                where IDPemborong='$pbr' and KategoriID ='$kategori' and ItemID ='$item'");
            return $query->result();
        }
    }

    function GetPerbandinganHargaRow($pbr, $kategori, $item)
    {
        if ($pbr == 0 && $kategori != 0 && $item == 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.KategoriID = '$kategori' ORDER BY Harga ASC");
            return $query->result();
        } elseif ($pbr != 0 && $kategori != 0 && $item == 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.KategoriID = '$kategori' and a.IDPemborong = '$pbr' ORDER BY Harga ASC");
            return $query->result();
        } elseif ($pbr == 0 && $kategori == 0 && $item != 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.ItemID = '$item' ORDER BY Harga ASC");
            return $query->result();
        } elseif ($pbr == 0 && $kategori != 0 && $item != 0) {
            $query = $this->db->query("SELECT ItemID,NamaSub,Perusahaan,Harga,A.IDPemborong,A.KategoriID FROM vwMstHarga as A left join [192.168.3.32].psgborongan.dbo.tblMstPemborong as B ON A.IDPemborong = B.IDPemborong left join tblMstSubPemborong as C ON A.IDSubPemborong = C.IDSubPemborong
                 WHERE A.ItemID = '$item' and KategoriID ='$kategori' ORDER BY Harga ASC");
            return $query->result();
        }
    }

    function GetKodeItemResult()
    {
        $query = $this->db->query("SELECT * FROM tblMstItem");
        return $query->result();
    }

    function GetItemPerKategori($kategori)
    {
        $query = $this->db->query("SELECT DISTINCT NamaItem,ItemID FROM vwMstHarga where KategoriID = '$kategori'");
        return $query->result();
    }

    //END PERBANDINGAN HARGA

    // BEGIN :: PRINT SLIP BELANJA SEMBAKO

    function printSlipBelanjaSembakoHdr($hdrid)
    {
        $query = $this->db->query("SELECT * FROM vwTrnPotonganBonHdr where HeaderID = '$hdrid'");
        return $query->result();
    }
    function printSlipBelanjaSembakoDtl($hdrid)
    {
        $query = $this->db->query("SELECT * FROM vwTrnPotonganBonDtl where HeaderID = '$hdrid'");
        return $query->result();
    }
    // END :: PRINT SLIP BELANJA SEMBAKO

    function AmbilHdrTerbaru()
    {
        $query = $this->db->query("SELECT TOP 1 HeaderID FROM vwTrnPotonganBonHdr ORDER BY HeaderID DESC");
        return $query->result();
    }

    // BEGIN SISA PERIODE SEBELUMNYA 
    function getSisaCicilan($nofix, $periode)
    {
        $query = $this->PSGBOR->query("SELECT  PeriodeAkanDipotong AS PeriodeGajian, FixNo, Sisa
                           FROM  vwTrnPotonganBONPemborongSisaCicilanSum
                           where PeriodeAkanDipotong = '$periode' and FixNo = '$nofix'");
        return $query->result();
    }
    function getSisaSembako($nofix, $periode)
    {
        $query = $this->PSGBOR->query("SELECT PeriodePotongan AS PeriodeGajian, FixNo, SisaBon AS TotalPotongan
                           FROM  vwTrnPotonganBONPemborongSisaBonSum
                           where FixNo = '$nofix' and PeriodePotongan = '$periode'");
        return $query->result();
    }

    function getSisaCicilanBaru($nofix, $periode)
    {
        $query = $this->PSGBOR->query("SELECT  PeriodeAkanDipotong AS PeriodeGajian, FixNo, Sisa
                           FROM  vwTrnPotonganBONPemborongSisaCicilanSum
                           where PeriodeAkanDipotong = '$periode' and FixNo = '$nofix'");
        return $query->result();
    }

    function getSisaSembakoBaru($nofix, $periode)
    {
        $query = $this->PSGBOR->query("SELECT FixNo,SUM(sisa_sebelumnya) as SisaPotonganTKBaru FROM [192.168.2.3].PSGRekrutmen.dbo.vwTrnSisaPeriodeSebelumnya 
                                where PeriodeAkanDatang between PeriodeAwal and '$periode' and FixNo = '$nofix' and PeriodeGajian >= '2023-01-16' GROUP BY FixNo ");
        return $query->result();
    }

    function getSisaSembakoBaruSebelumnya($nofix, $periode)
    {
        $query = $this->db->query("SELECT FixNo,SUM(sisa_TKBaru) as SisaPotonganTKBaru FROM vwSisaPeriodeSebelumnyaSembako 
                                where PeriodeAkanDatang between PeriodeAwal and '$periode' and FixNo = '$nofix' GROUP BY FixNo");
        return $query->result();
    }

    // END


}
