<div class="page-header">
    <h1>
        Transaksi
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Get Kouta Pemboronga
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-ms-12">
        <div class="panel panel-color panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">Kuota For MPD</h4>
            </div>
            <div class="panel-body">
                <div class="panel-main">
                    <div class="row" style="padding-bottom: 20px">
                        <div class="col-xs-12">
                        	<table class="table table-bordered table-bordered table-colored table-primary">
                        		<thead>
                        			<th>Dept</th>
                        			<th>Minta</th>
                        			<th>Sukses</th>
                        			<th>Jumlah Yg Sudah diidentifikasi</th>
                        		</thead>
                        		<tbody>
                        			<?php 
									    $tot_minta = 0;
									    $tot_sukses = 0;
		                                $tot_identifikasi = 0;
									    foreach ($_getIssue as $r):

									    $target = $r->TKTarget;
		                                $sedia  = $r->TKSedia;
		                                $minta  = $r->TKPermintaan;
		                                $jumlahID = $r->Identifikasi;

		                                $sisa   = $target-$sedia;
		                                $penuhi = $sisa-$minta;
		                                $diidentifikasi = $jumlahID-($penuhi);


		                                $tot_minta += $sisa;
		                                $tot_sukses += $penuhi;
		                                $tot_identifikasi += $diidentifikasi;

		                                $tot_target = $tot_minta-$tot_sukses-$tot_identifikasi;
									?>
									<tr>
										<td><?= $r->DeptAbbr;?></td>
										<td><?= $sisa;?></td>
										<td><?= $penuhi;?></td>
										<td><?= $diidentifikasi;?></td>
									</tr>
									<?php endforeach;?>
                        		</tbody>
                        		<tbody>
                        			<tr>
	                        			<th>Total</th>
	                        			<th><?= $tot_minta;?></th>
	                        			<th><?= $tot_sukses;?></th>
	                        			<th><?= $tot_identifikasi;?></th>
	                        		</tr>
                        		</tbody>
                        		<tfoot>
                        			<tr>
                        				<th colspan="3">Target</th>
										<th><input type="hidden" name="txttarget" id="txttarget" value="<?= $tot_target;?>"><?= $tot_target;?></th>
                        			</tr>
                        		</tfoot>
                        	</table>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-xs-12">
                    		<form class="form-horizontal" role="form" method="POST" id="formgetkuota">
                    			<div class="form-group">
                    				<label class="control-label col-sm-3">Target</label>
                    				<div class="col-sm-5">
                    					<input type="text" class="form-control input-sm target" id="inputgettarget" name="txtgettarget" onclick="sum(this.value);">
                    				</div>
                    			</div>
                    			<div class="form-group">
                    				<label class="control-label col-sm-3">Jumlah Pemborong</label>
                    				<div class="col-sm-5">
                    					<input type="text" class="form-control input-sm target" readonly id="inputgetjmlpbr" name="txtgetjmlpbr" value="15" onclick="sum(this.value);">
                    				</div>
                    			</div>
                    			<div class="form-group">
                    				<label class="control-label col-sm-3">Kuota Pemborong</label>
                    				<div class="col-sm-5">
                    					<input type="text" class="form-control input-sm target" readonly id="inputgetkuotapbr" name="txtgetkuotapbr" onclick="sum(this.value);">
                    				</div>
                    			</div>
                    			<div class="form-group">
                    				<label class="control-label col-sm-3">HK PSN</label>
                    				<div class="col-sm-5">
                    					<input type="text" class="form-control input-sm target" id="inputgethkpsn" name="txtgethkpsn" onclick="sum(this.value);">
                    				</div>
                    			</div>
                    			<div class="form-group">
                    				<label class="control-label col-sm-3">Kuota Per Hari / Pemborong</label>
                    				<div class="col-sm-5">
                    					<input type="text" class="form-control input-sm target" readonly id="inputgetperpbr" name="txtgetperpbr" onclick="sum(this.value);">
                    				</div>
                    			</div>
                    			<div class="form-group">
                    				<label class="control-label col-sm-3">Total</label>
                    				<div class="col-sm-5">
                    					<input type="text" class="form-control input-sm target" readonly id="inputgettotal" name="txtgettotal" onclick="sum(this.value);">
                    				</div>
                    			</div>
                    		</form>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        var val = parseInt(document.getElementById('txttarget').value);
		var val1 = parseInt(document.getElementById('inputgettarget').value);
		var val2 = parseInt(document.getElementById('inputgetjmlpbr').value);
		var val3 = parseInt(document.getElementById('inputgethkpsn').value);
		var total1 = val1/val2;
		var total2 = total1/val3;
		var total3 = total2*val2;
        document.getElementById('inputgettarget').value = Math.round(val);
		document.getElementById('inputgetkuotapbr').value = Math.round(total1);
		document.getElementById('inputgetperpbr').value = Math.round(total2);
		document.getElementById('inputgettotal').value = Math.round(total3);
		console.log(val2);
	});

	function sum(val){
		var val1 = parseInt(document.getElementById('inputgettarget').value);
		var val2 = parseInt(document.getElementById('inputgetjmlpbr').value);
		var val3 = parseInt(document.getElementById('inputgethkpsn').value);
		var total1 = val1/val2;
		var total2 = total1/val3;
		var total3 = total2*val2;
		document.getElementById('inputgetkuotapbr').value = Math.round(total1);
		document.getElementById('inputgetperpbr').value = Math.round(total2);
		document.getElementById('inputgettotal').value = Math.round(total3);
	}
</script>