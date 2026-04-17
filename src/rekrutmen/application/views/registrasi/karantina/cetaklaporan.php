<div class="page-header">
    <h1>
        LAPORAN DATA KARANTINA
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Tenaga Kerja PT. Pulau Sambu - Guntung
        </small>
    </h1>
</div><!-- /.page-header -->


<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Laporan Data Karantina Tenaga Kerja PT. Pulau Sambu - Guntung</h4>
    </div>
            <div class="widget-body">
                <div class="widget-main">

               <form action="<?= base_url('datakarantina/laporan'); ?>" method="POST">
                  <div class="row">
                     <div class="col-sm-1">
                        <div class="form-group">
                           <label for="">Tanggal Kedatangan</label>
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                           <input type="date" name="tanggal_kedatangan" id="tanggal_kedatangan" class="form-control">
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                           <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                        </div>
                     </div>
                  </div>
               </form>

                    <div class="table-responsive">
                        <table id="dataTables-listTK" class="table table-striped table-bordered table-hover">
                              <thead class="bg-primary">
                                 <tr class="bg-primary">
                                    <th class="bg-primary">ID Registrasi</th>
                                    <th class="bg-primary">Nama Karyawan</th>
                                    <th class="bg-primary">Jenis Kelamin</th>
                                    <th class="bg-primary">Perusahaan</th>
                                    <th class="bg-primary">Daerah Asal</th>
                                    <th class="bg-primary">Tanggal Kedatangan</th>
                                    <th class="bg-primary">Tanggal Rapid Tes</th>
                                    <th class="bg-primary">Tanggal Interview</th>
                                    <th class="bg-primary">Keterangan</th>
                                    <th class="bg-primary">Alamat Karantina</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php foreach ($tampil_laporan as $lap) { ?>
                                 <tr>
                                    <td><?= $lap['registrasi_id']; ?></td>
                                    <td><?= $lap['nama_karyawan']; ?></td>
                                    <td><?= $lap['jenis_kelamin']; ?></td>
                                    <td><?= $lap['perusahaan']; ?></td>
                                    <td><?= $lap['daerah_asal']; ?></td>
                                    <td><?= $lap['tanggal_kedatangan']; ?></td>
                                    <td><?= $lap['tanggal_rapid']; ?></td>
                                    <td><?= $lap['tanggal_interview']; ?></td>
                                    <td><?= $lap['keterangan']; ?></td>
                                    <td><?= $lap['alamat_karantina']; ?></td>
                                 </tr>
                                 <?php } ?>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <th colspan="10">
                                       <a href="<?= base_url('datakarantina/cetaklaporan'); ?>" target="_blank" class="btn btn-primary">Cetak Laporan</a>
                                    </th>
                                 </tr>
                              </tfoot>
                        </table>
                    </div>
               
               </div>
            </div>
    </div>

<!-- page specific plugin scripts -->        
<script src="http://192.168.3.5/rekrutmen/assets/sp/scroll-persen.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/jquery.dataTables.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script>    
    $('#dataTables-listTK').dataTable({
            "order" : ['0','desc']
        });
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('.datepick').datepicker({
            autoclose:true,
            format: 'dd-mm-yyyy'
        });
    });
</script>