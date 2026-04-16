  <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_updatereg extends CI_Model {

    function __construct() {
        parent:: __construct();
    }

    function getSuku(){
        $query = $this->db->get('tblMstSuku');
        return $query->result();
    }
    
    function getAgama(){
        $query = $this->db->get('tblMstAgama');
        return $query->result();
    }
    
    function getStatusKawin(){
        $query = $this->db->get('tblMstStatusKawin');
        return $query->result();
    }
    
    function getPendidikan(){
        $query = $this->db->get('tblMstPendidikan');
        return $query->result();
    }
    
    function getJurusan(){
        $query = $this->db->get('tblMstJurusan');
        return $query->result();
    }
    
    function getJabatan(){
        $query = $this->db->get('tblMstJabatan');
        return $query->result();
    }
     function get_mstProvinsi(){
         return $this->db->query("select ProvinsiID, ProvinsiName FROM RSUPPayroll.dbo.tblMstProvinsi")->result();
    }
    function get_KabupatenKota(){
         return $this->db->query("select Kabupaten_KotaID, ProvinsiID, Kabupaten_KotaName FROM RSUPPayroll.dbo.tblMstKabKota")->result();
    }

    function get_Kecamatan(){
        return $this->db->query("select KecamatanID, KabKotaID, ProvinsiID, KecamatanName FROM RSUPPayroll.dbo.tblMstKecamatan")->result();
    }

    function getDataanak(){
    	$query = $this->db->get('tblTrnAnak');
        return $query->result();
    }
    function get_Keluarga($hdrid){
    	$query = $this->db->query("select * from tblTrnKeluarga where HeaderID = '$hdrid'");
        return $query->result();
    }

    function get_pemborong_bygroup($idpemborong){
        if ($idpemborong > 0){
            $result = $this->db->get_where('vwMstPemborong', array('IDPemborong'=>$idpemborong));
        }else{
            $this->db->select('*');
            $this->db->from('vwMstPemborong');
            $this->db->order_by('IDPerusahaan','ASC');
            $this->db->order_by('IDPemborong','ASC');
            $result = $this->db->get();
        }
        return $result;
    }

    function getDataRegistrasi($hdrid){
        $this->db->where('HeaderID',$hdrid);
        return $this->db->get('vwtblTrnCalonTenagaKerja')->result();
    }

    function get_DataReg($id,$data){
    	$this->db->where('HeaderID',$id);
    	$this->db->update('tblTrnCalonTenagaKerja',$data);
    }

    function CekDataAnak($id){
    	$this->db->where('HeaderID',$id);
    	return $this->db->get('tblTrnAnak')->result();
    }

    function update_dataanak($id,$infoanak){
    	$this->db->where('HeaderID',$id);
    	$this->db->update('tblTrnAnak',$infoanak);
    }

    function simpan_dataanak($infoanak){
    	$this->db->insert('tblTrnAnak',$infoanak);
    }

    function cekdataKeluarga($hdrid){
    	$this->db->where('HeaderID',$hdrid);
    	return $this->db->get('tblTrnKeluarga')->result();

    }

    function update_datakeluarga($id,$infokel){
    	$this->db->where('HeaderID',$id);
    	$this->db->update('tblTrnKeluarga',$infokel);
    }

    function simpan_datakeluarga($infokel){
    	$this->db->insert('tblTrnKeluarga',$infokel);
    }

    function update_lulus($id,$data){
    	$this->db->where('HeaderID',$id);
    	$this->db->update('tblTrnCalonTenagaKerja',$data);
    }
    function update_Gagal($id,$data){
    	$this->db->where('HeaderID',$id);
    	$this->db->update('tblTrnCalonTenagaKerja',$data);
    }
    function update_TidakMengerjakan($id,$data){
    	$this->db->where('HeaderID',$id);
    	$this->db->update('tblTrnCalonTenagaKerja',$data);
    }

    function Update_CloseData($id,$data){
    	$this->db->where('HeaderID',$id);
    	$this->db->update('tblTrnCalonTenagaKerja',$data);
    }

}?>