<link rel="stylesheet" href="<?php echo base_url()?>assets/class/select2.css"/>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">MONITORING POTONGAN BON PER SUB</h4>
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
                                <select class="form-control" name="txtPemborong" id="pemborong" onchange="getSubPemborong()">
                                    <option value="">-- Pilih Pemborong --</option>
                                    <?php foreach ($_getDataPemborong as $pbr) {
                                        echo "<option value='$pbr->IDPemborong'>$pbr->Pemborong</option>";
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div id="subpbrid">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Sub Pemborong</label>
                                <div class="col-sm-4" id="tblSub">
                                    <select class="form-control" name="txtSubPemborong" id="subpemborong">
                                        <option value="">-- Pilih Sub Pemborong --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Periode</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="txtPeriode" id="periode">
                                    <option value="">- Pilih -</option>
                                    <option value="1">Periode 1</option>
                                    <option value="16">Periode 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bulan</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="txtBulan" id="bulan">
                                    <?php
                                        $b = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                        $a = 1;
                                        for($i=0; $i<12; $i++){
                                            if((date('n')-1) == $i){
                                                echo "<option value=".$a." selected>".$b[$i]."</option>";
                                            }else{
                                                echo "<option value=".$a.">".$b[$i]."</option>";
                                            }
                                            $a++;
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Tahun</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="txtTahun" id="tahun">
                                    <?php for($i=date('Y')-1;$i<=(date('Y')+2);$i++){
                                        if($i==date('Y')){ ?>
                                        <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
                                        <?php }else{ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php }} ?>
                                </select>
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
                           <div class="table-responsive" id="listid">
                           <table class="table table-bordered" id="dataTables">
                            <thead>
                              <tr>
                                <th class="text-center" style="background-color: #d9edf7;">No.</th>
                                <th class="text-center" style="background-color: #d9edf7;">Nofix</th>
                                <th class="text-center" style="background-color: #d9edf7;">NIK</th>
                                <th class="text-center" style="background-color: #d9edf7;">Nama Lengkap</th>
                                <th class="text-center" style="background-color: #d9edf7;">Total</th>
                                <th class="text-center" style="background-color: #d9edf7;">Actions</th>
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
   $(document).ready(function() {
        $('#dataTables').dataTable({
            paging: false,
            searching : false,
        });
        //  CariSub();
        // var jmlData = "<?php echo count($_getDataSub);?>";
        // if(jmlData == 1){
            
        //     console.log("jalan langsung");
        // }

    });

    function getSubPemborong(){
        var pbr = $('#pemborong').val();

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajaxSubPemborong')?>"+"/"+pbr,
            success: function(msg){
                if(msg == ''){
                    alert('Tidak ada data');
                } 
                else{
                    $("#subpbrid").html(msg);                                                     
                }
            }
       });
    }

    function Ajax_data(){
        console.log("testing");
        var pbr     = $('#pemborong').val();
        var sub     = $('#subpemborong').val();
        var periode = $('#periode').val();
        var bulan   = $('#bulan').val();
        var tahun   = $('#tahun').val();
        
        $('#listid').html('<p style="text-align:center;"><img src="<?php echo base_url();?>assets/images/NewLoading.gif"></p>');
        
        $.ajax({
        type: "GET",
        dataType: "html",
        url: "<?php echo base_url('PotonganBon/ajax_mnt_data_potongan')?>"+"/"+pbr+"/"+sub+"/"+periode+"/"+bulan+"/"+tahun,
        success: function(msg){
              if(msg == ''){
                alert('Tidak ada data');
              } 
              else{
                  $("#listid").html(msg);                                                     
              }
          }
       });
    }
</script>
