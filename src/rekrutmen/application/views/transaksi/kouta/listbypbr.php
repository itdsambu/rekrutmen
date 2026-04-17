<div class="page-header">
    <h1>
        Transaksi
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Kouta TK Pemborong
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12" id="controlsetup">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">List Kouta TK Pemborong</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTables" class="table table-bordered table-hover table-primary">
                            <thead class="bg-primary">
                                <tr>
                                    <th>RegID</th>
                                    <th>Nama</th>
                                    <th>CVNama</th>
                                    <th>Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($_getPBR as $row){?>
                                <tr>
                                    <td><?php echo $row->HeaderID?></td>
                                    <td><?php echo $row->Nama?></td>
                                    <td><?php echo $row->CVNama?></td>
                                    <td><?php echo $row->Periode?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#dataTables').dataTable({
            "order": [[0,'desc']]
        });
    })
</script>