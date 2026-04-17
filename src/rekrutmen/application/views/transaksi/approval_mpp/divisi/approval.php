<style>
    .detail-section {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #fafafa;
    }

    .detail-section-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #1ca8c5;
    }

    .detail-row {
        margin-bottom: 10px;
    }

    .detail-label {
        font-weight: bold;
        color: #666;
    }

    .detail-value {
        color: #333;
    }

    .lampiran-section {
        border: 2px solid #28a745;
        background-color: #f8fff8;
    }

    .lampiran-section.lampiran-b {
        border-color: #007bff;
        background-color: #f8f9ff;
    }

    .status-badge {
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
    }

    .status-draft {
        background-color: #6c757d;
        color: #fff;
    }

    .status-submitted {
        background-color: #ffc107;
        color: #333;
    }

    .status-approved {
        background-color: #28a745;
        color: #fff;
    }

    .status-rejected {
        background-color: #dc3545;
        color: #fff;
    }

    .detail-section {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .detail-section-title {
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 14px;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-info-circle"></i> Detail: <?= $header->NoPengajuan ?>
                    <?php
                    $statusClass = ['status-draft', 'status-submitted', 'status-approved', 'status-rejected'][$header->Status];
                    $statusText = ['Draft', 'Menunggu Approval', 'Disetujui', 'Ditolak'][$header->Status];
                    ?>

                </h3>
            </div>
            <div class="panel-body">
                <div class="detail-section">
                    <div class="detail-section-title">
                        <i class="fa fa-building"></i> Approval
                    </div>
                    <form action="" id="approvalForm">
                        <div class="row">
                            <!-- Kolom Approval -->
                            <div class="col-md-4">
                                <input type="hidden" name="txtId" value="<?= $header->ID ?>">
                                <label class="control-label bolder">Status Approval</label>

                                <div class="radio">
                                    <label>
                                        <input name="txtHasil" type="radio" class="ace" value="1" checked>
                                        <span class="lbl"> Disetujui</span>
                                    </label>
                                </div>

                                <div class="radio">
                                    <label>
                                        <input name="txtHasil" type="radio" class="ace" value="2">
                                        <span class="lbl"> Ditolak</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Kolom Keterangan -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label bolder">Keterangan / Catatan</label>
                                    <textarea id="inputKeterangan" name="txtKeterangan" class="form-control" rows="3"><?= $header->RejectionReason ?></textarea>
                                </div>
                            </div>

                            <!-- Kolom Tombol -->
                            <div class="col-md-3 text-right">
                                <label class="control-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Data Organisasi -->

                <div class="detail-section">
                    <div class="detail-section-title"><i class="fa fa-building"></i> Data Organisasi</div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="detail-label">Divisi:</span> <?= $header->Divisi ?: '-' ?></p>
                            <p><span class="detail-label">Departemen:</span> <?= $header->Departemen ?: '-' ?></p>
                            <p><span class="detail-label">Sub Departemen:</span> <?= $header->SubDepartemen ?: '-' ?> <?= $header->RejectionReason ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="detail-label">Jabatan:</span> <?= $header->Jabatan ?: '-' ?></p>
                            <p><span class="detail-label">Sub Jabatan:</span> <?= $header->SubJabatan ?: '-' ?></p>
                        </div>
                    </div>
                </div>

                <!-- Status & Jumlah -->
                <div class="detail-section">
                    <div class="detail-section-title"><i class="fa fa-info"></i> Status dan Jumlah</div>
                    <div class="row">
                        <div class="col-md-4">
                            <p><span class="detail-label">Tipe Perubahan:</span>
                                <?= ['', 'Penambahan Jabatan Baru', 'Penambahan Jabatan Lama', 'Jabatan Baru & Lama'][$header->TipePerubahan] ?></p>
                            <p><span class="detail-label">Status Jabatan:</span> <?= $header->StatusJabatan ?: '-' ?></p>
                            <p><span class="detail-label">Sifat Perubahan:</span> <?= $header->SifatPerubahan ?: '-' ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><span class="detail-label">Jumlah Sebelum:</span> <?= $header->JumlahSebelum ?> orang</p>
                            <p><span class="detail-label">Jumlah Sesudah:</span> <?= $header->JumlahSesudah ?> orang</p>
                            <?php $selisih = $header->JumlahSesudah - $header->JumlahSebelum; ?>
                            <p><span class="detail-label">Selisih:</span>
                                <span style="color:<?= $selisih > 0 ? 'green' : ($selisih < 0 ? 'red' : '#333') ?>; font-weight:bold;">
                                    <?= $selisih > 0 ? '+' : '' ?><?= $selisih ?> orang
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Latar Belakang -->
                <div class="detail-section">
                    <div class="detail-section-title"><i class="fa fa-file-text"></i> Latar Belakang & Proyeksi</div>
                    <p><span class="detail-label">Latar Belakang:</span></p>
                    <p><?= nl2br($header->LatarBelakang) ?: '-' ?></p>
                    <hr>
                    <p><span class="detail-label">Proyeksi Dampak:</span></p>
                    <p><?= nl2br($header->ProyeksiDampak) ?: '-' ?></p>
                </div>

                <!-- Kualifikasi -->
                <div class="detail-section">
                    <div class="detail-section-title"><i class="fa fa-graduation-cap"></i> Kualifikasi Kandidat</div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="detail-label">Pendidikan:</span> <?= $header->KualifikasiPendidikan ?: '-' ?></p>
                            <p><span class="detail-label">Pengalaman:</span> <?= $header->KualifikasiPengalaman ?: '-' ?></p>
                            <p><span class="detail-label">Manajerial:</span> <?= $header->KualifikasiManajerial ?: '-' ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="detail-label">Kompetensi:</span> <?= $header->KualifikasiKompetensi ?: '-' ?></p>
                            <p><span class="detail-label">Sertifikasi:</span> <?= $header->KualifikasiSertifikasi ?: '-' ?></p>
                            <p><span class="detail-label">Lain-lain:</span> <?= $header->KualifikasiLainnya ?: '-' ?></p>
                        </div>
                    </div>
                </div>

                <!-- LAMPIRAN A -->
                <?php if ($lampiranA) { ?>
                    <div class="detail-section lampiran-section">
                        <div class="detail-section-title" style="color:#28a745;">
                            <i class="fa fa-file-text-o"></i> LAMPIRAN A - Uraian Penambahan Sub Jabatan Baru
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p><span class="detail-label">Nama Sub Jabatan:</span> <?= $lampiranA->NamaSubJabatan ?: '-' ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><span class="detail-label">Level:</span> <?= $lampiranA->LevelJabatan ?: '-' ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><span class="detail-label">Pengisi:</span> <?= $lampiranA->PengisiSubJabatan ?: '-' ?></p>
                            </div>
                        </div>
                        <?php if ($lampiranA->Catatan) { ?><p><span class="detail-label">Catatan:</span> <?= nl2br($lampiranA->Catatan) ?></p><?php } ?>
                        <hr>
                        <p><span class="detail-label">Tugas & Tanggung Jawab:</span></p>
                        <p><?= nl2br($lampiranA->TugasTanggungJawab) ?: '-' ?></p>
                        <p><span class="detail-label">Wewenang:</span></p>
                        <p><?= nl2br($lampiranA->Wewenang) ?: '-' ?></p>
                        <p><span class="detail-label">Target Kerja:</span></p>
                        <p><?= nl2br($lampiranA->TargetKerja) ?: '-' ?></p>
                        <div class="row">
                            <div class="col-md-4">
                                <p><span class="detail-label">Hub. Atasan Bawahan:</span></p>
                                <p><?= nl2br($lampiranA->HubunganAtasanBawahan) ?: '-' ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><span class="detail-label">Hub. Internal:</span></p>
                                <p><?= nl2br($lampiranA->HubunganInternal) ?: '-' ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><span class="detail-label">Hub. Eksternal:</span></p>
                                <p><?= nl2br($lampiranA->HubunganEksternal) ?: '-' ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- LAMPIRAN B -->
                <?php if ($lampiranB) { ?>
                    <div class="detail-section lampiran-section lampiran-b">
                        <div class="detail-section-title" style="color:#007bff;">
                            <i class="fa fa-file-text-o"></i> LAMPIRAN B - Uraian Penambahan Sub Jabatan Lama
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p><span class="detail-label">Nama Sub Jabatan:</span> <?= $lampiranB->NamaSubJabatan ?: '-' ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><span class="detail-label">Level:</span> <?= $lampiranB->LevelJabatan ?: '-' ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><span class="detail-label">Pengisi:</span> <?= $lampiranB->PengisiSubJabatan ?: '-' ?></p>
                            </div>
                        </div>
                        <?php if ($lampiranB->Catatan) { ?><p><span class="detail-label">Catatan:</span> <?= nl2br($lampiranB->Catatan) ?></p><?php } ?>
                        <hr>
                        <p><span class="detail-label">Tugas & Tanggung Jawab:</span></p>
                        <p><?= nl2br($lampiranB->TugasTanggungJawab) ?: '-' ?></p>
                        <p><span class="detail-label">Wewenang:</span></p>
                        <p><?= nl2br($lampiranB->Wewenang) ?: '-' ?></p>
                        <p><span class="detail-label">Koordinasi:</span></p>
                        <p><?= nl2br($lampiranB->Koordinasi) ?: '-' ?></p>
                        <p><span class="detail-label">Pelaporan:</span></p>
                        <p><?= nl2br($lampiranB->Pelaporan) ?: '-' ?></p>
                    </div>
                <?php } ?>

                <!-- Tracking -->
                <div class="detail-section">
                    <div class="detail-section-title"><i class="fa fa-history"></i> Informasi Tracking</div>
                    <div class="row">
                        <div class="col-md-4">
                            <p><span class="detail-label">Dibuat Oleh:</span> <?= $header->CreatedBy ?></p>
                            <p><span class="detail-label">Tanggal:</span> <?= date('d-m-Y H:i', strtotime($header->CreatedDate)) ?></p>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/jsadd/sweetalert.min.js"></script>
<script src="<?= base_url() ?>assets/js/toastr.min.js"></script>

<script>
    function submitData(id) {
        swal({
            title: "Konfirmasi Submit",
            text: "Setelah disubmit, data tidak dapat diedit. Lanjutkan?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Ya, Submit!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: '<?= base_url() ?>perubahanmpp/submit',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.Err == 0) {
                        swal({
                            title: "Berhasil!",
                            text: res.Msg,
                            type: "success"
                        }, function() {
                            location.reload();
                        });
                    } else {
                        swal("Gagal!", res.Msg, "error");
                    }
                }
            });
        });
    }

    $(document).ready(function() {

        function toggleKeterangan() {
            var hasil = $('input[name="txtHasil"]:checked').val();

            if (hasil == '1') {
                $('#inputKeterangan')
                    .prop('readonly', true)
                // .val(''); // optional: kosongkan saat disetujui
            } else if (hasil == '2') {
                $('#inputKeterangan')
                    .prop('readonly', false)
                    .focus();
            }
        }

        // jalan saat load pertama
        toggleKeterangan();

        // jalan saat radio berubah
        $('input[name="txtHasil"]').on('change', function() {
            toggleKeterangan();
        });

    });
</script>