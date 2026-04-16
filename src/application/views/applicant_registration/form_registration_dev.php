<?php $this->load->view('applicant_registration/templates/header'); ?>
<style>
    .section {
        display: none;
    }

    .section.active {
        display: block;
    }

    /* Untuk mencegah background putih */
    body {
        background-color: #f4f4f4;
    }

    /* Gaya untuk overlay loading */
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        /* Tersembunyi secara default */
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* Gaya untuk teks loading */
    #loading-text {
        color: white;
        font-size: 24px;
        text-align: center;
        /* Mengatur teks ke tengah */
        position: absolute;
        /* Memungkinkan posisi teks di tengah */
        top: 50%;
        /* Pusat vertikal */
        left: 50%;
        /* Pusat horizontal */
        transform: translate(-50%, -50%);
        /* Menggeser teks ke tengah */
    }

    /* baru */
    @media screen and (max-width: 576px) {
    .card-title {
        font-size: 1.2rem;
    }

    label, span {
        font-size: 0.9rem;
    }

    .custom-file-label {
        font-size: 0.9rem;
    }
}

</style>

<!-- Overlay loading -->
<div id="loading-overlay">
    <div>
        <div id="loading-text"></div>
    </div>
</div>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">

            <form action="<?= base_url() ?>" method="POST" id="send-data">
                <!-- Section 1: Data Pribadi -->
                <section class="row flexbox-container active" id="section-1">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                            <h4 class="card-title"><i class="feather icon-user"></i> Data Pribadi</h4>
                            </div>
                            <div class="card-content">
                            <div class="card-body">
                                <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="form-group row">
                                    <label class="col-md-4 col-12 col-form-label">Nama Lengkap*</label>
                                    <div class="col-md-8 col-12">
                                        <input type="text" id="inputNamaLengkap" class="form-control" name="txtNama" placeholder="Nama Lengkap (Sesuai KTP)" value="<?= $nmlengkap ?>" required readonly>
                                        <input type="hidden" id="txtPerusahaan" name="txtPerusahaan" value="PT PULAU SAMBU" required>
                                        <input type="hidden" id="txtPemborong" name="txtPemborong" value="PT PULAU SAMBU" required>
                                        <input type="hidden" id="txtIDPemborong" name="txtIDPemborong" value="19" required>
                                        <input type="hidden" id="txtSubPemborong" name="txtSubPemborong" value="PT PULAU SAMBU,63" required>
                                        <input type="hidden" name="txtConfirm" id="inputConfirm" value="0" readonly>
                                    </div>
                                    </div>

                                    <div class="form-group row">
                                    <label class="col-md-4 col-12 col-form-label">NO. KTP*</label>
                                    <div class="col-md-8 col-12">
                                        <input type="text" id="inputNoKTP" class="form-control isNumberKey" name="txtNoKTP" placeholder="KTP" maxlength="16" required value="<?= $ktp ?>">
                                        <small id="ktpError" class="text-danger d-block" style="display: none;"></small>
                                    </div>
                                    </div>

                                    <div class="form-group row">
                                    <label class="col-md-4 col-12 col-form-label">File KTP*</label>
                                    <div class="col-md-8 col-12">
                                        <div class="custom-file">
                                        <input type="file" name="txtFileKTP" class="custom-file-input" id="pdfUpload" accept=".pdf" required>
                                        <label class="custom-file-label" for="pdfUpload">Upload KTP Format PDF</label>
                                        </div>
                                        <canvas id="pdfPreview" style="display: none; margin-top: 10px; max-width: 100%; height: auto; width: 150px; height: 100px;"></canvas>
                                    </div>
                                    </div>

                                    <div class="form-group row">
                                    <label class="col-md-4 col-12 col-form-label">No KK*</label>
                                    <div class="col-md-8 col-12">
                                        <input type="text" id="inputNoKK" class="form-control isNumberKey" name="txtNoKK" placeholder="No KK" required maxlength="16">
                                        <small id="noKKError" class="text-danger d-block" style="display:none;">No KK harus terdiri dari 16 digit angka.</small>
                                    </div>
                                    </div>

                                    <div class="form-group row">
                                    <label class="col-md-4 col-12 col-form-label">Alamat Sesuai KTP*</label>
                                    <div class="col-md-8 col-12">
                                        <textarea class="form-control" name="txtAlamatKTP" id="inputAlamatKtp" placeholder="Input Alamat Sesuai e-KTP"></textarea>
                                    </div>
                                    </div>

                                    <div class="form-group row">
                                    <label class="col-md-4 col-12 col-form-label">Alamat Sekarang*</label>
                                    <div class="col-md-8 col-12">
                                        <textarea class="form-control" name="txtAlamat" id="inputAlamat" placeholder="Input Alamat Sekarang"></textarea>
                                    </div>
                                    </div>

                                    <div class="form-group row">
                                    <div class="col-6 col-sm-4">
                                        <label>RT*</label>
                                        <input type="text" id="inputRT" class="form-control" name="txtRT" placeholder="RT">
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <label>RW*</label>
                                        <input type="text" id="inputRW" class="form-control" name="txtRW" placeholder="RW">
                                    </div>
                                    <div class="col-12 col-sm-4 mt-1 mt-sm-0">
                                        <label>Kelurahan*</label>
                                        <input type="text" id="inputKelurahan" class="form-control" name="txtKelurahan" placeholder="Kelurahan">
                                    </div>
                                    </div>

                                    <div class="form-group row">
                                    <div class="col-12 d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-primary w-100 w-sm-auto next-btn" data-next="2">Next</button>
                                    </div>
                                    </div>

                                </div> <!-- .form-body -->
                                </div> <!-- .form -->
                            </div> <!-- .card-body -->
                            </div> <!-- .card-content -->
                        </div> <!-- .card -->
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                    </section>


                <!-- Section 2: Data Probadi next -->
                <section class=" row flexbox-container" id="section-2" style="display: none;">
                    <div class="col-xl-12 col-12 d-flex justify-content-center">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="feather icon-user"></i> Data Pribadi</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Tinggal Dengan*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputTinggalDengan" class="form-control" name="txtTinggalDengan" placeholder="Tinggal Dengan" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Hubungan dengan Calon Pelamar*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputTinggalDengan" class="form-control" name="txtHubungan" placeholder="Hubungan dengan Calon Pelamar" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Nomor Ponsel*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputNoPonsel" class="form-control isNumberKey" name="txtNoPonsel" placeholder="0822XXXXXX" required maxlength="13">
                                                                <small id="noPonselError" class="text-danger" style="display:none;">Nomor ponsel harus terdiri dari 10-13 digit angka.</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Tempat Lahir*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputTempatLahir" class="form-control" name="txtTempatLahir" placeholder="Input Tempat Lahir" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Tanggal Lahir*</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <!-- <input type="text" id="inputTanggalLahir" class="form-control" name="txtTanggalLahir" placeholder="Input Tanggal Lahirs" required> -->
                                                                <div class="input-group date datepicker">
                                                                    <span class="input-group-prepend">
                                                                        <button class="btn btn-primary waves-effect waves-light" type="button"><i class="feather icon-calendar"></i></button>
                                                                    </span>
                                                                    <input class="form-control maskdate valid_date dttgl" size="10" type="text" name="txtTanggalLahir" id="inputTanggalLahir" placeholder="dd-mm-yyyy" autocomplete="off" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <span>Usia*</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" id="inputUmur" class="form-control" name="txtUmur" placeholder="Usia" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Jenis Kelamin*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtJekel" id="customRadio1" value="LAKI-LAKI" checked required>
                                                                                <label class="custom-control-label" for="customRadio1">Laki-laki</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtJekel" value="PEREMPUAN" id="customRadio2">
                                                                                <label class="custom-control-label" for="customRadio2">Perempuan</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Tinggi Badan</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputTinggiBadan" class="form-control isNumberKey" name="txtTinggiBadan" placeholder="Input Tinggi Badan">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Berat Badan</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputBeratBadan" class="form-control isNumberKey" name="txtBeratBadan" placeholder="Input Berat Badan">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Suku*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="select2 form-control" name="txtSuku" id="txtSuku" required>
                                                                    <option value="">-Pilih-</option>
                                                                    <?php
                                                                    foreach ($_getSuku as $rowSuku) :
                                                                        echo "<option value='$rowSuku->Suku'>$rowSuku->Suku</option>";
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Tombol Previous & Next -->
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <button type="button" class="btn btn-secondary prev-btn" data-prev="1">Previous</button>
                                                        <button type="button" class="btn btn-primary next-btn" data-next="3">Next</button>
                                                        <!-- <button type="submit" class="btn btn-primary ">submit</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 3: Data Probadi next -->
                <section class="row flexbox-container" id="section-3" style="display: none;">
                    <div class="col-xl-12 col-12 d-flex justify-content-center">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="feather icon-user"></i> Data Pribadi</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Daerah Asal*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputDaerahAsal" class="form-control" name="txtDaerahAsal" placeholder="Input Daerah Asal" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Provinsi*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="select2 form-control" name="txtProvinsi" id="selectProvinsi" required>
                                                                    <option value="">-Pilih-</option>
                                                                    <?php
                                                                    foreach ($_getprovinsi as $row) :
                                                                        echo "<option value='$row->ProvinsiID'>$row->ProvinsiName</option>";
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Kabupaten*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="select2 form-control" name="txtKabupaten" id="selectKabupaten" required>
                                                                    <option value="">-Pilih-</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Kecamatan*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="select2 form-control" name="txtKecamatan" id="selectKecamatan" required>
                                                                    <option value="">-Pilih-</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Bahasa Daerah</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputBahasaDaerah" class="form-control " name="txtBahasaDaerah" placeholder="Input Bahasa Daerah">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Agama*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="select2 form-control" name="txtAgama" id="txtAgama" required>
                                                                    <option value="">-Pilih-</option>
                                                                    <?php
                                                                    foreach ($_getAgama as $row) :
                                                                        echo "<option value='$row->IDAgama,$row->Agama'>$row->Agama</option>";
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Status Perkawinan*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="select2 form-control" name="txtStatus" id="txtStatus" required>
                                                                    <option value="">-Pilih-</option>
                                                                    <?php
                                                                    foreach ($_getStatusKawin as $rowStatus) :
                                                                        // echo "<option value='$rowStatus->ID'>$rowStatus->StatusKawin</option>";
                                                                        // testing karena data yang tersimpan sebelumnya ID di DB 15/04/2025
                                                                        echo "<option value='$rowStatus->StatusKawin'>$rowStatus->StatusKawin</option>";
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Kerabat Terdekat*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="txtkerabatterdekat" class="form-control " name="txtkerabatterdekat" placeholder="Kerabat Terdekat" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Nomor HP. Kerabat*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="txtnohpkerabat" class="form-control isNumberKey" name="txtnohpkerabat" placeholder="0822XXXXXX" required maxlength="13">
                                                                <small id="noHpKerabatError" class="text-danger" style="display:none;">Nomor ponsel harus terdiri dari 10-13 digit angka.</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Hubungan dgn. Kerabat*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="txthubungan" class="form-control" name="txthubungan" placeholder="Hubungan" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Alamat Kerabat</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <textarea type="text" id="inputAlamatKerabat" class="form-control" name="txtAlamatKerabat" placeholder="Input Alamat Kerabat"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Previous & Next -->
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <button type="button" class="btn btn-secondary prev-btn" data-prev="2">Previous</button>
                                                        <button type="button" class="btn btn-primary next-btn" data-next="4">Next</button>
                                                        <!-- <button type="submit" class="btn btn-primary ">submit</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <!-- Section 4: Data Suami/Istri -->
                <section class="row flexbox-container" id="section-4" style="display: none;">
                    <div class="col-xl-12 col-12 d-flex justify-content-center">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="feather icon-users"></i> Data Suami/Istri/Anak</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Nama Suami/ Istri</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputNamaPasangan" class="form-control" name="txtNamaPasangan" placeholder="Input Nama Suami/Istri">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Tangal Lahir Suami/ Istri</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <!-- <input type="text" id="inputTanggalLahir" class="form-control" name="txtTanggalLahir" placeholder="Input Tanggal Lahirs" required> -->
                                                                <div class="input-group date datepicker">
                                                                    <span class="input-group-prepend">
                                                                        <button class="btn btn-primary waves-effect waves-light" type="button"><i class="feather icon-calendar"></i></button>
                                                                    </span>
                                                                    <input class="form-control maskdate valid_date dttgl" size="10" type="text" name="txtTglLahirPasangan" id="inputTglLahirPasangan" placeholder="dd-mm-yyyy" autocomplete="off" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Pekerjaan Suami/ Istri</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputPekerjaanPasangan" class="form-control" name="txtPekerjaanPasangan" placeholder="Input Pekerajaan Suami/ Istri">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Alamat Suami/ Istri</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <textarea type="text" id="inputAlamatPasangan" class="form-control" name="txtAlamatPasangan" placeholder="Input Alamat Suami/ Istri"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Jumlah Anak</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputJumlahAnak" class="form-control isNumberKey" name="txtJumlahAnak" placeholder="Jumlah Anak" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12" id="listAnak" style="display: none">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover table-striped">
                                                                <thead>

                                                                </thead>
                                                                <tbody id="dataTable">
                                                                    <tr class="text-center">
                                                                        <td valign="top"><input name="chk[]" type="checkbox" /></td>
                                                                        <td>
                                                                            <input type="text" name="txtNamaAnak[]" autocomplete="off" id="inputNamaAnak" placeholder="Nama Anak" class="form-control" style="width: 200px;">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="txtTempatLahirAnak[]" autocomplete="off" id="inputTempatLahirAnak" placeholder="Tempat Lahir" class="form-control" style="width: 200px;">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="txtTanggalLahirAnak[]" autocomplete="off" id="inputTanggalLahirAnak" class="form-control  dttgl maskdate valid_date text-center" data-date="" data-date-format="dd-mm-yyyy" value="" placeholder="dd-mm-yyyy" maxlength="10" aria-invalid="false" style="width: 200px;">
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control" id="inputJekelAnak" name="txtJekelAnak[]" style="width: 200px;">
                                                                                <option value="">-- Pilih Jenis Kelamin</option>
                                                                                <option value="M">Laki-laki</option>
                                                                                <option value="P">Perempuan</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="txtAlamatAnak[]" autocomplete="off" id="inputTempatLahirAnak" placeholder="Alamat" class="form-control" style="width: 200px;">
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                                <tfoot class="bg-primary" id="dataTableFoot">
                                                                    <tr>
                                                                        <td class="table-primary align-middle text-center" colspan="100%" align="center" style="background-color: #D3D3D3;">
                                                                            <button type="button" class="btn btn-sm bg-gradient-success waves-effect waves-light" id="tambah_baris1" onClick="addRow('dataTable')">Tambah Baris</button>
                                                                            <button type="button" class="btn btn-sm bg-gradient-warning waves-effect waves-light" id="hapus_baris" onClick="deleteRow('dataTable')">Hapus Baris</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- Tombol Previous & Next -->
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <button type="button" class="btn btn-secondary prev-btn" data-prev="3">Previous</button>
                                                        <button type="button" class="btn btn-primary next-btn" data-next="5">Next</button>
                                                        <!-- <button type="submit" class="btn btn-primary ">submit</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

                <!-- Section 5: Data Keluarga -->
                <section class="row flexbox-container" id="section-5" style="display: none;">
                    <div class="col-xl-12 col-12 d-flex justify-content-center">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="feather icon-users"></i> Data Keluarga</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Nama Bapak Kandung*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputNamaBapak" class="form-control" name="txtNamaBapak" placeholder="Input Nama Bapak Kandung" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Nama Ibu Kandung*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputNamaIbu" class="form-control" name="txtNamaIbu" placeholder="Input Nama Ibu Kandung" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Pekerjaan Orang Tua*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputPekerjaanOrtu" class="form-control" name="txtPekerjaanOrtu" placeholder="Input Pekerjaan Orang Tua" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Jumlah Saudara*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputJumlahSaudara" class="form-control isNumberKey" name="txtJumlahSaudara" placeholder="Input Jumlah Saudara" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Anak ke*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="inputAnakKe" class="form-control isNumberKey" name="txtAnakKe" placeholder="Input AnakKe" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12" id="listSaudara" style="display: none">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover table-striped">
                                                                <thead>

                                                                </thead>
                                                                <tbody id="dataTable7">
                                                                    <tr class="text-center">
                                                                        <td valign="top"><input name="chk[]" type="checkbox" /></td>
                                                                        <td>
                                                                            <input type="text" name="txtNamaSaudara[]" autocomplete="off" id="inputNamaSaudara" placeholder="Nama Saudara Kandung" class="form-control" style="width: 200px;">
                                                                        </td>
                                                                        <td>
                                                                             <select class="form-control" id="inputJekelSaudara" name="txtJekelSaudara[]" style="width: 200px;">
                                                                                <option value="">-- Pilih Jenis Kelamin</option>
                                                                                <option value="M">Laki-laki</option>
                                                                                <option value="P">Perempuan</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="txtUmurSaudara[]" autocomplete="off" id="inputUmurSaudara" placeholder="Umur" class="form-control isNumberKey" style="width: 200px;">
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" name="txtPekerjaanSaudara[]" autocomplete="off" id="inputPekerjaanSaudara" placeholder="Pekerjaan" class="form-control" style="width: 200px;">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="txtPrusahaanSaudara[]" autocomplete="off" id="inputPrusahaanSaudara" placeholder="Perusahaan" class="form-control" style="width: 200px;">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="txtJabatanSaudara[]" autocomplete="off" id="inputJabatanSaudara" placeholder="Jabatan" class="form-control" style="width: 200px;">
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                                <tfoot class="bg-primary" id="dataTableFoot">
                                                                    <tr>
                                                                        <td class="table-primary align-middle text-center" colspan="100%" align="center" style="background-color: #D3D3D3;">
                                                                            <button type="button" class="btn btn-sm bg-gradient-success waves-effect waves-light" id="tambah_baris1" onClick="addRow('dataTable7')">Tambah Baris</button>
                                                                            <button type="button" class="btn btn-sm bg-gradient-warning waves-effect waves-light" id="hapus_baris" onClick="deleteRow('dataTable7')">Hapus Baris</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Previous & Next -->
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <button type="button" class="btn btn-secondary prev-btn" data-prev="4">Previous</button>
                                                        <button type="button" class="btn btn-primary next-btn" data-next="6">Next</button>
                                                        <!-- <button type="submit" class="btn btn-primary ">submit</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

               <!-- Section 6: Pendidikan Terakhir -->
                <section class="row flexbox-container" id="section-6" style="display: none;">
                    <div class="col-xl-12 col-12 d-flex justify-content-center mb-0">
                        <div class="col-md-8 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="feather icon-home"></i> Riwayat Pendidikan</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Pendidikan Terakhir -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-12">Pendidikan Terakhir*</label>
                                                            <div class="col-md-8 col-12">
                                                                <select class="form-control" id="inputPendidikan" name="txtPendidikan" required>
                                                                    <option value="">-Pilih-</option>
                                                                    <?php foreach ($_getPendidikan as $rowPendidikan) : ?>
                                                                        <option value="<?= $rowPendidikan->Pendidikan ?>"><?= $rowPendidikan->Pendidikan ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nama Sekolah -->
                                                    <div class="col-12" id="inputSekolah">
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-12">Nama Sekolah</label>
                                                            <div class="col-md-8 col-12">
                                                                <input type="text" id="inputShcool" class="form-control" name="txtShcool" placeholder="Input Nama Sekolah">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nama Universitas -->
                                                    <div class="col-12" id="inputUniversitas" style="display: none;">
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-12">Nama Universitas</label>
                                                            <div class="col-md-8 col-12">
                                                                <input type="text" id="inputUniv" class="form-control" name="txtUniv" placeholder="Input Nama Universitas">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Jurusan -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-12">Jurusan</label>
                                                            <div class="col-md-8 col-12">
                                                                <select class="form-control" id="inputJurusan" name="txtJurusan" disabled>
                                                                    <option value="">-Pilih-</option>
                                                                    <?php foreach ($_getJurusan as $rowJurusan) : ?>
                                                                        <option value="<?= $rowJurusan->Jurusan ?>"><?= $rowJurusan->Jurusan ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Ijazah Terakhir -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-12">Ijazah Terakhir</label>
                                                            <div class="col-md-8 col-12">
                                                                <input type="text" id="inputIjsTerakhir" class="form-control" name="txtIjsTerakhir" placeholder="Input Ijazah Terakhir">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tabel Riwayat Pendidikan -->
                                                    <div class="col-12">
                                                        <p class="text-danger">*Wajib Isi !!!</p>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr class="text-center">
                                                                        <th rowspan="3">✔</th>
                                                                        <th rowspan="3" style="min-width: 120px;">TINGKAT</th>
                                                                        <th rowspan="3">NAMA SEKOLAH / TEMPAT</th>
                                                                        <th rowspan="3">JURUSAN</th>
                                                                        <th rowspan="3">Tahun Masuk</th>
                                                                        <th rowspan="3">Tahun Keluar</th>
                                                                        <th rowspan="3">LULUS</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="dataPendidikan">
                                                                    <tr>
                                                                        <td><input name="chk[]" type="checkbox" /></td>
                                                                        <td>
                                                                            <select class="form-control" name="txtTingkatanPendidikan[]" style="width:200px;" required>
                                                                                <option value="">-Pilih-</option>
                                                                                <?php foreach ($_getPendidikan as $rowPendidikan) : ?>
                                                                                    <option value="<?= $rowPendidikan->Pendidikan ?>"><?= $rowPendidikan->Pendidikan ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="text" name="txtNmSekolahPendidikan[]" class="form-control" autocomplete="off" style="width:200px;"></td>
                                                                        <td>
                                                                            <select class="form-control" name="txtJurusanPendidikan[]" style="display:none; width:200px;">
                                                                                <option value="">-- Silahkan pilih Jurusan --</option>
                                                                                <?php foreach ($_getJurusan as $rowJurusan) : ?>
                                                                                    <option value="<?= $rowJurusan->ID ?>"><?= $rowJurusan->Jurusan ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="text" name="txtThnMasukPendidikan[]" class="form-control" maxlength="4" style="width:200px;"></td>
                                                                        <td><input type="text" name="txtThnLulusPendidikan[]" class="form-control" maxlength="4" style="width:200px;"></td>
                                                                        <td>
                                                                            <select class="form-control" name="txtLulusPendidikan[]" style="width:200px;">
                                                                                <option value="YA">YA</option>
                                                                                <option value="TIDAK LULUS">TIDAK LULUS</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="7" class="text-center bg-light">
                                                                            <button type="button" class="btn btn-success btn-sm" onclick="addRow('dataPendidikan')">Tambah Baris</button>
                                                                            <button type="button" class="btn btn-warning btn-sm" onclick="deleteRow('dataPendidikan')">Hapus Baris</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Navigasi -->
                                                    <div class="col-12 d-flex justify-content-between mt-2">
                                                        <button type="button" class="btn btn-secondary prev-btn" data-prev="5">Previous</button>
                                                        <button type="button" class="btn btn-primary next-btn" data-next="7">Next</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


               <!-- Section 7: Riwayat Pekerjaan -->
                <section class="row" id="section-7" style="display: none;">
                    <div class="col-12 mb-0">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="feather icon-feather"></i> Riwayat Pekerjaan</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form-horizontal">
                                        <div class="form-body">
                                            <div class="row">

                                                <!-- Diperbaiki: Ubah dari col-md-8 menjadi col-12 -->
                                                <div class="col-12"> <!-- Diperbaiki -->
                                                    <div class="form-group">
                                                        <label for="inputPengalamanKerja">Pengalaman Kerja</label> <!-- Diperbaiki -->
                                                        <input type="text" id="inputPengalamanKerja" class="form-control" name="txtPengalamanKerja" placeholder="Input Pengalaman Kerja">
                                                    </div>
                                                </div>

                                                <!-- Diperbaiki: Ubah dari col-md-8 menjadi col-12 -->
                                                <div class="col-12"> <!-- Diperbaiki -->
                                                    <div class="form-group">
                                                        <label for="inputKeahlian">Keahlian/ Keterampilan yang dikuasai</label>
                                                        <textarea id="inputKeahlian" class="form-control" name="txtKeahlian" placeholder="Input Keahlian/ Keterampilan yang dikuasai"></textarea>
                                                    </div>
                                                </div>

                                                <!-- Diperbaiki: Satu kolom penuh untuk mobile -->
                                                <div class="col-12"> <!-- Diperbaiki -->
                                                    <div class="form-group">
                                                        <label>Pernah Kerja di SAMBU GROUP*</label>
                                                        <div>
                                                            <!-- Diperbaiki: Gunakan custom-control-inline agar lebih rapi di mobile -->
                                                            <div class="custom-control custom-radio custom-control-inline"> <!-- Diperbaiki -->
                                                                <input type="radio" class="custom-control-input" name="txtPernahRSUP" id="txtPernahRSUP" value="YA">
                                                                <label class="custom-control-label" for="txtPernahRSUP">YA</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline"> <!-- Diperbaiki -->
                                                                <input type="radio" class="custom-control-input" name="txtPernahRSUP" id="txtPernahRSUP2" value="TIDAK" checked required>
                                                                <label class="custom-control-label" for="txtPernahRSUP2">TIDAK</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diperbaiki: col-md-8 jadi col-12 -->
                                                <div class="col-12"> <!-- Diperbaiki -->
                                                    <div class="form-group">
                                                        <label for="inputBagian">Bagian/ Department</label>
                                                        <input type="text" id="inputBagian" class="form-control" name="txtBagian" placeholder="Jika Ya, Di Bagian/ Department mana?" disabled>
                                                    </div>
                                                </div>

                                                <!-- Diperbaiki: Satu kolom penuh -->
                                                <div class="col-12"> <!-- Diperbaiki -->
                                                    <div class="form-group">
                                                        <label>Ada Keluarga yg Bekerja di SAMBU GROUP*</label>
                                                        <div>
                                                            <div class="custom-control custom-radio custom-control-inline"> <!-- Diperbaiki -->
                                                                <input type="radio" class="custom-control-input" name="txtAdaKeluarga" id="txtAdaKeluarga" value="YA">
                                                                <label class="custom-control-label" for="txtAdaKeluarga">YA</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline"> <!-- Diperbaiki -->
                                                                <input type="radio" class="custom-control-input" name="txtAdaKeluarga" id="txtAdaKeluarga2" value="TIDAK" checked required>
                                                                <label class="custom-control-label" for="txtAdaKeluarga2">TIDAK</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diperbaiki: Gunakan table-responsive agar responsif -->
                                                <div class="col-12" id="listkeluarga" style="display: none;"> <!-- Diperbaiki -->
                                                    <div class="form-group">
                                                        <div class="table-responsive"> <!-- Diperbaiki -->
                                                            <table class="table table-bordered table-hover table-striped">
                                                                <thead></thead>
                                                                <tbody id="dataTable2">
                                                                    <tr>
                                                                        <td><input name="chk[]" type="checkbox" /></td>
                                                                        <td><input type="text" name="kelnama[]" class="form-control" placeholder="Nama"></td>
                                                                        <td><input type="text" name="kelbagian[]" class="form-control" placeholder="Bagian"></td>
                                                                        <td><input type="text" name="kelpemborong[]" class="form-control" placeholder="Pemborong"></td>
                                                                        <td><input type="text" name="kelhubungan[]" class="form-control" placeholder="Hubungan Keluarga"></td>
                                                                        <td><input type="text" name="kelalamat[]" class="form-control" placeholder="Alamat"></td>
                                                                    </tr>
                                                                </tbody>
                                                                <tfoot class="bg-primary" id="dataTable2Foot">
                                                                    <tr>
                                                                        <td colspan="100%" class="text-center" style="background-color: #D3D3D3;">
                                                                            <button type="button" class="btn btn-sm btn-success" id="tambah_baris2" onClick="addRow('dataTable2')">Tambah Baris</button>
                                                                            <button type="button" class="btn btn-sm btn-warning" id="hapus_baris2" onClick="deleteRow('dataTable2')">Hapus Baris</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diperbaiki: Gunakan justify-content-between agar tombol responsif -->
                                                <div class="col-12 d-flex justify-content-between"> <!-- Diperbaiki -->
                                                    <button type="button" class="btn btn-secondary prev-btn" data-prev="6">Previous</button>
                                                    <button type="button" class="btn btn-primary next-btn" data-next="8">Next</button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <!-- sampe sini -->
                <!-- Section 8: Informasi lainnya -->
                <section class="row flexbox-container" id="section-8" style="display: none;">
                    <div class="col-xl-12 col-12 d-flex justify-content-center mb-0"> <!-- PERUBAHAN col-7 ke col-12 -->
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="feather icon-info"></i> Informasi Lainnya</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                     <div class="col-12 mb-1"> <!-- PERUBAHAN: tambahkan mb-1 untuk spasi -->
                                                        <div class="form-group row">
                                                             <div class="col-12 col-md-4"><!-- PERUBAHAN -->
                                                                <span>Hobby/ Kegemaran</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- PERUBAHAN -->
                                                                <textarea type="text" id="inputHobby" class="form-control" name="txtHobby" placeholder="Input Hobby atau Kegemaran"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="col-12 mb-1"> <!-- PERUBAHAN: tambahkan mb-1 untuk spasi -->
                                                        <div class="form-group row">
                                                             <div class="col-12 col-md-4"><!-- PERUBAHAN -->
                                                                <span>Kegiatan Ekstra</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- PERUBAHAN -->
                                                                <textarea id="inputKegiatanEkstra" class="form-control" name="txtKegiatanEkstra" placeholder="Input Kegiatan Ekstra"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="col-12 mb-1"> <!-- PERUBAHAN: tambahkan mb-1 untuk spasi -->
                                                        <div class="form-group row">
                                                             <div class="col-12 col-md-4"><!-- PERUBAHAN -->
                                                                <span>Kegiatan Organisasi</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- PERUBAHAN -->
                                                                <textarea id="inputOrganisasi" class="form-control" name="txtOrgnanisasi" placeholder="Input Kegiatan Organisasi"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="col-12 mb-1"> <!-- PERUBAHAN: tambahkan mb-1 untuk spasi -->
                                                        <div class="form-group row">
                                                             <div class="col-12 col-md-4"><!-- PERUBAHAN -->
                                                                <span>Keadaan Fisik*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- PERUBAHAN -->
                                                                <ul class="list-unstyled mb-0">
                                                                     <li class="d-block d-md-inline-block mb-1 mr-md-2"><!-- PERUBAHAN -->
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtKeadaanFisik" id="txtKeadaanFisik" value="CACAT">
                                                                                <label class="custom-control-label" for="txtKeadaanFisik">Cacat</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                     <li class="d-block d-md-inline-block mb-1 mr-md-2"><!-- PERUBAHAN -->
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtKeadaanFisik" id="txtKeadaanFisik2" value="NORMAL" checked required>
                                                                                <label class="custom-control-label" for="txtKeadaanFisik2">Tidak Cacat</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-block d-md-inline-block"><!-- PERUBAHAN -->
                                                                        <input id="inputCacatApa" class="form-control" name="txtCacatApa" placeholder="Jika Ya, Cacat apa?" disabled>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="col-12 mb-1"> <!-- PERUBAHAN: tambahkan mb-1 untuk spasi -->
                                                        <div class="form-group row">
                                                             <div class="col-12 col-md-4"><!-- PERUBAHAN -->
                                                                <span>Pernah Mengidap Penyakit*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- PERUBAHAN -->
                                                                <ul class="list-unstyled mb-0">
                                                                     <li class="d-block d-md-inline-block mb-1 mr-md-2"><!-- PERUBAHAN -->
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtPernahPenyakit" id="txtPernahPenyakit" value="YA">
                                                                                <label class="custom-control-label" for="txtPernahPenyakit">YA</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                     <li class="d-block d-md-inline-block mb-1 mr-md-2"><!-- PERUBAHAN -->
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtPernahPenyakit" id="txtPernahPenyakit2" value="TIDAK" checked required>
                                                                                <label class="custom-control-label" for="txtPernahPenyakit2">TIDAK</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-block d-md-inline-block"><!-- PERUBAHAN -->
                                                                        <input id="inputPenyakit" class="form-control" name="txtPenyakit" placeholder="Jika Ya, Penyakit apa?" disabled>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="col-12 mb-1"> <!-- PERUBAHAN: tambahkan mb-1 untuk spasi -->
                                                        <div class="form-group row">
                                                             <div class="col-12 col-md-4"><!-- PERUBAHAN -->
                                                                <span>Pernah Terlibat Kriminal*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- PERUBAHAN -->
                                                                <ul class="list-unstyled mb-0">
                                                                     <li class="d-block d-md-inline-block mb-1 mr-md-2"><!-- PERUBAHAN -->
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtPernahKriminal" id="txtPernahKriminal" value="YA">
                                                                                <label class="custom-control-label" for="txtPernahKriminal">YA</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                     <li class="d-block d-md-inline-block mb-1 mr-md-2"><!-- PERUBAHAN -->
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtPernahKriminal" id="txtPernahKriminal2" value="TIDAK" checked required>
                                                                                <label class="custom-control-label" for="txtPernahKriminal2">TIDAK</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-block d-md-inline-block"><!-- PERUBAHAN -->
                                                                        <input id="inputKriminal" class="form-control" name="txtKriminal" placeholder="Jika Iya, Tindakan Kriminal Apa yang Dilakukan?" disabled>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="col-12 mb-1"> <!-- PERUBAHAN: tambahkan mb-1 untuk spasi -->
                                                        <div class="form-group row">
                                                             <div class="col-12 col-md-4"><!-- PERUBAHAN -->
                                                                <span>Apakah Bertato?*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- PERUBAHAN -->
                                                                <ul class="list-unstyled mb-0">
                                                                     <li class="d-block d-md-inline-block mb-1 mr-md-2"><!-- PERUBAHAN -->
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtBertato" id="txtBertato" value="YA">
                                                                                <label class="custom-control-label" for="txtBertato">YA</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                     <li class="d-block d-md-inline-block mb-1 mr-md-2"><!-- PERUBAHAN -->
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtBertato" id="txtBertato2" value="TIDAK" checked required>
                                                                                <label class="custom-control-label" for="txtBertato2">TIDAK</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-block d-md-inline-block"><!-- PERUBAHAN -->
                                                                        <input id="inputTatoDimana" class="form-control" name="txtTatoDimana" placeholder="Jika Iya, Tato dibagian apa?" disabled>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- Tombol Previous & Next -->
                                                    <!-- <div class="col-12 d-flex justify-content-between"> -->
                                                    <div class="col-12 d-flex justify-content-between flex-column flex-md-row"> <!-- PERUBAHAN -->
                                                        <button type="button" class="btn btn-secondary prev-btn" data-prev="7">Previous</button>
                                                        <button type="button" class="btn btn-primary next-btn" data-next="9">Next</button>
                                                        <!-- <button type="submit" class="btn btn-primary ">submit</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 9: Informasi lainnya -->
                <section class="row flexbox-container" id="section-9" style="display: none;">
                    <div class="col-xl-12 col-12 d-flex justify-content-center mb-0">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="feather icon-info"></i> Informasi Lainnya</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">

                                                    <!-- Bertindik -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4">
                                                                <span>Apakah Bertindik?*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8 mt-1 mt-md-0"> <!-- ditambah mt-1 -->
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtBertindik" id="txtBertindik" value="YA" required>
                                                                                <label class="custom-control-label" for="txtBertindik">YA</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtBertindik" id="txtBertindik2" value="TIDAK" checked required>
                                                                                <label class="custom-control-label" for="txtBertindik2">TIDAK</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Rambut pendek -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4">
                                                                <span>Bersedia rambut pendek (Laki-laki)?*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8 mt-1 mt-md-0">
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtRambutPendek" id="txtRambutPendek" value="YA" required checked>
                                                                                <label class="custom-control-label" for="txtRambutPendek">YA</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtRambutPendek" id="txtRambutPendek2" value="TIDAK" checked>
                                                                                <label class="custom-control-label" for="txtRambutPendek2">TIDAK</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Kinerja -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4">
                                                                <span>Bersedia Diberhentikan, Jika Kinerja Dinilai Kurang?*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8 mt-1 mt-md-0">
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtBerhentikan" id="txtBerhentikan" value="YA" required checked>
                                                                                <label class="custom-control-label" for="txtBerhentikan">YA</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtBerhentikan" id="txtBerhentikan2" value="TIDAK" checked>
                                                                                <label class="custom-control-label" for="txtBerhentikan2">TIDAK</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Vaksin -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4">
                                                                <span>Apakah Sudah Vaksin ?*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8 mt-1 mt-md-0">
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtVaksin" id="txtVaksin" value="SUDAH" required>
                                                                                <label class="custom-control-label" for="txtVaksin">SUDAH</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtVaksin" id="txtVaksin2" value="BELUM" required checked>
                                                                                <label class="custom-control-label" for="txtVaksin2">BELUM</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Jenis vaksin -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4">
                                                                <span>Jenis Vaksin ?*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8 mt-1 mt-md-0">
                                                                <input type="text" id="inputJenisVaksin" class="form-control" name="txtJenisVaksin" placeholder="Jika SUDAH, Jenis Vaksin?" disabled value="TIDAK ADA">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Vaksin 1 -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4">
                                                                <span>Vaksin 1*</span>
                                                            </div>
                                                            <div class="col-12 col-md-4 mt-1 mt-md-0">
                                                                <div class="input-group date datepicker">
                                                                    <span class="input-group-prepend">
                                                                        <button class="btn btn-primary waves-effect waves-light" type="button"><i class="feather icon-calendar"></i></button>
                                                                    </span>
                                                                    <input class="form-control maskdate valid_date dttgl" size="10" type="text" name="txtTanggalVaksin" id="inputTanggalVaksin" placeholder="dd-mm-yyyy" autocomplete="off" required disabled />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Vaksin 2 -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4">
                                                                <span>Vaksin 2</span>
                                                            </div>
                                                            <div class="col-12 col-md-4 mt-1 mt-md-0">
                                                                <div class="input-group date datepicker">
                                                                    <span class="input-group-prepend">
                                                                        <button class="btn btn-primary waves-effect waves-light" type="button"><i class="feather icon-calendar"></i></button>
                                                                    </span>
                                                                    <input class="form-control maskdate valid_date dttgl" size="10" type="text" name="txtTanggalVaksin2" id="inputTanggalVaksin2" placeholder="dd-mm-yyyy" autocomplete="off" disabled />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Vaksin 3 -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4">
                                                                <span>Vaksin 3</span>
                                                            </div>
                                                            <div class="col-12 col-md-4 mt-1 mt-md-0">
                                                                <div class="input-group date datepicker">
                                                                    <span class="input-group-prepend">
                                                                        <button class="btn btn-primary waves-effect waves-light" type="button"><i class="feather icon-calendar"></i></button>
                                                                    </span>
                                                                    <input class="form-control maskdate valid_date dttgl" size="10" type="text" name="txtTanggalVaksin3" id="inputTanggalVaksin3" placeholder="dd-mm-yyyy" autocomplete="off" disabled />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Navigasi -->
                                                    <div class="col-12 d-flex justify-content-between flex-wrap mt-2">
                                                        <button type="button" class="btn btn-secondary prev-btn mb-1" data-prev="8">Previous</button>
                                                        <button type="button" class="btn btn-primary next-btn mb-1" data-next="10">Next</button>
                                                    </div>

                                                </div> <!-- row -->
                                            </div> <!-- form-body -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

               <!-- Section 10: Ahli waris -->
                <section class="row flexbox-container" id="section-10" style="display: none;">
                    <!-- Ubah dari col-7 menjadi col-12 agar responsif di HP -->
                    <div class="col-xl-12 col-12 d-flex justify-content-center mb-0 p-1 p-md-0"> <!-- perubahan -->
                        <div class="col-md-6 col-12">
                            <div class="card w-100"> <!-- tambah w-100 agar full width di hp -->
                                <div class="card-header">
                                    <h4 class="card-title"><i class="feather icon-users"></i> Ahli Waris</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Nama Ahli Waris -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4"><!-- perubahan -->
                                                                <span>Nama Ahli Waris*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- perubahan -->
                                                                <input type="text" id="inputAhliWaris" class="form-control form-control-sm" name="txtAhliWaris" placeholder="Input Nama Ahli Waris" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Jenis Kelamin Ahli Waris -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4"><!-- perubahan -->
                                                                <span>Jenis Kelamin Ahli Waris*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- perubahan -->
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtJekelAhliWaris" id="txtJekelAhliWaris" value="LAKI-LAKI" required>
                                                                                <label class="custom-control-label" for="txtJekelAhliWaris">Laki-laki</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" name="txtJekelAhliWaris" id="txtJekelAhliWaris2" value="PEREMPUAN" required checked>
                                                                                <label class="custom-control-label" for="txtJekelAhliWaris2">Perempuan</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Alamat Ahli Waris -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4"><!-- perubahan -->
                                                                <span>Alamat Ahli Waris*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- perubahan -->
                                                                <textarea id="inputAlamatAhliWaris" class="form-control form-control-sm" name="txtAlamatAhliWaris" placeholder="Input Alamat" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Hubungan Ahli Waris -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4"><!-- perubahan -->
                                                                <span>Hubungan Ahli Waris*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- perubahan -->
                                                                <input type="text" id="inputHubunganAhliWaris" class="form-control form-control-sm" name="txtHubunganAhliWaris" placeholder="Input Hubungan Ahli Waris" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Nomor HP Ahli Waris -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-12 col-md-4"><!-- perubahan -->
                                                                <span>Nomor HP Ahli Waris*</span>
                                                            </div>
                                                            <div class="col-12 col-md-8"><!-- perubahan -->
                                                                <input type="text" id="txtnohpkerabatAhliWaris" class="form-control form-control-sm isNumberKey" name="txtnohpkerabatAhliWaris" placeholder="0822xxxxxx" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Tombol Previous & Next -->
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <button type="button" class="btn btn-secondary prev-btn" data-prev="9">Previous</button>
                                                        <button type="button" class="btn btn-primary next-btn" data-next="11">Next</button>
                                                    </div>
                                                </div> <!-- row -->
                                            </div> <!-- form-body -->
                                        </div> <!-- form -->
                                    </div> <!-- card-body -->
                                </div> <!-- card-content -->
                            </div> <!-- card -->
                        </div> <!-- col -->
                    </div> <!-- col-xl-12 -->
                </section>


               <!-- Section 11: Akun Social Media -->
                <section class="row flexbox-container" id="section-11" style="display: none;">
                    <!-- 🔧 Diubah dari: col-xl-12 col-7 => col-12 untuk mobile full width -->
                    <div class="col-12 d-flex justify-content-center mb-0">
                        <!-- 🔧 Diubah dari: col-md-6 col-12 => col-12 agar full di HP -->
                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="feather icon-instagram"></i> Sosial Media yang Aktif
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- FACEBOOK -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <!-- 🔧 Diubah dari: col-md-4 => col-md-4 col-12 -->
                                                            <div class="col-md-4 col-12">
                                                                <!-- label opsional -->
                                                            </div>
                                                            <!-- 🔧 Diubah dari: col-md-8 => col-md-8 col-12 -->
                                                            <div class="col-md-8 col-12">
                                                                <fieldset class="form-label-group form-group position-relative has-icon-left input-divider-left">
                                                                    <input type="text" class="form-control" id="inputFacebook" name="txtFacebook" placeholder="">
                                                                    <div class="form-control-position">
                                                                        <i class="feather icon-facebook"></i>
                                                                    </div>
                                                                    <label for="inputFacebook">http://www.facebook.com/_________</label>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- TWITTER -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4 col-12"></div>
                                                            <div class="col-md-8 col-12">
                                                                <fieldset class="form-label-group form-group position-relative has-icon-left input-divider-left">
                                                                    <input type="text" class="form-control" id="inputTwitter" name="txtTwitter" placeholder="">
                                                                    <div class="form-control-position">
                                                                        <i class="feather icon-twitter"></i>
                                                                    </div>
                                                                    <label for="inputTwitter">http://www.x.com/_________</label>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- GMAIL -->
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4 col-12">
                                                                <span>Wajib Isi*</span>
                                                            </div>
                                                            <div class="col-md-8 col-12">
                                                                <fieldset class="form-label-group form-group position-relative has-icon-left input-divider-left">
                                                                    <input type="email" class="form-control" id="inputgmail" name="txtgmail" placeholder="Please Input Your E-Mail" required value="<?= $email ?>">
                                                                    <div class="form-control-position">
                                                                        <i class="feather icon-mail"></i>
                                                                    </div>
                                                                    <label for="inputgmail">Please Input Your E-Mail</label>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- BUTTONS -->
                                                    <div class="col-12 d-flex justify-content-between mt-2">
                                                        <button type="button" class="btn btn-secondary prev-btn w-100 mr-1" data-prev="10">Previous</button>
                                                        <button type="submit" class="btn btn-primary w-100 ml-1" id="btn-submit">Submit</button>
                                                    </div>
                                                    <!-- 🔧 Ditambahkan w-100 dan spacing (mr-1, ml-1) agar tombol rapi di HP -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            </form>



        </div>
    </div>
</div>
<!-- END: Content-->
<?php $this->load->view('applicant_registration/templates/footer'); ?>

<script>
    $(document).ready(function() {


        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right", // Atur posisi pesan
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000", // Waktu tampil pesan
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Fungsi untuk memeriksa apakah form pada section tertentu sudah lengkap
        function validateSection(section) {
            var isValid = true;
            // Only validate required inputs in the visible section
            section.find('input[required]:visible, select[required]:visible').each(function() {
                if ($(this).val() === '') {
                    isValid = false; // matikan dulu
                    // isValid = true;
                    return false; // exit the loop if an input is empty
                }
            });

            // Validasi untuk radio button yang required
            section.find('input[type="radio"][required]:visible').each(function() {
                var name = $(this).attr('name');
                if ($('input[name="' + name + '"]:checked').length === 0) {
                    isValid = false;
                    return false; // exit the loop if no radio button is selected
                }
            });
            return isValid;
        }

        var fullname = '<?= $this->session->userdata('fullname') ?>'
if (fullname == 'KIKI IRVANSYAH#') {
    $('.next-btn').click(function() {
            var currentSection = $(this).closest('section'); // Section yang sedang aktif
            var nextSectionId = $(this).data('next'); // Ambil ID section berikutnya
            var nextSection = $('#section-' + nextSectionId); // Section berikutnya

            // Validasi section saat ini
      
                // Animasi perpindahan section
                currentSection.fadeOut(200, function() {
                    currentSection.removeClass('active');
                    nextSection.fadeIn(200).addClass('active');
                });
           
        });
    
} else{

    // Event untuk tombol Next
    $('.next-btn').click(function() {
        var currentSection = $(this).closest('section'); // Section yang sedang aktif
        var nextSectionId = $(this).data('next'); // Ambil ID section berikutnya
        var nextSection = $('#section-' + nextSectionId); // Section berikutnya

        // Validasi section saat ini
        if (validateSection(currentSection)) {
            // Animasi perpindahan section
            currentSection.fadeOut(200, function() {
                currentSection.removeClass('active');
                nextSection.fadeIn(200).addClass('active');
            });
        } else {
            toastr.error('Tolong lengkapi semua form yang dibutuhkan.'); // Menggunakan toastr untuk peringatan
        }
    });
} // end if

        // Event untuk tombol Previous
        $('.prev-btn').click(function() {
            var currentSection = $(this).closest('section'); // Section yang sedang aktif
            var prevSectionId = $(this).data('prev'); // Ambil ID section sebelumnya
            var prevSection = $('#section-' + prevSectionId); // Section sebelumnya

            // Animasi perpindahan section
            currentSection.fadeOut(200, function() {
                currentSection.removeClass('active');
                prevSection.fadeIn(200).addClass('active');
            });
        });



        // // Validasi dan Submit Form dengan AJAX
        // $('form').on('submit', function(e) {
        //     e.preventDefault(); // Mencegah form dari submit standar

        //     var isValid = true;

        //     // Periksa semua section
        //     $('section').each(function() {
        //         if (!validateSection($(this))) {
        //             isValid = false;

        //             // Arahkan ke section yang tidak valid
        //             $('section').removeClass('active').hide();
        //             $(this).addClass('active').fadeIn();

        //             // Menggunakan toastr untuk peringatan
        //             toastr.error('Ada form yang belum diisi pada section ini.');
        //             return false; // Hentikan loop
        //         }
        //     });

        //     // Validasi No KK (harus 16 digit angka)
        //     var noKK = $('#inputNoKK').val();
        //     if (!/^\d{16}$/.test(noKK)) {
        //         isValid = false;
        //         $('#noKKError').show(); // Tampilkan pesan error
        //         toastr.error('Nomor KK harus 16 digit.');
        //     } else {
        //         $('#noKKError').hide(); // Sembunyikan pesan error jika valid
        //     }

        //     // Validasi No Ponsel (harus antara 10-13 digit angka)
        //     var noPonsel = $('#inputNoPonsel').val();
        //     if (!/^\d{10,13}$/.test(noPonsel)) {
        //         isValid = false;
        //         $('#noPonselError').show(); // Tampilkan pesan error
        //         toastr.error('Nomor Ponsel harus antara 10 hingga 13 digit.');
        //     } else {
        //         $('#noPonselError').hide(); // Sembunyikan pesan error jika valid
        //     }

        //     // Jika validasi gagal, hentikan proses submit
        //     if (!isValid) {
        //         return; // Hentikan eksekusi jika ada validasi yang tidak valid
        //     }

        //     // Jika validasi berhasil, lanjutkan dengan AJAX
        //     // var formData = $(this).serialize(); // Serialisasi semua data form

        //     // Jika valid, kirim data menggunakan FormData
        //     var Data = new FormData(this); // Ambil semua data form, termasuk file

        //     // console.log({
        //     //     formData,
        //     //     Data,
        //     // });

        //     // Menampilkan data di konsol
        //     for (var [key, value] of Data.entries()) {
        //         console.log(key + ':', value);
        //     }


        //     $.ajax({
        //         url: '<?= base_url("applicant_registration/submit_form") ?>', // Ganti dengan URL yang sesuai
        //         type: 'POST',
        //         data: Data,
        //         dataType: 'json',
        //         processData: false, // don't process the data
        //         contentType: false, // don't set contentType
        //         beforeSend: function() {
        //             // Menampilkan overlay dan teks loading
        //             $('#loading-overlay').show();

        //             // Set isProcessing to true
        //             isProcessing = true;

        //             // Mulai efek Typed.js
        //             typed = new Typed('#loading-text', {
        //                 strings: [
        //                     "Sedang memproses, harap bersabar...",
        //                     "Validasi data penting Anda...",
        //                     "Sistem kami sedang bekerja keras...",
        //                     "Pastikan semua data tersimpan dengan aman...",
        //                     "Sebentar lagi selesai, tetap di sini ya!"
        //                 ],
        //                 typeSpeed: 50,
        //                 backSpeed: 30,
        //                 backDelay: 500,
        //                 loop: true
        //             });

        //             // Aktifkan event sebelum pengguna menutup halaman
        //             window.addEventListener("beforeunload", preventCloseWithSweetAlert);
        //         },
        //         success: function(response) {
        //             console.log(response);
        //             if (response.status === 'success') {
        //                 // Jika sukses
        //                 // toastr.success('Form berhasil dikirim!');
        //                 // Hentikan Typed.js dan sembunyikan overlay

        //                 setTimeout(() => {
        //                     successHandler()
        //                 }, 3000)

        //             } else {
        //                 typed.destroy();
        //                 $('#loading-overlay').hide();
        //                 toastr.error(response.message);
        //             }
        //             // Lakukan aksi lain jika diperlukan, seperti redirect
        //         },
        //         error: function(xhr, status, error) {
        //             // Jika gagal
        //             typed.destroy();
        //             $('#loading-overlay').hide();
        //             toastr.error('Terjadi kesalahan saat mengirim form.');
        //         }
        //     });
        // });

        // Validasi dan Submit Form dengan AJAX
        $('form').on('submit', function(e) {
            e.preventDefault(); // Mencegah form dari submit standar
            console.log('submit...');
            

            var isValid = true;

            // Periksa semua section
            $('section').each(function() {
                if (!validateSection($(this))) {
                    isValid = false;

                    // Arahkan ke section yang tidak valid
                    $('section').removeClass('active').hide();
                    $(this).addClass('active').fadeIn();

                    // Menggunakan toastr untuk peringatan
                    toastr.error('Ada form yang belum diisi pada section ini.');
                    return false; // Hentikan loop
                }
            });
            console.log('ada form belum diisi : ', isValid );
            

            // Validasi No KK (harus 16 digit angka)
            var noKK = $('#inputNoKK').val();
            if (!/^\d{16}$/.test(noKK)) {
                isValid = false;
                $('#noKKError').show(); // Tampilkan pesan error
                toastr.error('Nomor KK harus 16 digit.');
            } else {
                $('#noKKError').hide(); // Sembunyikan pesan error jika valid
            }
            console.log('inputNoKK : ', isValid );


            // Validasi No Ponsel (harus antara 10-13 digit angka)
            var noPonsel = $('#inputNoPonsel').val();
            if (!/^\d{10,13}$/.test(noPonsel)) {
                isValid = false;
                $('#noPonselError').show(); // Tampilkan pesan error
                toastr.error('Nomor Ponsel harus antara 10 hingga 13 digit.');
            } else {
                $('#noPonselError').hide(); // Sembunyikan pesan error jika valid
            }
            console.log('noPonselError : ', isValid );


            // Jika validasi gagal, hentikan proses submit
            if (!isValid) {
                console.log('is valid false');                
                return; // Hentikan eksekusi jika ada validasi yang tidak valid
            }

            // Menampilkan dialog konfirmasi menggunakan SweetAlert
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan semua data sudah diisi dengan benar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btn-submit').prop('disabled', true);

                    // Jika pengguna mengkonfirmasi, lanjutkan dengan AJAX

                    // Jika valid, kirim data menggunakan FormData
                    var Data = new FormData(this); // Ambil semua data form, termasuk file

                    // Menampilkan data di konsol
                    for (var [key, value] of Data.entries()) {
                        console.log(key + ':', value);
                    }

                    $.ajax({
                        url: '<?= base_url("applicant_registration/submit_form") ?>', // Ganti dengan URL yang sesuai
                        type: 'POST',
                        data: Data,
                        dataType: 'json',
                        processData: false, // don't process the data
                        contentType: false, // don't set contentType
                        beforeSend: function() {
                            // Menampilkan overlay dan teks loading
                            $('#loading-overlay').show();

                            // Set isProcessing to true
                            isProcessing = true;

                            // Mulai efek Typed.js
                            typed = new Typed('#loading-text', {
                                strings: [
                                    "Sedang memproses, harap bersabar...",
                                    "Validasi data penting Anda...",
                                    "Sistem kami sedang bekerja keras...",
                                    "Pastikan semua data tersimpan dengan aman...",
                                    "Sebentar lagi selesai, tetap di sini ya!"
                                ],
                                typeSpeed: 50,
                                backSpeed: 30,
                                backDelay: 500,
                                loop: true
                            });

                            // Aktifkan event sebelum pengguna menutup halaman
                            window.addEventListener("beforeunload", preventCloseWithSweetAlert);
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status === 'success') {
                                // Jika sukses

                                setTimeout(() => {
                                    successHandler()
                                }, 3000)

                            } else {
                                typed.destroy();
                                $('#loading-overlay').hide();
                                toastr.error(response.message);
                                $('#btn-submit').prop('disabled', false);

                            }
                            // Lakukan aksi lain jika diperlukan, seperti redirect
                        },
                        error: function(xhr, status, error) {
                            // Jika gagal
                            typed.destroy();
                            $('#loading-overlay').hide();
                            // Tampilkan detail error ke user melalui alert
                            alert(
                                "AJAX Error!\n" +
                                "Status: " + status + "\n" +
                                "Error: " + error + "\n" +
                                "Response:\n" + xhr.responseText
                            );
                            // toastr.error('Terjadi kesalahan saat mengirim form.');
                            $('#btn-submit').prop('disabled', false);

                        }
                    });
                }
            });
        });


        // Fungsi untuk menangani keberhasilan simpan data
        function successHandler() {
            // Hentikan Typed.js dan sembunyikan overlay
            typed.destroy();
            $('#loading-overlay').hide();

            // Menampilkan efek confetti saat berhasil
            confetti({
                particleCount: 1000, // Meningkatkan jumlah partikel
                spread: 360, // Menyebar ke seluruh layar
                origin: {
                    x: 0.5, // Posisi horizontal tengah
                    y: 0.5 // Posisi vertikal tengah
                }
            });

            // Menampilkan pesan sukses dengan SweetAlert
            Swal.fire({
                title: 'Data Berhasil Disimpan!',
                text: 'Terima kasih telah mengisi data.',
                icon: 'success',
                confirmButtonText: 'Oke'
            }).then(() => {
                // Sembunyikan overlay setelah pesan dikonfirmasi
                $('#loading-overlay').hide();
                setTimeout(() => {
                    window.location.href = "<?= base_url('success') ?>";
                })
            });
        }

        // Fungsi untuk mencegah penutupan halaman dengan SweetAlert
        function preventCloseWithSweetAlert(event) {
            if (isProcessing) { // Cek apakah AJAX sedang berjalan
                event.preventDefault();
                event.returnValue = ''; // Diperlukan untuk beberapa browser agar beforeunload bekerja

                // Tampilkan SweetAlert sebagai konfirmasi
                Swal.fire({
                    title: 'Apakah Anda yakin ingin meninggalkan halaman ini?',
                    text: "Data sedang diproses. Jika Anda meninggalkan halaman, data mungkin tidak tersimpan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Tinggalkan',
                    cancelButtonText: 'Tetap di sini'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user memilih 'Tinggalkan', izinkan halaman ditutup
                        window.removeEventListener("beforeunload", preventCloseWithSweetAlert);
                        window.location.href = "about:blank"; // Ini akan menutup halaman atau bisa disesuaikan
                    }
                });

                return false; // Mencegah action default sebelum user memilih
            }
        }




        $(document).on('focus', '.maskdate', function() {
            $(this).mask("00-00-0000", {
                placeholder: "dd-mm-yyyy"
            });
        });

        $('#inputTanggalLahir').on('change', function() {
            var tanggalLahir = $(this).val();
            if (tanggalLahir) {
                // Memisahkan tanggal, bulan, dan tahun
                var parts = tanggalLahir.split("-");
                var day = parseInt(parts[0], 10);
                var month = parseInt(parts[1], 10) - 1; // Bulan dimulai dari 0
                var year = parseInt(parts[2], 10);

                // Buat objek tanggal dari input
                var birthDate = new Date(year, month, day);
                var today = new Date();

                // Hitung usia
                var age = today.getFullYear() - birthDate.getFullYear();
                var monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                // Tampilkan usia di field umur
                $('#inputUmur').val(age);
            } else {
                $('#inputUmur').val('');
            }
        });
    });

    // validasi no ktp
    $(document).ready(function() {
        $('#inputNoKTP').on('blur', function() {
            var noKTP = $(this).val().trim();
            var ktpError = $('#ktpError');

            // Reset pesan error
            ktpError.hide();

            // Validasi No. KTP
            if (noKTP === '') {
                ktpError.text('No. KTP tidak boleh kosong.').show();
                $(this).focus();
                return false;
            }
            if (!/^\d{16}$/.test(noKTP)) {
                ktpError.text('Format No. KTP tidak valid. Harus terdiri dari 16 digit angka.').show();
                $(this).focus();
                return false;
            }

            // Jika validasi lolos
            ktpError.hide();
        });
    });

    $(document).ready(function() {
        $('#pdfUpload').on('change', function() {
            var file = this.files[0]; // Ambil file yang dipilih
            var label = $(this).next('.custom-file-label'); // Ambil label file
            label.html(file.name); // Update label dengan nama file

            // Jika file adalah PDF, tampilkan pratinjau
            if (file && file.type === 'application/pdf') {
                var reader = new FileReader(); // Membaca file
                reader.onload = function(e) {
                    var pdfData = new Uint8Array(e.target.result);
                    var loadingTask = pdfjsLib.getDocument({
                        data: pdfData
                    }); // Muat PDF
                    loadingTask.promise.then(function(pdf) {
                        // Ambil halaman pertama dari PDF
                        pdf.getPage(1).then(function(page) {
                            var scale = 1.5; // Skala untuk pratinjau
                            var viewport = page.getViewport({
                                scale: scale
                            });
                            var canvas = document.getElementById('pdfPreview');
                            var context = canvas.getContext('2d');

                            canvas.width = viewport.width;
                            canvas.height = viewport.height;

                            // Render halaman ke dalam kanvas
                            var renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };
                            page.render(renderContext);
                            $(canvas).show(); // Tampilkan kanvas
                        });
                    });
                };
                reader.readAsArrayBuffer(file); // Baca file sebagai ArrayBuffer
            } else {
                $('#pdfPreview').hide(); // Sembunyikan pratinjau jika bukan PDF
            }
        });
    });

    $(document).ready(function() {
        $('#inputNoKK').on('input', function() {
            var noKK = $(this).val(); // Ambil nilai dari input No KK
            var noKKError = $('#noKKError'); // Ambil elemen error

            // Validasi No KK: harus 16 digit dan hanya angka
            if (noKK.length > 0 && (!/^\d{16}$/.test(noKK))) {
                noKKError.show(); // Tampilkan pesan error
            } else {
                noKKError.hide(); // Sembunyikan pesan error
            }
        });


    });

    $(document).ready(function() {
        $('#inputNoPonsel, #txtnohpkerabat').on('input', function() {
            var noPonsel = $(this).val(); // Ambil nilai dari input No Ponsel
            var noPonselError = $('#noPonselError'); // Ambil elemen error
            var noHpKerabatError = $('#noHpKerabatError'); // Ambil elemen error

            // Validasi No Ponsel: harus 10-13 digit dan hanya angka
            if (noPonsel.length > 0 && (!/^\d{10,13}$/.test(noPonsel))) {
                if (this.id === 'inputNoPonsel') {
                    noPonselError.show(); // Tampilkan pesan error
                }
                if (this.id === 'txtnohpkerabat') {
                    noHpKerabatError.show(); // Tampilkan pesan error
                }
            } else {
                if (this.id === 'inputNoPonsel') {
                    noPonselError.hide(); // Sembunyikan pesan error
                }
                if (this.id === 'txtnohpkerabat') {
                    noHpKerabatError.hide(); // Sembunyikan pesan error
                }
            }
        });



        // Mengatur agar hanya input angka
        $('.isNumberKey').on('keypress', function(e) {
            // Cegah input jika bukan angka
            if (e.which < 48 || e.which > 57) {
                e.preventDefault();
            }
        });
    });

    $(document).ready(function() {

        const csrfName = '<?= $csrfName; ?>'; // Nama token yang Anda buat
        const csrfHash = '<?= $csrfHash; ?>'; // Ambil hash dari PHP

        $('#selectProvinsi').on('change', function() {
            idp = $(this).find(":selected").val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?= base_url() ?>/Applicant_registration/getkabupaten',
                data: {
                    idprov: idp,
                    [csrfName]: csrfHash,
                },
                success: function(d, r, x) {
                    data = d.data;
                    $('#selectKabupaten').empty().html('<option value="">Silahkan pilih Kabupaten</option>');
                    for (i = 0; i < data.length; i++) {
                        $('#selectKabupaten').append('<option value="' + data[i].Kabupaten_KotaID + '">' + data[i].Kabupaten_KotaName + '</option>');
                    }
                }
            });
        });

        $('#selectKabupaten').on('change', function() {
            idp = $('#selectProvinsi').find(":selected").val();
            ikab = $(this).find(":selected").val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?= base_url() ?>/Applicant_registration/getkecamatan',
                data: {
                    idprov: idp,
                    idkab: ikab,
                    [csrfName]: csrfHash,
                },
                success: function(d, r, x) {
                    data = d.data;
                    $('#selectKecamatan').empty().html('<option value="">Silahkan pilih Kecamatan</option>');
                    for (i = 0; i < data.length; i++) {
                        $('#selectKecamatan').append('<option value="' + data[i].KecamatanID + '">' + data[i].KecamatanName + '</option>');
                    }
                }
            });
        });

        $(document).on('change', '#inputTingkatanPendidikan', function() {
            var pd = $(this).val()
            var q = $(this)
            if (pd == 'D1' || pd == 'D2' || pd == 'D3' || pd == 'D4' || pd == 'S1' || pd == 'S2' || pd == 'S3' || pd == 'SMA' || pd == 'SMK' || pd == 'MAN' || pd == 'SMU') {
                q.closest('tr').find('#inputJurusanPendidikan').css("display", "block");
            } else {
                q.closest('tr').find('#inputJurusanPendidikan').css("display", "none");
            }
        })


        $('#txtStatus').change(function() {
            let txtStatus = $(this).find('option:selected').text()
            StatusChange(txtStatus)
        })

        function StatusChange(vstatus) {
            if (vstatus === "Nikah" || vstatus === "Duda" || vstatus === "Janda") {
                $('#listAnak').show();

                $('#inputNamaPasangan').prop('disabled', false);
                $('#inputTglLahirPasangan').prop('disabled', false);
                $('#inputPekerjaanPasangan').prop('disabled', false);
                $('#inputAlamatPasangan').prop('disabled', false);
            } else {
                $('#inputNamaPasangan').val('');
                $('#inputTglLahirPasangan').val('');
                $('#inputPekerjaanPasangan').val('');
                $('#inputAlamatPasangan').val('');

                $('#listAnak').hide();

                $('#inputNamaPasangan').prop('disabled', true);
                $('#inputTglLahirPasangan').prop('disabled', true);
                $('#inputPekerjaanPasangan').prop('disabled', true);
                $('#inputAlamatPasangan').prop('disabled', true);
            }
        }

    })

    $(document).ready(function() {
        $('#tambah_baris1, #hapus_baris').click(function() {
            let rowCount = $('#dataTable tr').length;
            $('#inputJumlahAnak').val(rowCount)
        })
    })

    $(document).ready(function() {
        $('#inputPendidikan').change(function() {
            let pendidikan = $(this).find('option:selected').val()
            PendidikanChange(pendidikan)
        })

        function PendidikanChange(objvalue) {
            if (objvalue === '' || objvalue === "TIDAK SEKOLAH" || objvalue === "SD" || objvalue === "SMP" || objvalue === "MTS") {
                $('#inputJurusan').val('');
                $('#inputJurusan').prop('disabled', true);
            } else {
                $('#inputJurusan').prop('disabled', false);
            }

            if (objvalue === "D1" || objvalue === "D2" || objvalue === "D3" || objvalue === "D4" || objvalue === "S1" || objvalue === "S2" || objvalue === "S3") {
                $('#inputSekolah').hide();
                $('#inputUniversitas').show();
            } else if (objvalue === "TIDAK SEKOLAH" || objvalue === "") {
                $('#inputSekolah').show();
                $('#inputSekolah').prop('readonly', true);
                $('#inputUniversitas').hide();
            } else {
                $('#inputSekolah').show();
                $('#inputSekolah').prop('readonly', false);
                $('#inputUniversitas').hide();
            }
        }

        $(document).on('change', 'input[name=txtPernahRSUP]', function() {
            let p = $(this).val()
            if (p === 'YA') {
                $('#inputBagian').prop('disabled', false)
            } else {
                $('#inputBagian').prop('disabled', true)
                $('#inputBagian').val('')
            }
        })

        $(document).on('change', 'input[name=txtAdaKeluarga]', function() {
            let p = $(this).val()
            if (p === 'YA') {
                $('#listkeluarga').css("display", "block");
            } else {
                $('#listkeluarga').css("display", "none");
            }
        })

        $(document).on('click', 'input[name=txtKeadaanFisik]', function() {
            let p = $(this).val()
            if (p === 'CACAT') {
                $('#inputCacatApa').prop("disabled", false);
            } else {
                $('#inputCacatApa').prop("disabled", true);
            }
        })

        $(document).on('click', 'input[name=txtPernahPenyakit]', function() {
            let p = $(this).val()
            if (p === 'YA') {
                $('#inputPenyakit').prop("disabled", false);
            } else {
                $('#inputPenyakit').prop("disabled", true);
            }
        })
        $(document).on('click', 'input[name=txtPernahKriminal]', function() {
            let p = $(this).val()
            if (p === 'YA') {
                $('#inputKriminal').prop("disabled", false);
            } else {
                $('#inputKriminal').prop("disabled", true);
            }
        })

        $(document).on('click', 'input[name=txtBertato]', function() {
            let p = $(this).val()
            if (p === 'YA') {
                $('#inputTatoDimana').prop("disabled", false);
            } else {
                $('#inputTatoDimana').prop("disabled", true);
            }
        })

        $(document).on('click', 'input[name=txtVaksin]', function() {
            let p = $(this).val()
            if (p === 'SUDAH') {
                $('#inputJenisVaksin').prop("disabled", false);
                $('#inputJenisVaksin').prop("required", true);
                $('#inputJenisVaksin').val("");

                $('#inputTanggalVaksin').prop("disabled", false);
                $('#inputTanggalVaksin').prop("required", true);
                $('#inputTanggalVaksin').val("");

                $('#inputTanggalVaksin2').prop("disabled", false);
                $('#inputTanggalVaksin2').val("");

                $('#inputTanggalVaksin3').prop("disabled", false);
                $('#inputTanggalVaksin3').val("");
            } else {
                $('#inputJenisVaksin').prop("disabled", true);
                $('#inputJenisVaksin').prop("required", false);
                $('#inputJenisVaksin').val('TIDAK ADA');

                $('#inputTanggalVaksin').prop("disabled", true);
                $('#inputTanggalVaksin').prop("required", false);
                $('#inputTanggalVaksin').val(null);

                $('#inputTanggalVaksin2').prop("disabled", true);
                $('#inputTanggalVaksin2').val(null);

                $('#inputTanggalVaksin3').prop("disabled", true);
                $('#inputTanggalVaksin3').val(null);
            }
        })

        $(document).on('keyup', '#inputJumlahSaudara', function() {
            let v = parseInt($(this).val())
            if (v > 0) {

                $('#listSaudara').css("display", "block");
            } else {
                $('#listSaudara').css("display", "none");
            }

        })

    })
</script>
<?php $this->load->view('applicant_registration/templates/footer_end'); ?>