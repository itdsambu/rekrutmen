<select class="form-control" id="inputTransaksi" name="comboTansaksi">
    <option value=""> -- Pilih </option>
    <option value="1"> HARIAN </option>
    <?php foreach ($_getBagian as $row):?>
        <option value="<?php echo $row->IDPekerjaan;?>"> <?php echo $row->Pekerjaan;?> </option>
    <?php endforeach; ?>
</select>