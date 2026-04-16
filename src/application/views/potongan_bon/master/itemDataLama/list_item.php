<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">LIST MASTER ITEM</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
            <?php if($this->input->get('msg') == "success"){
                  echo "<div class='alert alert-success'>";
                  echo "<strong>Sukses !!!</strong> Data berhasil di Simpan.";
                  echo "</div>";
              }elseif($this->input->get('msg') == "failed"){
                  echo "<div class='alert alert-danger'>";
                  echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diregistrasi..!!";
                  echo "</div>";
              }?>
                
            </div>
            <form class="form-horizontal" role="form" method="POST" >
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                      <div class="col-lg-12" id="tbllist">
                        <div class="table-responsive">
                           <table class="table table-bordered" id="dataTables">
                            <thead>
                              <tr>
                                <th class="text-center">Kode Item</th>
                                <th class="text-center">Nama Item</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Barcode</th>
                                <th class="text-center">Created By</th>
                                <th class="text-center">Updated Barcode</th>
                               <th class="text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <a href="<?php echo site_url('PotonganBon/tambah_mst_item')?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Item</a>
                        </div>
                    </div> -->
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
   $(document).ready(function() {
        $('#dataTables').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('PotonganBon/getMstItem')?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [ 0 ],
                "orderable": false,
            },],
        });
    });
</script>
<div class="modal fade" id="myModalCari" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">TAMBAH HARGA PER ITEM</h4>
            </div>
            <div class="modal-body">
                <div id="lihat_detail" class="well">
                    
                    <div id="getListPra">
                        <table class="table table-hover table-striped table table-striped table-hover table-bordered">
                            <thead>
                            <tr>
                                <th style="text-align: center">Nama Item</th>
                                <th style="text-align: center">Satuan</th>
                                <th style="text-align: center">Kategori</th>
                                <th style="text-align: center">Harga</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td></td>

                            </tr>
                            </tbody>
                                               
                        </table>  
                                             
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>

    function openModal(id){
        var ItemID = id;
        
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/modalItem')?>"+"/"+ItemID,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $('#lihat_detail').html(msg);                                                      
                  }
              }
       });
        
        $('#myModalCari').modal('show');
    }
</script>
</div>