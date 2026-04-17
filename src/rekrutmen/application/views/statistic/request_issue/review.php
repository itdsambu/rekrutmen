    <button class="btn btn-minier btn-success" id="btnExportReview">
        <i class="ace-icon fa fa-file-excel-o bigger-120"></i> Export to Excel
    </button>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTables-review">
        <thead>
            <tr>
                <th >IDReg</th>
                <th >NoFIX</th>
                <th >Nama</th>
                <th >CV/Pemborong</th>
                <th >Dept Tujuan</th>
                <th >L/P</th>
                <th >Tanggal Lahir</th>
                <th >Status</th>
                <th >VGM Approval</th>
                <th >Tgl Posting</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_getTenaker as $row):?>
            <tr>
                <td><?php echo $row->HeaderID; ?></td>
                <td><?php echo $row->Nofix; ?></td>
                <td><?php echo $row->Nama; ?></td>
                <td><?php echo $row->CVNama; ?></td>
                <td><?php echo $row->DeptTujuan; ?></td>
                <td>
                    <?php
                    if($row->Jenis_Kelamin == "M" || $row->Jenis_Kelamin == "LAKI-LAKI"){
                        echo 'L';
                    }  else {
                        echo 'P';
                    }
                    ?>
                </td>
                <td class="text-right"><?php echo date('d F Y', strtotime($row->Tgl_Lahir)); ?></td>
                <td><?php echo ucwords(strtolower($row->Status_Personal)); ?></td>
                <td class="text-right"><?php echo date('d F Y H:i:s', strtotime($row->VGMDate)); ?></td>
                <td class="text-right"><?php echo date('d F Y H:i:s', strtotime($row->tgl_posting)); ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-review').dataTable();
        
        $("#btnExportReview").click(function () {
            $("#tblExport").battatech_excelexport({
                containerid: "dataTables-review"
               , datatype: 'table'
            });
        });
    });
</script>