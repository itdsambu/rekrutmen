<?php 

class M_karantina extends CI_Model {  

   public function check_data($create_date,$nama_pemborong,$jumlah_karantina){
      $query = "SELECT
                     * 
                  FROM
                     tblTrnKarantina_hdr 
                      
                  WHERE 
                     create_date >= '2022-04-04'
                     AND create_date = '$create_date'
                     AND nama_pemborong = '$nama_pemborong'
                     AND jumlah_karantina = '$jumlah_karantina'
                     ";
      return $this->db->query($query)->result_object();
   }

   public function getAllData() { 
      $query = "SELECT * FROM tblTrnKarantina_hdr ORDER BY create_date DESC";
      return $this->db->query($query)->result_array();
   }

   public function list_pemborong(){
      $query = $this->db->query("SELECT Perusahaan FROM vwMstPemborong ORDER BY Perusahaan ASC");

      if ($query->num_rows() > 0) {
         return $query->result();
     }
   }

   public function insertData() {

      $tanggal_inputan     = $this->input->post('tanggal_inputan');
      $nama_pemborong      = strtoupper($this->input->post('nama_pemborong'));
      $jumlah_karantina    = $this->input->post('jumlah_karantina');
      $complate_date       = $this->input->post('complate_date');
      $complate_time       = $this->input->post('complate_time');
      $complate_by         = strtoupper($this->session->userdata('username'));
      $complate_comp       = gethostbyaddr($_SERVER['REMOTE_ADDR']);
      $update_by           = $this->input->post('update_by');
      $update_tanggal      = $this->input->post('update_tanggal');

      
      $data1 = [
         'create_date'     => $tanggal_inputan,
         'jumlah_karantina'   => $jumlah_karantina,
         'nama_pemborong'  => $nama_pemborong,
         'complate_date'   => $complate_date,
         'complate_time'   => $complate_time,
         'complate_by'     => $complate_by,
         'complate_comp'   => $complate_comp,
         'tanggal_inputan' => $tanggal_inputan,
         'update_by'       => $update_by,
         'update_tanggal'  => $update_tanggal 
      ];
      $this->db->insert('tblTrnKarantina_hdr', $data1);
      $id = $this->db->insert_id(); 

      $registrasi_id        = $this->input->post('id_registrasi[]');
      $tanggal_kedatangan   = $this->input->post('tanggal_datang[]');
      $tanggal_rapid        = $this->input->post('tanggal_rapid[]');
      $tanggal_interview    = $this->input->post('tanggal_interview[]');
      $keterangan           = $this->input->post('keterangan[]');
      $alamat_karantina     = $this->input->post('alamat_karantina[]');
      $nama_karyawan        = $this->input->post('nama_karyawan[]');
      $jenis_kelamin        = $this->input->post('jenis_kelamin[]');
      $perusahaan           = $this->input->post('perusahaan[]');
      $daerah_asal          = $this->input->post('daerah_asal[]');
      $tgl_klr_karantina    = $this->input->post('tgl_klr_karantina[]');
      $tgl_masuk_karantina = $this->input->post('tgl_masuk_karantina[]');
      $hasil_tes_karantina = $this->input->post('hasil_tes_karantina[]');
      $status_karantina    = $this->input->post('status_karantina[]');


      $jumlah = count($this->input->post('id_registrasi'));
      for ($i=0; $i < $jumlah; $i++ ) {

         if($tgl_klr_karantina == ''){
            $tgl_karantina = NULL;
         }else{
            $tgl_karantina = $tgl_klr_karantina;
         }
         if($status_karantina == ''){
            $dt_status_karantina = NULL;
         }else{
            $dt_status_karantina = $status_karantina;
         }
         if($tgl_masuk_karantina == ''){
            $tgl_masukkarantina = NULL;
         }else{
            $tgl_masukkarantina = $tgl_masuk_karantina;
         }
         if($hasil_tes_karantina == ''){
            $hasil_tes_karan = NULL;
         }else{
            $hasil_tes_karan = $hasil_tes_karantina;
         }
   

         $data2[$i] = [
            'header_id'          => $id,
            'registrasi_id'      => $registrasi_id[$i],
            'tanggal_kedatangan' => $tanggal_kedatangan[$i],
            'tanggal_rapid'      => $tanggal_rapid[$i],
            'tanggal_interview'  => $tanggal_interview[$i],
            'keterangan'         => $keterangan[$i],
            'alamat_karantina'   => $alamat_karantina[$i],
            'nama_karyawan'      => $nama_karyawan[$i],
            'jenis_kelamin'      => $jenis_kelamin[$i],
            'perusahaan'         => $perusahaan[$i],
            'daerah_asal'        => $daerah_asal[$i],      
            'tgl_klr_karantina'  => $tgl_karantina[$i],      
            'tgl_masuk_karantina'  => $tgl_masukkarantina[$i],     
            'hasil_tes_karantina'  => $hasil_tes_karan[$i],      
            'status_karantina'     => $dt_status_karantina[$i]      
         ];
         $this->db->insert('tblTrnKarantina_dtl', $data2[$i]);
      }
      
   }

   public function getDetail($id) {
      $query = "SELECT * FROM tblTrnKarantina_dtl 
                JOIN tblTrnKarantina_hdr ON tblTrnKarantina_dtl.header_id = tblTrnKarantina_hdr.header_id 
                WHERE tblTrnKarantina_hdr.header_id = '$id' 
                ORDER BY registrasi_id ASC";
      return $this->db->query($query)->result_array();
   }

   public function getDataDetail($id) {
      $query = "SELECT * FROM tblTrnKarantina_dtl 
                JOIN tblTrnKarantina_hdr ON tblTrnKarantina_dtl.header_id = tblTrnKarantina_hdr.header_id 
                WHERE tblTrnKarantina_dtl.detail_id = $id";
      return $this->db->query($query)->result_array()[0];
   }

   public function getDataResult($id) {
      $query = "SELECT *
                FROM tblTrnKarantina_dtl 
                JOIN tblTrnKarantina_hdr 
                ON tblTrnKarantina_dtl.header_id = tblTrnKarantina_hdr.header_id 
                WHERE tblTrnKarantina_hdr.header_id = $id";
      return $this->db->query($query)->result_object();
   }

   public function getAllTK($where)
   {  
      $this->db->where($where);
      $this->db->select('HeaderID, Nama, Jenis_Kelamin, CVNama, Daerah_Asal');
      return $this->db->get('tblTrnCalonTenagaKerja')->result();
   }

   public function getLaporan() {
      $tanggal_kedatangan1 = $this->input->post('tanggal_kedatangan1');
      $tanggal_kedatangan2 = $this->input->post('tanggal_kedatangan2');

      $this->db->where('tanggal_kedatangan', $tanggal_kedatangan1);
      return $this->db->get('tblTrnKarantina_dtl')->result();
      
   }

   public function deleteData($id) {
      $query = "DELETE FROM tblTrnKarantina_dtl WHERE header_id = $id";
      return $this->db->query($query);
   }
   public function delete_row($id){
      return $this->db->delete('tblTrnKarantina_dtl', ['detail_id' => $id]);
   }

   public function tombolUbah($id) {
      $headerId         = $this->input->post('headerId');
      $registrasiId     = $this->input->post('registrasiId');
      $namaKaryawan     = $this->input->post('namaKaryawan');
      $jenisKelamin     = $this->input->post('jenisKelamin');
      $perusahaan       = $this->input->post('perusahaan');
      $daerahAsal       = $this->input->post('daerahAsal');
      $tanggalDatang    = $this->input->post('tanggalDatang');
      $tanggalRapid     = $this->input->post('tanggalRapid');
      $tanggalInterview = $this->input->post('tanggalInterview');
      $keterangan       = $this->input->post('keterangan');
      $alamatKarantina  = $this->input->post('alamatKarantina');
      $tgl_klr_karantina = $this->input->post('tgl_klr_karantina');
      $tgl_masuk_karantina = $this->input->post('tgl_masuk_karantina');
      $hasil_tes_karantina = $this->input->post('hasil_tes_karantina');
      $status_karantina    = $this->input->post('status_karantina');

      $data = [
         'header_id'          => $headerId,
         'registrasi_id'      => $registrasiId,  
         'tanggal_kedatangan' => $tanggalDatang,
         'tanggal_rapid'      => $tanggalRapid,
         'tanggal_interview'  => $tanggalInterview,
         'keterangan'         => $keterangan,
         'alamat_karantina'   => $alamatKarantina,
         'tgl_klr_karantina'     => $tgl_klr_karantina,
         'tgl_masuk_karantina'  => $tgl_masuk_karantina,
         'hasil_tes_karantina'  => $hasil_tes_karantina,
         'status_karantina'  => $status_karantina,
         'nama_karyawan'      => $namaKaryawan,
         'jenis_kelamin'      => $jenisKelamin,
         'perusahaan'         => $perusahaan,
         'daerah_asal'        => $daerahAsal
      ];

      $this->db->where('detail_id', $id);
      $this->db->update('tblTrnKarantina_dtl', $data);
   }

   public function updateEditDetail() {
      $data1 = [
         'create_date'       => $this->input->post('create_date'),
         'complate_date'     => $this->input->post('complate_date'),
         'complate_time'     => $this->input->post('complate_time'),
         'complate_by'       => $this->input->post('complate_by'),
         'complate_comp'     => $this->input->post('complate_comp'),
         'tanggal_inputan'   => $this->input->post('tanggal_inputan'),
         // 'nama_pemborong'    => $this->input->post('nama_pemborong'),
         // 'jumlah_karantina'     => $this->input->post('jumlah_karantina'),
         'update_tanggal'    => $this->input->post('update_tanggal'),
         'update_by'         => strtoupper($this->session->userdata('username'))
      ];
      $this->db->where('header_id', $this->input->post('header_id'));
      $this->db->update('tblTrnKarantina_hdr', $data1);

      $status_karantina = $this->input->post('status_karantina');
      $tgl_klr_karantina = $this->input->post('tgl_klr_karantina');
      $tgl_masuk_karantina = $this->input->post('tgl_masuk_karantina');
      $hasil_tes_karantina = $this->input->post('hasil_tes_karantina');
      if ($status_karantina != '') {
         $status_karantina = $status_karantina;
      } else {
         $status_karantina = NULL;
      }

      if($tgl_klr_karantina == ''){
         $tgl_karantina = NULL;
      }else{
         $tgl_karantina = $tgl_klr_karantina;
      }
      if($tgl_masuk_karantina == ''){
         $tgl_masukkarantina = NULL;
      }else{
         $tgl_masukkarantina = $tgl_masuk_karantina;
      }
      if($hasil_tes_karantina == ''){
         $hasil_tes_karan = NULL;
      }else{
         $hasil_tes_karan = $hasil_tes_karantina;
      }


      $data2 = [
         'header_id'          => $this->input->post('header_id'),
         'registrasi_id'      => $this->input->post('id_registrasi'),
         'tanggal_kedatangan' => $this->input->post('tanggal_datang'),
         'tanggal_rapid'      => $this->input->post('tanggal_rapid'),
         'tanggal_interview'  => $this->input->post('tanggal_interview'),
         'nama_karyawan'      => $this->input->post('nama_karyawan'),
         'jenis_kelamin'      => $this->input->post('jenis_kelamin'),
         'perusahaan'         => $this->input->post('perusahaan'),
         'daerah_asal'        => $this->input->post('daerah_asal'),
         'alamat_karantina'   => $this->input->post('alamat_karantina'),
         'keterangan'         => $this->input->post('keterangan'),
         'tgl_klr_karantina'  => $tgl_karantina,
         'tgl_masuk_karantina'  => $tgl_masukkarantina,
         'hasil_tes_karantina'  => $hasil_tes_karan,
         'status_karantina'   => $status_karantina
      ];
      $this->db->where('detail_id', $this->input->post('detail_id'));
      $this->db->update('tblTrnKarantina_dtl', $data2);
      redirect('Datakarantina/editDetail/' . $this->input->post('detail_id'));
   }


   public function cetakExcel($id) {
      $query = "SELECT * FROM tblTrnKarantina_dtl WHERE header_id = '$id' ORDER BY detail_id desc";
      return $this->db->query($query)->result_array();
   }

}