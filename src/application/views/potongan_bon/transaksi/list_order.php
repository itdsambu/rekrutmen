
<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><i class="glyphicon glyphicon-shopping-cart"></i> LIST PESANAN </h4>
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
                  echo "<strong>Gagal !!!</strong> Data Sudah diinput..!!";
                  echo "</div>";
              }?>
                
            </div>
            <form class="form-horizontal" role="form" method="POST" action="#">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <!-- <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12">
                                        <p class="pull-left">
                                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('PotonganBon/ordermanual');?>"><i class="fa fa-plus"></i> Tambah Order</a>
                                        </p>
                                    </div>
                                </div> -->
                                <div class="table-responsive" id="listid">
                                   <table class="table table-bordered" id="dataTables">
                                    <thead>
                                      <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Tanggal Order</th>
                                        <!-- <th class="text-center">Nofix</th> -->
                                        <th class="text-center">Nik</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">CV</th>
                                        <th class="text-center">Pemborong</th>
                                        <!-- <th class="text-center">Sub Pemborong</th> -->
                                        <th class="text-center">Aksi</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $no = 1;
                                            foreach($_getListOrder as $get){?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++;?></td>
                                                    <td class="text-center"><?php echo date('d-m-Y',strtotime($get->Tanggal))?></td>
                                                    <!-- <td class="text-center"><?php echo $get->Nofix?></td> -->
                                                    <td class="text-center"><?php echo $get->Nik?></td>
                                                    <td class="text-left"><?php echo $get->Nama?></td>
                                                    <td class="text-center"><?php echo $get->Perusahaan?></td>
                                                    <td class="text-center"><?php echo $get->Pemborong?></td>
                                                    <!-- <td class="text-center"><?php echo $get->NamaSubPemborong?></td> -->
                                                    <td class="text-center">
                                                        <a href="<?php echo base_url('PotonganBon/lihat_pesanan/'.date('Y-m-d',strtotime($get->Tanggal)).'/'.$get->Nofix.'/'.$get->IDSubPemborong.'/'.$get->HeaderID);?>" class="btn btn-minier btn-round btn-success"><i class="glyphicon glyphicon-inbox"></i> Proses</a>
                                                        <a href="<?php echo base_url('PotonganBon/delete/'.$get->HeaderID);?>" class="btn btn-minier btn-round btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                    </tbody>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <br>
                                <div class="form-group">
                                    <label class="col-lg-0 control-label"></label>
                                    <div class="col-sm-6">
                                        <a href="<?php echo site_url('PotonganBon/OrderManual') ?>" class="btn btn-sm btn-default">Kembali</a>
                                        <a href="<?php echo base_url('PotonganBon/ExportExcelTrnBelumProses');?>" class="btn btn-sm btn-success"><i class="fa fa-excel-o"></i>Export To Excel</a>
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
    });
</script>

