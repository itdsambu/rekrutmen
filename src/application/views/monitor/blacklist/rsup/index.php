<div class="page-header">
	<h1>
		MONITOR
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			yang bermasalah di RSUP
		</small>
	</h1>
</div>

<section class="content">
	<div class="row">
        <div class="col-xs-12">
        	<div class="nav-tabs-custom">
        		<ul class="nav nav-tabs">
        			<li><a href="#fa-icons" data-toggle="tab">Karyawan</a></li>
        			<li class="active"><a href="#glyphicons" data-toggle="tab">Tenaga Kerja</a></li>
        		</ul>
        		<div class="widget-main">  
        			<form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('Blacklist/filterdatalistrsup');?>">
                    <div class="row">
                		<div class="col-xs-12 col-sm-8"></div>
                		<div class="col-xs-12 col-sm-4">	
        					<div class="form-group">
		                        <label class="col-sm-4 control-label no-padding-right">Nama</label>
		                        <div class="col-sm-8">
		                            <input name="txtNama" id="inputNama" type="text" class="form-control input-sm" autocomplete="off" />
		                        </div>
                    		</div>
                    		<div class="form-group">
		                        <label class="col-sm-4 control-label no-padding-right"></label>
		                        <div class="col-sm-8">
		                            <input name="btnCari" id="inputcari" type="submit" value="Cari" class="btn btn-mini btn-block" />
		                        </div>
                    		</div>
                		</div>
                	</div>
                </form>
            	</div>
        		<div class="tab-content">
        			<div class="tab-pane" id="fa-icons">
		                <section id="new">
		                	<h4 class="page-header">List Karyawan Bermasalah di RSUP</h4>
		                	<div class="widget-body">
		                		<div class="row">
		                			<div class="col-sm-12">
		                				<div class="table-responsive">
		                					<table id="dataTablesK" class="table table-hover table-bordered">
		                						<thead>
		                							<tr>
		                								<th>NIK</th>
														<th>REGNO</th>
					                                    <th>NAMA</th>
					                                    <th>DEPARTMENT</th>
														<th>TANGGAL LAHIR</th>
														<th>ALAMAT RUMAH</th>
					                                    <th>TANGGAL MASUK</th>
					                                    <th>TANGGAL KELUAR</th>
					                                    <th>KETERANGAN</th>
														<th>ACTION</th>
		                							</tr>
		                						</thead>
		                						<tbody>
		                							<?php $no=0; foreach ($getBlacklistKRSUP as $rowK) { ?>
		                							<tr class="info" data-id="<?php echo $rowK->RegNo;?>">
		                								<td><?php echo $rowK->NIK;?></td>
														<td><?php echo $rowK->RegNo;?></td>
		                								<td><?php echo $rowK->NAMA;?></td>
		                								<td><?php echo $rowK->BagianAbbr;?></td>
		                								<td data-order="<?php echo $rowK->TGLLAHIR; ?>"><?php echo $rowK->TEMPATLHR;?>,<?php echo date('d-m-Y', strtotime($rowK->TGLLAHIR));?></td>
		                								<td><?php echo $rowK->ALAMATS;?></td>
		                								<td data-order="<?php echo $rowK->TGLMASUK; ?>"><?php echo date('d-m-Y', strtotime($rowK->TGLMASUK));?></td>
		                								<td data-order="<?php echo $rowK->TGLKELUAR; ?>"><?php echo date('d-m-Y', strtotime($rowK->TGLKELUAR));?></td>
		                								<td><?php echo $rowK->Blacklist_ket;?></td>
														<td><a href="#" title="Detail Karyawan Bermasalah" class="detailK btn btn-minier btn-round btn-info"><i class="ace-icon fa fa-files-o bigger-100"></i>Detail</a></td>
		                							</tr>
		                							<?php } ?>
		                						</tbody>
		                					</table>
		                				</div>
		                			</div>
		                		</div>
		                	</div>
		                </section>
		            </div>
		            <div class="tab-pane active" id="glyphicons">
		            	<section id="new">
		            		<h4 class="page-header">List Tenaga Kerja Bermasalah di RSUP</h4>
							<div class="widget-body">
		                		<div class="row">
		                			<div class="col-sm-12">
		                				<div class="table-responsive">
		                					<table id="dataTablesTK" class="table table-hover table-bordered">
		                						<thead>
		                							<tr>
														<th>FIXNO</th>
		                								<th>NIK</th>
					                                    <th>NAMA</th>
					                                    <th>PEMBORONG</th>
					                                    <th>NAMA CV</th>
					                                    <th>DEPARTMENT</th>
														<th>TTL</th>
					                                    <th>TANGGAL MASUK</th>
					                                    <th>TANGGAL KELUAR</th>
														<th>TANGGAL KELUAR TEMPORARY</th>
					                                    <th>KETERANGAN</th>
					                                    <th>NAMA IBU</th>
														<th>ACTION</th>
					                                    <!-- <th>Action</th> -->
		                							</tr>
		                						</thead>
		                						<tbody>
		                							<?php $no=0; foreach($getBlacklistTKRSUP as $rowTK){ ?>
		                							<tr class="info" data-id="<?php echo $rowTK->RequestID;?>">
														<td><?php echo $rowTK->Nofix;?></td>
		                								<td><?php echo $rowTK->Nik;?></td>
		                								<td><?php echo $rowTK->Nama;?></td>
		                								<td><?php echo $rowTK->Pemborong;?></td>
		                								<td><?php echo $rowTK->Perusahaan;?></td>
		                								<td><?php echo $rowTK->Bagian;?></td>
		                								<td data-order="<?php echo $rowTK->TanggalLahir; ?>"><?php echo $rowTK->TempatLahir;?>,<?php echo date('d-m-Y', strtotime($rowTK->TanggalLahir));?></td>
		                								<td data-order="<?php echo $rowTK->TanggalMasuk; ?>"><?php echo date('d-m-Y', strtotime($rowTK->TanggalMasuk));?></td>
														<td data-order="<?php echo $rowTK->TanggalKeluar; ?>">
															<?php if ($rowTK->TanggalKeluar == NULL){echo '';}else{echo date('d-m-Y', strtotime($rowTK->TanggalKeluar));};?>
														</td>
														<td data-order="<?php echo date('Y-m-d', strtotime($rowTK->TanggalKeluarTemporary)); ?>">
															<?php if ($rowTK->TanggalKeluarTemporary == NULL){echo '';}else{echo date('d-m-Y', strtotime($rowTK->TanggalKeluarTemporary));};?>
														</td>
		                								<td><?php echo $rowTK->ketKeluar;?></td>
		                								<td><?php echo $rowTK->NamaIbuKandung;?></td>
		                								<td><a href="#" title="Detail Tenaga kerja Bermasalah" class="detailTK btn btn-minier btn-round btn-info"><i class="ace-icon fa fa-files-o bigger-100"></i>Detail</a></td>
		                							</tr>
		                							<?php } ?>
		                						</tbody>
		                					</table>
		                				</div>
		                			</div>
		                		</div>
		                	</div>
		                </section>
		            </div>
        		</div>
        	</div>
        </div>
    </div>
</section>
<div class="modal fade" id="viewModalK" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dinamiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Informasi Karyawan Bermasalah RSUP</h4>
            </div>
            <div class="modal-body">
            	<input type="hidden" name="iddetail" id="inputdetail">
            	<div id="detailK" class="well">
            		
            	</div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModalTK" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dinamiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Informasi Tenaga Kerja Bermasalah RSUP</h4>
            </div>
            <div class="modal-body">
            	<input type="hidden" name="iddetail" id="inputdetail">
            	<div id="detailTK" class="well">
            		
            	</div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>

<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/jquery.dataTables.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script type="text/javascript" src="http://192.168.3.5/rekrutmen/assets/jqv/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="http://192.168.3.5/rekrutmen/assets/moment.min.js"></script>
<script type="text/javascript" src="http://192.168.3.5/rekrutmen/assets/datetime-moment.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTablesK').dataTable({
			"order": [[2,'asc']]
		});
		$('#dataTablesTK').dataTable({
			"order": [[2,'asc']]
		});
    });
</script>
<script>
	$(document).ready(function(){
		// $('dataTablesK').tablesorter();
		$.fn.dataTable.moment('DD/MM/YYYY');
        $('#dataTablesK').DataTable();
		$('[data-rel=tooltip]').tooltip();
		$('#dataTablesK').on("click", ".detailK", function(){
			var id = $(this).closest('tr').data('id');
			$.ajax({
				url 	: "<?php echo site_url('blacklist/detailKRSUP');?>",
				type	: "POST",
				data 	: "kode="+id,
				datatype: "json",
				cache	: false,
				success	: function(msg){
					$("#detailK").html(msg);
				}
			});
			$('#viewModalK').modal("show");
		});
	})
</script>
<script>
	$(document).ready(function(){
		// $('dataTablesTK').tablesorter();
		$.fn.dataTable.moment('DD/MM/YYYY');
        $('#dataTablesTK').DataTable();
		$('[data-rel=tooltip]').tooltip();
		$('#dataTablesTK').on("click", ".detailTK", function(){
			var id = $(this).closest('tr').data('id');
			$.ajax({
				url 	: "<?php echo site_url('blacklist/detailTKRSUP');?>",
				type	: "POST",
				data 	: "kode="+id,
				datatype: "json",
				cache	: false,
				success	: function(msg){
					$("#detailTK").html(msg);
				}
			});
			$('#viewModalTK').modal("show");
		});
	})
</script>