
<table class="table table-hover hover-tab table-striped table table-striped table-hover table-bordered" id="getListPra">
    <thead>
        <tr>
            <th class="text-center">Nik</th>
            <th class="text-center">Nama Lengkap</th>
            <th class="text-center">Pemborong</th>
            <th class="text-center">Dept/Bag</th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach($_getTK as $key){?>
            <tr id="<?php echo $key->FixNo?>" onclick="pilih_nik('<?=trim($key->FixNo);?>')" data-dismiss="modal" class="text-center">
                <!-- <td id="<?php echo $key->FixNo?>" onclick="pilih_nik('<?=trim($key->FixNo);?>')" data-dismiss="modal" class="text-center"> -->
                <input type="hidden" name="txtNik"  value="<?php echo $key->Nik?>">
                <input type="hidden" name="txtFixNo"  value="<?php echo $key->FixNo?>">
                <!-- <input type="hidden" name="txtPemborong" id="SubPemborong" value="<?php echo $key->IDSubPemborong?>"> -->
                <input type="hidden" name="txtPemborong" id="SubPemborong" value="<?php echo $key->IDToko?>">
                <input type="hidden" name="txtPemborong" id="Pemborong" value="<?php echo $key->IDPemborongNew?>">

                <!-- </td> -->
                <td><?php echo $key->Nik?></td>
                <td><?php echo $key->Nama?></td>
                <td class="text-center"><?php echo $key->Pemborong?></td>
                <td class="text-center"><?php echo $key->BagianAbbr?></td>
            </tr>
            <?php 
        }?>
    </tbody>
</table>
<script type="text/javascript">
    function pilih($id){
        var id = $id;
        var pbr = $('#pemborong').val();
        alert(id);
        alert(pbr);
            // $.ajax({
            //     type: "POST",
            //     dataType: "html",
            //     url : "<?php echo site_url('PotonganBon/ajaxDataTK')?>",
            //     data: {
            //         'id' : id,
            //         'pbr' : pbr,
            //     },
            //     success: function(msg){
            //         $('#ajaxformmodal').html(msg);
            //     }
            // });
    };
</script>