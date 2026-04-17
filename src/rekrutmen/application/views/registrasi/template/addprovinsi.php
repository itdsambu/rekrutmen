<script>
	$(function(){
		$('#selectProvinsi').on('change',function(){
			idp = $(this).find(":selected").val();
			$.ajax({
			    type:'GET',
				dataType:'json',
				url:'<?=base_url()?>/registrasi/getkabupaten',
				data:{idprov:idp},
				success	: function(d,r,x){
					data = d.data;
					$('#selectKabupaten').empty().html('<option value="">Silahkan pilih Kabupaten</option>');
					for(i=0;i<data.length;i++){
						$('#selectKabupaten').append('<option value="' + data[i].Kabupaten_KotaID +'">'+ data[i].Kabupaten_KotaName +'</option>');
					}
				}
			});
		});
			
		$('#selectKabupaten').on('change',function(){
			idp = $('#selectProvinsi').find(":selected").val();
			ikab = $(this).find(":selected").val();
			$.ajax({
			    type:'GET',
				dataType:'json',
				url:'<?=base_url()?>/registrasi/getkecamatan',
				data:{idprov:idp,idkab:ikab},
				success	: function(d,r,x){
					data = d.data;
					$('#selectKecamatan').empty().html('<option value="">Silahkan pilih Kecamatan</option>');
					for(i=0;i<data.length;i++){
						$('#selectKecamatan').append('<option value="' + data[i].KecamatanID +'">'+ data[i].KecamatanName +'</option>');
					}
				}
			});
		});
	});
</script>

<div class="form-group">				
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Provinsi* </label>
    <div class="col-sm-8">
        <select class="col-xs-12 col-sm-10" name="txtProvinsi" id="selectProvinsi" required="">
            <option value=""> -- Silahkan pilih Provinsi</option>
            <?php foreach ($_getprovinsi as $rowProvinsi):
			    if(isset($_getData)){
					if ($_getData[0]->ProvinsiID==$rowProvinsi->ProvinsiID){
						?>
						<option value="<?= $rowProvinsi->ProvinsiID?>" selected><?= $rowProvinsi->ProvinsiName?></option>   
						<?php
					}else{
						?>
						<option value="<?= $rowProvinsi->ProvinsiID?>"><?= $rowProvinsi->ProvinsiName?></option>   
						<?php
					}
				}else{?>
			        <option value="<?= $rowProvinsi->ProvinsiID?>"><?= $rowProvinsi->ProvinsiName?></option>   
				<?php }?>	
            <?php endforeach;?>                                                
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kabupaten* </label>
    <div class="col-sm-8">
        <select class="col-xs-12 col-sm-10"  id="selectKabupaten" name="txtKabupaten" required="">
		     <option value=""> -- Silahkan pilih Kabupaten</option>
		     <?php 
			   if(isset($_getkabupaten)) {
				 foreach ($_getkabupaten as $kab):
				     if(isset($_getData)){
						if($_getData[0]->KabKotaID==$kab->Kabupaten_KotaID){
							?>
							<option value="<?=$kab->Kabupaten_KotaID ?>" selected><?=$kab->Kabupaten_KotaName?></option>
							<?php
						}else{?>
							<option value="<?=$kab->Kabupaten_KotaID ?>" ><?=$kab->Kabupaten_KotaName?></option>
							<?php
						}
					 }else{
						?>
						<option value="<?=$kab->Kabupaten_KotaID?>"><?=$kab->Kabupaten_KotaName?></option>
						<?php
					 }
				 endforeach;
			 }?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kecamatan* </label>
    <div class="col-sm-8">
        <select class="col-xs-12 col-sm-10" name="txtKecamatan" id="selectKecamatan" required="">
            <option value=""> -- Silahkan pilih Kecamatan</option>                                                                                             
			<?php 
				if (isset($_getkecamatan)) 
				{
					foreach($_getkecamatan as $row):
					   if(isset($_getData)){
						if($_getData[0]->KecamatanID==$row->KecamatanID){
								?>
								<option value="<?= $row->KecamatanID?>" selected><?=$row->KecamatanName?></option>
								<?php
						}else{
								?>
								<option value="<?= $row->KecamatanID?>"><?=$row->KecamatanName?></option>
								<?php																	
						}	
					   }
					endforeach;
					
				}?>
        </select>
    </div>
</div>