<table class="table table-bordered" id="dataTables1">
<thead>
  <tr>
    <th class="text-center" style="background-color: #d9edf7;">No.</th>
    <th class="text-center" style="background-color: #d9edf7;">NIK</th>
    <th class="text-center" style="background-color: #d9edf7;">Nama Lengkap</th>
    <th class="text-center" style="background-color: #d9edf7;">Dept</th>
    <th class="text-center" style="background-color: #d9edf7;">Total</th>
    <th class="text-center" style="background-color: #d9edf7;">Actions</th>
  </tr>
</thead>
<tbody>
    <?php 
    $no = 1;
    foreach($_getData as $get){?>
    <tr>
        <td class="text-center"><?php echo $no++;?></td>
        <td class="text-center"><?php echo $get->Nik?></td>
        <td><?php echo $get->Nama?></td>
        <td class="text-center"><?php echo $get->Bagian?></td>
        <td class="text-center">
            <input type="text" name="txtTotal" value="Rp. <?php foreach($_getTotal as $key){
                if($get->Nofix == $key->Nofix){
                    echo number_format($key->GrandTotal,0,",",".");
                }}?>" readonly>
        </td>
        <td class="text-center">
            <a href="#" class="btn btn-minier btn-primary" id="<?php echo $get->Nofix?>" onclick="get_detail_potongan(this.id);">Detail
                <input type="hidden" name="txtTglAwal" id="tglAwal" value="<?php echo $tglAwal;?>">
                <input type="hidden" name="txtTglAkhir" id="tglAkhir" value="<?php echo $tglAkhir;?>">
            </a>
        </td>
    </tr>
    <?php }?>
</tbody>
<tfoot>
    <tr>
        
    </tr>
</tfoot>
</table>

<script type="text/javascript">
     $(document).ready(function() {
        $('#dataTables1').dataTable({
        });
    });
</script>

