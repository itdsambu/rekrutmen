<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-file-text-o"></i>
        Form Pengajuan Perubahan Organisasi (MPP)
    </span>
</h4>

<style>
    .form-section {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #fafafa;
    }

    .form-section-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #1ca8c5;
    }

    .required-field::after {
        content: " *";
        color: red;
    }

    .tipe-card {
        border: 2px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 100%;
        min-height: 200px;
    }

    .tipe-card:hover {
        border-color: #1ca8c5;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .tipe-card.selected {
        border-color: #1ca8c5;
        background-color: #e8f7fa;
    }

    .tipe-card .icon {
        font-size: 48px;
        color: #1ca8c5;
        margin-bottom: 15px;
    }

    .tipe-card h4 {
        margin-bottom: 10px;
        color: #333;
    }

    .tipe-card p {
        color: #666;
        font-size: 13px;
    }

    .lampiran-section {
        display: none;
        border: 2px solid #28a745;
        background-color: #f8fff8;
    }

    .lampiran-section.lampiran-b {
        border-color: #007bff;
        background-color: #f8f9ff;
    }

    .lampiran-section.active {
        display: block;
    }

    .checkbox-group label {
        margin-right: 20px;
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-plus-circle"></i> Buat Pengajuan Baru</h3>
            </div>
            <div class="panel-body">
                <!-- Step 1: Pilih Tipe -->
                <div id="step1" class="form-section">
                    <div class="form-section-title">
                        <i class="fa fa-list-ol"></i> Langkah 1: Pilih Tipe Perubahan
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="tipe-card" data-tipe="1" onclick="selectTipe(1)">
                                <div class="icon"><i class="fa fa-plus-square"></i></div>
                                <h4>Penambahan Jabatan Baru</h4>
                                <p>Jabatan yang belum ada di MPP. Mengisi Form Utama + Lampiran A</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tipe-card" data-tipe="2" onclick="selectTipe(2)">
                                <div class="icon"><i class="fa fa-edit"></i></div>
                                <h4>Penambahan Jabatan Lama</h4>
                                <p>Jabatan yang sudah ada di MPP. Mengisi Form Utama + Lampiran B</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tipe-card" data-tipe="3" onclick="selectTipe(3)">
                                <div class="icon"><i class="fa fa-copy"></i></div>
                                <h4>Jabatan Baru & Lama</h4>
                                <p>Kombinasi keduanya. Mengisi Form Utama + Lampiran A + Lampiran B</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="formPerubahanMPP" method="post">
                    <input type="hidden" name="tipe_perubahan" id="input_tipe_perubahan" value="<?= $header->TipePerubahan; ?>">
                    <input type="hidden" name="id" id="id" value="<?= $header->ID; ?>">

                    <!-- Data Organisasi -->
                    <div id="formUtama" class="form-section" style="display:none;">
                        <div class="form-section-title"><i class="fa fa-building"></i> Data Organisasi</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required-field">Divisi</label>
                                    <input type="text" class="form-control" name="divisi" value="<?= $header->Divisi; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required-field">Departemen</label>
                                    <input type="text" class="form-control" name="departemen" value="<?= $header->Departemen; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Departemen (contoh: MP1, MP2, MPM)</label>
                                    <select class="form-control" id="sub_departemen" name="sub_departemen" data-live-search="true">
                                        <option value="">-- Pilih Sub Departemen --</option>
                                        <?php if (isset($getSubDept)) foreach ($getSubDept as $row) { ?>
                                            <option value="<?= $row->deptabbr ?>" <?= $row->deptabbr == $header->SubDepartemen ? 'selected' : '' ?>><?= $row->deptabbr ?> - <?= $row->deptname ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required-field">Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan" placeholder="Masukkan nama jabatan" value="<?= $header->Jabatan; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Jabatan</label>
                                    <input type="text" class="form-control" name="sub_jabatan" value="<?= $header->SubJabatan; ?>" placeholder="Masukkan sub jabatan">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Jabatan -->
                    <div id="sectionStatusJabatan" class="form-section" style="display:none;">
                        <div class="form-section-title"><i class="fa fa-check-square"></i> Status Jabatan</div>
                        <div class="checkbox-group">
                            <label class="radio-inline">
                                <input type="radio" name="status_jabatan" value="BARU" <?= $header->StatusJabatan == 'BARU' ? 'checked' : '' ?>> <strong>BARU*</strong> (belum ada di MPP)
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status_jabatan" value="LAMA" <?= $header->StatusJabatan == 'LAMA' ? 'checked' : '' ?>> <strong>LAMA**</strong> (sudah ada di MPP)
                            </label>
                        </div>
                        <small class="text-muted">*) Mengisi Lampiran A | **) Mengisi Lampiran B</small>
                    </div>

                    <!-- Jumlah Pemangku -->
                    <div id="sectionJumlah" class="form-section" style="display:none;">
                        <div class="form-section-title"><i class="fa fa-users"></i> Jumlah Pemangku Jabatan</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required-field">Sebelum (di MPP)</label>
                                    <input type="number" class="form-control" id="jumlah_sebelum" name="jumlah_sebelum" min="0" value="<?= $header->JumlahSebelum; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required-field">Sesudah (diajukan)</label>
                                    <input type="number" class="form-control" id="jumlah_sesudah" name="jumlah_sesudah" min="0" value="<?= $header->JumlahSesudah; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Selisih</label>
                                    <input type="text" class="form-control" id="selisih" readonly value="<?= ($header->JumlahSesudah - $header->JumlahSebelum); ?>" style="font-weight:bold;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sifat Perubahan -->
                    <div id="sectionSifat" class="form-section" style="display:none;">
                        <div class="form-section-title"><i class="fa fa-exchange"></i> Sifat Perubahan</div>
                        <div class="checkbox-group">
                            <label class="radio-inline">
                                <input type="radio" name="sifat_perubahan" value="PENAMBAHAN" <?= $header->SifatPerubahan == 'PENAMBAHAN' ? 'checked' : '' ?>> <strong>PENAMBAHAN</strong>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sifat_perubahan" value="TETAP" <?= $header->SifatPerubahan == 'TETAP' ? 'checked' : '' ?>> <strong>TETAP</strong>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sifat_perubahan" value="PENGURANGAN" <?= $header->SifatPerubahan == 'PENGURANGAN' ? 'checked' : '' ?>> <strong>PENGURANGAN</strong>
                            </label>
                        </div>
                    </div>

                    <!-- Latar Belakang -->
                    <div id="sectionLatarBelakang" class="form-section" style="display:none;">
                        <div class="form-section-title"><i class="fa fa-file-text"></i> Latar Belakang & Proyeksi</div>
                        <div class="form-group">
                            <label class="required-field">Latar Belakang Perubahan</label>
                            <textarea class="form-control" name="latar_belakang" rows="4" placeholder="Uraikan latar belakang perubahan organisasi..." required><?= $header->LatarBelakang; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="required-field">Proyeksi Dampak/Value</label>
                            <textarea class="form-control" name="proyeksi_dampak" rows="4" placeholder="Dampak perubahan terhadap operasional..." required><?= $header->ProyeksiDampak; ?></textarea>
                        </div>
                    </div>

                    <!-- Struktur Organisasi -->
                    <div id="sectionStruktur" class="form-section" style="display:none;">
                        <div class="form-section-title"><i class="fa fa-sitemap"></i> Struktur Organisasi</div>
                        <textarea class="form-control" name="struktur_organisasi" rows="6" placeholder="Gambarkan struktur organisasi setelah perubahan..."><?= $header->StrukturOrganisasi; ?></textarea>
                    </div>

                    <!-- Kualifikasi -->
                    <div id="sectionKualifikasi" class="form-section" style="display:none;">
                        <div class="form-section-title"><i class="fa fa-graduation-cap"></i> Kualifikasi Kandidat</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pendidikan dan jurusan</label>
                                    <input type="text" class="form-control" name="kualifikasi_pendidikan" placeholder="Contoh: S1 Teknik" value="<?= $header->KualifikasiPendidikan; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pengalaman bekerja</label>
                                    <input type="text" class="form-control" name="kualifikasi_pengalaman" placeholder="Contoh: Min 3 tahun" value="<?= $header->KualifikasiPengalaman; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pengalaman manajerial</label>
                                    <input type="text" class="form-control" name="kualifikasi_manajerial" value="<?= $header->KualifikasiManajerial; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kompetensi</label>
                                    <input type="text" class="form-control" name="kualifikasi_kompetensi" value="<?= $header->KualifikasiKompetensi; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sertifikasi/Izin</label>
                                    <input type="text" class="form-control" name="kualifikasi_sertifikasi" value="<?= $header->KualifikasiSertifikasi; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lain-lain</label>
                                    <input type="text" class="form-control" name="kualifikasi_lainnya" value="<?= $header->KualifikasiLainnya; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LAMPIRAN A -->
                    <div id="lampiranA" class="form-section lampiran-section">
                        <div class="form-section-title" style="color:#28a745;">
                            <i class="fa fa-file-text-o"></i> LAMPIRAN A - Uraian Penambahan Sub Jabatan Baru
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required-field">Nama Sub Jabatan</label>
                                    <input type="text" class="form-control" name="lampiran_a_nama_sub_jabatan" value="<?= isset($lampiranA) ? $lampiranA->NamaSubJabatan : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required-field">Level Jabatan</label>
                                    <select class="form-control" name="lampiran_a_level_jabatan">
                                        <option value="">-- Pilih Level --</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Pelaksana' ? 'selected' : '' ?> value="Pelaksana">Pelaksana</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Supervisor 1' ? 'selected' : '' ?> value="Supervisor 1">Supervisor 1</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Supervisor 2' ? 'selected' : '' ?> value="Supervisor 2">Supervisor 2</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Executive' ? 'selected' : '' ?> value="Executive">Executive</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Middle Management' ? 'selected' : '' ?> value="Middle Management">Middle Management</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Top Management' ? 'selected' : '' ?> value="Top Management">Top Management</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="required-field">Pengisi Sub Jabatan</label>
                            <div class="checkbox-group">
                                <label class="radio-inline"><input type="radio" name="lampiran_a_pengisi" value="Promosi" <?= isset($lampiranA) && $lampiranA->PengisiSubJabatan == 'Promosi' ? 'checked' : '' ?>> Promosi</label>
                                <label class="radio-inline"><input type="radio" name="lampiran_a_pengisi" value="Rotasi" <?= isset($lampiranA) && $lampiranA->PengisiSubJabatan == 'Rotasi' ? 'checked' : '' ?>> Rotasi</label>
                                <label class="radio-inline"><input type="radio" name="lampiran_a_pengisi" value="Rekrut Baru" <?= isset($lampiranA) && $lampiranA->PengisiSubJabatan == 'Rekrut Baru' ? 'checked' : '' ?>> Rekrut Baru</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea class="form-control" name="lampiran_a_catatan" rows="2"><?= isset($lampiranA) ? $lampiranA->Catatan : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="required-field">Tugas & Tanggung Jawab</label>
                            <textarea class="form-control" name="lampiran_a_tugas" rows="4"><?= isset($lampiranA) ? $lampiranA->TugasTanggungJawab : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="required-field">Wewenang</label>
                            <textarea class="form-control" name="lampiran_a_wewenang" rows="3"><?= isset($lampiranA) ? $lampiranA->Wewenang : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="required-field">Target Kerja</label>
                            <textarea class="form-control" name="lampiran_a_target_kerja" rows="3"><?= isset($lampiranA) ? $lampiranA->TargetKerja : ''; ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hubungan Atasan Bawahan</label>
                                    <textarea class="form-control" name="lampiran_a_hub_atasan_bawahan" rows="3"><?= isset($lampiranA) ? $lampiranA->HubunganAtasanBawahan : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hubungan Internal</label>
                                    <textarea class="form-control" name="lampiran_a_hub_internal" rows="3"><?= isset($lampiranA) ? $lampiranA->HubunganInternal : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hubungan Eksternal</label>
                                    <textarea class="form-control" name="lampiran_a_hub_eksternal" rows="3"><?= isset($lampiranA) ? $lampiranA->HubunganEksternal : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LAMPIRAN B -->
                    <div id="lampiranB" class="form-section lampiran-section lampiran-b">
                        <div class="form-section-title" style="color:#007bff;">
                            <i class="fa fa-file-text-o"></i> LAMPIRAN B - Uraian Penambahan Sub Jabatan Lama
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required-field">Nama Sub Jabatan</label>
                                    <input type="text" class="form-control" name="lampiran_b_nama_sub_jabatan" value="<?= isset($lampiranB) ? $lampiranB->NamaSubJabatan : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required-field">Level Jabatan</label>
                                    <select class="form-control" name="lampiran_b_level_jabatan">
                                        <option <?= $lampiranB->LevelJabatan == '' ? 'selected' : '' ?> value="">-- Pilih Level --</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Pelaksana' ? 'selected' : '' ?> value="Pelaksana">Pelaksana</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Supervisor 1' ? 'selected' : '' ?> value="Supervisor 1">Supervisor 1</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Supervisor 2' ? 'selected' : '' ?> value="Supervisor 2">Supervisor 2</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Executive' ? 'selected' : '' ?> value="Executive">Executive</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Middle Management' ? 'selected' : '' ?> value="Middle Management">Middle Management</option>
                                        <option <?= $lampiranB->LevelJabatan == 'Top Management' ? 'selected' : '' ?> value="Top Management">Top Management</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="required-field">Pengisi Sub Jabatan</label>
                            <div class="checkbox-group">
                                <label class="radio-inline"><input type="radio" name="lampiran_b_pengisi" value="Promosi" <?= isset($lampiranB) && $lampiranB->PengisiSubJabatan == 'Promosi' ? 'checked' : '' ?>> Promosi</label>
                                <label class="radio-inline"><input type="radio" name="lampiran_b_pengisi" value="Rotasi" <?= isset($lampiranB) && $lampiranB->PengisiSubJabatan == 'Rotasi' ? 'checked' : '' ?>> Rotasi</label>
                                <label class="radio-inline"><input type="radio" name="lampiran_b_pengisi" value="Rekrut Baru" <?= isset($lampiranB) && $lampiranB->PengisiSubJabatan == 'Rekrut Baru' ? 'checked' : '' ?>> Rekrut Baru</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea class="form-control" name="lampiran_b_catatan" rows="2"><?= isset($lampiranB) ? $lampiranB->Catatan : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="required-field">Tugas & Tanggung Jawab</label>
                            <textarea class="form-control" name="lampiran_b_tugas" rows="4"><?= isset($lampiranB) ? $lampiranB->TugasTanggungJawab : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="required-field">Wewenang</label>
                            <textarea class="form-control" name="lampiran_b_wewenang" rows="3"><?= isset($lampiranB) ? $lampiranB->Wewenang : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Koordinasi</label>
                            <textarea class="form-control" name="lampiran_b_koordinasi" rows="3"><?= isset($lampiranB) ? $lampiranB->Koordinasi : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Pelaporan</label>
                            <small class="text-muted">* untuk jabatan manajerial</small>
                            <textarea class="form-control" name="lampiran_b_pelaporan" rows="3"><?= isset($lampiranB) ? $lampiranB->Pelaporan : ''; ?></textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div id="sectionButtons" class="form-section" style="display:none;">
                        <div class="text-center">
                            <a href="<?= base_url('perubahanmpp') ?>" class="btn btn-default btn-lg">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                            <button type="button" class="btn btn-warning btn-lg" onclick="resetForm()">
                                <i class="fa fa-refresh"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save"></i> Update Draft
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/toastr.min.js"></script>
<script>
    const base_url = '<?= base_url() ?>';
    let selectedTipe = 0;

    function selectTipe(tipe) {
        selectedTipe = tipe;
        $('#input_tipe_perubahan').val(tipe);

        $('.tipe-card').removeClass('selected');
        $('.tipe-card[data-tipe="' + tipe + '"]').addClass('selected');

        $('#formUtama, #sectionStatusJabatan, #sectionJumlah, #sectionSifat, #sectionLatarBelakang, #sectionStruktur, #sectionKualifikasi, #sectionButtons').slideDown();

        $('#lampiranA, #lampiranB').removeClass('active').hide();

        if (tipe == 1) {
            $('#lampiranA').addClass('active').slideDown();
            $('input[name="status_jabatan"][value="BARU"]').prop('checked', true);
        } else if (tipe == 2) {
            $('#lampiranB').addClass('active').slideDown();
            $('input[name="status_jabatan"][value="LAMA"]').prop('checked', true);
        } else if (tipe == 3) {
            $('#lampiranA, #lampiranB').addClass('active').slideDown();
        }

        $('html, body').animate({
            scrollTop: $('#formUtama').offset().top - 100
        }, 500);
    }

    function resetForm() {
        if (confirm('Reset form?')) {
            $('#formPerubahanMPP')[0].reset();
            $('.tipe-card').removeClass('selected');
            $('#formUtama, #sectionStatusJabatan, #sectionJumlah, #sectionSifat, #sectionLatarBelakang, #sectionStruktur, #sectionKualifikasi, #sectionButtons, #lampiranA, #lampiranB').hide();
            selectedTipe = 0;
            $('#selisih').val('');
        }
    }

    $('#jumlah_sebelum, #jumlah_sesudah').on('change keyup', function() {
        let sebelum = parseInt($('#jumlah_sebelum').val()) || 0;
        let sesudah = parseInt($('#jumlah_sesudah').val()) || 0;
        let selisih = sesudah - sebelum;

        $('#selisih').val((selisih > 0 ? '+' : '') + selisih).css('color', selisih > 0 ? 'green' : (selisih < 0 ? 'red' : '#333'));

        $('input[name="sifat_perubahan"][value="' + (selisih > 0 ? 'PENAMBAHAN' : (selisih < 0 ? 'PENGURANGAN' : 'TETAP')) + '"]').prop('checked', true);
    });

    $('#formPerubahanMPP').on('submit', function(e) {
        e.preventDefault();
        console.log('submit..');

        if (selectedTipe == 0) {
            toastr.warning('Pilih tipe perubahan terlebih dahulu');
            return;
        }

        $.ajax({
            url: base_url + 'perubahanmpp/update',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
            },
            success: function(res) {
                if (res.Err == 0) {
                    toastr.success(res.Msg);
                    setTimeout(function() {
                        window.location.href = base_url + 'perubahanmpp';
                    }, 1500);
                } else {
                    toastr.error(res.Msg);
                    $('button[type="submit"]').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Draft');
                }
            },
            error: function() {
                toastr.error('Terjadi kesalahan sistem');
                $('button[type="submit"]').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Draft');
            }
        });
    });


    let uri = "<?= $this->uri->segment(2) ?>";
    if (uri === 'edit') {
        let tipe = <?= $header->TipePerubahan ?>;
        selectTipe(tipe);
    }
</script>