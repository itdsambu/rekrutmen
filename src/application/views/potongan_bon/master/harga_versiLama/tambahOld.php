<link rel="stylesheet" href="<?php echo base_url()?>assets/class/select2.css"/>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">TAMBAH MASTER HARGA</h4>
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
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_mst_harga');?>">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                      <div class="col-lg-12">
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Tanggal</label>
                      		<div class="col-sm-4">
                      			<input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d')?>">
                      		</div>
                      	</div>
                      	<div class="form-group">
                            <label class="col-lg-2 control-label">Pemborong</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="txtPemborong" id="pemborong" onchange="callAjax()">
                                    <?php if(count($_getDataPemborong)>1){$selected ='';}else{$selected='selected';} ?>                                   <option value="">- Pilih -</option>
                                    <?php foreach($_getDataPemborong as $pbr){
                                        echo "<option value='".$pbr->IDPemborong."' ".$selected.">".$pbr->Pemborong."</option>";
                                    }?>
                                </select>
                            </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                           <div class="table-responsive" id="tbllist">
                           <table class="table table-bordered" id="dataTables">
                            <thead>
                              <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nama Item</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Harga</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($_getDataItem as $itm){?>
                                <tr>
                                    <td class="text-center"><?php echo $no++;?>
                                        <input type="hidden" name="">
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control" style="width: 100%;" name="txtNamaItem[]" value="<?php echo $itm->NamaItem?>" >
                                        <input type="hidden" name="txtItemID[]" value="<?php echo $itm->ItemID?>">
                                    </td>
                                    <td>
                                       <input type="text" name="txtNamaSatuan[]" value="<?php echo $itm->SingkatanSatuan?>">
                                       <input type="hidden" name="txtSatuanID[]" value="<?php echo $itm->SatuanID?>">
                                    </td>
                                    <td>
                                        <input type="text" name="txtNamaKategori[]" value="<?php echo $itm->NamaKategori?>">
                                        <input type="hidden" name="txtKategoriID[]" value="<?php echo $itm->KategoriID?>">
                                    </td>
                                    <td>
                                        <input type="text" name="txtHarga[]" class="form-control" value="0">
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
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
   $(document).ready(function() {
        $('#dataTables').dataTable();
        var jmlData = "<?php echo count($_getDataPemborong);?>";
        if(jmlData == 1){
            callAjax();
            console.log("jalan langsung");
        }
    });
</script>
<script type="text/javascript">
    function callAjax(){
        var pemborong = $('#pemborong').val();

        $.ajax({
        type: "GET",
        dataType: "html",
        url: "<?php echo base_url('PotonganBon/ajax_pemborong')?>"+"/"+pemborong,
        success: function(msg){
              if(msg == ''){
                alert('Tidak ada data');
              } 
              else{
                  $("#tbllist").html(msg);                                                     
              }
          }
       });
    }
</script>