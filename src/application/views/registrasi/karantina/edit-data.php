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
              <h4>Edit Data Karantina</h4>
           </div>
           <div class="panel-body">
               <form class="form-horizontal" action="<?php echo base_url('Datakarantina/update') ?>" method="POST">
                  <div class="row">
                     <div class="form-group">
                        <input type="hidden" name="create_date" value="<?php echo $result[0]->create_date; ?>">
                        <input type="hidden" name="complate_date" value="<?php echo $result[0]->create_date; ?>">
                        <input type="hidden" name="complate_time" value="<?php echo $result[0]->complate_time; ?>">
                        <input type="hidden" name="complate_by" id="complate_by" value="<?php echo $result[0]->complate_by; ?>">
                        <input type="hidden" name="update_tanggal" id="update_tanggal" value="<?= date('Y-m-d'); ?>">
                        <input type="hidden" name="header_id" id="header_id" value="<?php echo $result[0]->header_id; ?>">
                     </div>
                  </div>
                  
                  <?php // var_dump($result); ?>
                  <div class="row table-responsive">
                     <table class="table table-bordered" id="tbl_karantina">
                        <thead class="bg-primary">
                           <tr class="bg-primary">
                              <th class="bg-primary">ID Registrasi</th>
                              <th class="bg-primary">Nama Karyawan</th>
                              <th class="bg-primary">Jenis Kelamin</th>
                              <th class="bg-primary">Perusahaan</th>
                              <th class="bg-primary">Daerah Asal</th>
                              <th class="bg-primary">Tanggal Datang</th>
                              <th class="bg-primary">Tanggal Rapid Tes</th>
                              <th class="bg-primary">Tanggal Interview</th>
                              <th class="bg-primary">Alamat Karantina</th>
                              <th class="bg-primary">Keterangan</th>
                              <th class="bg-primary" colspan="2">Action</th>
                           </tr>
                        </thead>
                        <tbody id="dataTable">
                           <?php 
                           if(isset($result->detail_id)) { ?>
                              <tr>
                                 <td colspan="11">
                                    <p align="center">Data tidak ada</p>
                                 </td>
                              </tr>
                           <?php } else {
                              foreach ($result as $rs) { ?>
                              <tr>
                                 <td>
                                    <input type="text" name="detail_id" id="detail_id" class="detail_id" value="<?php echo $rs->detail_id; ?>">
                                    <input type="text" name="id_registrasi[]" id="id_registrasi" class="form-control id_registrasi" value="<?php echo $rs->registrasi_id; ?>" autocomplete="off" required>
                                 </td>
                                 <td>
                                    <input type="text" name="nama_karyawan[]" id="nama_karyawan" class="form-control nama_karyawan" value="<?php echo $rs->nama_karyawan; ?>" autocomplete="off" required>
                                 </td>
                                 <td>
                                    <select name="jenis_kelamin[]" id="jenis_kelamin" class="form-control jenis_kelamin" autocomplete="off" required>
                                       <option value="">--Pilih--</option>
                                       <option value="LAKI-LAKI" <?php if($rs->jenis_kelamin == "LAKI-LAKI"){echo "selected";} ?>>LAKI-LAKI</option>
                                       <option value="WANITA" <?php if($rs->jenis_kelamin == "WANITA"){echo "selected";} ?>>WANITA</option>
                                    </select>
                                 </td>
                                 <td>
                                    <input type="text" name="perusahaan[]" id="perusahaan" class="form-control perusahaan" value="<?php echo $rs->perusahaan; ?>" autocomplete="off" required>
                                 </td>
                                 <td>
                                    <input type="text" name="daerah_asal[]" id="daerah_asal" class="form-control daerah_asal" value="<?php echo $rs->daerah_asal; ?>" autocomplete="off" required>
                                 </td>
                                 <td>
                                    <div class="input-group">
                                       <input type="date" name="tanggal_datang[]" id="tanggal_datang" class="form-control tanggal_datang" ="" value="<?php echo $rs->tanggal_kedatangan; ?>" autocomplete="off" required>
                                    </div>
                                 </td>
                                 <td>
                                    <div class="input-group">
                                       <input type="date" name="tanggal_rapid[]" id="tanggal_rapid" class="form-control tanggal_rapid" value="<?php echo $rs->tanggal_rapid; ?>" autocomplete="off" required>
                                    </div>
                                 </td>
                                 <td>
                                    <div class="input-group">
                                       <input type="date" name="tanggal_interview[]" id="tanggal_interview" class="form-control tanggal_interview" value="<?php echo $rs->tanggal_interview; ?>" autocomplete="off" required>
                                    </div>
                                 </td>
                                 <td>
                                    <textarea name="alamat_karantina[]" id="alamat_karantina" cols="30" class="form-control alamat_karantina"><?php echo $rs->alamat_karantina; ?></textarea>
                                 </td>
                                 <td>
                                    <textarea name="keterangan[]" id="keterangan" cols="30" class="form-control keterangan"><?php echo $rs->keterangan; ?></textarea>
                                 </td>
                                 <td>
                                    <button type="button" id="hapusData" class="btn btn-primary btn-sm" value="<?php echo $rs->detail_id; ?>">Hapus</button>
                                 </td>
                                 <td>
                                    <button type="button" id="ubahData" class="btn btn-success btn-sm" value="<?php echo $rs->detail_id; ?>">Ubah</button>
                                 </td>
                              </tr>
                              <?php } } ?>
                        </tbody>
                     </table>
                  </div>
                  <div align="left">
                     <button type="submit" class="btn btn-primary">Simpan</button>
                     <a href="<?php echo base_url('Datakarantina'); ?>" class="btn btn-danger">Batal</a>
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
         });
      });

      $('#tbl_karantina').on('click', '#ubahData', function() {
         var id               = $(this).val();
         console.log(id);
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
         $.ajax({
            url: "<?php echo base_url('Datakarantina/tombolUbahDetail'); ?>",
            type: "POST",
            data: {id:id, headerId:headerId, registrasiId:registrasiId, namaKaryawan:namaKaryawan, jenisKelamin:jenisKelamin, 
                   perusahaan:perusahaan, daerahAsal:daerahAsal, tanggalDatang:tanggalDatang, tanggalRapid:tanggalRapid, tanggalInterview:tanggalInterview,
                   keterangan:keterangan, alamatKarantina:alamatKarantina},
            success: function() {
               var baseurl = "<?php print site_url(); ?>";
               alert('Data berhasil diubah');
               window.location.href = baseurl+'Datakarantina/edit/'+headerId;
            }
         });
      });

   });

    
</script>