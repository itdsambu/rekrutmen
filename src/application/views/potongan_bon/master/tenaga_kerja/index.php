<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">LIST MASTER TENAGA KERJA</h4>
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
                  echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diinput..!!";
                  echo "</div>";
              }?>
                
            </div>
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/update_subpemborong');?>">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Pemborong</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="txtPemborong" id="pemborong" onchange="get_item_pemborong()">
                                    <?php if(count($_getDataPemborong)>1){$selected ='';}else{$selected='selected';} ?>                                   <option value="">- Pilih -</option>
                                    <?php foreach($_getDataPemborong as $pbr){
                                        echo "<option value='".$pbr->IDPemborong."' ".$selected.">".$pbr->Pemborong."</option>";
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-lg-2 control-label">Sub Pemborong</label>
                            <div class="col-sm-4" id="tblSub">
                                
                            </div>
                        </div>
                      <div class="col-lg-12" >
                        <div class="table-responsive" id="tbllistTK"> 
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label"></label>
                <div class="col-sm-2">
                    <button class="btn btn-sm btn-success">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
   $(document).ready(function() {
        $('#dataTables').dataTable();
        var jmlData = "<?php echo count($_getDataPemborong);?>";
        if(jmlData == 1){
            get_item_pemborong();
            console.log("jalan langsung");
        }
    });

   function get_item_pemborong(){
        var pbr = $('#pemborong').val();

        $('#tbllistTK').html('<p style="text-align:center;"><img src="<?php echo base_url();?>assets/images/8REG.gif"></p>');
        $.ajax({
        type: "GET",
        dataType: "html",
        url: "<?php echo base_url('PotonganBon/ajaxTenagaKerja')?>"+"/"+pbr,
        success: function(msg){
              if(msg == ''){
                alert('Tidak ada data');
              } 
              else{
                  $("#tbllistTK").html(msg);                                                     
              }
          }
       });

        $.ajax({
        type: "GET",
        dataType: "html",
        url: "<?php echo base_url('PotonganBon/ajax_sub')?>"+"/"+pbr,
        success: function(msg){
              if(msg == ''){
                alert('Tidak ada data');
              } 
              else{
                  $("#tblSub").html(msg);                                                     
              }
          }
       });
    }
</script>
