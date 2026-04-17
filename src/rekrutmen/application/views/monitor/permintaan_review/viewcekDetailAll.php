<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Identifikasi
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">List Identifikasi Karyawan Approved</h4>

                        <div class="widget-toolbar">
                        </div>
                        <div class="widget-toolbar">
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main"> 
                            <div class="table-responsive">
                                <table id="dataTables-listTK" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">ID</th>
                                        <th rowspan="2">TransID</th>
                                        <th rowspan="2">Departemen</th>
                                        <th rowspan="2">Pekerjaan</th>
                                        <th rowspan="2">NAMA</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach($_getTrans as $row):?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row->HeaderID; ?></td>
                                            <td><?php echo $row->TransID; ?></td>
                                            <td><?php echo $row->DeptAbbr; ?></td>
                                            <td><?php echo $row->Pekerjaan; ?></td>
                                            <td><?php echo $row->Nama; ?></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-listTK').dataTable({
            "order": [[0,'desc']]
        });
    });
</script>
