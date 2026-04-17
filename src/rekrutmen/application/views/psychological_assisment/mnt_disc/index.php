<?php
/* 
 */
?>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery.battatech.excelexport.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">MONITORING DISC</h4>
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
                            <label class="col-lg-2 control-label">Tanggal Tes</label>
                            <div class="col-sm-4">
                                <input type="date" name="txtTanggalTes" id="tanggaltes" class="form-control" value="<?php echo date('Y-m-d')?>">
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
                                <th class="text-center" style="background-color: #d9edf7;">ID Register</th>
                                <th class="text-center" style="background-color: #d9edf7;">Nama Lengkap</th>
                                <th class="text-center" style="background-color: #d9edf7;">Jenis Kelamin</th>
                                <th class="text-center" style="background-color: #d9edf7;">Usia</th>
                                <th class="text-center" style="background-color: #d9edf7;">Tanggal Tes</th>
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
                                    <td></td>
                                </tr>
                            </tbody>
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
    });
</script>
<script type="text/javascript">
    function Ajax_data(){
        var tanggal = $('#tanggaltes').val();

        $('#listid').html('<p style="text-align:center;"><img src="<?php echo base_url();?>assets/images/NewLoading.gif"></p>');

        $.ajax({
        type: "GET",
        dataType: "html",
        url: "<?php echo base_url('Mnt_DISC/ajax_data_test')?>"+"/"+tanggal,
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