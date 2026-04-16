<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Identifikasi
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="table-responsive">
	<div class="widget-header">
		<h4 class="widget-title">List Identifikasi</h4>
	</div>
    <table id="dataTables-cek" class="table table-striped table-bordered table-hover dataTables-cek">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">ID</th>
                <th rowspan="2">TransID</th>
                <th rowspan="2">NAMA</th>
                <th rowspan="2">Status</th>
            </tr>
        </thead>
        <tbody>
        	<?php $no=1; foreach($getTrans as $row):?>
        	<tr data-id='<?php echo $row->HeaderID;?>'>
        		<td><?php echo $no++; ?></td>
                <td><?php echo $row->HeaderID; ?></td>
        		<td><?php echo $row->TransID; ?></td>
        		<td><?php echo $row->Nama; ?></td>
                <td>
                    <a href="<?php echo site_url('monitor/updateidentifikasi')."?hdrid=".$row->HeaderID."&id=".$row->TransID;?>"><i class="fa fa-close"></i></a>
                </td>
        	</tr>
        <?php endforeach;?>
        </tbody>
    </table>
	<br />
	<br />
	<div class="widget-header">
		<h4 class="widget-title">List Success</h4>
	</div>
    <table id="dataTables-cek1" class="table table-striped table-bordered table-hover dataTables-cek">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">ID</th>
                <th rowspan="2">TransID</th>
                <th rowspan="2">NAMA</th>
                <th rowspan="2">Hapus</th>
            </tr>
        </thead>
        <tbody>
        	<?php $no=1; foreach($getTranssucces as $row):?>
        	<tr>
        		<td><?php echo $no++; ?></td>
                <td><?php echo $row->HeaderID; ?></td>
        		<td><?php echo $row->TransID; ?></td>
        		<td><?php echo $row->Nama; ?></td>
                <td><a href="<?php echo site_url('monitor/hapusidentifikasi')."?hdrid=".$row->HeaderID."&id=".$row->TransID;?>"><i class="fa fa-trash"></i></a></td>
        	</tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <br/>
    <div class="widget-header">
        <h4 class="widget-title">List Failed</h4>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-cek').dataTable({
            "order": [[0,'desc']]
        });
    });
</script>