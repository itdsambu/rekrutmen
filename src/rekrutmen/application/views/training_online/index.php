<link href="<?php echo base_url(); ?>assets/plugins/FlipClock-master/compiled/flipclock.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/sweetalert2-11.3.6/dist/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>assets/sweetalert2-11.3.6/dist/sweetalert2.min.js"></script>
<?php foreach ($_dept as $dept) {
	$nama_dept = $dept->DeptAbbr;
} ?>
<div id="successid">
	<form class="form-horizontal" role="form" method="POST" id="formSave">
		<div class="row">
			<div class="col-12">
				<div class="card m-b-20">
					<div class="card-body">
						<div class="alert alert-primary">
							<h4 class="mt-0 header-title"><b> <center>DATA DIRI</center> </b></h4>
						</div>
						<br>
						<div id="ajaxfrommodal">
							<?php if ($nama_dept == 'ELC') { ?>
								<div class="form-group row">
									<label for="example-search-input" class="col-sm-2 col-form-label">Status Pekerja</label>
									<div class="col-sm-4" id="status">
										<select class="form-control status" name="txtStatus" id="sts_pekerja">
											<option value="">- Pilih Status TK -</option>
											<option value="1">Tenaga Kerja</option>
											<option value="2">Non Tenaga Kerja</option>
										</select>
									</div>
								</div>
								<?php
							} ?>

							<div class="form-group row NIK">
								<label for="example-search-input" class="col-sm-2 col-form-label">NIK</label>
								<div class="col-sm-4">
									<input type="text" name="txtNik" id="nik_id" class="form-control" onchange="get_list_tkb();" placeholder="Input NIK">
									<input type="hidden" name="txtfixReg" id="fixreg" class="form-control" readonly required>
									<input type="hidden" name="txtPerson" id="idPerson" class="form-control" readonly required>
									<input type="hidden" name="txtStatusPerson" id="karyawanSt" class="form-control" readonly required>
								</div>
							</div>

							<div class="form-group row ID">
								<label for="example-search-input" class="col-sm-2 col-form-label">ID</label>
								<div class="col-sm-4">
									<input type="text" name="txtId" id="id_register" class="form-control" onchange="get_list_tkb();" placeholder="Input ID" required>
								</div>
							</div>

							<div class="form-group row">
								<label for="example-search-input" class="col-sm-2 col-form-label">Nama</label>
								<div class="col-sm-4">
									<input type="text" name="txtNama" id="nama_lengkap" class="form-control nama_lengkap" readonly required placeholder="Nama Auto">
								</div>
							</div>

							<div class="form-group row" id="bagian">
								<label for="example-search-input" class="col-sm-2 col-form-label">Bagian</label>
								<div class="col-sm-4">
									<input type="text" name="txtBagian" id="bagian" class="form-control bagian" readonly required placeholder="Bagian Auto">
									<input type="hidden" name="txtBagianID" id="bagianID" class="form-control" readonly required placeholder="Bagian Auto">
								</div>
							</div>

							<div class="form-group row" id="jabatan">
								<label for="example-search-input" class="col-sm-2 col-form-label">Jabatan</label>
								<div class="col-sm-4">
									<input type="text" name="txtJabatan" id="jabatan" class="form-control jabatan" readonly required placeholder="Jabatan Auto">
								</div>
							</div>

						</div>
						<br>
						<br>
						
						<div class="alert alert-primary">
							<h4 class="mt-0 header-title"><b> <center>KRITERIA SOAL </center> </b></h4>
						</div>
						<br>
						<div class="form-group row">
							<label for="example-search-input" class="col-sm-2 col-form-label">Departemen</label>
							<div class="col-sm-4">
								<select class="form-control" name="txtDept" id="dept" readonly>
									<?php foreach ($_dept as $dept) {
										echo "<option value='$dept->DeptID'>" . $dept->DeptAbbr . "</option>";
									} ?>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label for="example-search-input" class="col-sm-2 col-form-label">Jenis Soal</label>
							<div class="col-sm-4">
								<select class="form-control" name="txtJenisSoal" id="jenis_soal" readonly>
									<option value="">- Pilih Jenis Soal -</option>
									<?php if ($jenis_soal == 1) {
										echo '<option value="1" selected>Pre Test</option>
						            			 <option value="2">Post Test</option>';
									} elseif ($jenis_soal == 2) {
										echo '<option value="1">Pre Test</option>
						            			 <option value="2" selected>Post Test</option>';
									} else {
										echo '<option value="1">Pre Test</option>
						            			 <option value="2">Post Test</option>';
									} ?>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label for="example-search-input" class="col-sm-2 col-form-label">Materi</label>
							<?php if ($nama_dept == 'ELC') { ?>
								<div class="col-sm-4">
									<textarea class="form-control" name="txtMateri" id="materi_id" readonly></textarea>
									<!-- <input type="text" class="form-control" name="txtMateri" id="materi_id" value="" readonly> -->
								</div>
								<input type="hidden" name="txtMateriid" id="materidtl_id" value="">
								<input type="hidden" name="txtIdKategoriMateri" id="idKategoriMateri">
								<?php
							} else { ?>
								<?php foreach ($materi as $mtr) { ?>
									<div class="col-sm-4">
										<textarea class="form-control" name="txtMateri" id="materi_id" readonly><?php echo $mtr->JudulMateri; ?></textarea>
									</div>
									<input type="hidden" name="txtMateriid" id="materidtl_id" value="<?php echo $mtr->IKPMateriDtl ?>">
									<input type="hidden" name="txtIdKategoriMateri" id="idKategoriMateri">
									<?php 
								}
							} ?>
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
						<?php foreach ($getSoal as $row) { ?>
							<input type="hidden" name="txtHdrSoal" id="txtHdrSoal" value="<?php echo $row->IdMstSoalHdr; ?>" class="txt form-control">
							<?php 
						} ?>

						<div class="form-group row">
							<label for="example-search-input" class="col-sm-2 col-form-label">Waktu Pengerjaan</label>
							<div class="col-sm-4">
								<?php foreach ($_getWaktu as $key) {
									$durasi = $key->SettingWaktu;
									$waktu = date('H:i:s', strtotime($key->WaktuPublish . '+' . $durasi . ' minute'));

									$tanggal_sekarang = date('M d, Y');
									$tanggal_publis = date('M d, Y', strtotime($key->WaktuPublish)); ?>

									<input type="hidden" name="txtWaktu" id="waktu" class="form-control" value="<?php echo $waktu; ?>">
									<input type="hidden" name="txtTanggal" id="Tanggal" value="<?php echo date('M d, Y', strtotime($key->WaktuPublish)); ?>">
									<input type="hidden" name="txtWaktuPublish" id="waktuPublish" value="<?php echo date('H:i:s', strtotime($key->WaktuPublish)); ?>">
									<input type="hidden" name="txtJamSekarang" id="JamSekarang" value="<?php echo date('H:i:00'); ?>">

									<?php if ($tanggal_publis == $tanggal_sekarang) { ?>
										<a href="#" class="btn btn-md btn-success" onclick="start()">START</a>
										<?php 
									} else { ?>
										<div class="card-body">
											<div class="alert alert-danger" role="alert">
												<h2 class="alert-heading font-18 blink_me" style="text-align: center;"></h2>
												<h2 class="alert-heading font-18 blink_me" style="text-align:center;font-weight: bold;">HALAMAN TIDAK DAPAT DI AKSES..!!</h2>
												<p class="mb-0" style="text-align:center;"></p>
											</div>
										</div>
										<script type="text/javascript">
											function blinker() {
												$('.blink_me').fadeOut(2000);
												$('.blink_me').fadeIn(1000);
											}
											setInterval(blinker, 1000);
										</script>
										<?php 
									} ?>
									<?php 
								} ?>
								<br>
								Registration closes in <span id="time"></span> minutes!
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="row" id="pengerjaan_soal_id">

		</div>
		<div class="row" id="ttd_view">

		</div>
	</form>
</div>

<script type="text/javascript">
	const nik        = document.querySelector('.NIK');
	const id         = document.querySelector('.ID');
	const bagian     = document.querySelector('#bagian');
	const jabatan    = document.querySelector('#jabatan');
	
	nik.style.display    = 'none';
	id.style.display     = 'none';

	const status = document.querySelector("div#status select");

	status.addEventListener('change', function() {

		if (this.value == 1) {
			nik.style.display        = 'block';
			id.style.display         = 'none';
			bagian.style.display     = 'block';
			jabatan.style.display    = 'block';

			$.ajax({
				type: "POST",
				url: `<?php echo site_url('TrainingOnline/getKategoriMateri'); ?>`,
				data: {data: this.value},
				dataType: "json",
				success: function (response) {
					if (response.status == true) {
						$('#idKategoriMateri').val(response.data[0].KategoriMateri);
						$('#materi_id').text(response.data[0].NamaMateri);
						$('#materidtl_id').val(response.data[0].IKPMateriDtl);
						
					} else {
						Swal.fire('Oops!', `Materi untuk Tenaga Kerja Belum ada ..!!`, `warning`).then((result) => {
							window.location.reload();
						});
					}
				}
			});

		} else if (this.value == 2) {
			id.style.display       = 'block';
			nik.style.display      = 'none';
			bagian.style.display   = 'none';
			jabatan.style.display  = 'none';

			$.ajax({
				type: "POST",
				url: `<?php echo site_url('TrainingOnline/getKategoriMateri'); ?>`,
				data: {data: this.value},
				dataType: "json",
				success: function (response) {
					if (response.status == true) {
						$('#idKategoriMateri').val(response.data[0].KategoriMateri);
						$('#materi_id').text(response.data[0].NamaMateri);
						$('#materidtl_id').val(response.data[0].IKPMateriDtl);

					} else {
						Swal.fire('Oops!', `Materi untuk Non Tenaga Kerja Belum ada ..!!`, `warning`).then((result) => {
							window.location.reload();
						});
					}
				}
			});

		} else {
			id.style.display       = 'none';
			nik.style.display      = 'none';
			bagian.style.display   = 'block';
			jabatan.style.display  = 'block';
		}
	});
</script>

<script type="text/javascript">
	// $('.navbar-header .navbar-brand small').prop('style', 'display:none');
	$('.navbar-buttons').prop('style', 'display:none');
	$('#menu-toggler').prop('style', 'display:none');
	$('head title').text('PostTest/PreTest Training Online');
	$('.navbar-header .navbar-brand small').empty().append('PostTest/PreTest Training Online');

	function get_list_tkb() {
		let nik         = $('#nik_id').val();
		let dept        = $('#dept').val();
		let dept_text   = $('#dept').find('option:selected').text();
		let status_tk	= $('.status').find('option:selected').val();
		let id_register = $('#id_register').val();

		const rmName = document.querySelector('div#nmLengkap');
		
		if (status_tk == 1 && dept != '') {
			$.ajax({
				type: "POST",
				url: `<?php echo site_url('TrainingOnline/get_tenaga_kerja'); ?>`,
				data: {
					nik,
					dept
				},
				dataType: "json",
				success: function (response) {
					if (response.status == true) {
						$('#fixreg').val(response.data.RegFixno);
						$('#idPerson').val(response.data.PersonID);
						$('#karyawanSt').val(response.data.StatusPerson);
						$('#nama_lengkap').val(response.data.Nama);
						$('.bagian').val(response.data.Departemen);
						$('#bagianID').val(response.data.DeptID);
						$('.jabatan').val(response.data.Jabatan);
					} else {
						// Swal.fire('NIK TIDAK TERDAFTAR', `Sebagai Peserta Pada Departemen `+dept_text+`..!!`, `warning`).then((result) => {
						// 	window.location.reload();
						// });
						Swal.fire('HALAMAN INI TIDAK DAPAT DI AKSES', `Anda Tidak Terdaftar Sebagai PESERTA `+dept+`..!!`, `warning`).then((result) => {
							window.location.reload();
						});
					}
				}
			});
		} else if (dept == 13) {
			$.ajax({
				type: "POST",
				url: `<?php echo site_url('TrainingOnline/get_calon_tk'); ?>`,
				data: {
					id_register,
					dept_text
				},
				dataType: "json",
				success: function (response) {
					if (response.status == true) {
						$.each(response.data, function (key, value) { 
							let nameTkb = value.Nama;
							$('#nama_lengkap').val(nameTkb);
						});
					} else {
						Swal.fire('ID TIDAK TERDAFTAR', `untuk mengikuti PostTest/PreTest Training Online ..!!`, `warning`).then((result) => {
							window.location.reload();
						});
					}

					settingNode();
				}
			});
		} else {
			Swal.fire('404', `Halaman ini tidak dapat di akses ..!!`, `warning`).then((result) => {
				window.location.reload();
			});
		}
	}

	function settingNode() {
		let status_tk   = $('.status').find('option:selected').val();
		const nik       = document.querySelector('.NIK');
		const id        = document.querySelector('.ID');

		const status    = document.querySelector("div#status select");

		if (status == 1) {
			if (status_tk == 1) {
				nik.style.display    = 'block';
				id.style.display     = 'none';
			} else {
				nik.style.display    = 'none';
				id.style.display     = 'block';
			}

			status.addEventListener('change', function() {
				if (this.value == 1) {
					nik.style.display    = 'block';
					id.style.display     = 'none';
					// $('.nama_lengkap').text('tes');

				} else if (this.value == 2) {
					id.style.display   = 'block';
					nik.style.display  = 'none';
					// $('.nama_lengkap').text('tes2');

				} else {
					id.style.display   = 'none';
					nik.style.display  = 'none';

					window.location.reload();
				}
			});
		} else {
			if (status_tk == 1) {
				nik.style.display    = 'block';
				id.style.display     = 'none';
			} else {
				nik.style.display    = 'none';
				id.style.display     = 'block'
			}

			status.addEventListener('change', function() {
				if (this.value == 1) {
					nik.style.display    = 'block';
					id.style.display     = 'none';
				} else if (this.value == 2) {
					id.style.display   = 'block';
					nik.style.display  = 'none';
				} else {
					id.style.display   = 'none';
					nik.style.display  = 'none';

					window.location.reload();
				}
			});
		}
	}

	function getRuangan() {
		var ruangan = $('#ruangan').val();

		$.ajax({
			type: "POST",
			dataType: "html",
			url: "<?php echo site_url('TrainingOnline/getRuangan/') ?>" + ruangan,

			success: function(msg) {
				$('#ruangan_id').html(msg);
			}
		});
	}

	function viewttd() {
		$('.btn_ttd').prop('style', 'display: none');
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "<?php echo site_url('TrainingOnline/get_tanda_tangan') ?>",

			success: function(msg) {
				$('#ttd_view').html(msg);
			}
		});
	}

	function start() {
		let materi        = $('#materidtl_id').val();
		let jenis_soal    = $('#jenis_soal').val();
		let idHdrSoal     = $('#txtHdrSoal').val();
		let jam           = $('#waktuPublish').val();
		let jam_sekarang  = $('#JamSekarang').val();
		let jam_akhir     = $('#waktu').val();
		let nik_id        = $('#nik_id').val();
		let dept          = $('#dept').val();
		let bagian        = $('#bagianID').val();
		let ruangan       = $('#ruangan').val();
		let karyawanSt    = $("#karyawanSt").val();
		let fixReg        = $("#fixreg").val();
		let id_register   = $('#id_register').val();

		// if (nik_id != '') {
		// 	if (jam_sekarang >= jam) {
		// 		if (ruangan != '') {
		// 			$.ajax({
		// 				type: "POST",
		// 				url: "<?php echo site_url('TrainingOnline/getDataSoal/') ?>",
		// 				data: {
		// 					materi,
		// 					jenis_soal,
		// 					idHdrSoal,
		// 					nik_id
		// 				},
		// 				dataType: "json",
		// 				success: function (response) {
		// 					console.log(response);
		// 				}
		// 			});
		// 		} else {
		// 			Swal.fire('Oops!', `HARAP ISI RUANGAN TERLEBIH DAHULU..!!`, `warning`).then((result) => {
		// 				window.location.reload();
		// 			});
		// 		}
		// 	} else {
		// 		Swal.fire('HALAMAN INI TIDAK DAPAT DI AKSES', `Silahkan hubungi HRD untuk mengakses halaman ini..!!`, `warning`).then((result) => {
		// 			window.location.reload();
		// 		});
		// 	}
		// } else if (id_register != '') {
		// 	if (jam_sekarang >= jam) {
		// 		if (ruangan != '') {
		// 			console.log(ruangan);
		// 		} else {
		// 			Swal.fire('Oops!', `HARAP ISI RUANGAN TERLEBIH DAHULU..!!`, `warning`).then((result) => {
		// 				window.location.reload();
		// 			});
		// 		}
		// 	} else {
		// 		Swal.fire('HALAMAN INI TIDAK DAPAT DI AKSES', `Silahkan hubungi HRD untuk mengakses halaman ini..!!`, `warning`).then((result) => {
		// 			window.location.reload();
		// 		});
		// 	}
		// } else {
		// 	Swal.fire('Oops!', `Kolom NIK / ID tidak boleh kosong..!!`, `warning`).then((result) => {
		// 		window.location.reload();
		// 	});
		// }

		if (jam_sekarang >= jam) {
			if (dept == bagian) {
				if (ruangan != '') {
					$.ajax({
						type: "POST",
						dataType: "html",
						url: "<?php echo site_url('TrainingOnline/getDataSoal/') ?>" + materi + "/" + jenis_soal + "/" + idHdrSoal + "/" + nik_id,

						success: function(msg) {
							$('#pengerjaan_soal_id').html(msg);
							waktu_pengerjaan();
						}
					});
				} else {
					Swal.fire('HARAP ISI RUANGAN TERLEBIH DAHULU..!!', ``, `warning`).then((result) => {
						window.location.reload();
					});
				}
			} else if (dept == 13) {
				if (ruangan != '') {
					$.ajax({
						type: "POST",
						dataType: "html",
						url: "<?php echo site_url('TrainingOnline/getDataSoal/') ?>" + materi + "/" + jenis_soal + "/" + idHdrSoal + "/" + nik_id,

						success: function(msg) {
							$('#pengerjaan_soal_id').html(msg);
							waktu_pengerjaan();
						}
					});
				} else {
					Swal.fire('HARAP ISI RUANGAN TERLEBIH DAHULU..!!', ``, `warning`).then((result) => {
						window.location.reload();
					});
				}
			} else {
				Swal.fire('HALAMAN INI TIDAK DAPAT DI AKSES', `Anda Tidak Terdaftar Sebagai PESERTA `+dept+`..!!`, `warning`).then((result) => {
					window.location.reload();
				});
			}
		} else {
			Swal.fire('HALAMAN INI TIDAK DAPAT DI AKSES', `Silahkan hubungi HRD untuk mengakses halaman ini..!!`, `warning`).then((result) => {
				window.location.reload();
			});
		}
	}

	function waktu_pengerjaan() {
		let setting_waktu   = $('#waktu').val();
		let tanggal         = $('#Tanggal').val();

		// let tgl = tanggal + " " + setting_waktu;

		let tgl = `${tanggal} ${setting_waktu}`;

		let countDownDate = new Date(tgl).getTime();

		// // Update the count down every 1 second
		let x = setInterval(function() {

			// Get today's date and time
			let now = new Date().getTime();
			// Find the distance between now and the count down date
			let distance = countDownDate - now;

			// Time calculations for days, hours, minutes and seconds
			let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			let seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Output the result in an element with id="demo"
			document.getElementById("time").innerHTML = minutes + "m " + seconds + "s ";

			// console.log(`${minutes} m ${seconds} s`);
			// If the count down is over, write some text 
			if (distance < 0) {
				clearInterval(x);
				document.getElementById("time").innerHTML = "EXPIRED";
				// simpan();
				Swal.fire('WAKTU HABIS', `Data akan tersimpan otomatis`, `success`).then((result) => {
					window.location.reload();
				});
			}
		}, 1000);
	}
</script>

<script type="text/javascript">
	$('#sts_pekerja').change(function () {
		if ( this.value == 1) {
			$('#nama_lengkap').val('');
		} else if ( this.value == 2) {
			$('#nik_id').val('');
			$('#fixreg').val('');
			$('#idPerson').val('');
			$('#karyawanSt').val('');
			$('#nama_lengkap').val('');
			$('.bagian').val('');
			$('#bagianID').val('');
			$('.jabatan').val('');
			$('#materi_id').text('');
		} else {
			console.log('====================================');
			console.log(`Clear !!!`);
			console.log('====================================');
			window.location.reload();
		}
	});

	function simpan() {
		var jmlBaris        = document.getElementsByClassName('txt').length;
		var nik_id          = document.getElementById("nik_id");
		var karyawanSt      = document.getElementById("karyawanSt");
		var idPerson        = document.getElementById("idPerson");
		var dept            = document.getElementById("dept");
		var bagianID        = document.getElementById("bagianID");
		var jenis_soal      = document.getElementById("jenis_soal");
		var materidtl_id    = document.getElementById("materidtl_id");
		var ruangan         = document.getElementById("ruangan");
		//var nama_ruangan = document.getElementById("nama_ruangan");
		var txtHdrSoal      = document.getElementById("txtHdrSoal");
		var hdrid_jawaban   = document.getElementById("hdr_id_jawaban");
		var txtfixReg       = document.getElementById("fixreg");
		var nama_lengkap    = document.getElementById("nama_lengkap");

		var canvas          = document.getElementById("can");
		var dataURL         = canvas.toDataURL("image/png");
		var hidden_data     = document.getElementById('hidden_data').value = dataURL;

		var data_jawaban = [];
		for (var i = 0; i <= jmlBaris; i++) {
			var soal_id = document.getElementById(`soal_id_${i}`);
			var jawaban = document.getElementsByClassName(`txtobjectif_${i}`);
			var detailid = document.getElementsByClassName(`detail_id_${i}`);
			for (var j = 0; j < jawaban.length; j++) {
				if (jawaban[j].checked) {
					data_jawaban.push({
						"soal_id": soal_id.value,
						"jawaban": jawaban[j].value,
						"detailid": detailid[j].value
					});
				}

			}
		}
		$.ajax({
			url: "<?php echo base_url(); ?>TrainingOnline/simpan",
			type: "POST",
			dataType: "JSON",
			data: {
				"nik_id": nik_id.value,
				"karyawanSt": karyawanSt.value,
				"idPerson": idPerson.value,
				"dept": dept.value,
				"bagianID": bagianID.value,
				"data_jawaban": data_jawaban,
				"jenis_soal": jenis_soal.value,
				"materidtl_id": materidtl_id.value,
				"ruangan": ruangan.value,
				//"nama_ruangan" : nama_ruangan.value,
				"txtHdrSoal": txtHdrSoal.value,
				"hdrid_jawaban": hdrid_jawaban.value,
				"data_jawaban": data_jawaban,
				"hidden_data": hidden_data,
				"fixreg": txtfixReg.value,
			},
			// beforeSend:function()
			// {

			// },
			error: function() {
				Swal.fire('Gagal', `Server tidak merespon`, `error`).then((result) => {
					window.location.reload();
				});
			},
			success: function(pesan) {
				if (pesan > 0) {
					Swal.fire('Berhasil', `Data Berhasil Disimpan`, `success`).then((result) => {
						window.location.href = `<?php echo base_url() ?>TrainingOnline/lihat_hasil?hdrid=${hdrid_jawaban.value}&status=${karyawanSt.value}&fixregno=${fixreg.value}&nama=${nama_lengkap.value}#`;
					});
				} else if (pesan == "lebih3x") {
					Swal.fire('Gagal', `Data gagal Disimpan NIK sudah input 3x`, `error`).then((result) => {
						window.location.reload();
					});
				} else if (pesan == "bedadept") {
					Swal.fire('Gagal', `Mohon maaf anda tidak terdaftar di Dept`, `error`).then((result) => {
						window.location.reload();
					});
				} else {
					alert("GAGAL");
				}
			}
		});
	}
</script>