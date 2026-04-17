<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">DETAIL POTONGAN PEMBORONG</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="#">
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
                                                <th class="text-center">Sisa</th>
                                                <th class="text-center">Sembako</th>
                                                <th class="text-center">Cicilan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no=1;
                                            foreach($_getDataTrnTanggal as $get){?>
                                                <tr>
                                                    <td style="vertical-align: middle;text-align: center;"><?php echo $no++?></td>
                                                    <td style="vertical-align: middle;text-align: center;"><?php 
                                                        $n = 1;
                                                        foreach($_getDataTrnDtl as $dtl): ?>
                                                            <?php if($dtl->Tanggal == $get->Tanggal): ?>
                                                                <table class='table table-bordered'><?php echo number_format($dtl->total_sisa,0,",","."); ?></table>
                                                            <?php endif;?>
                                                            <?php if($dtl->total_sisa == NULL ): ?>

                                                            <?php else: ?>
                                                                <a href="<?php echo base_url()?>PotonganBon/detail_potongan_sisa/<?php echo $get->Nofix?>/<?php echo $get->HeaderID;?>" style="" class="btn btn-minier btn-round btn-success">Detail</a>
                                                                
                                                            <?php endif;?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td style="vertical-align: middle;text-align: center;"><?php 
                                                        $n = 1;
                                                        foreach($_getDataTotalSem as $sem):?>
                                                            <?php if($sem->Tanggal == $get->Tanggal) :?>
                                                                <table class='table table-bordered'><?php echo number_format($sem->total_sembako,0,",",".");?></table>
                                                            <?php endif;?>
                                                            <?php if($sem->total_sembako == NULL ): ?>

                                                            <?php else: ?>
                                                                <a href="<?php echo base_url()?>PotonganBon/detail_potongan_sembako/<?php echo $get->Nofix?>/<?php echo $get->HeaderID;?>" style="" class="btn btn-minier btn-round btn-success">Detail</a>
                                                                
                                                            <?php endif;?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td style="vertical-align: middle;text-align: center;"><?php 
                                                        $n = 1;
                                                        foreach($_getDataTotalCic as $Cic) :?>
                                                            <?php if($Cic->Tanggal == $get->Tanggal):?>
                                                                <table class='table table-bordered'><?php echo number_format($Cic->total_cicilan,0,",",".");?></table>
                                                            <?php endif;?>
                                                            <?php if($Cic->total_cicilan == NULL ): ?>

                                                            <?php else: ?>
                                                                <a href="<?php echo base_url()?>PotonganBon/detail_potongan_cicilan/<?php echo $get->Nofix?>/<?php echo $get->HeaderID;?>" style="" class="btn btn-minier btn-round btn-success">Detail</a>
                                                                
                                                            <?php endif;?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
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
<hr>
<script type="text/javascript">
   $(document).ready(function() {
        $('#dataTables').dataTable();
    });
</script>