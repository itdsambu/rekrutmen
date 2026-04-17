<table id="dataTables2" class="table table-striped table-bordered table-hover">
   <thead>
        <tr style="background: #4C87B9;color: #ffffff;">
            <th class="text-center">No</th>
            <th class="text-center">Pemborong</th>
            <th class="text-center">Sub Pemborong</th>  
            <th class="text-center">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1;
        $total = 0;
        foreach($getDataPemborong as $key=>$get){

            $total += $get->Jumlah;
            ?>
                <td class="text-center"><?php echo $key+1;?></td>
                <td><?php echo $get->Pemborong?></td>
                <td><?php echo $get->NamaSub?></td>
                <td class="text-center"><?php echo $get->Jumlah?>
                </td>
            </tr>
        <?php $i++; }?>
    </tbody>   
</table>
<br>
<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-3">
        <a href="<?php echo base_url();?>PotonganBon/EksportExcelList/<?php echo $tanggal ?>" class="btn btn-sm btn-round btn-primary">
            <i class="fa fa-excel"></i>
            Export To Excell
        </a>
   </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables2').dataTable();
    });
</script>