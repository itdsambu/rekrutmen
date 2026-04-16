
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
                                    <th class="text-center">Kategori Cicilan</th>
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
                                            foreach($_getDataTotalSisa as $dtl){
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
                                            foreach($_getDataTotalSisa as $dtl){
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
                                            foreach($_getDataTotalSisa as $dtl){
                                                if($dtl->Tanggal == $get->Tanggal){
                                                    echo "<table class='table table-bordered'>
                                                        <tr>
                                                            <td>".number_format($dtl->HargaFull,0,",",".")."</td>
                                                        </tr>
                                                    </table>";
                                                }

                                            }?>
                                        </td>
                                        <td>
                                            <?php 
                                            $n = 1;
                                            foreach($_getDataTotalSisa as $dtl){
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
                                            foreach($_getDataTotalSisa as $dtl){
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
                                        
                                            <?php 
                                            $n = 1;
                                            foreach($_getDataTotalSisa as $dtl){
                                                if($dtl->Tanggal == $get->Tanggal){
                                                    echo "<table class='table table-bordered'>
                                                        <tr>
                                                            <td>Rp.". number_format($dtl->Realisasi,0,",",".")."</td>
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
                                    foreach($_getDataTrnDtl as $key){
                                        echo "<td colspan='7' class='text-center'><strong>GRAND TOTAL</strong></td>";
                                        echo "<td class='text-center'><strong>Rp.".number_format($key->total_sisa,0,",",".")."</strong></td>";
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