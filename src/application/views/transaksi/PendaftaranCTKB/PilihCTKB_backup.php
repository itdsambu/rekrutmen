<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/toExcel/jquery.battatech.excelexport.js"></script>
<div class="page-header">
    <h1>
        TRANSAKSI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Daftar CTKB
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
                        <h4 class="widget-title">List Tenaga Kerja Baru </h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>

                        <?php
                        $idpemborong    = $this->session->userdata('idpemborong');

                        if ($idpemborong == 0) { ?>
                            <!-- <div class="widget-toolbar no-border">
                                <span>
                                    <button class="btn btn-minier btn-success" id="btnExport">
                                        <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                                    </button>
                                </span>
                            </div> -->
                        <?php   } ?>
                    </div>

                    <br>
                    <div class="tabbable">
                        <ul class="nav nav-tabs padding-18 tab-size-bigger" id="myTab">
                            <li class="active">
                                <a data-toggle="tab" aria-expanded="true" href="#faq-tab-1">
                                    <i class="blue ace-icon fa fa-book bigger-120"></i>
                                    &nbsp Main &nbsp
                                </a>
                            </li>

                            <li>
                                <a data-toggle="tab" aria-expanded="true" href="#faq-tab-2">
                                    <i class="green ace-icon fa fa-pencil bigger-120"></i>
                                    Proses
                                </a>
                            </li>


                        </ul>

                        <div class="tab-content no-border padding-24">
                            <!-- ////////////////////////////////////////////////////////////////////////// TAB 1 ////////////////////////////////////////////////////////////////////////////////////////////// -->
                            <div id="faq-tab-1" class="tab-pane fade in active">


                                <?php
                                if ($idpemborong > 0) { ?>
                                    <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="table-responsive">
                                                    <table id="dataTables-listTK2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" class="ace chk_all">
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </th>
                                                                <th class="info">ID</th>
                                                                <th class="info">Nama</th>
                                                                <th class="info">Pemborong</th>
                                                                <th class="info">Sub Pemborong</th>
                                                                <th class="info">Tangga Lahir</th>
                                                                <th class="info">Jenis Kelamin</th>
                                                                <th class="info">
                                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                                </th>

                                                                <th class="info center">Vaksin</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            foreach ($_getTenaker as $set) :
                                                            ?>
                                                                <!-- <?php
                                                                        $xxx = '';
                                                                        if ($set->IdentifikasiValid == 'Salah') {
                                                                            $xxx = 'style="background-color: #ff9999;"';
                                                                        }
                                                                        echo '<tr ' . $xxx . ' data-id="' . $set->HeaderID . '" class="rowdetail" >';
                                                                        ?> -->

                                                                <td class="text-center">
                                                                    <div class="checkbox">
                                                                        <label class="pos-rel">
                                                                            <input name="chkPosting[]" id="chkPosting" class="chkPosting" type="checkbox" value="<?php echo $set->HeaderID; ?>">
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 50px " class="text-right header"><?php echo $set->HeaderID; ?></td>
                                                                <td><?php echo $set->Nama; ?></td>
                                                                <td><?php echo $set->Pemborong; ?>
                                                                    <?php if ($set->Pemborong == 'YAO HSING') {
                                                                        $tipe = 1;
                                                                    } else {
                                                                        $tipe = 0;
                                                                    } ?>
                                                                    <input name="txtTipe[]" type="hidden" value="<?php echo $tipe; ?>" readonly="">
                                                                </td>
                                                                <td><?php echo $set->SubPemborong; ?></td>
                                                                <td class="text-right"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
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
                                                                <td>
                                                                    <div class="text-left"><?php echo $set->RegisteredBy; ?></div>
                                                                    <div class="text-right smaller-90"><?php echo $set->RegisteredDate; ?></div>
                                                                </td>
                                                                <?php $color = '';
                                                                $set->Vaksin == 'SUDAH' ? $color = 'style="background-color: #7CFC00;"' : $color = 'style="background-color: #ff9999;"';
                                                                echo '<td ' . $color . ' data-id="' . $set->Vaksin . '" class="rowdetail center" >' . $set->Vaksin;
                                                                ?>
                                                                </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <h4 class="blue">
                                        <i class="ace-icon fa fa-chec1k"></i>
                                        <div class="widget-toolbar no-border">
                                            <span>
                                                <button class="btn btn-minier btn-success" id="btnExport">
                                                    <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                                                </button>
                                            </span>
                                        </div>
                                    </h4>
                                    <form id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label no-padding-right">Range</label>
                                                <div class="col-sm-8">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="input-sm form-control datepick start_date" id="start_date" name="start_date" value="<?= date('d-m-Y', strtotime($start_date)) ?>" autocomplete="off">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>
                                                        <input type="text" class="input-sm form-control datepick end_date" id="end_date" name="end_date" value="<?= date('d-m-Y', strtotime($end_date)) ?>" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3">
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-8 right">
                                                    <input type="submit" name="btnCari" id="inputCari" value="Refresh" class="btn btn-mini btn-block btn-round btn-info" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    <br>
                                    <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="table-responsive">
                                                    <table id="dataTables-listTK" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" class="ace chk_all">
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </th>
                                                                <th class="info">ID</th>
                                                                <th class="info">Nama</th>
                                                                <th class="info">Pemborong</th>
                                                                <th class="info">Sub Pemborong</th>
                                                                <th class="info">Tangga Lahir</th>
                                                                <th class="info">Jenis Kelamin</th>
                                                                <th class="info">
                                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                                </th>
                                                                <th class="info center">Tgl. Daftar by PBR</th>
                                                                <th class="info center">Vaksin</th>
                                                                <th class="info center">Opsi</th>
                                                                <th class="info center">Keterangan</th>
                                                                <th class="info center">Pilihan Tanda</th>
                                                                <th class="info center">Kualifikasi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            foreach ($_getTenaker as $set) :
                                                            ?>


                                                                <td class="text-center">
                                                                    <div class="checkbox">
                                                                        <label class="pos-rel">
                                                                            <input name="chkPosting[]" id="chkPosting" class="chkPosting" type="checkbox" value="<?php echo $set->HeaderID; ?>">
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 50px " class="text-right header headerid"><?php echo $set->HeaderID; ?></td>
                                                                <td><?php echo $set->Nama; ?></td>
                                                                <td><?php echo $set->Pemborong; ?>
                                                                    <?php if ($set->Pemborong == 'YAO HSING') {
                                                                        $tipe = 1;
                                                                    } else {
                                                                        $tipe = 0;
                                                                    } ?>
                                                                    <input name="txtTipe[]" type="hidden" value="<?php echo $tipe; ?>" readonly="">
                                                                </td>
                                                                <td><?php echo $set->SubPemborong; ?></td>
                                                                <td class="text-right"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
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
                                                                <td>
                                                                    <div class="text-left"><?php echo $set->RegisteredBy; ?></div>
                                                                    <div class="text-right smaller-90"><?php echo $set->RegisteredDate; ?></div>
                                                                </td>
                                                                <td>
                                                                    <div class="text-center"><?php echo $set->DikirimDate; ?></div>
                                                                </td>
                                                                <?php $color = '';
                                                                $set->Vaksin == 'SUDAH' ? $color = 'style="background-color: #7CFC00;"' : $color = 'style="background-color: #ff9999;"';
                                                                echo '<td ' . $color . ' data-id="' . $set->Vaksin . '" class="rowdetail center" >' . $set->Vaksin;
                                                                ?>
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
                                                                <td class="center">
                                                                    <select class="form-control keterangan" name="keterangan" id="keterangan">
                                                                        <option value="">-- Pilih --</option>
                                                                        <option value="belum_3_bln" <?= $set->KeteranganKirim == 'belum_3_bln' ? 'selected' : '' ?>>Daftar 2 CV belum 3 bulan</option>
                                                                        <option value="belum_1_bln" <?= $set->KeteranganKirim == 'belum_1_bln' ? 'selected' : '' ?>>Daftar di CV yang sama belum 1 bulan</option>
                                                                        <option value="belum_ada_lowongan" <?= $set->KeteranganKirim == 'belum_ada_lowongan' ? 'selected' : '' ?>>Belum sesuai kualifikasi/belum ada lowongan</option>
                                                                        <option value="blacklist" <?= $set->KeteranganKirim == 'blacklist' ? 'selected' : '' ?>>Blacklist</option>
                                                                        <option value="nik_tidak_valid" <?= $set->KeteranganKirim == 'nik_tidak_valid' ? 'selected' : '' ?>>NIK Tidak valid</option>
                                                                        <option value="blacklist_2_bln" <?= $set->KeteranganKirim == 'blacklist_2_bln' ? 'selected' : '' ?>>Blacklist 2 bulan</option>
                                                                    </select>
                                                                </td>
                                                                <td class="center">
                                                                    <select class="form-control proses" name="proses" id="proses" required>
                                                                        <option value="">-- Pilih --</option>
                                                                        <option value="proses" <?= $set->Proses == 'proses' ? 'selected' : '' ?>>Proses</option>
                                                                        <option value="belum" <?= $set->Proses == 'belum' ? 'selected' : '' ?>>Belum Bisa Proses</option>
                                                                        <option value="tidak" <?= $set->Proses == 'tidak' ? 'selected' : '' ?>>Tidak Bisa Proses</option>
                                                                    </select>
                                                                </td>
                                                                <?php if (isset($set->Kualifikasi)) { ?>
                                                                    <td><textarea name="kualifikasi" id="kualifikasi" class="kualifikasi" value="<?= $set->Kualifikasi ?>"><?= $set->Kualifikasi ?></textarea><br>
                                                                    <?php  } else { ?>
                                                                    <td><textarea name="kualifikasi" id="kualifikasi" class="kualifikasi"></textarea><br>
                                                                    <?php  } ?>
                                                                    <button type="button" name="simpan" id="simpan" class="simpan btn btn-primary btn-round btn-minier">Simpan</button>
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
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                <th>ID</th>
                                                                <th>Pemborong</th>
                                                                <th>Sub Pemborong</th>
                                                                <th>Asal</th>
                                                                <th>Keterangan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $no = 1;
                                                            foreach ($_getTenaker as $xl) { ?>
                                                                <tr>
                                                                    <td><?= $no++ ?></td>
                                                                    <td><?= $xl->Nama ?></td>
                                                                    <td><?= $xl->HeaderID ?></td>
                                                                    <td><?= $xl->CVNama ?></td>
                                                                    <td><?= $xl->SubPemborong ?></td>
                                                                    <td><?= $xl->Daerah_Asal ?></td>
                                                                    <td><?= $xl->KeteranganKirim ?></td>
                                                                </tr>
                                                            <?php  } ?>
                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </form>

                                    <div class="widget-toolbox padding-8 clearfix">
                                        <div class="row">
                                            <div class="col-md-6">

                                            </div>
                                            <div class="col-md-6">
                                                <button name="btnKirim" id="btnKirim" class="btnKirim btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                            <!-- ////////////////////////////////////////////////////////////////////////// TAB 2 ////////////////////////////////////////////////////////////////////////////////////////////// -->

                            <div id="faq-tab-2" class="tab-pane fade">

                                <?php if ($idpemborong > 0) { ?>
                                    <!-- <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="table-responsive">
                                                    <table id="dataTables-listTK2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" class="ace chk_all">
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </th>
                                                                <th class="info">ID</th>
                                                                <th class="info">Nama</th>
                                                                <th class="info">Pemborong</th>
                                                                <th class="info">Tangga Lahir</th>
                                                                <th class="info">Jenis Kelamin</th>
                                                                <th class="info">
                                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                                </th>

                                                                <th class="info center">Vaksin</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            foreach ($_getTenaker as $set) :
                                                            ?>                                                               

                                                                <td class="text-center">
                                                                    <div class="checkbox">
                                                                        <label class="pos-rel">
                                                                            <input name="chkPosting[]" id="chkPosting" class="chkPosting" type="checkbox" value="<?php echo $set->HeaderID; ?>">
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 50px " class="text-right header"><?php echo $set->HeaderID; ?></td>
                                                                <td><?php echo $set->Nama; ?></td>
                                                                <td><?php echo $set->Pemborong; ?>
                                                                    <?php if ($set->Pemborong == 'YAO HSING') {
                                                                        $tipe = 1;
                                                                    } else {
                                                                        $tipe = 0;
                                                                    } ?>
                                                                    <input name="txtTipe[]" type="hidden" value="<?php echo $tipe; ?>" readonly="">
                                                                </td>
                                                                <td class="text-right"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
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
                                                                <td>
                                                                    <div class="text-left"><?php echo $set->RegisteredBy; ?></div>
                                                                    <div class="text-right smaller-90"><?php echo $set->RegisteredDate; ?></div>
                                                                </td>
                                                                <?php $color = '';
                                                                $set->Vaksin == 'SUDAH' ? $color = 'style="background-color: #7CFC00;"' : $color = 'style="background-color: #ff9999;"';
                                                                echo '<td ' . $color . ' data-id="' . $set->Vaksin . '" class="rowdetail center" >' . $set->Vaksin;
                                                                ?>
                                                                </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </form> -->
                                <?php  } else { ?>
                                    <h4 class="blue">
                                        <i class="ace-icon fa fa-chec1k"></i>
                                        <div class="widget-toolbar no-border">
                                            <span>
                                                <button class="btn btn-minier btn-success" id="btnExportProses">
                                                    <i class="ace-icon fa fa-file-excel-o"></i> Export to Excel
                                                </button>
                                            </span>
                                        </div>
                                    </h4>
                                    <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/PilihCTKB'); ?>">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="table-responsive">
                                                    <table id="dataTables-listTK2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" class="ace chk_all">
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </th>
                                                                <th class="info">ID</th>
                                                                <th class="info">Nama</th>
                                                                <th class="info">Pemborong</th>
                                                                <th class="info">Sub Pemborong</th>
                                                                <th class="info">Tangga Lahir</th>
                                                                <th class="info">Jenis Kelamin</th>
                                                                <th class="info">
                                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                                </th>
                                                                <th class="info center">Tgl. Daftar by PBR</th>
                                                                <!-- <th class="info center">Tgl. Jadwal Interview</th> -->
                                                                <th class="info center">Vaksin</th>
                                                                <th class="info center">Opsi</th>
                                                                <!-- <th class="info center">Keterangan</th> -->
                                                                <th class="info center">Pilihan Tanda</th>
                                                                <th class="info center">Kualifikasi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            foreach ($_getTenakerProses as $set) :
                                                            ?>


                                                                <td class="text-center">
                                                                    <div class="checkbox">
                                                                        <label class="pos-rel">
                                                                            <input name="chkPosting[]" id="chkPosting" class="chkPosting" type="checkbox" value="<?php echo $set->HeaderID; ?>">
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 50px " class="text-right header headerid"><?php echo $set->HeaderID; ?></td>
                                                                <td><?php echo $set->Nama; ?></td>
                                                                <td><?php echo $set->Pemborong; ?>
                                                                    <?php if ($set->Pemborong == 'YAO HSING') {
                                                                        $tipe = 1;
                                                                    } else {
                                                                        $tipe = 0;
                                                                    } ?>
                                                                    <input name="txtTipe[]" type="hidden" value="<?php echo $tipe; ?>" readonly="">
                                                                </td>
                                                                <td><?php echo $set->SubPemborong; ?></td>
                                                                <td class="text-right"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
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
                                                                <td>
                                                                    <div class="text-left"><?php echo $set->RegisteredBy; ?></div>
                                                                    <div class="text-right smaller-90"><?php echo $set->RegisteredDate; ?></div>
                                                                </td>
                                                                <td>
                                                                    <div class="text-center"><?php echo $set->DikirimDate; ?></div>
                                                                </td>
                                                                <!-- <td>
                                                                        <div class="text-center"><?php echo $set->JadwalInterview; ?></div>
                                                                    </td> -->
                                                                <?php $color = '';
                                                                $set->Vaksin == 'SUDAH' ? $color = 'style="background-color: #7CFC00;"' : $color = 'style="background-color: #ff9999;"';
                                                                echo '<td ' . $color . ' data-id="' . $set->Vaksin . '" class="rowdetail center" >' . $set->Vaksin;
                                                                ?>
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
                                                                <!-- <td class="center">
                                                                        <select class="form-control keterangan" name="keterangan" id="keterangan">
                                                                            <option value="">-- Pilih --</option>
                                                                            <option value="belum_3_bln" <?= $set->KeteranganKirim == 'belum_3_bln' ? 'selected' : '' ?>>Daftar 2 CV belum 3 bulan</option>
                                                                            <option value="belum_1_bln" <?= $set->KeteranganKirim == 'belum_1_bln' ? 'selected' : '' ?>>Daftar di CV yang sama belum 1 bulan</option>
                                                                            <option value="belum_ada_lowongan" <?= $set->KeteranganKirim == 'belum_ada_lowongan' ? 'selected' : '' ?>>Belum sesuai kualifikasi/belum ada lowongan</option>
                                                                            <option value="blacklist" <?= $set->KeteranganKirim == 'blacklist' ? 'selected' : '' ?>>Blacklist</option>
                                                                            <option value="nik_tidak_valid" <?= $set->KeteranganKirim == 'nik_tidak_valid' ? 'selected' : '' ?>>NIK Tidak valid</option>
                                                                            <option value="blacklist_2_bln" <?= $set->KeteranganKirim == 'blacklist_2_bln' ? 'selected' : '' ?>>Blacklist 2 bulan</option>
                                                                        </select>
                                                                    </td> -->
                                                                <td class="center">
                                                                    <select class="form-control proses" name="proses" id="proses" required readonly disabled>
                                                                        <option value="">-- Pilih --</option>
                                                                        <option value="proses" <?= $set->Proses == 'proses' ? 'selected' : '' ?>>Proses</option>
                                                                        <option value="belum" <?= $set->Proses == 'belum' ? 'selected' : '' ?>>Belum Bisa Proses</option>
                                                                        <option value="tidak" <?= $set->Proses == 'tidak' ? 'selected' : '' ?>>Tidak Bisa Proses</option>
                                                                    </select>
                                                                </td>
                                                                <?php if (isset($set->Kualifikasi)) { ?>
                                                                    <td><textarea name="kualifikasi" id="kualifikasi" class="kualifikasi" value="<?= $set->Kualifikasi ?>"><?= $set->Kualifikasi ?></textarea><br>
                                                                    <?php  } else { ?>
                                                                    <td><textarea name="kualifikasi" id="kualifikasi" class="kualifikasi"></textarea><br>
                                                                    <?php  } ?>
                                                                    <button type="button" name="simpan" id="simpan" class="simpan btn btn-primary btn-round btn-minier">Simpan</button>
                                                                    </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div id="toExcel" class="table table-responsive">
                                                    <table id="exportToExcelProses" class="table table-bordered" hidden="">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                <th>ID</th>
                                                                <th>Pemborong</th>
                                                                <th>Sub Pemborong</th>
                                                                <th>Asal</th>
                                                                <th>Tgl. Lahir</th>
                                                                <th>Jenis Kelamin</th>
                                                                <th>Tgl. Daftar By PBR</th>
                                                                <th>Vaksin</th>
                                                                <th>Ket. Proses</th>
                                                                <th>Keterangan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $no = 1;
                                                            foreach ($_getTenakerProses as $xl) { ?>
                                                                <tr>
                                                                    <td><?= $no++ ?></td>
                                                                    <td><?= $xl->Nama ?></td>
                                                                    <td><?= $xl->HeaderID ?></td>
                                                                    <td><?= $xl->CVNama ?></td>
                                                                    <td><?= $xl->SubPemborong ?></td>
                                                                    <td><?= $xl->Daerah_Asal ?></td>
                                                                    <td><?= date('d-M-Y',  strtotime($xl->Tgl_Lahir)) ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $jekel = $xl->Jenis_Kelamin;
                                                                        if ($jekel == 'M' || $jekel == 'LAKI-LAKI') {
                                                                            echo 'Laki-laki';
                                                                        } elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                                                            echo 'Perempuan';
                                                                        } else {
                                                                            echo 'Not Identified';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?= date("d-m-Y", strtotime($xl->RegisteredDate)); ?></td>
                                                                    <td><?= $xl->Vaksin; ?></td>
                                                                    <td><?= $xl->Proses; ?></td>
                                                                    <td><?= $xl->KeteranganKirim ?></td>
                                                                </tr>
                                                            <?php  } ?>
                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                    <div class="widget-toolbox padding-8 clearfix">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label no-padding-right">Jadwal Interview</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-daterange input-group">
                                                            <input type="text" class="input-sm form-control datepick jadwal_interview" id="jadwal_interview" name="jadwal_interview" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button name="btnUpdateTglInterview" id="btnUpdateTglInterview" class="btnUpdateTglInterview btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>

                                <?php  } ?>
                            </div>
                        </div>
                    </div>

                    <br>
                    <?php
                    // <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
                    // echo form_open('postingTenaker/doPosting', $att);
                    ?>




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

    $(document).on('click', '.chk_all', function() {
        if (this.checked) {
            $('.chkPosting').prop('checked', true)
        } else {
            $('.chkPosting').prop('checked', false)
        }

    })

    $(document).ready(function() {
        $('#dataTables-listTK').dataTable();
        $('#dataTables-listTK2').dataTable();
        $('[data-rel=tooltip]').tooltip();


        $("#btnExport").click(function() {
            $("#tblExport").battatech_excelexport({
                containerid: "exportToExcel",
                datatype: 'table'
            });
        });

        $("#btnExportProses").click(function() {
            $("#tblExport").battatech_excelexport({
                containerid: "exportToExcelProses",
                datatype: 'table'
            });
        });

    });







    $(document).ready(function() {
        // view modal
        $("#dataTables-listTK").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').find('.chkPosting').val();
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


        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').find('.chkPosting').val();
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

            var id = $(this).closest('tr').find('.chkPosting').val();
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

        $("#dataTables-listTK2").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').find('.chkPosting').val();
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

        $("#dataTables-listTK2").on("click", ".detail", function() {
            var id = $(this).closest('tr').find('.chkPosting').val();
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

        $("#dataTables-listTK2").on("click", ".detailInfo", function() {

            var id = $(this).closest('tr').find('.chkPosting').val();
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
        // end view modal

        // Update proses
        var urlSaveKirimPBR = '<?= base_url() ?>Registrasi/updateProses';
        $('.btnKirim').click(function(event) {
            var headerID = []
            var keterangan = []
            var proses = []

            $('#dataTables-listTK .chkPosting').each(function(i, e) {
                if ($(this).is(':checked')) {
                    headerID.push($(this).val())
                    keterangan.push($(this).closest('tr').find('.keterangan').val())
                    proses.push($(this).closest('tr').find('.proses').val())
                }
            })

            if (headerID.length === 0) {
                Swal.fire(
                    'Gagal!',
                    'Tidak ada data yang di pilih !!!',
                    'warning'
                )
                return
            }



            if (proses.includes('')) {
                Swal.fire(
                    'Gagal!',
                    'Anda belum memilih tanda "Proses/Belum Bisa Proses/Tidak Bisa Proses" !!!',
                    'warning'
                )
                return
            }

            Swal.fire({
                title: 'Anda Yakin?',
                text: "Anda yakin ingin memproses daftar nama ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: urlSaveKirimPBR,
                        dataType: 'json',
                        data: {
                            headerID,
                            keterangan,
                            proses
                        },
                        success: function(data) {
                            console.log(data.ket);
                            Swal.fire(
                                data.msg,
                                'Data ' + data.msg + ' disimpan!',
                                data.type
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        }
                    });
                }
            })



        });

        // Update jadwal interview
        $('.btnUpdateTglInterview').click(function(event) {
            var headerID = []
            var jadwalInterview = $('#jadwal_interview').val()

            if (jadwalInterview.trim() == '') {
                Swal.fire(
                    'Gagal!',
                    'Jadwal Interview Tidak Boleh Kosong !!!',
                    'warning'
                )
                return
            }

            $('#dataTables-listTK2 .chkPosting').each(function(i, e) {
                if ($(this).is(':checked')) {
                    headerID.push($(this).val())
                }
            })

            if (headerID.length === 0) {
                Swal.fire(
                    'Gagal!',
                    'Tidak ada data yang di pilih !!!',
                    'warning'
                )

                return
            }

            Swal.fire({
                title: 'Anda Yakin?',
                text: "Anda yakin ingin memproses daftar nama ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('Registrasi/updateJdwlInterview') ?>",
                        dataType: 'json',
                        data: {
                            headerID,
                            jadwalInterview
                        },
                        success: function(data) {
                            console.log(data.msg);
                            Swal.fire(
                                data.msg,
                                'Data ' + data.msg + ' disimpan!',
                                data.type
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            })



        });
    });


    // simpan kualifikasi

    var urlSaveKualifikasi = '<?= base_url() ?>Monitor/updateKualifikasi';
    $('.simpan').click(function(event) {

        var kualifikasi = $(this).closest('tr').find('.kualifikasi').val()
        var headerID = $(this).closest('tr').find('.headerid').text()

        $.ajax({
            type: "POST",
            url: urlSaveKualifikasi,
            dataType: 'json',
            data: {
                headerID,
                kualifikasi
            },
            success: function(data) {
                console.log(data);
                Swal.fire(
                    data.msg,
                    'Data ' + data.msg + ' disimpan!',
                    data.type
                )
            }
        });

    });


    $(document).on('change', '#dataTables-listTK .keterangan', function() {
        var keterangan = $(this).val()
        if (keterangan == 'blacklist' || keterangan == 'blacklist_2_bln') {
            $(this).closest('tr').find('.proses').val('tidak').trigger('change')
        } else {
            $(this).closest('tr').find('.proses').val('belum').trigger('change')
        }
    })
</script>