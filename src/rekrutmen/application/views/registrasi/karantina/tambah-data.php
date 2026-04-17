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
              <h4>Tambah Data Karantina</h4>
           </div>
           <div class="panel-body">
               <form class="form-horizontal" action="<?= base_url('datakarantina/tambahdata'); ?>" method="POST">
                  <div class="row">
                     <div class="form-group">
                        <label class="col-sm-2 control-label" style="text-align:left;"> <b>Create Date</b> </label>
                        <div class="col-sm-3">
                           <input type="date" id="tanggal_inputan" name="tanggal_inputan" class="form-control datepick" required autocomplete="off">
                        </div>
                     </div>
                     <div class="form-group">
                        <input type="hidden" name="complate_date" id="complate_date" value="<?= date('Y-m-d'); ?>">
                        <input type="hidden" name="complate_time" id="complate_time" value="<?= time('H:i:s'); ?>">
                        <input type="hidden" name="update_tanggal" id="update_tanggal" value="<?= date('Y-m-d'); ?>">
                        <input type="hidden" name="update_by" id="update_by" value="">
                     </div>
                  </div>
                  <div class="row">
                     <div class="form-group">
                        <label class="col-sm-2 control-label" style="text-align:left;"> <b>Nama Pemborong</b> </label>
                        <!-- <div class="col-sm-3">
                           <input type="text" id="nama_pemborong" name="nama_pemborong" class="form-control" placeholder="Nama Pemborong" required>
                        </div> -->
                        <div class="col-sm-3">
                           <select id="nama_pemborong"  name="nama_pemborong" class="form-control">
                              <option value="">--Pilih--</option>
                              <?php foreach($pemborong as $row){
                                    ?>
                              <option value="<?php echo $row->Perusahaan; ?>"><?php echo $row->Perusahaan; ?></option>
                                    <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="form-group">
                        <label class="col-sm-2 control-label" style="text-align:left;"> <b>Jumlah Orang</b> </label>
                        <div class="col-sm-3">
                           <input type="number" id="jumlah_karantina" name="jumlah_karantina" class="angkasaja_3digit form-control" placeholder="Jumlah Tenaga Kerja Yang Akan Di Karantina" required>
                        </div>
                     </div>
                  </div>
                  

                  <div class="row">
                     <div class="col-lg-12">
                        <div class="table-responsive scrolly_table" id="scrolling_table_1" style="max-height: 1000px;">
                              <table class="table table-bordered table-hover table-striped">
                                 <thead id="head_tbl_freeze" class="fixed freeze_vertical bg-primary">
                                    <tr>
                                          <th rowspan="3" colspan="1">&#x2714;</th>
                                          <th rowspan="3" colspan="1">Registrasi</th>
                                          <th rowspan="3" colspan="1">Nama Karyawan</th>
                                          <th rowspan="3" colspan="1">Jenis Kelamin</th>
                                          <th rowspan="3" colspan="1">Perusahaan</th>
                                          <th rowspan="3" colspan="1">Daerah Asal</th>
                                          <th rowspan="3" colspan="1">Tanggal Datang</th>
                                          <th rowspan="3" colspan="1">Tanggal Rapid Tes</th>
                                          <th rowspan="3" colspan="1">Tanggal Interview</th>
                                          <th rowspan="3" colspan="1">Alamat Karantina</th>
                                          <th rowspan="3" colspan="1">Keterangan</th>
                                    </tr>


                                 </thead>
                                 <tbody id="dataTable">
                                    <tr>
                                          <td> 
                                             <input name="chk[]" type="checkbox" class="checkall">
                                          </td>
                                          <td>
                                             <div class="input-group">
                                             <input type="text" size="25" name="id_registrasi[]" id="id_registrasi" class="id_registrasi" autocomplete="off" required>
                                             </div>
                                          </td>
                                          <td id="nk">
                                             <div class="input-group">
                                             <input type="text" size="25" name="nama_karyawan[]" id="nama_karyawan" class="nama_karyawan" autocomplete="off" required>
                                             </div>
                                          </td>
                                          <td>
                                             <select name="jenis_kelamin[]" id="jenis_kelamin" class="jenis_kelamin" autocomplete="off" required>
                                             <option value="">--Pilih--</option>
                                             <option value="LAKI-LAKI">LAKI-LAKI</option>
                                             <option value="WANITA">WANITA</option>
                                             </select>
                                          </td>
                                          <td>
                                             <div class="input-group">
                                             <input type="text" size="25" name="perusahaan[]" id="perusahaan" class="perusahaan" autocomplete="off" required>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="input-group">
                                             <input type="text" size="25" name="daerah_asal[]" id="daerah_asal" class="daerah_asal" autocomplete="off" required>
                                             </div">
                                          </td>
                                          <td>
                                             <div class="input-group">
                                             <input type="date" name="tanggal_datang[]" id="tanggal_datang" class="tanggal_datang" autocomplete="off" required>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="input-group">
                                             <input type="date" name="tanggal_rapid[]" id="tanggal_rapid" class="tanggal_rapid" autocomplete="off" required>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="input-group">
                                             <input type="date" name="tanggal_interview[]" id="tanggal_interview" class="tanggal_interview" autocomplete="off" required>
                                             </div>
                                          </td>
                                          <td>
                                             <textarea name="alamat_karantina[]" id="alamat_karantina" cols="50" class="alamat_karantina"></textarea>
                                          </td>
                                          <td>
                                             <textarea name="keterangan[]" id="keterangan" cols="50" class="keterangan"></textarea>
                                          </td>
                                          <td>
                                    </tr>
                                 </tbody>
                                 <tfoot>
                                 <tr>
                                    <td colspan="33" align="center">
                                          <button type="button" class="btn btn-primary" id="tambahBaris">Tambah Baris</button>
                                          <button type="button" class="btn btn-danger" id="hapusBaris">Hapus Baris</button>
                                    </td>
                                 </tr>
                                 </tfoot>
                              </table>
                        </div>
                     </div>
                  </div>



                  
                  <div align="left">
                     <button type="submit" class="btn btn-primary">Simpan</button>
                     <button type="button" class="btn btn-danger">Batal</button>
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
                  if(res == 'Error'){interview
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

   });


   $('#tambahBaris').on('click', function() {
      var data = `<tr>
                     <td><input name="chk[]" type="checkbox" class="checkall"></td>";
                     <td><input type="text" name="id_registrasi[]" id="id_registrasi" class="form-control id_registrasi"></td>
                     <td><input type="text" name="nama_karyawan[]" id="nama_karyawan" class="form-control nama_karyawan"></td>
                     <td><select name="jenis_kelamin[]" id="jenis_kelamin" class="form-control jenis_kelamin">
                        <option value="">--Pilih--</option>
                        <option value="LAKI-LAKI">LAKI-LAKI</option>
                        <option value="WANITA">WANITA</option>
                     </select></td>
                     <td><input type="text" name="perusahaan[]" id="perusahaan" class="form-control perusahaan"></td>
                     <td><input type="text" name="daerah_asal[]" id="daerah_asal" class="form-control daerah_asal"></td>
                     <td>
                        <div class="input-group">
                           <input type="date" name="tanggal_datang[]" id="tanggal_datang" class="form-control datepick tanggal_datang">
                        </div>
                     </td>
                     <td>
                        <div class="input-group">
                           <input type="date" name="tanggal_rapid[]" id="tanggal_rapid" class="form-control datepick tanggal_rapid">
                        </div>
                     </td>
                     <td>
                        <div class="input-group">
                           <input type="date" name="tanggal_interview[]" id="tanggal_interview" class="form-control datepick tanggal_interview">
                        </div>
                     </td>
                     <td><textarea name="keterangan[]" id="keterangan" cols="50" class="form-control keterangan"></textarea></td>
                     <td><textarea name="alamat_karantina[]" id="alamat_karantina" cols="50" class="form-control alamat_karantina"></textarea></td>
                  </tr>`;

          $('table').append(data);
   });


   $('#hapusBaris').on('click', function() {
      $('.checkall:checkbox:checked').parents('tr').remove();
   });

    
</script>

