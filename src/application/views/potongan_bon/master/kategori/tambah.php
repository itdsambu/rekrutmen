
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">TAMBAH MASTER KATEGORI</h4>
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
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_mst_kategori');?>">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                      <div class="col-lg-12">
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Nama Kategori</label>
                      		<div class="col-sm-4">
                      			<input type="text" name="txtNamaKategori" class="form-control" placeholder="Nama Kategori">
                      		</div>
                      	</div>
                        
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Status</label>
                      		<div class="col-sm-4">
                      			<select class="form-control" name="txtStatus">
                      				<option value="1" selected="">Aktif</option>
                      				<option value="0">Tidak Aktif</option>
                      			</select>
                      		</div>
                      	</div>
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

<script type="text/javascript">
   $(document).ready(function() {
        $('#dataTables').dataTable();

        $(document).on('keyup', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });
    });
</script>