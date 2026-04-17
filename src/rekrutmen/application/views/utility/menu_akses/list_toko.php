<table id="tblMenu" class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th style="width: 100px" class="text-center">
                <label class="pos-rel">
                    <input type="checkbox" class="ace">
                    <span class="lbl"></span>
                </label>
            </th>
            <th>Toko</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($_getPerusahaan as $NamaToko):?>
            <tr>
                <td class="text-center">
                    <label class="pos-rel">
                        <input name="checkList[]" type="checkbox" class="ace" value="<?php echo $NamaToko->IDPerusahaan;?>"/>
                        <span class="lbl"></span>
                    </label>
                </td>
                <td><i class="ace-icon fa fa-check-square purple"></i> <strong><?php echo $NamaToko->Singkatan . ' - ' . $NamaToko->Pimpinan;?></strong>*</td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>