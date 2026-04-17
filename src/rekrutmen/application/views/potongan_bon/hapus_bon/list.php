<table class="table table-bordered" id="dataTables1">
<thead>
  <tr>
    <th class="text-center" style="background-color: #d9edf7;">No.</th>
    <th class="text-center" style="background-color: #d9edf7;">NIK</th>
    <th class="text-center" style="background-color: #d9edf7;">Nama Lengkap</th>
    <th class="text-center" style="background-color: #d9edf7;">Dept</th>
    <th class="text-center" style="background-color: #d9edf7;">Total</th>
  </tr>
</thead>
<tbody>
    <?php 
    $no = 1;
    foreach($_getData as $get){?>
    <tr>
        <td class="text-center"><?php echo $no++;?></td>
        <td class="text-center"><?php echo $get->Nik?></td>
        <td><?php echo $get->NAMA?></td>
        <td class="text-center"><?php echo $get->BagianAbbr?></td>
        <td class="text-center">
           <a href="<?=base_url();?>PotonganBon/detailhdr/<?= rtrim(base64_encode($get->Nofix),'=')?>/<?= $get->periodegajian;?>" class="btn btn-minier btn-primary">Rp. <?php echo number_format($get->total,0,",","."); ?></a>
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