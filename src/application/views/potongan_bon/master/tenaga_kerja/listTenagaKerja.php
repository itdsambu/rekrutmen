<table class="table table-bordered" id="dataTables1">
<thead>
  <tr>
    <th class="text-center">No</th>
    <th class="text-center">Nofix</th>
    <th class="text-center">NIK</th>
    <th class="text-center">Nama Lengkap</th>
    <th class="text-center">Tanggal Lahir </th>
    <th class="text-center">Nama Ibu </th>
    <th class="text-center">Dept / Bagian</th>
    <th class="text-center">Sub Pemborong</th>
  </tr>
</thead>
<tbody>
    <?php 
        $no = 1;
        foreach($_getTK as $get){?>
            <tr>
                <td class="text-center" id=""><?php echo $no++;?></td>
                <td class="text-center"><?php echo $get->Nofix ?></td>
                <td><?php echo $get->Nik ?></td>
                <td class="text-center"><?php echo $get->Nama ?></td>
                <td class="text-center"><?php echo date('d-m-Y',strtotime($get->TanggalLahir)) ?></td>
                <td class="text-center"><?php echo $get->NamaIbuKandung ?></td>
                <td class="text-center"><?php echo $get->Bagian ?></td>
                <td class="text-center"><?php echo $get->NamaSub ?></td>
            </tr>
    <?php }?>
</tbody>
</table>     
<script type="text/javascript">
   $(document).ready(function() {
        $('#dataTables1').dataTable();
    });
</script>