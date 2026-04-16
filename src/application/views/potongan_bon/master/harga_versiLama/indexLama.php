<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">LIST MASTER SUPLIER</h4>
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
            <form class="form-horizontal" role="form" method="POST" >
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                      <div class="col-lg-12" id="tbllist">
                        <div class="table-responsive">
                           <table class="table table-bordered" id="dataTables">
                            <thead>
                              <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Pemborong</th>
                                <th class="text-center">Perusahaan</th>
                                <th class="text-center">Created By</th>
                                <th class="text-center">Updated By</th>
                                <th class="text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($_getDataHdr as $hdr){?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++;?></td>
                                        <td class="text-center"><?php echo date('d-M-Y',strtotime($hdr->Tanggal))?></td>
                                        <td><?php echo $hdr->Pemborong?></td>
                                        <td><?php echo $hdr->Perusahaan?></td>
                                        <td>
                                            <div class="text-center"><?php echo $hdr->CreatedBy?></div>
                                            <div class="text-right smaller-80"><?php echo date('d-M-Y',strtotime($hdr->CreatedDate))?></div>
                                        </td>
                                        <td>
                                            <div class="text-center"><?php echo $hdr->UpdateBy?></div>
                                            <div class="text-right smaller-80">
                                                <?php if($hdr->UpdateDate == NULL){echo "";}else{echo date('d-M-Y',strtotime($hdr->UpdateDate));}?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo base_url('PotonganBon/getDetailItemHarga?id='.$hdr->HeaderHargaID)?>" class="btn btn-minier btn-round btn-success"> Detail </a>
                                        </td>
                                    </tr>
                                <?php }?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="<?php echo site_url('PotonganBon/tambah_mst_harga')?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Item</a>
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

<div class="modal fade" id="myModalCari" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Detail Item</h4>
            </div>
            <div id="lihat_detail">
              <div class="modal-body">
                
              </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function get_detail(clicked_id){
        // alert(clicked_id);
        $.post("<?php echo site_url();?>PotonganBon/getDetailItemHarga?id="+clicked_id, function (data){
            $('#lihat_detail').html(data);
        });
        $('#myModalCari').modal('show');
    }

    </script>
</div>