<?php
/* 
 * Author : Ismo___
 */
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery.battatech.excelexport.js"></script>

<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Lihat Berkas Tenaga Kerja
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">List Calon Tenaga Kerja </h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                        <div class="widget-toolbar no-border">
                            <span>
                                <button class="btn btn-minier btn-success" id="btnExport">
                                    <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <select class="form-control" name="selTenaker" id="selTenaker">
                                        <option value="">All (Semua)</option>
                                        <option value="verifi">Unverified</option>
                                        <option value="proses">Proses</option>
                                        <option value="identifi">Belum Identifikasi</option>
                                        <option value="belumposting">Belum Posting</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <?= $this->session->userdata('w_datea') . 'a' ?> -->
                            <br>
                            <div class="col-xs-12 col-sm-4" <?php echo ($this->session->userdata('userid') == 'KIKI' || $this->session->userdata('userid') == 'riyan' ? '' : 'style="display: none;"') ?>>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right">Range</label>
                                    <div class="col-sm-8">
                                        <div class="input-daterange input-group">
                                            <input type="text" class="input-sm form-control datepick txtDateA" id="txtDateA" name="txtDateA" value="">
                                            <span class="input-group-addon">
                                                <i class="fa fa-exchange"></i>
                                            </span>
                                            <input type="text" class="input-sm form-control datepick txtDateZ" id="txtDateZ" name="txtDateZ" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="data" class="table table-responsive">
                                <table id="dataTables-listTK" class="toExcel table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Pemborong</th>
                                            <th>Tangga Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Record Interview</th>
                                            <th>
                                                <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                            </th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($_getListTK as $set) :
                                        ?>
                                            <?php
                                            if ($set->InputOnline === 1) {
                                                echo '<tr data-id="' . $set->HeaderID . '" class="rowdetail success" >';
                                            } else {
                                                echo '<tr data-id="' . $set->HeaderID . '" class="rowdetail" >';
                                            }
                                            ?>
                                            <td class="headerid"><?php echo  $set->HdrID; ?></td>
                                            <td><?php echo $set->Nama; ?></td>
                                            <td><?php echo $set->Pemborong; ?></td>
                                            <td class="text-right col-md-1"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
                                            <td><?php
                                                $jekel = $set->Jenis_Kelamin;
                                                if ($jekel == 'M' || $jekel == 'LAKI-LAKI') {
                                                    echo 'Laki-laki';
                                                } elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                                    echo 'Perempuan';
                                                } else {
                                                    echo 'Gx Jelas';
                                                }
                                                ?></td>
                                            <td class="text-center">
                                                <?php
                                                if ($set->WawancaraKe == NULL) {
                                                    echo 'Belum Pernah';
                                                } else {
                                                ?>
                                                    <a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                                                        <i class="ace-icon fa fa-files-o bigger-100"></i> <?php echo $set->WawancaraKe . ' kali'; ?>
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="text-left"><?php echo ucwords(strtolower($set->CreatedBy)); ?></div>
                                                <div class="text-right smaller-90"><?php echo $set->RegisteredDate; ?></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                                        Berkas
                                                        <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-default">
                                                        <li>
                                                            <?php if ($set->KTP != NULL) { ?>
                                                                <a title="show detail" href="#" class="detail" data-name="KTP" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">KTP</a>
                                                            <?php } else {
                                                                echo "<a><small><i>KTP is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Lamaran != NULL) { ?>
                                                                <a title="show detail" href="#" class="detail" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Lamaran</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Lamaran is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->CV != NULL) { ?>
                                                                <a title="show detail" href="#" class="detail" data-name="CV" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Curiculum Vitae</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Ijazah != NULL) { ?>
                                                                <a title="show detail" href="#" class="detail" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Ijazah</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Ijazah is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($set->Transkrip != NULL) { ?>
                                                                <a title="show detail" href="#" class="detail" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama)); ?>">Transkrip Niali</a>
                                                            <?php } else {
                                                                echo "<a><small><i>Transkrip is NULL</i></small></a>";
                                                            } ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a title="View Detail" data-rel="tooltip" href="#" class="detailInfo btn btn-minier btn-round btn-primary">
                                                    <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                                </a>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="toExcel" class="table table-responsive">
                                <table id="exportToExcel" class="table table-bordered" hidden="">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Regis ID</th>
                                            <th>Nama</th>
                                            <th>Pemborong</th>
                                            <th>Perusahaan</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Alamat</th>
                                            <th>RT</th>
                                            <th>RW</th>
                                            <th>Handphone</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Tinggal Dengan</th>
                                            <th>Hubungan Dengan Pelamar</th>
                                            <th>Tinggi Badan</th>
                                            <th>Berat Badan</th>
                                            <th>Suku</th>
                                            <th>Daerah Asal</th>
                                            <th>Bahasa Daerah</th>
                                            <th>Agama</th>
                                            <th>Status Perkawianan</th>

                                            <th>Nama Pasangan</th>
                                            <th>Tanggal Lahir Pasangan</th>
                                            <th>Pekerjaan Pasangan</th>
                                            <th>Alamat Pasangan</th>
                                            <th>Jumlah Anak</th>

                                            <th>Nama Ayah</th>
                                            <th>Nama Ibu</th>
                                            <th>Pekerjaan Ortu</th>
                                            <th>Anak Ke</th>
                                            <th>Jumlah saudara</th>

                                            <th>Pendidikan Terakhir</th>
                                            <th>Jurusan</th>
                                            <th>Nama Univ/ Sekolah</th>
                                            <th>Rata Nilai</th>
                                            <th>Tahun Masuk</th>
                                            <th>Tahun Lulus</th>

                                            <th>Pengalaman Kerja</th>
                                            <th>Skill/ Keahlian</th>
                                            <th>Pernah Kerja di SAMBU</th>
                                            <th>Bagian/ Department</th>

                                            <th>Hobby</th>
                                            <th>Kegiatan Ekstra</th>
                                            <th>Kegiatan Organisasi</th>
                                            <th>Keadaan Fisik</th>
                                            <th>Idap Penyakit</th>
                                            <th>Penyakit Apa</th>
                                            <th>Pernah Terlibat Kriminal</th>
                                            <th>Perkara Apa</th>
                                            <th>Bertato</th>
                                            <th>Bertindik</th>
                                            <th>Sedia Rambut Pendek
                                            <th>
                                            <th>Sedia Diberhentikan
                                            <th>

                                            <th>Facebook
                                            <th>
                                            <th>Twitter
                                            <th>
                                            <th>Register By
                                            <th>
                                            <th>Register Date
                                            <th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $noUrut = 1;
                                        foreach ($_getListTKtoExcel as $row) : ?>
                                            <tr>
                                                <td><?php echo $noUrut++; ?></td>
                                                <td><?php echo $row->HeaderID; ?></td>
                                                <td><?php echo $row->Nama; ?></td>
                                                <td><?php echo $row->Pemborong; ?></td>
                                                <td><?php echo $row->CVNama; ?></td>
                                                <td><?php if ($row->Jenis_Kelamin == 'M') {
                                                        echo 'Laki-laki';
                                                    } else {
                                                        echo 'Perempuan';
                                                    } ?></td>
                                                <td><?php echo $row->Alamat; ?></td>
                                                <td><?php echo $row->RT; ?></td>
                                                <td><?php echo $row->RW; ?></td>
                                                <td><?php echo $row->NoHP; ?></td>
                                                <td><?php echo $row->Tempat_Lahir; ?></td>
                                                <td><?php echo date('d M Y', strtotime($row->Tgl_Lahir)); ?></td>
                                                <td><?php echo $row->TinggalDengan; ?></td>
                                                <td><?php echo $row->HubunganDenganTK; ?></td>
                                                <td><?php echo $row->TinggiBadan; ?></td>
                                                <td><?php echo $row->BeratBadan; ?></td>
                                                <td><?php echo $row->Suku; ?></td>
                                                <td><?php echo $row->Daerah_Asal; ?></td>
                                                <td><?php echo $row->BahasaDaerah; ?></td>
                                                <td><?php echo $row->Agama; ?></td>
                                                <td><?php echo $row->Status_Personal; ?></td>

                                                <td><?php echo $row->NamaSuamiIstri; ?></td>
                                                <td><?php echo date('d M Y', strtotime($row->TglLahirSuamiIstri)); ?></td>
                                                <td><?php echo $row->PekerjaanSuamiIstri; ?></td>
                                                <td><?php echo $row->AlamatSuamiIstri; ?></td>
                                                <td><?php echo $row->JumlahAnak; ?></td>

                                                <td><?php echo $row->NamaBapak; ?></td>
                                                <td><?php echo $row->NamaIbuKandung; ?></td>
                                                <td><?php echo $row->ProfesiOrangTua; ?></td>
                                                <td><?php echo $row->AnakKe; ?></td>
                                                <td><?php echo $row->JumlahSaudara; ?></td>

                                                <td><?php echo $row->Pendidikan; ?></td>
                                                <td><?php echo $row->Jurusan; ?></td>
                                                <td><?php echo $row->Universitas; ?></td>
                                                <td><?php echo $row->IPK; ?></td>
                                                <td><?php echo $row->TahunMasuk; ?></td>
                                                <td><?php echo $row->TahunLulus; ?></td>

                                                <td><?php echo $row->PengalamanKerja; ?></td>
                                                <td><?php echo $row->Keahlian; ?></td>
                                                <td><?php echo $row->PernahKerjaDiSambu; ?></td>
                                                <td><?php echo $row->KerjadiBagian; ?></td>

                                                <td><?php echo $row->Hobby; ?></td>
                                                <td><?php echo $row->KegiatanEkstra; ?></td>
                                                <td><?php echo $row->KegiatanOrganisasi; ?></td>
                                                <td><?php echo $row->KeadaanFisik; ?></td>
                                                <td><?php echo $row->PernahIdapPenyakit; ?></td>
                                                <td><?php echo $row->PenyakitApa; ?></td>
                                                <td><?php echo $row->Kriminal; ?></td>
                                                <td><?php echo $row->PerkaraApa; ?></td>
                                                <td><?php echo $row->Bertato; ?></td>
                                                <td><?php echo $row->Bertindik; ?></td>
                                                <td><?php echo $row->SediaPotongRambut; ?>
                                                <td>
                                                <td><?php echo $row->Sediadiberhentikan; ?>
                                                <td>

                                                <td><?php echo $row->AccountFacebook; ?>
                                                <td>
                                                <td><?php echo $row->AccountTwitter; ?>
                                                <td>
                                                <td><?php echo $row->CreatedBy; ?>
                                                <td>
                                                <td><?php echo $row->CreatedDate; ?>
                                                <td>
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
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewModalInterview" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Record Wawancara</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detailInterview" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal to Excel -->
<div class="modal fade" id="modalToExcel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"> Export to Excel</h4>
            </div>
            <div class="modal-body">
                <div id="showTable">

                </div>
                Isi Body
            </div>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detail" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewModalInfo" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Data Karyawan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detailInfo" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('.datepick').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });

    $(document).ready(function() {
        $('#dataTables-listTK').dataTable();

        $("#btnExport").click(function() {
            $("#tblExport").battatech_excelexport({
                containerid: "exportToExcel",
                datatype: 'table'
            });
        });

        $("#dataTables-listTK").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('wawancaraTujuan/cekRecordInterview'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detailInterview").html(msg);
                }
            });
            $("#viewModalInterview").modal("show");
        });

        $("#btnExport").click(function() {
            var select = document.getElementById('select').value;
            $.ajax({
                url: "<?php echo site_url('monitor/toExcel'); ?>",
                type: "POST",
                data: "select=" + select,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#showTable").html(msg);
                }
            });
            document.getElementById('titleModal').innerHTML = select;
            $("#modalToExcel").modal("show");
        });

        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            var name = $(this).data('name');
            var tk = $(this).data('tk');

            document.getElementById('titleModal').innerHTML = "Berkas " + name + " dari saudara, <strong class='green'>" + tk + " </strong>";
            $.ajax({
                url: "<?php echo site_url('monitor/viewDocs'); ?>",
                type: "POST",
                data: "kode=" + id + "&nama=" + name,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detail").html(msg);
                }
            });
            $("#viewModal").modal("show");
        });

        $("#dataTables-listTK").on("click", ".detailInfo", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('uploadBerkas/detailtk'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detailInfo").html(msg);
                }
            });
            $("#viewModalInfo").modal("show");
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('change', '#txtDateZ', function() {
            let datez = $(".txtDateZ").val()
            let datea = $(".txtDateA").val();
            let selTenaker = $("#selTenaker").val();
            console.log(datea);
            $.ajax({
                type: "POST",
                // dataType: 'json',
                url: "<?= site_url('monitor/selectViewTanggal')  ?>",
                data: {
                    datea,
                    datez,
                },
                success: function(data) {
                    $('#data').html(data);
                    // $('#selTenaker').val(selTenaker).trigger('change')
                }
            })

        })
    })
    // $("#txtDateZ").change(function() {

    // })

    $("#selTenaker").change(function() {
        var selected = $("#selTenaker").val();
        // var datea = $(".txtDateA").val();
        // var datea = $(".txtDateZ").val();

        if (selected === 'verifi') {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('monitor/selectViewTenakerVerifi') ?>",
                success: function(msg) {
                    $('#data').html(msg);
                }
            });
            $.ajax({
                url: "<?php echo site_url('monitor/toExcel'); ?>",
                type: "POST",
                data: "select=verifi",
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#toExcel").html(msg);
                }
            });
        } else if (selected === 'proses') {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('monitor/selectViewTenakerProses') ?>",
                success: function(msg) {
                    $('#data').html(msg);
                }
            });
            $.ajax({
                url: "<?php echo site_url('monitor/toExcel'); ?>",
                type: "POST",
                data: "select=proses",
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#toExcel").html(msg);
                }
            });
        } else if (selected === 'identifi') {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('monitor/selectViewTenakeridentifi') ?>",
                success: function(msg) {
                    $('#data').html(msg);
                }
            });
            $.ajax({
                url: "<?php echo site_url('monitor/toExcel'); ?>",
                type: "POST",
                data: "select=identifi",
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#toExcel").html(msg);
                }
            });
        } else if (selected === 'belumposting') {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('monitor/selectViewTenakerBelumPosting') ?>",
                success: function(msg) {
                    $('#data').html(msg);
                }
            });
            $.ajax({
                url: "<?php echo site_url('monitor/toExcel'); ?>",
                type: "POST",
                data: "select=identifi",
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#toExcel").html(msg);
                }
            });
        } else if (selected === 'closed') {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('monitor/selectViewTenakerClosed') ?>",
                success: function(msg) {
                    $('#data').html(msg);
                }
            });

            $.ajax({
                url: "<?php echo site_url('monitor/toExcel'); ?>",
                type: "POST",
                data: "select=closed",
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#toExcel").html(msg);
                }
            });
        } else {
            location.reload();
        }
    });
</script>