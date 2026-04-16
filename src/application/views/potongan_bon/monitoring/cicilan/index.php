<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">MONITORING CICILAN</h4>
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
                                <select class="form-control" name="txtPemborong" id="pemborong" onchange="CariSub()">
                                    <?php if(count($_getDataPemborong)>1){$selected ='';}else{$selected='selected';} ?>                                   
                                    <option value="">- Pilih Pemborong -</option>
                                    <?php foreach($_getDataPemborong as $pbr){
                                        echo "<option value='".$pbr->IDPemborong."' ".$selected.">".$pbr->Pemborong."</option>";
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">CV Perusahaan</label>
                            <div class="col-sm-4" id="tblSub">
                            <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Periode</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="txtPeriode" id="periode">
                                    <option value="">- Pilih Periode -</option>
                                    <option value="1">Periode 1</option>
                                    <option value="16">Periode 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bulan</label>
                            <div class="col-sm-4">
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
                            <div class="table-responsive" id="tbllistmntcicilan">
                               <table class="table table-bordered" id="dataTables">
                                <thead>
                                  <tr>
                                    <th class="text-center" style="background-color: #d9edf7;">No.</th>
                                    <!-- <th class="text-center" style="background-color: #d9edf7;">Fixno</th> -->
                                    <th class="text-center" style="background-color: #d9edf7;">Nama</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Nik</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Dept</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Item Cicilan</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Quantity</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Harga Total</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Dp</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Harga Yang  Harus Dibayar</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Jumlah  Periode Cicilan</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Periode  Pemotongan</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Nominal  Cicilan</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Total Periode  Yang Sudah Tercicil</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Total Periode  Yang Belum Tercicil</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Sisa Cicilan  Yang Harus Dilunasu</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <!-- <td></td> -->
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
    $(document).ready(function() {
        $('#dataTables').dataTable({
            paging: false,
            searching : false,
        });
         CariSub();
        var jmlData = "<?php echo count($_getDataSub);?>";
        if(jmlData == 1){
            
            console.log("jalan langsung");
        }

    });

    function CariSub(){
        console.log("test");
        var pemborong = $('#pemborong').val();

        if(pemborong == ''){

        }else{
            $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/MntSub')?>"+"/"+pemborong,
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

    function Ajax_data(){
        var pbr = $('#pemborong').val();
        var sub = $('#subpemborong').val();
        var periode = $('#periode').val();
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();

        $('#tbllistmntcicilan').html('<p style="text-align:center;"><img src="<?php echo base_url();?>assets/images/NewLoading.gif"></p>');
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajaxMntCicilan')?>"+"/"+pbr+"/"+sub+"/"+periode+"/"+bulan+"/"+tahun,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#tbllistmntcicilan").html(msg);                                                     
                  }
              }
           });

    }
</script>