<?php
if ($pesan == 'anotherPemborong') {
    $txt = "<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> " . $namatk . " <small>telah terdaftar oleh Pemborong lain!!</small>";
} elseif ($pesan == 'karyawanAktif') {
    $txt = "<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> " . $namatk . " <small>masih aktif sebagai Tenaga Kerja!!</small>";
} elseif ($pesan == 'calonGagalScreen') {
    $txt = "<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> " . $namatk . " <small>telah/pernah mendaftar dan ditolak!!</small>";
} elseif ($pesan == 'calonInTemp') {
    $txt = "<strong>Maaf..!</strong> <small>Calon Tenaga Kerja atas Nama</small> " . $namatk . " <small>masih dalam waktu tenggang tanggal dia keluar!!</small>";
}
?>
<div class="widget-box widget-color-red2 ui-sortable-handle">
    <div class="widget-header">
        <h4 class="widget-title"><strong>Gagal Simpan!!</strong> Registrasi Anda Ditolak</h4>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="1 ace-icon fa fa-chevron-up bigger-125"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-main">
            <h5>Data yang anda masukkan tidak tersimpan.</h5>
            <div class="alert alert-block alert-danger">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <i class="ace-icon fa fa-warning"></i>&nbsp;<?php echo $txt; ?>
            </div>
        </div>

        <div class="widget-toolbox padding-8 clearfix">
            <a class="btn btn-xs btn-primary" href="<?php echo site_url('registrasi'); ?>"><span class="fa fa-arrow-left">&nbsp;</span> Kembali ke form Registrasi</a>
        </div>
    </div>
</div>