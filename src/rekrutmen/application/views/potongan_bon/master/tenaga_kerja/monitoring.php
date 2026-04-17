<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">LIST TENAGA KERJA</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <form class="form-horizontal" role="form" method="POST">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Pemborong</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="txtPemborong" id="pemborong" onchange="CariSub()">
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
                                <?php $nama_sub = $this->session->userdata('username'); ?>
                                 <select class="form-control" name="txtSubPemborong" id="subpemborong" onchange="Cariitem()">
                                    <option value="">- Pilih -</option>
                                    <?php foreach($_getDataSub as $pbr){
                                        if($nama_sub == $pbr->NamaSub){$selected ='selected';}else{$selected='';}
                                        echo "<option value='".$pbr->IDSubPemborong."' ".$selected.">".$pbr->NamaSub."</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                      <div class="col-lg-12" >
                        <div class="table-responsive" id="tbllistTKerja"> 
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
   $(document).ready(function() {
        $('#dataTables').dataTable();
        CariSub();
        var jmlData = "<?php echo count($_getDataSub);?>";
        if(jmlData == 1){
            console.log("jalan langsung");
        }
    });

    function CariSub()
    {
        console.log("test1");
        var pemborong = $('#pemborong').val();
    
        if(pemborong == ''){

        }else{
            $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_subpbr2')?>"+"/"+pemborong,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#tblSub").html(msg);                                                     
                  }
              }
           });
    }}

    function Cariitem()
    {
        console.log("test2");
            var pemborong = $('#pemborong').val();
            var subpemborong = $('#subpemborong').val();
            
            if(subpemborong == ''){

            }else{
                $('#tbllistTKerja').html('<p style="text-align:center;"><img src="<?php echo base_url();?>assets/images/8REG.gif"></p>');
                $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/ajax_TenagaKerja')?>"+"/"+pemborong+"/"+subpemborong,
                success: function(msg){
                      if(msg == ''){
                        alert('Tidak ada data');
                      } 
                      else{
                          $("#tbllistTKerja").html(msg);                                                     
                      }
                  }
               });
    }}
</script>
