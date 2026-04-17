<div class="widget-body">
    <div class="widget-main">
        <div class="row">
            <div class="form-horizontal">
                <div class="col-lg-12">
                    <?php foreach($_getDataTrnHdr as $hdr){?>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Pemborong</label>
                        <div class="col-sm-5">
                            <input type="text" name="txtPemborong" class="form-control" value="<?php echo $hdr->Pemborong?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Sub Pemborong</label>
                        <div class="col-sm-5">
                            <input type="text" name="txtSubPemborong" class="form-control" value="<?php echo $hdr->NamaSub?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Perusahaan</label>
                        <div class="col-sm-5">
                            <input type="text" name="txtPerusahaan" class="form-control" value="<?php echo $hdr->Perusahaan?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">NIK</label>
                        <div class="col-sm-5">
                            <input type="text" name="txtNik" class="form-control" value="<?php echo $hdr->Nik?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Nama</label>
                        <div class="col-sm-5">
                            <input type="text" name="txtNama" class="form-control" value="<?php echo $hdr->Nama?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Bagian/Dept</label>
                        <div class="col-sm-5">
                            <input type="text" name="txtDept" class="form-control" value="<?php echo $hdr->Bagian?>" readonly>
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
            <div class="col-lg-12">
                <div class="form-horizontal">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Kategori Cicilan</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php 
                               $no=1;
                               foreach($_getDataDetailSisaCicilan as $key){?>
                                <tr>
                                    <td class="text-center"><?php echo $no++;?></td>
                                    <td><?php echo $key->NamaCicilan;?></td>
                                    <td class="text-center"><?php echo $key->Quantity;?></td>
                                    <td class="text-center"><?php echo $key->NamaSatuan;?></td>
                                    <td class="text-center"><?php echo $key->NamaKategori;?></td>
                                    <td class="text-center">Rp.<?php echo number_format($key->HargaCicilan,0,",",".");?></td>
                                </tr>
                               <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-center" colspan="5">TOTAL</td>
                                    <td class="text-center">Rp.
                                        <?php foreach($_getTotalDetail as $ttl){
                                        echo number_format($ttl->Sisa_Cicilan,0,",",".");
                                        }?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<script type="text/javascript">
   $(document).ready(function() {
        $('#dataTables').dataTable();
    });
</script>