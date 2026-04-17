
    <?php 
    $no = 1;
    foreach($_getDataItem as $get){?>
    <tr>
        <td class="text-center" id=""><?php echo $no++;?>
            <input type="hidden" name="txtHeaderid">
        </td>
        <td class="text-center" id=""><?php echo $get->NamaItem?>
            <input type="hidden" name="TxtItemID" id="TxtItemID" value="<?php echo $get->ItemID?>">
        </td>
        <td><?php echo $get->NamaSatuan?>
            <input type="hidden" id="txtSatuanID" name="txtSatuanID" value="<?php echo $get->SatuanID?>">
            <input type="hidden" name="txtKategoriID" id="txtKategoriID" value="<?php echo $get->KategoriID?>">
        </td>
        <td class="text-center">
            <input id="harga" name="txtHarga" value="<?php echo $get->Harga?>">
        </td>
    </tr>
    <?php }?>
