//<!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/class/select2.css"/>
 --><div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">UBAH MASTER ITEM</h4>
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
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/update_mst_item');?>">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                      <div class="col-lg-12">
                        <?php foreach($_getDataItem as $get){?>
                            <input type="hidden" name="txtItemID" value="<?php echo $get->ItemID?>">
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Kode Item</label>
                      		<div class="col-sm-4">
                      			<input type="text" name="txtKodeItem" class="form-control" readonly="" value="<?php echo $get->KodeItem?>" readonly>
                      		</div>
                      	</div>
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Nama Item</label>
                      		<div class="col-sm-4">
                      			<input type="text" name="txtNamaItem" class="form-control" placeholder="Nama Item" value="<?php echo $get->NamaItem?>" readonly>
                      		</div>
                      	</div>
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Satuan</label>
                      		<div class="col-sm-4">
                      			
                                <input type="text" name="txtSatuanid" class="form-control" placeholder="Nama Item" required value="<?php echo $get->SingkatanSatuan?>" readonly>
                                <input type="hidden" name="txtSatuan" class="form-control" placeholder="Nama Item" required value="<?php echo $get->SatuanID?>" readonly>
                      		</div>
                      	</div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kategori Barang</label>
                            <div class="col-sm-4">
                                
                                <input type="text" name="txtKategoriid" class="form-control" placeholder="Nama Item" required value="<?php echo $get->NamaKategori?>" readonly>
                                <input type="hidden" name="txtKategori" class="form-control" placeholder="Nama Item" required value="<?php echo $get->KategoriID?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kode Barcode</label>
                            <div class="col-sm-4">
                                <input type="text" name="txtBarcode" id="Barcode" class="form-control" value ="<?php echo $get->KodeBarkode?>" onkeyup="getSearchBarcode(this.value);" placeholder="Barcode">
                            </div>
                        </div>
                        <?php }?>
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label"></label>
                      		<div class="col-sm-4">
                      			<button class="btn btn-sm btn-success">Simpan</button>
                      		</div>
                      	</div>
                      </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="row" id="dataKode" hidden>
  <div class="col-sm-12 col-lg-12 col-12">
    <div class="form-group">
      <div class="table-responsive">
         <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">Kode Item</th>
              <th class="text-center">Nama Item</th>
              <th class="text-center">Satuan</th>
              <th class="text-center">Kategori</th>
              <th class="text-center">Barcode</th>
              <th class="text-center">dibuat oleh</th>
            </tr>
          </thead>
          <tbody id="bodyKode">
              <tr>
                <td colspan="5" class="text-center">Sedang mencari data item...</td>
              </tr>
          </tbody>
        </table>
      </div>
    </div>  
  </div>  
</div>
<script type="text/javascript">
     $(document).ready(function() {

        // Fungsi Ketika Input Barcode Diisi
        $('#Barcode').on('keydown',function(event){
            // Jika tombol Enter
            if(event.keyCode === 13) {
                event.preventDefault();
                // Ambil Isi Barcode
                var barCode = $('#Barcode').val();
                
            }
        });

      $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
    });
   $(document).ready(function() {
        $('#dataTables').dataTable();
    });

   // $(function(){
   //   $('.select2').select2();
   // });

   function getSearchBarcode(kode){
    if(kode.length >= 3){      
        $.ajax({
            url:"<?=base_url()?>PotonganBon/get_search_barcode",
            type:"POST",
            data:{
                    kode:kode,
                },
            dataType:"JSON",
            error:function(){
                $("#dataKode").attr("hidden", false);
            },
            success:function(response)
            {
              var tbody;
              $("#dataKode").attr("hidden", false);
              if(response.length == 0){
                tbody += `<
                  <tr>
                    <td colspan="5" class="text-center">Data item tidak ditemukan...</td>
                  </tr>`;
              }else{
                console.log(response);
                for(i = 0; i < response.length;i++){
                  tbody += `<
                    <tr>
                      <tr>
                          <td class="text-center">${response[i].KodeItem}</td>
                          <td>${response[i].NamaItem}</td>
                          <td class="text-center">${response[i].SingkatanSatuan}</td>
                          <td class="text-center">${response[i].NamaKategori}</td>
                          <td class="text-center">${response[i].KodeBarkode}</td>
                          <td>
                              <div class="text-left">${response[i].CreatedBy}</div>
                              <div class="text-right smaller-80">${response[i].CreatedDate}</div>
                          </td>                               
                      </tr>
                    </tr>`;
                }
              }
              $("#bodyKode").html(tbody);
            }
        });
    }else{
      $("#dataKode").attr("hidden", true);      
    }
  }
</script>