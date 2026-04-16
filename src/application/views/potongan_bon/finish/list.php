<table class="table table-bordered" id="dataTables1">
<thead>
  <tr>
    <th class="text-center" style="background-color: #d9edf7;">No.</th>
    <th class="text-center" style="background-color: #d9edf7;">NIK</th>
    <th class="text-center" style="background-color: #d9edf7;">Nama Lengkap</th>
    <th class="text-center" style="background-color: #d9edf7;">Dept</th>
    <th class="text-center" style="background-color: #d9edf7;">Total</th>
    <th class="text-center" style="background-color: #d9edf7;">Total Realisasi</th>
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
        <td class="text-center"><?php echo $get->BagianAbbr?></td>
        <td class="text-center">Rp. <?php echo number_format($get->GrandTotal,0,",","."); ?></td>
        <td class="text-center">
            <?php if($get->GrandTotalRealisasi): ?>
                Rp. <?php echo number_format($get->GrandTotalRealisasi,0,",","."); ?>
            <?php else: ?>
                Belum diatur
            <?php endif;?>
        </td>
        <td class="text-center">
            <?php if($get->GrandTotalRealisasi): ?>
                <a href="<?=base_url();?>PotonganBon/TransaksiAkhir_komplit/<?php echo $get->Nofix;?>/<?=$tglAwal;?>/<?=$tglAkhir;?>/<?=date('Ym',strtotime($tglAwal)).str_pad($periode,2,'0',STR_PAD_LEFT);?>" class="btn btn-minier btn-success">Komplit</a>
            <?php else: ?>
                <a href="<?=base_url();?>PotonganBon/TransaksiAkhir_seleksi/<?php echo $get->Nofix;?>/<?=$tglAwal;?>/<?=$tglAkhir;?>/<?=$periode;?>" class="btn btn-minier btn-primary">Proses</a>
            <?php endif;?>

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