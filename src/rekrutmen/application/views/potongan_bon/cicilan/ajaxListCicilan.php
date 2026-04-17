<table class="table table-bordered" id="dataTables1">
    <thead>
    <tr>
        <th class="text-center">No.</th>
        <th class="text-center">Tanggal Order</th>
        <th class="text-center">Nik</th>
        <th class="text-center">Nama</th>
        <th class="text-center">CV</th>
        <th class="text-center">Pemborong</th>
        <th class="text-center">Sub Pemborong</th>
        <th class="text-center">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    foreach($_getListOrder as $get){?>
        <tr>
            <td class="text-center"><?php echo $no++;?></td>
            <td class="text-center"><?php echo date('d-m-Y',strtotime($get->Tanggal));?></td>
            <td class="text-center"><?php echo $get->Nik;?></td>
            <td class="text-left"><?php echo $get->Nama;?></td>
            <td class="text-center"><?php echo $get->Perusahaan;?></td>
            <td class="text-center"><?php echo $get->Pemborong;?></td>
            <td class="text-center"><?php echo $get->NamaSub;?></td>
            <td class="text-center">
                <a href="<?php echo base_url('PotonganBon/lihat_pesanan_cicilan/'.date('Y-m-d',strtotime($get->Tanggal)).'/'.$get->Nofix.'/'.$get->IDSubPemborong.'/'.$get->HeaderID);?>" class="btn btn-minier btn-round btn-success"><i class="glyphicon glyphicon-inbox"></i> Edit</a>
                <!-- <a href="<?php echo base_url('PotonganBon/HapusCicilan/'.$get->HeaderID);?>" class="btn btn-minier btn-round btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus </a> -->
                <a href="#" class="btn btn-minier btn-round btn-danger" id="<?= $get->HeaderID?>" onclick="viewHapus(this.id)"><i class="glyphicon glyphicon-trash"></i> Hapus </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables1').dataTable();
    });
</script>