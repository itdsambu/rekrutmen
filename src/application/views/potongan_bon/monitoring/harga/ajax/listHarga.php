<table class="table table-bordered" id="dataTables1">
  <thead>
    <tr>
      <th class="text-center" style="background-color: #d9edf7;">No.</th>
      <th class="text-center" style="background-color: #d9edf7;">Nama Item</th>
      <th class="text-center" style="background-color: #d9edf7;">Satuan</th>
      <th class="text-center" style="background-color: #d9edf7;">Kategori</th>
      <th class="text-center" style="background-color: #d9edf7;">Harga</th>
      <th class="text-center" style="background-color: #d9edf7;">Catatan</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $no = 1;
    foreach($_getListMntHarga as $get){?>
      <tr>
          <td class="text-center"><?php echo $no++;?></td>
          <td><?php echo $get->NamaItem?></td>
          <td><?php echo $get->NamaSatuan?></td>
          <td><?php echo $get->NamaKategori?></td>
          <td>Rp.<?php echo $get->Harga?></td>
          <td class="text-center"><a href="#" id="<?php echo $get->DetailHargaID?>" class="btn btn-minier btn-primary btn-round" onclick="ajaxCatatan(this.id)"><i class="fa fa-pencil"></i></a></td>
      </tr>
    <?php }?>
  </tbody>
</table>

<!-- Modal Catatan -->
<div class="modal fade" id="MyModalCatatan" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Input Catatan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_catatan_harga');?>">
                  <div id="catatanid">
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Javascript Modal -->
<script type="text/javascript">
    function ajaxCatatan(clicked_id){
        // alert(clicked_id);
        $.post("<?php echo site_url();?>PotonganBon/InputCatatanHarga?id="+clicked_id, function (data){
            $('#catatanid').html(data);
        });
        $('#MyModalCatatan').modal('show');
    }

</script>


<script type="text/javascript">
     $(document).ready(function() {
        $('#dataTables1').dataTable({
        });
    });
</script>