<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Master Satuan</h4>
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
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-lg-11 control-label"></label>
                                <div class="col-sm-1">
                                    <a href="<?php echo site_url('PotonganBon/tambah_mst_satuan')?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Satuan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form class="form-horizontal" role="form" method="POST" >
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                      <div class="col-lg-12" id="tbllist">
                        <div class="table-responsive">
                           <table class="table table-bordered" id="dataTables">
                            <thead>
                              <tr>
                                <th class="text-center">Nama Satuan</th>
                                <th class="text-center">Singkatan</th>
                                <th class="text-center">Created By</th>
                                <th class="text-center">Updated By</th>
                                <th class="text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
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
        $('#dataTables').dataTable();
    });
</script>