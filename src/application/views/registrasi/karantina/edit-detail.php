<div class="page-header">
    <h1>
        DATA KARANTINA
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Tenaga Kerja PT. Pulau Sambu - Guntung
        </small>
    </h1>
</div><!-- /.page-header -->
<br>
<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="panel panel-info">
           <div class="panel-heading">
              <h4>Edit Detail Data Karantina</h4>
           </div>
           <div class="panel-body">
               <form class="form-horizontal" action="<?php echo base_url('Datakarantina/updateEditDetail'); ?>" method="POST">
                  <div class="row">
                     <div class="form-group">
                        <input type="hidden" name="create_date" value="<?php echo $tampilData['create_date']; ?>">
                        <input type="hidden" name="complate_date" value="<?php echo $tampilData['complate_date']; ?>">
                        <input type="hidden" name="complate_time" value="<?php echo $tampilData['complate_time']; ?>">
                        <input type="hidden" name="complate_by" id="complate_by" value="<?php echo $tampilData['complate_by']; ?>">
                        <input type="hidden" name="complate_comp" id="complate_comp" value="<?php echo $tampilData['complate_comp']; ?>">
                        <input type="hidden" name="tanggal_inputan" id="tanggal_inputan" value="<?php echo $tampilData['tanggal_inputan']; ?>">
                        <input type="hidden" name="update_tanggal" id="update_tanggal" value="<?php echo date('Y-m-d'); ?>">
                        <input type="hidden" name="header_id" id="header_id" value="<?php echo $tampilData['header_id']; ?>">
                     </div>
                  </div>
                  
                  


                  <div class="row table-responsive">
                  <table class="table table-bordered table-hover table-striped">
                        <thead id="head_tbl_freeze" class="fixed freeze_vertical bg-primary">
                           <tr class="bg-primary">
                              <th rowspan="1" class="bg-primary">ID Registrasi</th>
                              <th rowspan="1" class="bg-primary">Nama Karyawan</th>
                              <th rowspan="1" class="bg-primary">Jenis Kelamin</th>
                              <th rowspan="1" class="bg-primary">Perusahaan</th>
                              <th rowspan="1" class="bg-primary">Daerah Asal</th>
                              <th rowspan="1" class="bg-primary">Tanggal Datang</th>
                              <th rowspan="1" class="bg-primary">Tanggal Rapid Tes</th>
                              <th rowspan="1" class="bg-primary">Tanggal Interview</th>
                              <th rowspan="1" class="bg-primary">Alamat Karantina</th>
                              <th rowspan="1" class="bg-primary">Tanggal Masuk Karantina</th>
                              <th rowspan="1" class="bg-primary">Keterangan</th>
                              <th rowspan="1" class="bg-primary">Status Karantina</th>
                              <th rowspan="1" class="tes3 bg-primary">Tanggal Keluar Karantina</th>
                              <th rowspan="1" class="tes4 bg-primary">Hasil Tes Karantina</th>
                           </tr>
                        </thead>
                        <tbody id="dataTable">
                              <tr>
                                 <td>
                                    <input type="hidden" name="detail_id" id="detail_id" class="detail_id" value="<?php echo $tampilData['detail_id']; ?>">
                                    <input type="text" name="id_registrasi" id="id_registrasi" class="w-100 p-3 id_registrasi" autocomplete="off" required value="<?php echo $tampilData['registrasi_id']; ?>">
                                 </td>
                                 <td>
                                    <input type="text" name="nama_karyawan" id="nama_karyawan" class="w-100 p-3 nama_karyawan" value="<?php echo $tampilData['nama_karyawan']; ?>" autocomplete="off" required>
                                 </td>
                                 <td>
                                    <select style="text-align: center;" name="jenis_kelamin" id="jenis_kelamin" class="w-100 p-3 jenis_kelamin" autocomplete="off" required>
                                       <option value="">--Pilih--</option>
                                       <option value="LAKI-LAKI" <?php if($tampilData['jenis_kelamin'] == "LAKI-LAKI"){echo "selected";} ?>>LAKI-LAKI</option>
                                       <option value="WANITA" <?php if($tampilData['jenis_kelamin'] == "WANITA"){echo "selected";} ?>>WANITA</option>
                                    </select>
                                 </td>
                                 <td>
                                    <input type="text" style="text-align: center;" name="perusahaan" id="perusahaan" class="w-100 p-3 perusahaan" value="<?php echo $tampilData['perusahaan']; ?>" autocomplete="off" required>
                                 </td>
                                 <td>
                                    <input type="text" style="text-align: center;" name="daerah_asal" id="daerah_asal" class="w-100 p-3 daerah_asal" value="<?php echo $tampilData['daerah_asal']; ?>" autocomplete="off" required>
                                 </td>
                                 <td>
                                    <div class="input-group">
                                       <input type="date" style="text-align: center;" name="tanggal_datang" id="tanggal_datang" class="w-100 p-3 tanggal_datang" ="" value="<?php echo $tampilData['tanggal_kedatangan']; ?>" autocomplete="off" required>
                                    </div>
                                 </td>
                                 <td>
                                    <div class="input-group">
                                       <input type="date" style="text-align: center;" name="tanggal_rapid" id="tanggal_rapid" class="w-100 p-3 tanggal_rapid" value="<?php echo $tampilData['tanggal_rapid']; ?>" autocomplete="off" required>
                                    </div>
                                 </td>
                                 <td>
                                    <div class="input-group">
                                       <input type="date" style="text-align: center;" name="tanggal_interview" id="tanggal_interview" class="w-100 p-3 tanggal_interview" value="<?php echo $tampilData['tanggal_interview']; ?>" autocomplete="off" required>
                                    </div>
                                 </td>
                                 <td>
                                    <textarea style="text-align: center;" name="alamat_karantina" id="alamat_karantina" cols="30" class="w-100 p-3 alamat_karantina"><?php echo $tampilData['alamat_karantina']; ?></textarea>
                                 </td>
                                 <td>
                                 <input type="date" style="text-align: center;" name="tgl_masuk_karantina" id="tgl_masuk_karantina" class="w-100 p-3 tgl_masuk_karantina" value="<?php echo $tampilData['tgl_masuk_karantina']; ?>" autocomplete="off">
                                 </td>
                                 <td>
                                    <textarea style="text-align: center;" name="keterangan" id="keterangan" cols="30" class="w-100 p-3 keterangan"><?php echo $tampilData['keterangan']; ?></textarea>
                                 </td>
                                 <td>
                                   <select style="text-align: center;" class="status_karantina" name="status_karantina" id="status_karantina">
                                     <option value="">- Pilih -</option>
                                     <option value="1" <?php if ($tampilData['status_karantina'] == '1') { echo "selected"; } ?>>Lulus</option>
                                     <option value="0" <?php if ($tampilData['status_karantina'] == '0') { echo "selected"; } ?>>Tidak Lulus</option>
                                   </select>
                                 </td>
                                 <td>
                                 <input type="date" style="text-align: center;" name="tgl_klr_karantina" id="tgl_klr_karantina" class="w-100 p-3 tgl_klr_karantina" value="<?php echo $tampilData['tgl_klr_karantina']; ?>" autocomplete="off">
                                 </td>
                                 <td>
                                 <input type="text" style="text-align: center;" name="hasil_tes_karantina" id="hasil_tes_karantina" class="w-100 p-3 hasil_tes_karantina" value="<?php echo $tampilData['hasil_tes_karantina']; ?>" autocomplete="off">
                                 </td>
                              </tr>
                        </tbody>
                     </table>
                  </div>
                  <div align="left">
                     <button type="submit" class="btn btn-primary" id="ubahData">Ubah</button>
                     <a href="<?php echo base_url('Datakarantina/detail/') . $tampilData['header_id']; ?>" class="btn btn-danger">Batal</a>
                  </div>
               </form>
           </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" />
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>

<script>

   $(document).ready(function() {

      $(document).on('change', '.status_karantina', function(){
            var that = $(this);
            var status = that.val();
            console.log(status);

            if(status == '0'){
               $('.tes3').hide();
               $('.tes4').hide();
               $('.tgl_klr_karantina').hide();
               $('.hasil_tes_karantina').hide();
            }else{
               $('.tes3').show();
               $('.tes4').show();
               $('.tgl_klr_karantina').show();
               $('.hasil_tes_karantina').show();
            }

      });



      $(document).on('change', '.id_registrasi', function(){
         var reg_id = $(this).val();
         var col_nm_karyawan = $(this).closest('tr').find('.nama_karyawan');
         var col_jenis_kelamin = $(this).closest('tr').find('.jenis_kelamin');
         var col_perusahaan = $(this).closest('tr').find('.perusahaan');
         var col_daerah_asal = $(this).closest('tr').find('.daerah_asal');
         $.ajax({
            type: "POST",
            data: {reg_id:reg_id},
            url: "<?php echo base_url()?>"+"Datakarantina/dataAjax/",
            success: function(res){
                  if(res == 'Error'){
                  //alert('Tidak ada data '/*+warehouse*/);
                  } 
                  else{
                     var datan = res.split('//');
                     col_nm_karyawan.val(datan[1]);
                     col_jenis_kelamin.empty()
                     if(datan[2] == 'LAKI-LAKI'){
                        var selected_laki_laki = "selected"
                     }else{
                        var selected_laki_laki = ""
                     }
                     if(datan[2] == 'PEREMPUAN'){
                        var selected_perempuan = "selected"
                     }else{
                        var selected_perempuan = ""
                     }
                     col_jenis_kelamin.append(`<option value="">--Pilih--</option>
                                               <option value="LAKI-LAKI" `+selected_laki_laki+`>LAKI-LAKI</option>
                                               <option value="WANITA" `+selected_perempuan+`>WANITA</option>`);
                     col_perusahaan.val(datan[3])
                     col_daerah_asal.val(datan[4])
                  }
            }
         });
      });

      $('#tbl_karantina').on('click', '#hapusData', function() {
         var id = $(this).val();
         var header_id = $('#header_id').val();
         $.ajax({
            url : "<?php echo base_url(); ?>Datakarantina/delete_row",
            type : "POST",
            data : {id:id},
            success:function(){
               var baseurl = "<?php print site_url(); ?>";
               alert('Data berhasil dihapus');
               window.location.href = baseurl+'Datakarantina/edit/'+header_id;
            }
         })
      })

      $('#tbl_karantina').on('click', '#ubahData', function() {
         var id               = $(this).val();
         var headerId         = $('#header_id').val();
         var registrasiId     = $('#id_registrasi').val();
         var namaKaryawan     = $('#nama_karyawan').val();
         var jenisKelamin     = $('#jenis_kelamin').val();
         var perusahaan       = $('#perusahaan').val();
         var daerahAsal       = $('#daerah_asal').val();
         var tanggalDatang    = $('#tanggal_datang').val();
         var tanggalRapid     = $('#tanggal_rapid').val();
         var tanggalInterview = $('#tanggal_interview').val();
         var keterangan       = $('#keterangan').val();
         var alamatKarantina  = $('#alamat_karantina').val();
         var tgl_klr_karantina    = $('#tgl_klr_karantina').val();
         var hasil_tes_karantina  = $('#hasil_tes_karantina').val();
         // alert(id);
         $.ajax({
            url: "<?php echo base_url('Datakarantina/tombolUbahDetail'); ?>",
            type: "POST",
            data: {id:id, headerId:headerId, registrasiId:registrasiId, namaKaryawan:namaKaryawan, jenisKelamin:jenisKelamin, 
                   perusahaan:perusahaan, daerahAsal:daerahAsal, tanggalDatang:tanggalDatang, tanggalRapid:tanggalRapid, tanggalInterview:tanggalInterview,
                   keterangan:keterangan, alamatKarantina:alamatKarantina, tgl_klr_karantina:tgl_klr_karantina, hasil_tes_karantina:hasil_tes_karantina},
            success: function() {
               var baseurl = "<?php print site_url(); ?>";
               alert('Data berhasil diubah');
               window.location.href = baseurl+'Datakarantina/edit/'+headerId;
            }
         });
      });

   });

    
</script>

