<link rel="stylesheet" href="<?php echo base_url()?>assets/class/select2.css"/>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">PERBANDINGAN HARGA</h4>
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
            <form class="form-horizontal" role="form" method="POST" action="#">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Pemborong</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="txtPemborong" id="pemborong">
                                    <?php if(count($_getDataPemborong)>1){$selected ='';}else{$selected='selected';} ?>                                   
                                    <option value="0">- Pilih Pemborong -</option>
                                    <?php foreach($_getDataPemborong as $pbr){
                                        echo "<option value='".$pbr->IDPemborong."' ".$selected.">".$pbr->Pemborong."</option>";
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kategori</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" name="txtKategori" id="kategori" onchange="ajax_kategori()">
                                    <option value="0">- Pilih Kategori -</option>
                                    <?php foreach($_getMstKategori as $ktg){
                                        echo "<option value='$ktg->KategoriID'>".$ktg->NamaKategori."</option>";
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div id="itemid">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Item</label>
                                <div class="col-sm-4">
                                    <!-- <select class="form-control select2" name="txtItem" id="item">
                                        <option value="0">- Pilih Item -</option>
                                        <?php foreach($_getItem as $itm){
                                            echo "<option value='$itm->ItemID'>".$itm->NamaItem."</option>";
                                        }?>
                                    </select> -->
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label"></label>
                            <div class="col-sm-4">
                                <a href="#" class="btn btn-sm btn-success" onclick="Ajax_data()"><i class="fa fa-search"></i> Cari</a>
                            </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive" id="tbllistharga">
                               <table class="table table-bordered" id="dataTables">
                                <thead>
                                  <tr>
                                    <th class="text-center" style="background-color: #d9edf7;">No.</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Kode Item</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Nama Item</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Barcode</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Singkatan</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Kategori</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Pemborong</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Sub Pemborong</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Harga</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        
                                    </tr>
                                </tfoot>
                              </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>



<script type="text/javascript">
    // $(document).ready(function () {
    //     $('.select2').select2();
    // });
    function Ajax_data(){
        var pbr = $('#pemborong').val();
        var ktgri = $('#kategori').val();
        var itm = $('#item').val();

        //alert(pbr);

        $('#tbllistharga').html('<p style="text-align:center;"><img src="<?php echo base_url();?>assets/images/NewLoading.gif"></p>');
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajaxBandingHarga')?>"+"/"+pbr+"/"+ktgri,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#tbllistharga").html(msg);                                                     
                  }
              }
           });

    }
    function ajax_kategori(){
        var kategori = $('#kategori').val();

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ItemByKategori')?>"+"/"+kategori,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#itemid").html(msg);                                                     
                  }
              }
           });
    }
</script>