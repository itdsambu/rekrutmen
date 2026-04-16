<form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_mst_harga');?>">
<table class="table table-bordered" id="dataTables1">
<div class="form-group">
    <label class="col-lg-2 control-label">Tanggal</label>
    <div class="col-sm-4">
        <input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d')?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Tanggal</label>
    <div class="col-sm-4">
        <select class="form-control" name="txtPemborong" id="pemborong" onchange="CariItem()">
            <?php if(count($_getDataPemborong)>1){$selected ='';}else{$selected='selected';} ?>                                   
            <option value="">- Pilih -</option>
            <?php foreach($_getDataPemborong as $pbr){
                echo "<option value='".$pbr->IDPemborong."' ".$selected.">".$pbr->Pemborong."</option>";
            }?>
        </select>
    </div>
</div>
<thead>
  <tr>
    <th class="text-center" style="background-color: #d9edf7;">No.</th>
    <th class="text-center" style="background-color: #d9edf7;">Nama</th>
    <th class="text-center" style="background-color: #d9edf7;">Satuan</th>
    <th class="text-center" style="background-color: #d9edf7;">Harga</th>
    
  </tr>
</thead>
<tbody id="tblItem">
    
</tbody>
<tfoot>
    <tr>
        <td>
        <button type="submit" class="btn btn-success"> Simpan </button>
        <td>
    </tr>
</tfoot>

</table>
</form>

<script type="text/javascript">
   $(document).ready(function() {
        $('#dataTables').dataTable();
        var jmlData = "<?php echo count($_getDataPemborong);?>";
        if(jmlData == 1){
            CariItem();
            console.log("jalan langsung");
        }
        CariItem();
    });

    function CariItem(){
        console.log("test");
        var pemborong = $('#pemborong').val();

        $.ajax({
        type: "GET",
        dataType: "html",
        url: "<?php echo base_url('PotonganBon/ajax_modal')?>/<?=$id_item;?>"+"/"+pemborong,
        success: function(msg){
              if(msg == ''){
                alert('Tidak ada data');
              } 
              else{
                  $("#tblItem").html(msg);                                                     
              }
          }
       });
    }

</script>