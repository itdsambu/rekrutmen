<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">LIST MASTER HARGA</h4>
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
                            <div class="form-horizontal">
                                <div class="col-lg-12">
                                    <?php foreach($_getDataHdr as $hdr){?>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Tanggal</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="txtTanggal" class="form-control" value="<?php echo date('d-m-Y',strtotime($hdr->Tanggal))?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Sub Pemborong</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="txtSub" class="form-control" value="<?php echo $hdr->NamaSub?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Pemborong</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="txtPemborong" class="form-control" value="<?php echo $hdr->Pemborong?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Perusahaan</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="txtPerusahaan" class="form-control" value="<?php echo $hdr->Perusahaan?>" readonly>
                                            </div>
                                        </div>

                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12" id="tbllist">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTables">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Item</th>
                                            <th>Satuan</th>
                                            <th>Kategori</th>
                                            <th>Harga</th>
                                            <th>Catatan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($_getDtlHarga as $key=>$dtl){?>
                                            <tr>
                                                <td class="text-center"><?php echo $key+1;?></td>
                                                <td><?php echo $dtl->NamaItem?></td>
                                                <td><?php echo $dtl->SingkatanSatuan?></td>
                                                <td><?php echo $dtl->NamaKategori?></td>
                                                <td><?php echo number_format($dtl->Harga,2)?></td>
                                                <td><?php echo $dtl->Catatan?></td>
                                            </tr>
                                        <?php }?>
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
