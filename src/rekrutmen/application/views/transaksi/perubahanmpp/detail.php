<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-file-text-o"></i>
        Detail Pengajuan Perubahan MPP
    </span>
</h4>

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
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-info-circle"></i> Detail: <?= $header->NoPengajuan ?>
                    <?php
                    $statusClass = ['status-draft', 'status-submitted', 'status-submitted', 'status-submitted', 'status-approved', 'status-rejected'][$header->Status];
                    $statusText = ['Draft', 'Menunggu Approval Dept', 'Menunggu Approval Divisi', 'Menunggu Approval HRD', 'Selesai', 'Rejected'][$header->Status];
                    ?>
                    <span class="status-badge <?= $statusClass ?> pull-right"><?= $statusText ?></span>
                </h3>
            </div>
            <div class="panel-body">
                <!-- Data Organisasi -->
                <div class="detail-section">
                    <div class="detail-section-title"><i class="fa fa-building"></i> Data Organisasi</div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><span class="detail-label">Divisi:</span> <?= $header->Divisi ?: '-' ?></p>
                            <p><span class="detail-label">Departemen:</span> <?= $header->Departemen ?: '-' ?></p>
                            <p><span class="detail-label">Sub Departemen:</span> <?= $header->SubDepartemen ?: '-' ?></p>
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

                <!-- Buttons -->
                <div class="text-center">
                    <a href="javascript:void(0)" class="btn btn-default btn-lg" onclick="if (document.referrer) { history.back(); } else { window.location.href='<?= base_url('perubahanmpp') ?>'; }">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>

                    <?php if ($header->Status == 0) { ?>
                        <a href="<?= base_url('perubahanmpp/edit/' . encode_str($header->ID)) ?>" class="btn btn-warning btn-lg"><i class="fa fa-edit"></i> Edit</a>
                        <button type="button" class="btn btn-success btn-lg" onclick="submitData('<?= encode_str($header->ID) ?>')"><i class="fa fa-send"></i> Submit</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/jsadd/sweetalert.min.js"></script>
<script>
    function submitData(id) {
        // Pastikan 'id' sudah didefinisikan sebelumnya
        Swal.fire({
            title: 'Konfirmasi Submit',
            text: "Setelah disubmit, data tidak dapat diedit. Lanjutkan?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ya, Submit!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Optional: disable tombol atau tampilkan loading
                Swal.showLoading();

                $.ajax({
                    url: '<?= base_url() ?>perubahanmpp/submit',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.Err == 0) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: res.Msg,
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', res.Msg, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'Terjadi kesalahan server: ' + error, 'error');
                    }
                });
            }
        });

    }
</script>