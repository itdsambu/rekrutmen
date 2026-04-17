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
<hr>
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
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Nama Item</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no=1;
                                foreach($_getDataTrnTanggal as $get){?>
                                    <tr>
                                        <td style="vertical-align: middle;text-align: center;"><?php echo $no++?></td>
                                        <td style="vertical-align: middle;text-align: center;"><?php echo date('d-m-Y',strtotime($get->Tanggal))?></td>
                                        <td>
                                            <?php 
                                            $n = 1;
                                            foreach($_getDataTrnDtl as $dtl){
                                                if($dtl->Tanggal == $get->Tanggal){
                                                    echo "<table class='table table-bordered'>
                                                        <tr>
                                                            <td>".$dtl->NamaItem."</td>
                                                        </tr>
                                                    </table>";
                                                }

                                            }?>
                                        </td>
                                        <td>
                                            <?php 
                                            $n = 1;
                                            foreach($_getDataTrnDtl as $dtl){
                                                if($dtl->Tanggal == $get->Tanggal){
                                                    echo "<table class='table table-bordered'>
                                                        <tr>
                                                            <td>".$dtl->Quantity."</td>
                                                        </tr>
                                                    </table>";
                                                }

                                            }?>
                                        </td>
                                        <td>
                                            <?php 
                                            $n = 1;
                                            foreach($_getDataTrnDtl as $dtl){
                                                if($dtl->Tanggal == $get->Tanggal){
                                                    echo "<table class='table table-bordered'>
                                                        <tr>
                                                            <td>".number_format($dtl->Harga,0,",",".")."</td>
                                                        </tr>
                                                    </table>";
                                                }

                                            }?>
                                        </td>
                                        <td>
                                            <?php 
                                            $n = 1;
                                            foreach($_getDataTrnDtl as $dtl){
                                                if($dtl->Tanggal == $get->Tanggal){
                                                    echo "<table class='table table-bordered'>
                                                        <tr>
                                                            <td>".$dtl->SingkatanSatuan."</td>
                                                        </tr>
                                                    </table>";
                                                }

                                            }?>
                                        </td>
                                        <td>
                                            <?php 
                                            $n = 1;
                                            foreach($_getDataTrnDtl as $dtl){
                                                if($dtl->Tanggal == $get->Tanggal){
                                                    echo "<table class='table table-bordered'>
                                                        <tr>
                                                            <td>".$dtl->NamaKategori."</td>
                                                        </tr>
                                                    </table>";
                                                }

                                            }?>
                                        </td>
                                        <td style="vertical-align: middle;text-align: center;">
                                            <!-- Rp.<?php echo number_format($get->Total,0,",",".")?> -->
                                            Rp. <?php 
                                            $n = 1;
                                            foreach($_getDataTrnDtl as $dtl){
                                                if($dtl->Tanggal == $get->Tanggal){
                                                    echo "<table class='table table-bordered'>
                                                        <tr>
                                                            <td>".number_format($dtl->Total,0,",",".")."</td>
                                                        </tr>
                                                    </table>";
                                                }

                                            }?>
                                        </td>
                                    </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <?php 
                                    foreach($_getDataTrnTotal as $key){
                                        echo "<td colspan='7' class='text-center'><strong>GRAND TOTAL</strong></td>";
                                        echo "<td class='text-center'><strong>Rp.".number_format($key->GrandTotal,0,",",".")."</strong></td>";
                                    }?>
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