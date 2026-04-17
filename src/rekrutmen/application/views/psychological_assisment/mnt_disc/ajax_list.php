<table class="table table-bordered" id="dataTables2">
  <thead>
    <tr>
      <th class="text-center" style="background-color: #d9edf7;">No.</th>
      <th class="text-center" style="background-color: #d9edf7;">ID Register</th>
      <th class="text-center" style="background-color: #d9edf7;">Nama Lengkap</th>
      <th class="text-center" style="background-color: #d9edf7;">Jenis Kelamin</th>
      <th class="text-center" style="background-color: #d9edf7;">Usia</th>
      <th class="text-center" style="background-color: #d9edf7;">Tanggal Tes</th>
      <th class="text-center" style="background-color: #d9edf7;">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $no = 1;
    foreach($_getDataHdr as $hdr){?>
      <tr>
          <td class="text-center"><?php echo $no++;?></td>
          <td class="text-center"><?php echo $hdr->RegisterID;?></td>
          <td><?php echo $hdr->Nama;?></td>
          <td class="text-center"><?php echo $hdr->Jenis_Kelamin;?></td>
          <td class="text-center"><?php echo $hdr->Usia;?></td>
          <td class="text-center"><?php echo $hdr->TanggalTes;?></td>
          <td class="text-center">
            <a href="#" id="<?php echo $hdr->HasilHdrID?>" class="btn btn-sm btn-round btn-warning" onclick='hasil(this.id)'>Lihat Hasil</a>
            <a href="#" id="<?php echo $hdr->HasilHdrID?>" class="btn btn-sm btn-round btn-primary" onclick="gambaranDiri(this.id)">Hasil</a>
          </td>
      </tr>
    <?php }?>
  </tbody>
</table>

<script type="text/javascript">
   $(document).ready(function() {
        $('#dataTables2').dataTable({
            paging: false,
            searching : false,
        });
    });
</script>

<!-- Modal Lihat hasil -->
<div class="modal fade" id="MyModalMenu" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header"> <!--style="background-color: #008cba">-->                
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">HASIL TES DISC :</h4>
          </div>
          <div id="lihat_detail">
            <div class="modal-body">
              <hr>
            </div>
          </div>
      </div>
  </div>
</div>
<!-- Javascript Modal -->
<script type="text/javascript">
    function hasil(clicked_id) {
        // alert(clicked_id);
        $.post("<?php echo site_url(); ?>Mnt_DISC/lihat_hasil_test?id=" + clicked_id, function(data) {
            $('#lihat_detail').html(data);
        });
        $('#MyModalMenu').modal('show');
    }

</script>

<!-- Modal Hasil Gambaran diri -->
<div class="modal fade" id="MyModalGambaranDiri" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header"> <!--style="background-color: #008cba">-->                
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">GAMBARAN DIRI : </h4>
          </div>
          <div id="lihat_detail2">
            <div class="modal-body">
              <hr>
            </div>
          </div>
      </div>
  </div>
</div>
<!-- Javascript Modal -->
<script type="text/javascript">
    function gambaranDiri(clicked_id) {
        // alert(clicked_id);
        $.post("<?php echo site_url(); ?>Mnt_DISC/hasil_gambaran_diri?id=" + clicked_id, function(data) {
            $('#lihat_detail2').html(data);
        });
        $('#MyModalGambaranDiri').modal('show');
    }

</script>