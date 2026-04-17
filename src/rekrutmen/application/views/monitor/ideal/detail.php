<div class="row">
	<div class="col-xs-6">
		<h4 class="row header smaller lighter blue">
		    <span class="col-sm-12">
		        <i class="ace-icon fa fa-info-circle"></i>
		        Karyawan
		    </span>
		</h4>
		<div class="table-responsive">
		    <table class="table table-striped">
		        <thead>
		            <tr>
		                <th>Pekerjaan</th>
		                <th>Total</th>
		            </tr>
		        </thead>
		        <tbody>
		        	<?php foreach($_getKaryawan as $kry){?>
		        	<tr>
		        		<td><?php echo $kry->JabatanName;?></td>
		        		<td><?php echo $kry->TotalJabatan;?></td>
		        	</tr>
		        	<?php } ?>
		        </tbody>
		    </table>
		</div>
	</div>
	<div class="col-xs-6">
		<h4 class="row header smaller lighter blue">
		    <span class="col-sm-12">
		        <i class="ace-icon fa fa-info-circle"></i>
		        Harian/Borongan
		    </span>
		</h4>
		<div class="table-responsive">
		    <table class="table table-striped">
		        <thead>
		            <tr>
		                <th>Pekerjaan</th>
		                <th>Total</th>
		            </tr>
		        </thead>
		        <tbody>
		        	<?php foreach($_getBorongan as $bor){?>
		        	<tr>
		        		<td><?php echo $bor->Jabatan;?></td>
		        		<td><?php echo $bor->TotalJabatan;?></td>
		        	</tr>
		        	<?php } ?>
		        </tbody>
		    </table>
		</div>
	</div>
</div>