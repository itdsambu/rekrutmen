<!-- <link rel="stylesheet" href="asss/path/to/compiled/flipclock.css" /> -->
<link href="<?php echo base_url();?>assets/plugins/FlipClock-master/compiled/flipclock.css" rel="stylesheet" type="text/css" />
<!-- <script src="<?php echo base_url();?>assets/plugins/FlipClock-master/compiled/flipclock.min.js"></script>
 --><div id="successid">
	<form class="form-horizontal" role="form" method="POST" id="formSave">
		<div class="row">
			<div class="col-12">
				<div class="card m-b-20">
					<div class="card-body">
						<div class="alert alert-primary"><h4 class="mt-0 header-title"><b><center>DATA DIRI</center></b></h4></div>
							<br>
							<div id="ajaxfrommodal">
							    <div class="form-group row">
							        <label for="example-search-input" class="col-sm-2 col-form-label">NIK</label>
							        <div class="col-sm-4">
							           <input type="text" name="txtNik" id="nik_id" class="form-control" onchange="get_list_tkb();" placeholder="Input NIK" required>
		       						   <input type="hidden" name="txtfixReg" id="fixreg" class="form-control" value="" readonly required>

							        </div>
							    </div>
							    <div class="form-group row">
							        <label for="example-search-input" class="col-sm-2 col-form-label">Nama</label>
							        <div class="col-sm-4">
							           <input type="text" name="txtNama" id="nama_lengkap" class="form-control" readonly required placeholder="Nama Auto">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label for="example-search-input" class="col-sm-2 col-form-label">Bagian</label>
							        <div class="col-sm-4">
							            <input type="text" name="txtBagian" id="bagian" class="form-control" readonly required placeholder="Bagian Auto">
							        </div>
							    </div>
							    <div class="form-group row">
							    	<label for="example-search-input" class="col-sm-2 col-form-label">Jabatan</label>
							        <div class="col-sm-4">
							            <input type="text" name="txtJabatan" id="jabatan" class="form-control" readonly required placeholder="Jabatan Auto">
							        </div>
							    </div>
							</div>
							<br>
							<br>
							<div class="alert alert-primary"><h4 class="mt-0 header-title"><b><center>KRITERIA SOAL </center></b></h4></div>
							<br>
							<div class="form-group row">
						        <label for="example-search-input" class="col-sm-2 col-form-label">Departemen</label>
						        <div class="col-sm-4">
						            <select class="form-control" name="txtDept" id="dept" readonly>
						            	<?php foreach($_dept as $dept){
						            		echo "<option value='$dept->DeptID'>".$dept->DeptAbbr."</option>";
						            	}?>
						            </select>
						        </div>
						    </div>
						    <div class="form-group row">
						        <label for="example-search-input" class="col-sm-2 col-form-label">Jenis Soal</label>
						        <div class="col-sm-4">
						            <select class="form-control" name="txtJenisSoal" id="jenis_soal" readonly>
						            	<option value="">- Pilih Jenis Soal -</option>
						            	<?php if($jenis_soal == 1){
						            		echo '<option value="1" selected>Pre Test</option>
						            			 <option value="2">Post Test</option>';
						            	}elseif($jenis_soal == 2){
						            		echo '<option value="1">Pre Test</option>
						            			 <option value="2" selected>Post Test</option>';
						            	}else{
						            		echo '<option value="1">Pre Test</option>
						            			 <option value="2">Post Test</option>';
						            	}?>
						            </select>
						        </div>
						    </div>
						    <div class="form-group row">
						        <label for="example-search-input" class="col-sm-2 col-form-label">Materi</label>
						        <?php foreach($materi as $mtr){?>
						        <div class="col-sm-4">
						            
						            	<textarea  class="form-control" name="txtMateri" id="materi_id" readonly><?php echo $mtr->JudulMateri;?></textarea>
						        	
						        </div>
						        <input type="hidden" name="txtMateriid" id="materidtl_id" value="<?php echo $mtr->IKPMateriDtl?>">
						        <?php }?>
						    </div>
						    <div class="form-group row">
					        	<label for="example-search-input" class="col-sm-2 col-form-label">Ruangan/Lokasi</label>
						        <div class="col-sm-4">
						            <select class="form-control" name="txtRuangan" id="ruangan" onclick="getRuangan();">
						            	<option value="">- Pilih Ruangan -</option>
						            	<option value="1">Ruang Training Internal Departemen</option>
						            	<option value="2">Ruang Training PSN</option>
						            	<option value="3">Ditentukan Oleh Dept/Bagian Masing-Masing</option>
						            </select>
						        </div>
						        <div class="col-sm-2" id="ruangan_id">
						        	
						        </div>
						    </div>
						    <?php
							foreach($getSoal as $row){?>
					     		<input type="hidden" name="txtHdrSoal" id="txtHdrSoal" value="<?php echo $row->IdMstSoalHdr;?>" class="txt form-control">
					     	<?php }?>
						    <div class="form-group row">
						    	<label for="example-search-input" class="col-sm-2 col-form-label">Waktu Pengerjaan</label>
						    	<div class="col-sm-4">
						    		<?php foreach($_getWaktu as $key){
						    			$durasi = $key->SettingWaktu;
						    			// $publish = date('H:i:s',strtotime($key->WaktuPublish));
						    			// echo $publish;
						    			// $menit = $menit1+$menit2;
						    			$waktu = date('H:i:s',strtotime($key->WaktuPublish.'+'.$durasi.' minute'));
						    			// echo $key->WaktuPublish;
						    			$tanggal_sekarang = date('M d, Y');
						    			$tanggal_publis = date('M d, Y',strtotime($key->WaktuPublish));
						    		?>
						    			<input type="hidden" name="txtWaktu" id="waktu" class="form-control" value="<?php echo $waktu; ?>">
						    			<input type="hidden" name="txtTanggal" id="Tanggal" value="<?php echo date('M d, Y',strtotime($key->WaktuPublish));?>">
							            <input type="hidden" name="txtWaktuPublish" id="waktuPublish" value="<?php echo date('H:i:s',strtotime($key->WaktuPublish));?>">
							            <input type="hidden" name="txtJamSekarang" id="JamSekarang" value="<?php echo date('H:i:00');?>">

						    			<?php if($tanggal_publis == $tanggal_sekarang){?>
						    					<a href="#" class="btn btn-md btn-success" onclick="start()">START</a>
						    			<?php } else {?>
						    				<div class="card-body">
												<div class="alert alert-danger" role="alert">
			                						<h2 class="alert-heading font-18 blink_me" style="text-align: center;"></h2>
			                						<h2 class="alert-heading font-18 blink_me" style="text-align:center;font-weight: bold;">HALAMAN TIDAK DAPAT DI AKSES..!!</h2>
			                						<p class="mb-0" style="text-align:center;"></p>
			            						</div>
											</div>
											<script type="text/javascript">
			            						function blinker() {
			                						$('.blink_me').fadeOut(1000);
			                						$('.blink_me').fadeIn(1000);
			            						}
			            						setInterval(blinker, 1000);
			    							</script>
			    						<?php }?>
						    		<?php }?>
						    		<br>
						    		Registration closes in <span id="time">02:00</span> minutes!
						    	</div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="pengerjaan_soal_id">
			
		</div>
	</form>
</div>



<script type="text/javascript">
	function get_list_tkb(){
		var nik 		= $('#nik_id').val();

		 //alert(nik);
		$.ajax({
			type: "POST",
			dataType: "html",
			url : "<?php echo site_url('TrainingOnline/cari_tenaga_kerja/')?>"+nik,

			success: function(msg){
				$('#ajaxfrommodal').html(msg);
			}
		});
	}

	function getRuangan() {
		var ruangan = $('#ruangan').val();

		$.ajax({
			type: "POST",
			dataType: "html",
			url : "<?php echo site_url('TrainingOnline/getRuangan/')?>"+ruangan,

			success: function(msg){
				$('#ruangan_id').html(msg);
			}
		});
	}

	function start(){
		var materi 		  = $('#materidtl_id').val();
		var jenis_soal    = $('#jenis_soal').val();
		var idHdrSoal 	  = $('#txtHdrSoal').val();
		var jam           = $('#waktuPublish').val();
        var jam_sekarang  = $('#JamSekarang').val();
        var jam_akhir 	  = $('#waktu').val();
        var nik_id 		  = $('#nik_id').val();
        

        
		
		if(jam_sekarang >= jam){
			
        		$.ajax({
					type: "POST",
					dataType: "html",
					url : "<?php echo site_url('TrainingOnline/getDataSoal/')?>"+materi+"/"+jenis_soal+"/"+idHdrSoal+"/"+nik_id,

					success: function(msg){
						$('#pengerjaan_soal_id').html(msg);
						waktu_pengerjaan();
					}
				});
	        
            
        }else{
            Swal.fire('HALAMAN INI TIDAK DAPAT DI AKSES', `Silahkan hubungi HRD untuk mengakses halaman ini..!!`, `warning`).then((result)=>{
                window.location.reload();                                               
            });
        }

	}

	function waktu_pengerjaan(){
		var setting_waktu = $('#waktu').val();
		var tanggal 	  = $('#Tanggal').val();

		var tgl = tanggal+" "+setting_waktu;
		// console.log(setting_waktu);
		console.log(tgl);
		var countDownDate = new Date(tgl).getTime();
		console.log(countDownDate);

		// Update the count down every 1 second
		var x = setInterval(function() {

		// Get today's date and time
		var now = new Date().getTime();
		    
		  // Find the distance between now and the count down date
		  var distance = countDownDate - now;
		    
		  // Time calculations for days, hours, minutes and seconds
		  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		    
		  // Output the result in an element with id="demo"
		  document.getElementById("time").innerHTML = minutes + "m " + seconds + "s ";
		    
		  // If the count down is over, write some text 
		  if (distance < 0) {
		    clearInterval(x);
		    document.getElementById("time").innerHTML = "EXPIRED";
		     simpan();
		    Swal.fire('WAKTU HABIS', `Data akan tersimpan otomatis`, `success`).then((result)=>{
                window.location.reload();                                               
            });
		  }
		}, 1000);
	}

	

</script>
<script type="text/javascript">
	function simpan(){
		var jmlBaris  = document.getElementsByClassName('txt').length;
		var nik_id = document.getElementById("nik_id");
		var karyawanSt = document.getElementById("karyawanSt");
		var idPerson = document.getElementById("idPerson");
		var dept = document.getElementById("dept");
		var bagianID = document.getElementById("bagianID");
		var jenis_soal = document.getElementById("jenis_soal");
		var materidtl_id = document.getElementById("materidtl_id");
		var ruangan = document.getElementById("ruangan");
		var nama_ruangan = document.getElementById("nama_ruangan");
		var txtHdrSoal = document.getElementById("txtHdrSoal");
		var hdrid_jawaban = document.getElementById("hdr_id_jawaban");
		var data_jawaban = [];
		for(var i= 0; i<=jmlBaris;i++){
			var soal_id = document.getElementById(`soal_id_${i}`);
			var jawaban = document.getElementsByClassName(`txtobjectif_${i}`);
			var detailid = document.getElementsByClassName(`detail_id_${i}`);
			for(var j = 0; j < jawaban.length; j++){
				if(jawaban[j].checked){
		        	data_jawaban.push({"soal_id": soal_id.value, "jawaban":jawaban[j].value, "detailid":detailid[j].value});
		      	}

			}
        }

        // console.log(data_jawaban);

		$.ajax({
            url:"<?php echo base_url();?>TrainingOnline/simpan",
            type: "POST",
            dataType : "JSON",
            data: 
            {
            	"nik_id" : nik_id.value,
            	"karyawanSt" : karyawanSt.value,
            	"idPerson" : idPerson.value, 
            	"dept" : dept.value,
            	"bagianID" : bagianID.value,
            	"data_jawaban" : data_jawaban,
            	"jenis_soal"   : jenis_soal.value,
            	"materidtl_id" : materidtl_id.value,
            	"ruangan" : ruangan.value,
            	"nama_ruangan" : nama_ruangan.value,
            	"txtHdrSoal"   : txtHdrSoal.value,
            	"hdrid_jawaban"   : hdrid_jawaban.value,
            	"data_jawaban" : data_jawaban,
            },
            // beforeSend:function()
            // {

            // },
            error: function(){
        		Swal.fire('Gagal', `Server tidak merespon`, `error`).then((result)=>{
	            	window.location.reload();
               });
            },
         	success: function(pesan){
             	if(pesan > 0){
             		
                    Swal.fire('Berhasil', `Data Berhasil Disimpan`, `success`).then((result)=>{
                        window.location.href = `<?php echo base_url()?>TrainingOnline/lihat_hasil?hdrid=${hdrid_jawaban.value}&status=${karyawanSt.value}#`;                        
                    });
               }else if(pesan == "lebih3x"){
	         		Swal.fire('Gagal', `Data gagal Disimpan NIK sudah input 3x`, `error`).then((result)=>{
	                    window.location.reload();	                                            
	                });
               }else if(pesan == "bedadept"){
	         		Swal.fire('Gagal', `Mohon maaf anda tidak terdaftar di Dept`, `error`).then((result)=>{
	                    window.location.reload();	                                            
	                });
               }else{
             		alert("GAGAL");
             		// console.log(pesan);
             	}
            }
         });
	}
</script>
