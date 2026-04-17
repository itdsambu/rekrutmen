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
        <h4 class="widget-title">Monitoring Data Karantina Tenaga Kerja PT. Pulau Sambu - Guntung</h4>
    </div>
            <div class="widget-body">
                <div class="widget-main">
                <!-- Design Disini -->
                    <div class="table-responsive">
                        <table id="dataTables-listTK" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal Input</th>
                                    <th>Nama Pemborong</th>

                                    <th>Di Update Oleh</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($view as $vi) : ?>
                                <tr>
                                    <td><?php echo date('d-m-Y', strtotime($vi['create_date'])); ?></td>
                                    <td><?php echo $vi['nama_pemborong']; ?></td>

                                    <td><?php echo $vi['update_by']; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('Datakarantina/detail/') . $vi['header_id']; ?>" class="btn btn-primary btn-sm">Detail</a> |
                                        <!-- <a href="<?php //echo base_url('Datakarantina/edit/') . $vi['header_id']; ?>" class="btn btn-success btn-sm">Edit</a> | -->
                                        <a href="<?php echo base_url('Datakarantina/cetak/') . $vi['header_id']; ?>" class="btn btn-yellow btn-sm" target="_blank">Cetak</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </>
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
            "order" : ['3','desc']
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