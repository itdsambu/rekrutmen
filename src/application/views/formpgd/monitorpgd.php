<?php
    $Dept = $this->session->userdata('dept');
   // echo $this->session->userdata('groupuser');
?>
<div class="page-header">
	<h1>
		MONITOR
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			Permohonan PGD
		</small>
	</h1>
</div>
<?php if (($this->session->userdata('dept') == 'PSN') OR ($this->session->userdata('dept') == 'ITD')):?>
<div class="row">
	<div class="col-xs-12">
		<div class="widget-box">
			<div class="widget-header">
				<h5 class="widget-title">List Permohonan PGD</h5>
				<div class="widget-toolbar">
					<a class="btn btn-minier btn-danger btn-xs btn-bold" href="<?php echo base_url("Suratpgd/inputpgd");?>">
						<i class="ace-icon fa fa-user-plus"></i> Tambah
					</a>
				</div>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<div class="table-responsive">
						<table id="dataTables" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>#</th>
                                    <th>NAMA</th>
									<th>NIK</th>
                                    <th>DEPARTEMEN</th>
                                    <th>JABATAN</th>
                                    <th>PERUSAHAAN/CV</th>
                                    <th>PEMBORONG</th>
                                    <th>TANGGAL MASUK</th>
									<th>MESS/BLOK</th>
									<th>TTD</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($getdatapgd as $r):
									$img = $r->TandaTangan;
								?>
								<tr class="info" data-id="<?php echo $r->NIK;?>">
									<td><?php echo ++$no; ?></td>
									<td><?php echo $r->NAMA; ?></td>
									<td><?php echo $r->NIK; ?></td>
									<td><?php echo $r->DeptAbbr; ?></td>
									<td><?php echo $r->Jabatan; ?></td>
									<td><?php echo $r->Perusahaan; ?></td>
									<td><?php echo $r->Pemborong; ?></td>
									<td><?php echo $r->TglMasuk; ?></td>
									<td><?php echo $r->Alamat; ?></td>
									<td><img width="100" onload="form_base64_decode_preview(this)" onplay="this.onload()" onloadedmetadata="this.onload()" onerror="this.support_decode_preview=false" alt="" src="<?php echo $r->TandaTangan; ?>"/></td>
									<td><a href="javascript:void(0);" class="detail btn btn-minier btn-round btn-danger"><i class="ace-icon fa fa-files-o bigger-100"> Detail</a></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php else:?>
<div class="row">
	<div class="col-xs-12">
		<div class="widget-box">
			<div class="widget-header">
				<h5 class="widget-title">List Permohonan PGD</h5>
				<div class="widget-toolbar">
					<a class="btn btn-minier btn-danger btn-xs btn-bold" href="<?php echo base_url("Suratpgd/inputpgd");?>">
						<i class="ace-icon fa fa-user-plus"></i> Tambah
					</a>
				</div>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<div class="table-responsive">
						<table id="dataTables" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>#</th>
                                    <th>NAMA</th>
									<th>NIK</th>
                                    <th>DEPARTEMEN</th>
                                    <th>JABATAN</th>
                                    <th>PERUSAHAAN/CV</th>
                                    <th>PEMBORONG</th>
                                    <th>TANGGAL MASUK</th>
									<th>MESS/BLOK</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if(empty($getdatapgddept)){?>
									<p class="text-center">Data Masih Kosong</p>
								<?php } else { 
									$no=1;
									foreach ($getdatapgddept as $r){
								?>
								<tr class="info" data-id="<?php echo $r->NIK;?>">
									<td><?php echo $no++; ?></td>
									<td><?php echo $r->NAMA; ?></td>
									<td><?php echo $r->NIK; ?></td>
									<td><?php echo $r->DeptAbbr; ?></td>
									<td><?php echo $r->Jabatan; ?></td>
									<td><?php echo $r->Perusahaan; ?></td>
									<td><?php echo $r->Pemborong; ?></td>
									<td><?php echo $r->TglMasuk; ?></td>
									<td><?php echo $r->Alamat; ?></td>
									<td><a href="javascript:void(0);" class="detail btn btn-minier btn-round btn-danger"><i class="ace-icon fa fa-files-o bigger-100"> Detail</a></td>
								</tr>
								<?php } } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif;?>
<script src="<?= base_url()?>assets/js/form_base64_decode_preview.min.js"></script>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Informasi Permohonan PGD</h4>
            </div>
            <div class="modal-body">
            	<input type="hidden" name="iddetail" id="inputdetail">
            	<div id="detail" class="well">
            		
            	</div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqv/jquery.tablesorter.min.js"></script>
<script>
	$(document).ready(function(){
		$('dataTables').tablesorter();
		$('[data-rel=tooltip]').tooltip();
		$('#dataTables').on("click", ".detail", function(){
			var id = $(this).closest('tr').data('id');
			$.ajax({
				url 	: "<?php echo site_url('Suratpgd/detail');?>",
				type	: "POST",
				data 	: "kode="+id,
				datatype: "json",
				cache	: false,
				success	: function(msg){
					$("#detail").html(msg);
				}
			});
			$('#viewModal').modal("show");
		});
	})
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#dataTables').dataTable({
			"order": [[0,'asc']]
		});
	})
</script>