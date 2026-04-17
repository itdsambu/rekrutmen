<div class="col-xs-6">
    <div id="tblPemborong" class="table table-responsive">
        <table id="dataTables-listTK" class="highchart table table-bordered" data-graph-container="#graphcontainer" data-graph-type="column">
            <thead>
                <tr>
                    <th>Nama Pemborong</th>
                    <th>Total Input Tgl : <?php echo $_getTgl;?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_getData as $row): 
                ?>
                <tr>
                    <td><?php echo $row->Pemborong;?></td>
                    <td><?php echo $row->TotalDaftar;?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="col-xs-6">
    <div id="tblPemborongBln" class="table table-responsive">
        <table id="dataTables-listTKbln" class="highchart table table-bordered" data-graph-container="#graphcontainer" data-graph-type="column">
            <?php
                $thn    = substr($_getTgl, 0, 4);
                $bln    = substr($_getTgl, 5, 2);
                $awal   = $thn."-".$bln."-01";
            ?>
            <thead>
                <tr>
                    <th>Nama Pemborong</th>
                    <th>Total Input dari Tgl <?php echo $awal;?> s/d <?php echo $_getTgl;?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_getBuln as $row): 
                ?>
                <tr>
                    <td><?php echo $row->Pemborong;?></td>
                    <td><?php echo $row->TotalDaftar;?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!--<div id="graphcontainer" class="col-xs-12"></div>
<div id="graphcontainerBln" class="col-xs-12"></div>

<script src="<?php echo base_url(); ?>assets/hc/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/hc/js/jquery.highchartTable-min.js"></script>
<script>
    $(document).ready(function(){
        // Do chart before turning table into a datatable
        $('#dataTables-listTK').highchartTable();
        $('#dataTables-listTKbln').highchartTable();

    });
</script>-->