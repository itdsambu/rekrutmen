<table class="table table-bordered" id="dataTables">
    <thead>
      <tr>
        <th class="text-center" style="background-color: #d9edf7;">No.</th>
        <th class="text-center" style="background-color: #d9edf7;">Nama Item</th>
        <th class="text-center" style="background-color: #d9edf7;">Satuan</th>
        <th class="text-center" style="background-color: #d9edf7;">Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    foreach($GetItem as $itm){?>
        <tr>
            <td class="text-center"><?php echo $no++; ?></td>
            <td><?php echo $itm->NamaItem ?></td>
            <td class="text-center"><?php echo $itm->SingkatanSatuan ?></td>
            <td class="text-center">
                <a class="btn btn-minier btn-round btn-primary" id="<?php echo $itm->ItemID ?>" onclick="input_quantity(this.id)"><i class="glyphicon glyphicon-shopping-cart"></i>
                 <input type="hidden" name="txtPemborong" id="pemborongid" value="<?php echo $pbrid ?>">
                 <input type="hidden" name="txtHeader" id="headerid" value="<?php echo $hdrid ?>">
                 <input type="hidden" name="txtNofix" id="nofix" value="<?php echo $nofix ?>">
                 <!-- <input type="hidden" name="txtItemID" id="itemid" value="<?php echo $itm->ItemID ?>"> -->
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>



<div class="modal fade" id="myModalCari" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Quantity</h4>
            </div>
            <div id="lihat_detail">
              <div class="modal-body">
                
              </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    function input_quantity(id){
        var itemid   = id;
        var pbrid    = $('#pemborongid').val();
        var hdrid    = $('#headerid').val();
        var nofix    = $('#nofix').val();

        // alert(itemid);
        // alert(pbrid);
        // alert(hdrid);
        // alert(nofix);
         $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url('Order/input_quantity')?>"+"/"+itemid+"/"+pbrid+"/"+hdrid+"/"+nofix,
            success: function(msg){
                load_halaman_order();
            }
          });
    } 

    </script>
</div>