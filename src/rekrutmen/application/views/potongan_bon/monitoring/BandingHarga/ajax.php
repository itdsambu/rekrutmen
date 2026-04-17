<table class="table table-bordered" id="dataTables">
<thead>
  <tr>
    <th class="text-center" style="background-color: #d9edf7;width: 10px;">No.</th>
    <th class="text-center" style="background-color: #d9edf7;width: 50px;">Kode Item</th>
    <th class="text-center" style="background-color: #d9edf7;width: 200px;">Nama Item</th>
    <th class="text-center" style="background-color: #d9edf7;width: 80px;">Barcode</th>
    <th class="text-center" style="background-color: #d9edf7;width: 50px;">Singkatan</th>
    <th class="text-center" style="background-color: #d9edf7;width: 50px;">Kategori</th>
    <th class="text-center" style="background-color: #d9edf7;width: 50px;">Cv Perusahaan</th>
    <th class="text-center" style="background-color: #d9edf7;width: 50px;">Harga</th>
  </tr>
</thead>
<tbody>
    <?php 
    $no = 1;
    foreach($getData as $get){?>
    <tr>
        <td class="text-center"><?php echo $no++;?></td>
        <td><?php echo $get->KodeItem?></td>
        <td><?php echo $get->NamaItem?></td>
        <td><?php echo $get->KodeBarkode?></td>
        <td><?=$get->SingkatanSatuan?></td>
        <td><?=$get->NamaKategori?></td>
        <td>
            <table class="table table-bordered">
                <?php foreach($getItem as $itm){
                    if($get->ItemID == $itm->ItemID){?>
                    <tr>
                        <td><?php echo $itm->Perusahaan?></td>
                    </tr>
                <?php } }?>
            </table>
        </td>
        <td>
            <table class="table table-bordered">
                <?php foreach($getItem as $itm){
                    if($get->ItemID == $itm->ItemID){?>
                    <tr>
                        <td>Rp.<?php echo number_format($itm->Harga,0,",",".")?></td>
                    </tr>
                <?php } }?>
            </table>
        </td>
    </tr>
    <?php }?>
</tbody>
</table>
