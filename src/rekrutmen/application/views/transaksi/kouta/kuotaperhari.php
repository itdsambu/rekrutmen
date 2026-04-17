<div class="page-header">
    <h1>
        Transaksi
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Kouta TK Perhari
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12" id="controlsetup">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">List Kouta TK Pemborong</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                	<?php if($this->session->flashdata('_message')):?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" rolw="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                    </div>
                    <?php endif;?>
                    <div class="col-sm-12" style="padding-bottom: 20px;">
                        <table class="table table-bordered table-hover table-primary">
							<thead>
								<tr>
									<th>CVNama</th>
									<th>Kuota Per Pemborong</th>
									<th>Total input Non Pendidikan</th>
									<th>Sisa Kuota</th>
								</tr>
							</thead>
							<tbody>
								<?php 
                                    $jml = 0;
                                    $sisa=0; foreach($sisakuota as $r){ $sisa += $r->SisaKuota; $jml +=$r->KuotaNonPendidikan;?>
								<tr>
									<td><?= $r->CVNama?></td>
									<td><?= $r->KuotaNonPendidikan?></td>
									<td><?= $r->TotalInput?></td>
									<td><?= $r->SisaKuota?></td>
								</tr>
								<?php } ?>
							</tbody>
							<tfoot>
								<tr>
									<th colspan="1">Total Sisa</th>
                                    <th colspan="1"><?= $jml?></th>
                                    <th colspan="1"></th>
									<th colspan="1"><?= $sisa?></th>
								</tr>
							</tfoot>
						</table>
                    </div>
                    <div class="col-sm-12">
                        <table id="dataTables" class="table table-bordered table-hover table-primary">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Kouta</th>
									<th>Start Input</th>
                                    <th>Batas Input</th>
                                    <th>Pengumuman</th>
                                    <th>Setting</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($_getKouta as $row){?>
                                <tr data-id="<?php echo $row->DayNumber?>" class="rowdetail">
                                    <td><?php echo $row->DayNumber?></td>
                                    <td><?php echo $row->DayName?></td>
                                    <td><?php echo $row->Kuota?></td>
									<td>
                                    	<?php
                                    		if($row->StartInput == NULL){
                                    			echo '<span class="label label-xs label-danger">Jam belum disetting</span>';
                                    		}else{
                                    			echo '<span class="label label-xs label-danger">'.date('H:i',strtotime($row->StartInput)).'</span>';
                                    		}
                                    	?>
                                    </td>
                                    <td>
                                    	<?php
                                    		if($row->BatasInput == NULL){
                                    			echo '<span class="label label-xs label-danger">Jam belum disetting</span>';
                                    		}else{
                                    			echo '<span class="label label-xs label-danger">'.date('H:i',strtotime($row->BatasInput)).'</span>';
                                    		}
                                    	?>
                                    </td>
                                    <td><?php echo $row->Alert;?></td>
                                    <td>
                                    	<a title="View Issue" data-rel="tooltip" href="#" class="setting btn btn-minier btn-round btn-primary">
                                            <i class="ace-icon fa fa-gear bigger-100"></i> Setting
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="row">
    <div class="col-xs-12" id="controlsetup">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">List Kouta TK Pemborong</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if($this->session->flashdata('_message')):?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" rolw="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                    </div>
                    <?php endif;?>
					<div class="col-sm-12" style="padding-bottom: 20px;">
                        <table class="table table-bordered table-hover table-primary">
							<thead>
								<tr>
									<th>CVNama</th>
									<th>Kuota Per Pemborong</th>
									<th>Total input Non Pendidikan</th>
									<th>Sisa Kuota</th>
								</tr>
							</thead>
							<tbody>
								<?php $sisa=0; foreach($sisakuota as $r){ $sisa += $r->SisaKuota;?>
								<tr>
									<td><?= $r->CVNama?></td>
									<td><?= $r->KuotaNonPendidikan?></td>
									<td><?= $r->TotalInput?></td>
									<td><?= $r->SisaKuota?></td>
								</tr>
								<?php } ?>
							</tbody>
							<tfoot>
								<tr>
									<th colspan="3">Total Sisa</th>
									<th colspan="3"><?= $sisa?></th>
								</tr>
							</tfoot>
						</table>
                    </div>
                    <div class="col-sm-12">
                        <table id="dataTables" class="table table-bordered table-hover table-primary">
                            <thead class="bg-info">
                                <tr>
                                    <th style="text-align: center;" rowspan="2">No</th>
                                    <th style="text-align: center;" rowspan="2">Hari</th>
                                    <th style="text-align: center;" colspan="2">Pendidikan</th>
                                    <th style="text-align: center;" colspan="2">Non pendidikan</th>
                                    <th style="text-align: center;" rowspan="2">Start Input</th>
                                    <th style="text-align: center;" rowspan="2">End Input</th>
                                    <th style="text-align: center;" rowspan="2">Pengumuman</th>
                                    <th style="text-align: center;" rowspan="2">Setting</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">Kuota</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Kuota</th>
                                    <th style="text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($_getKouta as $row){?>
                                <tr data-id="<?php echo $row->DayNumber?>" class="rowdetail">
                                    <td><?php echo $row->DayNumber?></td>
                                    <td><?php echo $row->DayName?></td>
                                    <td><?php echo $row->KuotaPendidikan?></td>
                                    <td>
                                        <?php if($row->StsPendidikan == 0){?>
                                        <a href="<?php echo site_url('transaksi/lockKoutapendidikan')."?id=".$row->DayNumber."&sts=".$row->StsPendidikan;?>"  class="btn btn-primary btn-xs" title="Lock Kouta"><i class="fa fa-unlock"></i> UnLock</a>
                                        <?php } else { ?>
                                        <a href="<?php echo site_url('transaksi/lockKoutapendidikan')."?id=".$row->DayNumber."&sts=".$row->StsPendidikan;?>" class="btn btn-danger btn-xs" title="Unlock Kouta"><i class="fa fa-lock"></i> Lock</a>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $row->KuotaNonPendidikan?></td>
                                    <td>
                                        <?php if($row->StsNonPendidikan == 0){?>
                                        <a href="<?php echo site_url('transaksi/unlockKoutanonpendidikan')."?id=".$row->DayNumber;?>"  class="btn btn-primary btn-xs" title="Lock Kouta"><i class="fa fa-unlock"></i> UnLock</a>
                                        <?php } else { ?>
                                        <a href="<?php echo site_url('transaksi/unlockKoutanonpendidikan')."?id=".$row->DayNumber;?>" class="btn btn-danger btn-xs" title="Unlock Kouta"><i class="fa fa-lock"></i> Lock</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($row->StartInput == NULL){
                                                echo '<span class="label label-xs label-danger">Jam belum disetting</span>';
                                            }else{
                                                echo '<span class="label label-xs label-danger">'.date('H:i',strtotime($row->StartInput)).'</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($row->BatasInput == NULL){
                                                echo '<span class="label label-xs label-danger">Jam belum disetting</span>';
                                            }else{
                                                echo '<span class="label label-xs label-danger">'.date('H:i',strtotime($row->BatasInput)).'</span>';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $row->Alert;?></td>
                                    <td>
                                        <a title="View Issue" data-rel="tooltip" href="#" class="setting btn btn-minier btn-round btn-primary">
                                            <i class="ace-icon fa fa-gear bigger-100"></i> Setting
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<div class="modal fade" id="viewModalSetting" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Setting Kouta Khusus</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputsetting" name="idsetting">
                <div id="setting" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#dataTables").on("click", ".setting", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('transaksi/viewSettingDetail');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#setting").html(msg);
                }
            });
            $("#viewModalSetting").modal("show");
        });
    });
</script>