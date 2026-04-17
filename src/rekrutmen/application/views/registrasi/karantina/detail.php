<div class="page-header">
    <h1>
        MONITORING DATA KARANTINA
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Tenaga Kerja PT. Pulau Sambu - Guntung
        </small>
    </h1>
</div><!-- /.page-header -->
<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Detail Laporan Data Karantina Pertanggal : <?php if (isset($detail) && count($detail) > 0) { echo date('d-m-Y', strtotime($detail[0]['create_date'])); } else { echo '';}  ?></h4>
    </div>
            <div class="widget-body">
                <div class="widget-main">
                <!-- Design Disini -->
                    <div class="table-responsive">
                        <table id="dataTables-listTK" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>ID Registrasi</th>
                                    <th>Nama Karyawan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Perusahaan</th>
                                    <th>Daerah Asal</th>
                                    <th>Tanggal Kedatangan</th>
                                    <th>Tanggal Rapid Tes</th>
                                    <th>Tanggal Interview</th>
                                    <th>Tanggal Masuk Karantina</th>
                                    <th>Alamat Karantina</th>
                                    <th>Keterangan</th>
                                    <th>Status Karantina</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                <?php
                                 if (isset($detail)) {
                                 foreach ($detail as $dtl) : ?>
                                 <tr>
                                    <td><?php echo $dtl['registrasi_id']; ?></td>
                                    <td><?php echo $dtl['nama_karyawan']; ?></td>
                                    <td><?php echo $dtl['jenis_kelamin']; ?></td>
                                    <td><?php echo $dtl['perusahaan']; ?></td>
                                    <td><?php echo $dtl['daerah_asal']; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($dtl['tanggal_kedatangan'])); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($dtl['tanggal_rapid'])); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($dtl['tanggal_interview'])); ?></td>
                                    <td><?php if ($dtl['tgl_masuk_karantina'] >'1900-01-01') {  echo date('d-m-Y', strtotime($dtl['tgl_masuk_karantina']));} else {} ?></td>
                                    <td><?php echo $dtl['alamat_karantina']; ?></td>
                                    <td><?php echo $dtl['keterangan']; ?></td>
                                    <td><?php if ($dtl['status_karantina'] == '1') { echo "Lulus"; } else if ($dtl['status_karantina'] == '0')  { echo "Tidak Lulus";} else { echo "Masih Karantina";} ?></td>
                                    <?php if ($dept == 'PSN' || $dept == 'ITD') { ?>
                                    <td>
                                       <a href="<?php echo base_url('Datakarantina/editDetail/') . $dtl['detail_id']; ?>" class="btn btn-minier btn-round btn-primary">Edit</a>
                                       <br>
                                       <!-- <a href="<?php echo base_url('Datakarantina/delete_data/') . $dtl['header_id']; ?>" class="btn btn-minier btn-round btn-primary">hapus</a> -->
                                    </td>
                                    <?php } else { ?>
                                    <td>
                                       <a href="<?php echo base_url('Datakarantina/editDetail/') . $dtl['detail_id']; ?>" class="btn btn-minier btn-round btn-primary" disabled>Edit</a>
                                    </td>
                                    <?php } ?>
                                 </tr>
                                <?php endforeach; 
                              } else { ?>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                 </tr>
                              <?php }?>
                            </tbody>
                            <tfoot>
                               <tr>
                                  <td colspan="12">Jumlah Data Karantina : <strong><?php echo count($detail); ?> Orang</strong></td>
                               </tr>
                               <tr>
                                  <td colspan="12"><a href="<?php echo base_url('Datakarantina/index'); ?>" class="btn btn-sm btn-primary">Kembali</a></td>
                               </tr>
                            </tfoot>
                        </table>
                    </div>
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

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>

<script>
   
   //template tabel pencarian
   $('#dataTables-listTK').dataTable({
            "order" : ['0','desc']
      });
   
   //datepicker
   $(function($) {
      $('.datepick').datepicker({
         autoclose:true,
         format: 'dd-mm-yyyy'
        });
      });

   
</script>
