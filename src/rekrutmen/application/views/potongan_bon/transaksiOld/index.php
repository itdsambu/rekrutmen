<link rel="stylesheet" href="<?php echo base_url()?>assets/class/select2.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.css" />
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">TRANSAKSI POTONGAN BON</h4>
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
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_trn_potongan_pemborong');?>">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                      <div class="col-lg-12">
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Tanggal Transaksi</label>
                      		<div class="col-sm-4">
                      			<input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d')?>">
                      		</div>
                      	</div>
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Pemborong</label>
                      		<div class="col-sm-4">
                      			<select class="form-control select2" name="txtPemborong" id="pemborong" onchange="get_item_pemborong()">
                                    <option value="">- Pilih -</option>
                                    <?php foreach($_getDataPemborong as $pbr){
                                        echo "<option value='".$pbr->IDPemborong."'>".$pbr->Pemborong."</option>";
                                    }?>
                                </select>
                      		</div>
                      	</div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">NIK</label>
                            <div class="col-sm-4">
                                <input type="text" name="txtNik" id="nik" class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-sm btn-primary" onclick="cari_tenaga_kerja()"><i class="fa fa-search"></i> Cari By Nik</a>
                            </div>
                        </div>
                        <div id="tkid">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Nama Lengkap</label>
                                <div class="col-sm-4">
                                    <input type="text" name="txtNama" class="form-control" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bagian/Dept</label>
                                <div class="col-sm-4">
                                    <input type="text" name="txtDept" class="form-control" readonly="">
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                           <div class="table-responsive" id="listid">
                            <a class="btn btn-sm btn-warning" onclick="tambah_baris()"><i class="fa fa-plus"></i> Tambah Item</a>
                            <hr>
                           <table class="table table-bordered" id="dataTables">
                            <thead>
                              <tr>
                                <th class="text-center" style="background-color: #d9edf7;"><label class="label label-sm label-default"><i class="fa fa-trash"></i></label>
                                    
                                </th>
                                <th class="text-center" style="background-color: #d9edf7;">Nama Item</th>
                                <th class="text-center" style="background-color: #d9edf7;">Harga (Rp.)</th>
                                <th class="text-center" style="background-color: #d9edf7;">Quantity</th>
                                <th class="text-center" style="background-color: #d9edf7;">Satuan</th>
                                <th class="text-center" style="background-color: #d9edf7;">Kategori</th>
                                <th class="text-center" style="background-color: #d9edf7;">Total</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <a href="" class="btn btn-minier btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                    <td>
                                        <div>
                                            <select class="form-control select2" name="txtItem">
                                                <option value="">- Pilih -</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="txtHarga" value="0">
                                    </td>
                                    <td><input type="number" class="form-control" name="txtQuantity" value="0"></td>
                                    <td>
                                        <input type="text" class="form-control" name="txtSatuan" readonly="">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="txtKategori" readonly="">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="txtTotal" value="0" readonly="">
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-center"><strong>Grand Total</strong></td>
                                    <td>
                                        <input type="text" class="form-control" name="txtGrandTotal" id="grandTotal" value="0">
                                    </td>
                                </tr>
                            </tfoot>
                          </table>
                        </div>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-sm btn-success">Simpan</button>
                    <a href="" class="btn btn-sm btn-default">Kembali</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function cari_tenaga_kerja(){
        var nik = $('#nik').val();
        var pemborong = $('#pemborong').val();

        if(nik == 0){
            alert('Nik Harap Diisi..!!');
        }else{
            $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_tenaga_kerja')?>"+"/"+nik+"/"+pemborong,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#tkid").html(msg);                                                     
                  }
              }
           });
        }
    }

    function get_item_pemborong(){
        var pbr = $('#pemborong').val();

        $.ajax({
        type: "GET",
        dataType: "html",
        url: "<?php echo base_url('PotonganBon/ajax_list_item')?>"+"/"+pbr,
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

<script type="text/javascript">
   $(document).ready(function() {
    $('.select2').select2();
});
</script>
