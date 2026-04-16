<div class="form-horizontal">
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label class="col-sm-11 control-label"></label>
            <div class="col-sm-0">
                <a href="<?php echo base_url('Order/lihat_keranjang?nofix='.$nofix);?>" class="btn btn-sm btn-round btn-warning"><i class="glyphicon glyphicon-shopping-cart"></i><sup><?php echo $hitung;?></sup></a>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
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
        foreach($_getItem as $itm){?>
        <tr>
            <td class="text-center"><?php echo $no++;?></td>
            <td><?php echo $itm->NamaItem?></td>
            <td class="text-center"><?php echo $itm->SingkatanSatuan?>
            </td>
            <td class="text-center">
                <a class="btn btn-minier btn-round btn-primary" id="<?php echo $itm->ItemID ?>" onclick="input_quantity(this.id)"><i class="glyphicon glyphicon-shopping-cart"></i>
                 <input type="hidden" name="txtPemborong" id="pemborongid" value="<?php echo $sub ?>">
                 <input type="hidden" name="txtHeader" id="headerid" value="<?php echo $hdrid ?>">
                 <input type="hidden" name="txtNofix" id="nofix" value="<?php echo $nofix ?>">
                 <!-- <input type="hidden" name="txtItemID" id="itemid" value="<?php echo $itm->ItemID ?>"> -->
                </a>
            </td>
        </tr>
        <?php }?>
    </tbody>
  </table>
</div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable();
    });

    function input_quantity(id){
    var itemid   = id;
    var pbrid    = $('#pemborongid').val();
    var hdrid    = $('#headerid').val();
    var nofix    = $('#nofix').val();

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
